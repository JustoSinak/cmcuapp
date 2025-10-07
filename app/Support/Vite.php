<?php

namespace App\Support;

class Vite
{
    public static function asset(string $path): string
    {
        $hotFile = public_path('build/hot');
        if (file_exists($hotFile)) {
            $url = trim(file_get_contents($hotFile));
            return rtrim($url, '/') . '/' . ltrim($path, '/');
        }

        $manifestPath = public_path('build/manifest.json');
        if (! file_exists($manifestPath)) {
            // Fallback to Mix path if manifest missing
            return mix($path);
        }

        $manifest = json_decode(file_get_contents($manifestPath), true);
        $key = ltrim($path, '/');
        if (! isset($manifest[$key]['file'])) {
            return asset($path);
        }

        return asset('build/' . $manifest[$key]['file']);
    }

    public static function css(string $jsEntry): array
    {
        $manifestPath = public_path('build/manifest.json');
        if (! file_exists($manifestPath)) {
            return [];
        }

        $manifest = json_decode(file_get_contents($manifestPath), true);
        $key = ltrim($jsEntry, '/');
        if (! isset($manifest[$key]['css'])) {
            return [];
        }

        return array_map(function ($file) {
            return asset('build/' . $file);
        }, $manifest[$key]['css']);
    }
}


