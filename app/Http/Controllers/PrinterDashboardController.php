<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PrinterDashboardController extends Controller
{
    public function index()
    {
        // Get production company ID
        $productionCompany = session('admin');
        $productionCompanyId = null;
        
        // Handle the nested object structure
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