<?php

namespace App\Providers;

use App\Models\Order;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('partner.printer.*', function ($view) {
            $productionCompany = session('admin');
            $view->with('productionCompany', $productionCompany);
        });

        View::composer('partner.designer.*', function ($view) {
            $productionCompany = session('admin');
            $view->with('productionCompany', $productionCompany);
        });

        View::composer('partner.printer.dashboard', function ($view) {
            $productionCompany = session('admin');

            $pendingCount = Order::where('status_id', 1)->count();
            $designInProgressCount = Order::where('status_id', 2)->count();
            $finalizeOrderCount = Order::where('status_id', 3)->count();
            $awaitingPrintingCount = Order::where('status_id', 4)->count();
            $printingInProgressCount = Order::where('status_id', 5)->count();
            $view->with([
                'productionCompany' => $productionCompany,
                'pendingCount' => $pendingCount,
                'designInProgressCount' => $designInProgressCount,
                'finalizeOrderCount' => $finalizeOrderCount,
                'awaitingPrintingCount' => $awaitingPrintingCount,
                'printingInProgressCount' => $printingInProgressCount,
            ]);
        });
    }
}
