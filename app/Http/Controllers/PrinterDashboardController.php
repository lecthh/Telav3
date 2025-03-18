<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PrinterDashboardController extends Controller
{
    /**
     * Show the reviews for the production company.
     *
     * @return \Illuminate\View\View
     */
    public function reviews()
    {
        $productionCompany = session('admin');
        $productionCompanyId = null;
        
        if (is_object($productionCompany) && isset($productionCompany->id)) {
            $productionCompanyId = $productionCompany->id;
        } elseif (is_array($productionCompany) && isset($productionCompany['App\\Models\\ProductionCompany'])) {
            $productionCompanyId = $productionCompany['App\\Models\\ProductionCompany']['id'];
        } elseif (is_object($productionCompany) && property_exists($productionCompany, 'App\\Models\\ProductionCompany')) {
            $pcData = $productionCompany->{'App\\Models\\ProductionCompany'};
            $productionCompanyId = $pcData->id ?? ($pcData['id'] ?? null);
        }
        
        // Get the production company with its reviews
        $company = \App\Models\ProductionCompany::with(['reviews' => function($query) {
            $query->with('user')->orderBy('created_at', 'desc');
        }])->findOrFail($productionCompanyId);
        
        $avgRating = $company->avg_rating;
        $reviewCount = $company->review_count;
        
        $ratingDistribution = [
            5 => $company->reviews()->where('rating', 5)->count(),
            4 => $company->reviews()->where('rating', 4)->count(),
            3 => $company->reviews()->where('rating', 3)->count(),
            2 => $company->reviews()->where('rating', 2)->count(),
            1 => $company->reviews()->where('rating', 1)->count(),
        ];
        
        return view('partner.printer.profile.reviews', compact(
            'company', 
            'avgRating', 
            'reviewCount', 
            'ratingDistribution'
        ));
    }

    public function index()
    {
        // Get production company ID
        $productionCompany = session('admin');
        $productionCompanyId = null;
        
        // Log the admin session content for debugging
        Log::info('Dashboard session admin data', [
            'admin_session' => $productionCompany,
            'type' => gettype($productionCompany),
            'auth_id' => auth()->id(),
            'user_role' => auth()->user()->role_type_id ?? 'none'
        ]);
        
        // If session admin is missing, try to recover it from the database
        if (empty($productionCompany) && auth()->check() && auth()->user()->role_type_id == 2) {
            $productionCompany = \App\Models\ProductionCompany::where('user_id', auth()->id())->first();
            if ($productionCompany) {
                session(['admin' => $productionCompany]);
                Log::info('Recovered missing admin session data', ['company_id' => $productionCompany->id]);
            }
        }
        
        // Handle different possible data structures
        if (is_object($productionCompany) && isset($productionCompany->id)) {
            $productionCompanyId = $productionCompany->id;
        } elseif (is_array($productionCompany) && isset($productionCompany['App\\Models\\ProductionCompany'])) {
            $productionCompanyId = $productionCompany['App\\Models\\ProductionCompany']['id'];
        } elseif (is_object($productionCompany) && property_exists($productionCompany, 'App\\Models\\ProductionCompany')) {
            $pcData = $productionCompany->{'App\\Models\\ProductionCompany'};
            $productionCompanyId = $pcData->id ?? ($pcData['id'] ?? null);
        }
        
        // Get counts for each order status
        $pendingCount = Order::where('status_id', 1)
            ->where('production_company_id', $productionCompanyId)
            ->count();
            
        $designInProgressCount = Order::where('status_id', 2)
            ->where('production_company_id', $productionCompanyId)
            ->count();
            
        $finalizeOrderCount = Order::where('status_id', 3)
            ->where('production_company_id', $productionCompanyId)
            ->count();
            
        $awaitingPrintingCount = Order::where('status_id', 4)
            ->where('production_company_id', $productionCompanyId)
            ->count();
            
        $printingInProgressCount = Order::where('status_id', 5)
            ->where('production_company_id', $productionCompanyId)
            ->count();
            
        $readyForCollectionCount = Order::where('status_id', 6)
            ->where('production_company_id', $productionCompanyId)
            ->count();
            
        // Calculate total earnings from completed orders
        $completedOrders = Order::where('status_id', 7)
            ->where('production_company_id', $productionCompanyId)
            ->get();
            
        $totalEarnings = $completedOrders->sum('final_price');
        
        // Format for display with comma thousands separator
        $formattedTotalEarnings = number_format($totalEarnings, 2);
        
        // Get monthly completed orders for the chart (last 6 months)
        $monthlyOrders = [];
        $monthlyLabels = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $startOfMonth = $month->copy()->startOfMonth();
            $endOfMonth = $month->copy()->endOfMonth();
            
            $count = Order::where('production_company_id', $productionCompanyId)
                ->where('status_id', 7) // Completed orders
                ->whereBetween('updated_at', [$startOfMonth, $endOfMonth])
                ->count();
                
            $monthlyOrders[] = $count;
            $monthlyLabels[] = $month->format('M');
        }
        
        // Convert to JSON for JavaScript
        $monthlyOrdersJSON = json_encode($monthlyOrders);
        $monthlyLabelsJSON = json_encode($monthlyLabels);
        
        return view('partner.printer.dashboard', compact(
            'productionCompany',
            'pendingCount',
            'designInProgressCount',
            'finalizeOrderCount',
            'awaitingPrintingCount',
            'printingInProgressCount',
            'readyForCollectionCount',
            'completedOrders',
            'formattedTotalEarnings',
            'monthlyOrdersJSON',
            'monthlyLabelsJSON'
        ));
    }
}