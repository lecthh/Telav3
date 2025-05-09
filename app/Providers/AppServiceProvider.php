<?php

namespace App\Providers;

use App\Models\Designer;
use App\Models\Order;
use Illuminate\Support\Facades\View;
use App\Models\ProductionCompany;
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
            $productionCompany = ProductionCompany::where('user_id', auth()->id())->firstOrFail();
            $view->with('productionCompany', $productionCompany);
        });
        config(['javascript.pusher_app_key' => config('broadcasting.connections.pusher.key')]);
        config(['javascript.pusher_app_cluster' => config('broadcasting.connections.pusher.options.cluster')]);
        View::composer('partner.designer.*', function ($view) {
            try {
                $productionCompany = ProductionCompany::where('user_id', auth()->id())->first();
                if ($productionCompany) {
                    $view->with('productionCompany', $productionCompany);
                }
            } catch (\Exception $e) {
                // Don't add productionCompany to view if it doesn't exist
            }
        });

        View::composer(['designer.*', 'partner.designer.*'], function ($view) {
            try {

                $designer = Designer::where('user_id', auth()->id())->first();

                if ($designer) {
                    $view->with('designer', $designer);
                }
            } catch (\Exception $e) {
                // Don't add designer to view if it doesn't exist
            }
        });


        View::composer('partner.printer.dashboard', function ($view) {

            $productionCompany = ProductionCompany::where('user_id', auth()->id())->firstOrFail();
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
