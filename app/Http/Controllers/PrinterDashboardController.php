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
        
        $company = \App\Models\ProductionCompany::with(['reviews' => function($query) {
            $query->where('review_type', 'company')  // Only get company reviews
                  ->with('user')
                  ->orderBy('created_at', 'desc');
        }])->findOrFail($productionCompanyId);
        
        $companyReviews = $company->reviews()->where('review_type', 'company')->get();
        
        $avgRating = $companyReviews->avg('rating') ?: 0;
        $reviewCount = $companyReviews->count();
        
        $ratingDistribution = [
            5 => $company->reviews()->where('review_type', 'company')->where('rating', 5)->count(),
            4 => $company->reviews()->where('review_type', 'company')->where('rating', 4)->count(),
            3 => $company->reviews()->where('review_type', 'company')->where('rating', 3)->count(),
            2 => $company->reviews()->where('review_type', 'company')->where('rating', 2)->count(),
            1 => $company->reviews()->where('review_type', 'company')->where('rating', 1)->count(),
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
        $productionCompany = session('admin');
        $productionCompanyId = null;
        
        Log::info('Dashboard session admin data', [
            'admin_session' => $productionCompany,
            'type' => gettype($productionCompany),
            'auth_id' => auth()->id(),
            'user_role' => auth()->user()->role_type_id ?? 'none'
        ]);
        
        if (empty($productionCompany) && auth()->check() && auth()->user()->role_type_id == 2) {
            $productionCompany = \App\Models\ProductionCompany::where('user_id', auth()->id())->first();
            if ($productionCompany) {
                session(['admin' => $productionCompany]);
                Log::info('Recovered missing admin session data', ['company_id' => $productionCompany->id]);
            }
        }
        
        if (is_object($productionCompany) && isset($productionCompany->id)) {
            $productionCompanyId = $productionCompany->id;
        } elseif (is_array($productionCompany) && isset($productionCompany['App\\Models\\ProductionCompany'])) {
            $productionCompanyId = $productionCompany['App\\Models\\ProductionCompany']['id'];
        } elseif (is_object($productionCompany) && property_exists($productionCompany, 'App\\Models\\ProductionCompany')) {
            $pcData = $productionCompany->{'App\\Models\\ProductionCompany'};
            $productionCompanyId = $pcData->id ?? ($pcData['id'] ?? null);
        }
        
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
            
        // Calculate total earnings
        $completedOrders = Order::where('status_id', 7)
            ->where('production_company_id', $productionCompanyId)
            ->get();
            
        $totalEarnings = $completedOrders->sum('final_price');
        
        $formattedTotalEarnings = number_format($totalEarnings, 2);
        
        // Get monthly completed orders lst 6 months
        $monthlyOrders = [];
        $monthlyLabels = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $startOfMonth = $month->copy()->startOfMonth();
            $endOfMonth = $month->copy()->endOfMonth();
            
            $count = Order::where('production_company_id', $productionCompanyId)
                ->where('status_id', 7) 
                ->whereBetween('updated_at', [$startOfMonth, $endOfMonth])
                ->count();
                
            $monthlyOrders[] = $count;
            $monthlyLabels[] = $month->format('M');
        }
        
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

    public function notifications()
    {
        Log::info('Notifications method called', [
            'session_admin' => session('admin'),
            'user_id' => auth()->id(),
            'is_authenticated' => auth()->check()
        ]);
        
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
        
        Log::info('Production company ID extracted', [
            'productionCompanyId' => $productionCompanyId
        ]);
        
        // Recover admin session if needed (same as in index method)
        if (empty($productionCompany) && auth()->check() && auth()->user()->role_type_id == 2) {
            $productionCompany = \App\Models\ProductionCompany::where('user_id', auth()->id())->first();
            if ($productionCompany) {
                session(['admin' => $productionCompany]);
                $productionCompanyId = $productionCompany->id;
                Log::info('Recovered missing admin session data', ['company_id' => $productionCompany->id]);
            }
        }
        
        if (!$productionCompanyId) {
            Log::error('No production company ID found for notifications');
            return redirect()->route('printer-dashboard')->with('error', 'Session data is missing. Please try again.');
        }
        
        // Get the production company
        $company = \App\Models\ProductionCompany::find($productionCompanyId);
        
        if (!$company) {
            Log::error('Production company not found', ['id' => $productionCompanyId]);
            return redirect()->route('printer-dashboard')->with('error', 'Production company not found.');
        }
        
        // Get user ID from the production company
        $userId = $company->user_id;
        
        if (!$userId) {
            Log::error('No user ID associated with production company', ['company_id' => $productionCompanyId]);
            return redirect()->route('printer-dashboard')->with('error', 'User information not found.');
        }
        
        $notifications = \App\Models\Notification::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->paginate(15);
            
        // Mark notifications as read
        \App\Models\Notification::where('user_id', $userId)
            ->where('is_read', false)
            ->update(['is_read' => true]);
        
        return view('partner.printer.profile.notifications', compact('notifications'));
    }

    public function markAllNotificationsAsRead()
    {
        try {
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
            
            $user = \App\Models\ProductionCompany::where('id', $productionCompanyId)->first()->user;
            
            if (!$user) {
                return redirect()->back()->with('error', 'User not found');
            }
            
            \App\Models\Notification::where('user_id', $user->user_id)
                ->where('is_read', false)
                ->update(['is_read' => true]);
                
            return redirect()->back()->with('success', 'All notifications marked as read');
        } catch (\Exception $e) {
            Log::error('Mark all notifications read error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred');
        }
    }
}