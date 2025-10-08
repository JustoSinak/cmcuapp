<?php

namespace App\Services;

use App\Models\Patient;
use App\Models\Consultation;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

class PatientService
{
    /**
     * Get paginated patients with optimized queries
     */
    public function getPaginatedPatients(int $perPage = 50): LengthAwarePaginator
    {
        return Cache::remember('patients_paginated_' . request('page', 1), 300, function () use ($perPage) {
            return Patient::select(['id', 'nom', 'prenom', 'telephone', 'created_at'])
                ->with(['consultations' => function ($query) {
                    $query->select(['id', 'patient_id', 'created_at'])
                          ->latest()
                          ->limit(1);
                }])
                ->latest()
                ->paginate($perPage);
        });
    }

    /**
     * Search patients with optimized query
     */
    public function searchPatients(string $query): \Illuminate\Database\Eloquent\Collection
    {
        $cacheKey = 'patient_search_' . md5($query);
        
        return Cache::remember($cacheKey, 600, function () use ($query) {
            return Patient::select(['id', 'nom', 'prenom', 'telephone'])
                ->where(function ($q) use ($query) {
                    $q->where('nom', 'LIKE', "%{$query}%")
                      ->orWhere('prenom', 'LIKE', "%{$query}%")
                      ->orWhere('telephone', 'LIKE', "%{$query}%");
                })
                ->limit(20)
                ->get();
        });
    }

    /**
     * Get patient with related data optimized
     */
    public function getPatientWithRelations(int $patientId): ?Patient
    {
        return Cache::remember("patient_full_{$patientId}", 300, function () use ($patientId) {
            return Patient::with([
                'consultations' => function ($query) {
                    $query->select(['id', 'patient_id', 'user_id', 'created_at'])
                          ->with(['user:id,name'])
                          ->latest();
                },
                'dossiers' => function ($query) {
                    $query->select(['id', 'patient_id', 'created_at'])
                          ->latest();
                }
            ])->find($patientId);
        });
    }

    /**
     * Create patient with optimized validation
     */
    public function createPatient(array $data): Patient
    {
        DB::beginTransaction();
        
        try {
            $patient = Patient::create($data);
            
            // Clear related caches
            $this->clearPatientCaches();
            
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
    public function updatePatient(Patient $patient, array $data): bool
    {
        DB::beginTransaction();
        
        try {
            $updated = $patient->update($data);
            
            // Clear specific patient cache
            Cache::forget("patient_full_{$patient->id}");
            $this->clearPatientCaches();
            
            DB::commit();
            return $updated;
            
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Get patient statistics with caching
     */
    public function getPatientStats(): array
    {
        return Cache::remember('patient_stats', 3600, function () {
            return [
                'total_patients' => Patient::count(),
                'patients_today' => Patient::whereDate('created_at', today())->count(),
                'patients_this_month' => Patient::whereMonth('created_at', now()->month)->count(),
                'consultations_today' => Consultation::whereDate('created_at', today())->count(),
            ];
        });
    }

    /**
     * Clear patient-related caches
     */
    private function clearPatientCaches(): void
    {
        Cache::forget('patient_stats');
        
        // Clear paginated caches (assuming max 10 pages)
        for ($i = 1; $i <= 10; $i++) {
            Cache::forget("patients_paginated_{$i}");
        }
    }
}
