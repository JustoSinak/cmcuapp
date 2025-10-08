<?php

namespace App\Repositories;

use App\Models\Patient;
use App\Services\CacheService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class PatientRepository
{
    protected $cacheService;

    public function __construct(CacheService $cacheService)
    {
        $this->cacheService = $cacheService;
    }

    /**
     * Get all patients with optimized eager loading
     */
    public function getAllWithRelations(): Collection
    {
        return $this->cacheService->remember(
            'patients_all_with_relations',
            CacheService::TAGS['patients'],
            CacheService::TTL['medium'],
            function () {
                return Patient::select(['id', 'nom', 'prenom', 'telephone', 'created_at'])
                    ->with([
                        'consultations' => function ($query) {
                            $query->select(['id', 'patient_id', 'created_at'])
                                  ->latest()
                                  ->limit(3);
                        },
                        'factures' => function ($query) {
                            $query->select(['id', 'patient_id', 'montant', 'status']);
                        }
                    ])
                    ->latest()
                    ->get();
            }
        );
    }

    /**
     * Get paginated patients with search
     */
    public function getPaginated(int $perPage = 50, string $search = null): LengthAwarePaginator
    {
        $cacheKey = "patients_paginated_{$perPage}_" . md5($search ?? '');
        
        return $this->cacheService->remember(
            $cacheKey,
            CacheService::TAGS['patients'],
            CacheService::TTL['short'],
            function () use ($perPage, $search) {
                $query = Patient::select(['id', 'nom', 'prenom', 'telephone', 'created_at'])
                    ->with(['consultations' => function ($q) {
                        $q->select(['id', 'patient_id', 'created_at'])->latest()->limit(1);
                    }]);

                if ($search) {
                    $query->where(function ($q) use ($search) {
                        $q->where('nom', 'LIKE', "%{$search}%")
                          ->orWhere('prenom', 'LIKE', "%{$search}%")
                          ->orWhere('telephone', 'LIKE', "%{$search}%");
                    });
                }

                return $query->latest()->paginate($perPage);
            }
        );
    }

    /**
     * Find patient by ID with optimized relations
     */
    public function findWithRelations(int $id): ?Patient
    {
        return $this->cacheService->remember(
            "patient_with_relations_{$id}",
            CacheService::TAGS['patients'],
            CacheService::TTL['medium'],
            function () use ($id) {
                return Patient::with([
                    'consultations' => function ($query) {
                        $query->select(['id', 'patient_id', 'user_id', 'description', 'created_at'])
                              ->with(['user:id,name'])
                              ->latest();
                    },
                    'factures' => function ($query) {
                        $query->select(['id', 'patient_id', 'montant', 'status', 'created_at'])
                              ->latest();
                    },
                    'dossiers' => function ($query) {
                        $query->select(['id', 'patient_id', 'created_at'])
                              ->latest();
                    }
                ])->find($id);
            }
        );
    }

    /**
     * Search patients with advanced filters
     */
    public function search(array $filters): Collection
    {
        $cacheKey = 'patients_search_' . md5(serialize($filters));
        
        return $this->cacheService->remember(
            $cacheKey,
            CacheService::TAGS['patients'],
            CacheService::TTL['short'],
            function () use ($filters) {
                $query = Patient::select(['id', 'nom', 'prenom', 'telephone', 'created_at']);

                if (!empty($filters['name'])) {
                    $query->where(function ($q) use ($filters) {
                        $q->where('nom', 'LIKE', "%{$filters['name']}%")
                          ->orWhere('prenom', 'LIKE', "%{$filters['name']}%");
                    });
                }

                if (!empty($filters['phone'])) {
                    $query->where('telephone', 'LIKE', "%{$filters['phone']}%");
                }

                if (!empty($filters['date_from'])) {
                    $query->whereDate('created_at', '>=', $filters['date_from']);
                }

                if (!empty($filters['date_to'])) {
                    $query->whereDate('created_at', '<=', $filters['date_to']);
                }

                return $query->latest()->limit(100)->get();
            }
        );
    }

    /**
     * Get patient statistics
     */
    public function getStatistics(): array
    {
        return $this->cacheService->remember(
            'patients_statistics',
            CacheService::TAGS['stats'],
            CacheService::TTL['long'],
            function () {
                return [
                    'total' => Patient::count(),
                    'today' => Patient::whereDate('created_at', today())->count(),
                    'this_week' => Patient::whereBetween('created_at', [
                        now()->startOfWeek(),
                        now()->endOfWeek()
                    ])->count(),
                    'this_month' => Patient::whereMonth('created_at', now()->month)->count(),
                    'with_consultations' => Patient::has('consultations')->count(),
                    'without_consultations' => Patient::doesntHave('consultations')->count(),
                ];
            }
        );
    }

    /**
     * Create patient with cache invalidation
     */
    public function create(array $data): Patient
    {
        DB::beginTransaction();
        
        try {
            $patient = Patient::create($data);
            
            // Invalidate related caches
            $this->cacheService->flushTag(CacheService::TAGS['patients']);
            $this->cacheService->flushTag(CacheService::TAGS['stats']);
            
            DB::commit();
            return $patient;
            
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Update patient with cache invalidation
     */
    public function update(Patient $patient, array $data): bool
    {
        DB::beginTransaction();
        
        try {
            $updated = $patient->update($data);
            
            // Invalidate specific patient cache and related caches
            $this->cacheService->flushTag(CacheService::TAGS['patients']);
            
            DB::commit();
            return $updated;
            
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Delete patient with cache invalidation
     */
    public function delete(Patient $patient): bool
    {
        DB::beginTransaction();
        
        try {
            $deleted = $patient->delete();
            
            // Invalidate all related caches
            $this->cacheService->flushTag(CacheService::TAGS['patients']);
            $this->cacheService->flushTag(CacheService::TAGS['stats']);
            
            DB::commit();
            return $deleted;
            
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
