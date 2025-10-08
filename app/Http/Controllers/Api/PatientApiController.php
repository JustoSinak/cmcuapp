<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\PatientRepository;
use App\Services\CacheService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class PatientApiController extends Controller
{
    protected $patientRepository;
    protected $cacheService;

    public function __construct(PatientRepository $patientRepository, CacheService $cacheService)
    {
        $this->patientRepository = $patientRepository;
        $this->cacheService = $cacheService;
    }

    /**
     * Search patients for autocomplete (optimized for AJAX)
     */
    public function search(Request $request): JsonResponse
    {
        $query = $request->get('q', '');
        
        if (strlen($query) < 2) {
            return response()->json([
                'success' => true,
                'data' => [],
                'message' => 'Query too short'
            ]);
        }

        try {
            $cacheKey = "patient_search_autocomplete_" . md5($query);
            
            $patients = $this->cacheService->remember(
                $cacheKey,
                CacheService::TAGS['patients'],
                CacheService::TTL['short'],
                function () use ($query) {
                    return \App\Models\Patient::select(['id', 'nom', 'prenom', 'telephone'])
                        ->where(function ($q) use ($query) {
                            $q->where('nom', 'LIKE', "%{$query}%")
                              ->orWhere('prenom', 'LIKE', "%{$query}%")
                              ->orWhere('telephone', 'LIKE', "%{$query}%");
                        })
                        ->limit(10)
                        ->get()
                        ->map(function ($patient) {
                            return [
                                'id' => $patient->id,
                                'text' => "{$patient->nom} {$patient->prenom}",
                                'phone' => $patient->telephone,
                            ];
                        });
                }
            );

            return response()->json([
                'success' => true,
                'data' => $patients,
                'count' => $patients->count()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Search failed',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }

    /**
     * Get patient details (optimized for AJAX)
     */
    public function show(int $id): JsonResponse
    {
        try {
            $patient = $this->patientRepository->findWithRelations($id);

            if (!$patient) {
                return response()->json([
                    'success' => false,
                    'message' => 'Patient not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $patient->id,
                    'nom' => $patient->nom,
                    'prenom' => $patient->prenom,
                    'telephone' => $patient->telephone,
                    'adresse' => $patient->adresse,
                    'consultations_count' => $patient->consultations->count(),
                    'last_consultation' => $patient->consultations->first()?->created_at?->format('d/m/Y'),
                    'total_factures' => $patient->factures->sum('montant'),
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve patient',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }

    /**
     * Get patient statistics (optimized for dashboard)
     */
    public function statistics(): JsonResponse
    {
        try {
            $stats = $this->patientRepository->getStatistics();

            return response()->json([
                'success' => true,
                'data' => $stats
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve statistics',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }

    /**
     * Quick create patient (optimized for AJAX forms)
     */
    public function quickCreate(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'telephone' => 'nullable|string|max:20',
            'adresse' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $patient = $this->patientRepository->create($validator->validated());

            return response()->json([
                'success' => true,
                'message' => 'Patient created successfully',
                'data' => [
                    'id' => $patient->id,
                    'nom' => $patient->nom,
                    'prenom' => $patient->prenom,
                    'telephone' => $patient->telephone,
                ]
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create patient',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }

    /**
     * Get recent patients (optimized for dashboard widgets)
     */
    public function recent(Request $request): JsonResponse
    {
        try {
            $limit = min($request->get('limit', 10), 50); // Max 50 items
            
            $cacheKey = "recent_patients_{$limit}";
            
            $patients = $this->cacheService->remember(
                $cacheKey,
                CacheService::TAGS['patients'],
                CacheService::TTL['short'],
                function () use ($limit) {
                    return \App\Models\Patient::select(['id', 'nom', 'prenom', 'created_at'])
                        ->latest()
                        ->limit($limit)
                        ->get()
                        ->map(function ($patient) {
                            return [
                                'id' => $patient->id,
                                'name' => "{$patient->nom} {$patient->prenom}",
                                'created_at' => $patient->created_at->format('d/m/Y H:i'),
                                'created_human' => $patient->created_at->diffForHumans(),
                            ];
                        });
                }
            );

            return response()->json([
                'success' => true,
                'data' => $patients
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve recent patients',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }
}
