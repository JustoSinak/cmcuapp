<?php

namespace App\Services;

use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\UploadedFile;

class ImageOptimizationService
{
    /**
     * Image size configurations
     */
    const SIZES = [
        'thumbnail' => ['width' => 150, 'height' => 150],
        'small' => ['width' => 300, 'height' => 300],
        'medium' => ['width' => 600, 'height' => 600],
        'large' => ['width' => 1200, 'height' => 1200],
    ];

    /**
     * Supported image formats
     */
    const SUPPORTED_FORMATS = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

    /**
     * Maximum file size (in bytes)
     */
    const MAX_FILE_SIZE = 10 * 1024 * 1024; // 10MB

    /**
     * Optimize and resize uploaded image
     */
    public function optimizeUploadedImage(UploadedFile $file, string $directory = 'images'): array
    {
        try {
            // Validate file
            $this->validateImage($file);

            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = strtolower($file->getClientOriginalExtension());
            $filename = $this->generateUniqueFilename($originalName, $extension);

            // Create optimized versions
            $optimizedImages = [];
            $image = Image::make($file);

            // Original optimized version
            $optimizedImages['original'] = $this->saveOptimizedImage(
                $image,
                $directory . '/original/' . $filename,
                90 // Quality
            );

            // Generate different sizes
            foreach (self::SIZES as $sizeName => $dimensions) {
                $resizedImage = clone $image;
                $resizedImage->fit($dimensions['width'], $dimensions['height'], function ($constraint) {
                    $constraint->upsize(); // Prevent upsizing
                });

                $optimizedImages[$sizeName] = $this->saveOptimizedImage(
                    $resizedImage,
                    $directory . '/' . $sizeName . '/' . $filename,
                    $this->getQualityForSize($sizeName)
                );
            }

            // Generate WebP versions for better performance
            if ($extension !== 'webp') {
                $webpFilename = pathinfo($filename, PATHINFO_FILENAME) . '.webp';
                
                foreach (self::SIZES as $sizeName => $dimensions) {
                    $webpImage = clone $image;
                    $webpImage->fit($dimensions['width'], $dimensions['height'], function ($constraint) {
                        $constraint->upsize();
                    });

                    $optimizedImages[$sizeName . '_webp'] = $this->saveOptimizedImage(
                        $webpImage,
                        $directory . '/' . $sizeName . '/' . $webpFilename,
                        $this->getQualityForSize($sizeName),
                        'webp'
                    );
                }
            }

            Log::info('Image optimization completed', [
                'original_size' => $file->getSize(),
                'optimized_versions' => count($optimizedImages),
                'filename' => $filename
            ]);

            return [
                'success' => true,
                'filename' => $filename,
                'images' => $optimizedImages,
                'original_size' => $file->getSize(),
            ];

        } catch (\Exception $e) {
            Log::error('Image optimization failed', [
                'error' => $e->getMessage(),
                'file' => $file->getClientOriginalName()
            ]);

            throw $e;
        }
    }

    /**
     * Get optimized image URL with fallback
     */
    public function getOptimizedImageUrl(string $filename, string $size = 'medium', bool $preferWebp = true): string
    {
        $directory = 'images';
        
        // Try WebP first if preferred and supported
        if ($preferWebp && $this->browserSupportsWebp()) {
            $webpFilename = pathinfo($filename, PATHINFO_FILENAME) . '.webp';
            $webpPath = $directory . '/' . $size . '/' . $webpFilename;
            
            if (Storage::exists($webpPath)) {
                return Storage::url($webpPath);
            }
        }

        // Fallback to original format
        $imagePath = $directory . '/' . $size . '/' . $filename;
        
        if (Storage::exists($imagePath)) {
            return Storage::url($imagePath);
        }

        // Final fallback to original
        $originalPath = $directory . '/original/' . $filename;
        
        if (Storage::exists($originalPath)) {
            return Storage::url($originalPath);
        }

        // Return placeholder if nothing found
        return asset('images/placeholder.jpg');
    }

    /**
     * Delete all versions of an image
     */
    public function deleteImageVersions(string $filename): bool
    {
        try {
            $directory = 'images';
            $deleted = 0;

            // Delete original
            $originalPath = $directory . '/original/' . $filename;
            if (Storage::exists($originalPath)) {
                Storage::delete($originalPath);
                $deleted++;
            }

            // Delete all sizes
            foreach (array_keys(self::SIZES) as $sizeName) {
                $sizePath = $directory . '/' . $sizeName . '/' . $filename;
                if (Storage::exists($sizePath)) {
                    Storage::delete($sizePath);
                    $deleted++;
                }

                // Delete WebP version
                $webpFilename = pathinfo($filename, PATHINFO_FILENAME) . '.webp';
                $webpPath = $directory . '/' . $sizeName . '/' . $webpFilename;
                if (Storage::exists($webpPath)) {
                    Storage::delete($webpPath);
                    $deleted++;
                }
            }

            Log::info('Image versions deleted', [
                'filename' => $filename,
                'versions_deleted' => $deleted
            ]);

            return $deleted > 0;

        } catch (\Exception $e) {
            Log::error('Failed to delete image versions', [
                'filename' => $filename,
                'error' => $e->getMessage()
            ]);

            return false;
        }
    }

    /**
     * Validate uploaded image
     */
    private function validateImage(UploadedFile $file): void
    {
        if (!$file->isValid()) {
            throw new \InvalidArgumentException('Invalid file upload');
        }

        if ($file->getSize() > self::MAX_FILE_SIZE) {
            throw new \InvalidArgumentException('File size exceeds maximum allowed size');
        }

        $extension = strtolower($file->getClientOriginalExtension());
        if (!in_array($extension, self::SUPPORTED_FORMATS)) {
            throw new \InvalidArgumentException('Unsupported image format');
        }

        // Validate MIME type
        $mimeType = $file->getMimeType();
        if (!str_starts_with($mimeType, 'image/')) {
            throw new \InvalidArgumentException('File is not a valid image');
        }
    }

    /**
     * Save optimized image to storage
     */
    private function saveOptimizedImage($image, string $path, int $quality, string $format = null): array
    {
        $format = $format ?: pathinfo($path, PATHINFO_EXTENSION);
        
        // Encode image with optimization
        $encodedImage = $image->encode($format, $quality);
        
        // Save to storage
        Storage::put($path, $encodedImage);
        
        return [
            'path' => $path,
            'url' => Storage::url($path),
            'size' => strlen($encodedImage),
            'format' => $format,
            'quality' => $quality,
        ];
    }

    /**
     * Generate unique filename
     */
    private function generateUniqueFilename(string $originalName, string $extension): string
    {
        $sanitizedName = preg_replace('/[^a-zA-Z0-9_-]/', '', $originalName);
        $timestamp = time();
        $random = substr(md5(uniqid()), 0, 8);
        
        return $sanitizedName . '_' . $timestamp . '_' . $random . '.' . $extension;
    }

    /**
     * Get quality setting based on image size
     */
    private function getQualityForSize(string $sizeName): int
    {
        return match ($sizeName) {
            'thumbnail' => 70,
            'small' => 75,
            'medium' => 85,
            'large' => 90,
            default => 80,
        };
    }

    /**
     * Check if browser supports WebP
     */
    private function browserSupportsWebp(): bool
    {
        $accept = $_SERVER['HTTP_ACCEPT'] ?? '';
        return str_contains($accept, 'image/webp');
    }
}
