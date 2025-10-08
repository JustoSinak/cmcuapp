<?php

namespace App\Services;

use App\Models\Facture;
use App\Models\Patient;
use App\Models\Consultation;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FactureService
{
    /**
     * Get paginated factures with optimized queries
     */
    public function getPaginatedFactures(int $perPage = 50)
    {
        return Cache::remember('factures_paginated_' . request('page', 1), 300, function () use ($perPage) {
            return Facture::select(['id', 'patient_id', 'montant', 'status', 'created_at'])
                ->with(['patient:id,nom,prenom'])
                ->latest()
                ->paginate($perPage);
        });
    }

    /**
     * Get facture statistics with caching
     */
    public function getFactureStats(): array
    {
        return Cache::remember('facture_stats', 1800, function () {
            $today = Carbon::today();
            $thisMonth = Carbon::now()->startOfMonth();
            
            return [
                'total_factures' => Facture::count(),
                'factures_today' => Facture::whereDate('created_at', $today)->count(),
                'factures_this_month' => Facture::where('created_at', '>=', $thisMonth)->count(),
                'revenue_today' => Facture::whereDate('created_at', $today)->sum('montant'),
                'revenue_this_month' => Facture::where('created_at', '>=', $thisMonth)->sum('montant'),
                'pending_factures' => Facture::where('status', 'pending')->count(),
            ];
        });
    }

    /**
     * Search factures by date range with optimization
     */
    public function searchFacturesByDate(string $startDate, string $endDate)
    {
        $cacheKey = 'factures_search_' . md5($startDate . $endDate);
        
        return Cache::remember($cacheKey, 600, function () use ($startDate, $endDate) {
            return Facture::select(['id', 'patient_id', 'montant', 'status', 'created_at'])
                ->with(['patient:id,nom,prenom'])
                ->whereBetween('created_at', [$startDate, $endDate])
                ->orderBy('created_at', 'desc')
                ->get();
        });
    }

    /**
     * Create facture with optimized validation
     */
    public function createFacture(array $data): Facture
    {
        DB::beginTransaction();
        
        try {
            $facture = Facture::create($data);
            
            // Clear related caches
            $this->clearFactureCaches();
            
            DB::commit();
            return $facture;
            
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Generate consultation facture with optimization
     */
    public function generateConsultationFacture(int $patientId, array $consultationData): array
    {
        $cacheKey = "consultation_facture_{$patientId}";
        
        return Cache::remember($cacheKey, 300, function () use ($patientId, $consultationData) {
            $patient = Patient::with(['consultations' => function ($query) {
                $query->select(['id', 'patient_id', 'montant', 'created_at'])
                      ->latest();
            }])->find($patientId);
            
            if (!$patient) {
                throw new \Exception('Patient not found');
            }
            
            $totalConsultations = $patient->consultations->sum('montant');
            
            return [
                'patient' => $patient,
                'consultations' => $patient->consultations,
                'total_amount' => $totalConsultations,
                'facture_data' => $consultationData
            ];
        });
    }

    /**
     * Get monthly revenue report with caching
     */
    public function getMonthlyRevenueReport(int $year = null): array
    {
        $year = $year ?? Carbon::now()->year;
        $cacheKey = "monthly_revenue_{$year}";
        
        return Cache::remember($cacheKey, 3600, function () use ($year) {
            $monthlyData = [];
            
            for ($month = 1; $month <= 12; $month++) {
                $startDate = Carbon::create($year, $month, 1)->startOfMonth();
                $endDate = Carbon::create($year, $month, 1)->endOfMonth();
                
                $revenue = Facture::whereBetween('created_at', [$startDate, $endDate])
                    ->sum('montant');
                
                $monthlyData[] = [
                    'month' => $month,
                    'month_name' => $startDate->format('F'),
                    'revenue' => $revenue
                ];
            }
            
            return $monthlyData;
        });
    }

    /**
     * Export facture data with optimization
     */
    public function exportFactureData(int $factureId): array
    {
        return Cache::remember("facture_export_{$factureId}", 600, function () use ($factureId) {
            return Facture::with([
                'patient:id,nom,prenom,telephone,adresse',
                'consultations:id,facture_id,description,montant'
            ])->findOrFail($factureId);
        });
    }

    /**
     * Clear facture-related caches
     */
    private function clearFactureCaches(): void
    {
        Cache::forget('facture_stats');
        
        // Clear paginated caches
        for ($i = 1; $i <= 10; $i++) {
            Cache::forget("factures_paginated_{$i}");
        }
        
        // Clear monthly revenue cache for current year
        Cache::forget('monthly_revenue_' . Carbon::now()->year);
    }
}
