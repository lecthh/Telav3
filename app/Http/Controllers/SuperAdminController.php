<?php

namespace App\Http\Controllers;

use App\Models\Designer;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ProductionCompany;
use App\Models\Report;

class SuperAdminController extends Controller
{
    public function index()
    {
        $userCount = User::count();
        $productionCompanyCount = ProductionCompany::count();

        return view('superadmin.index', compact('userCount', 'productionCompanyCount'));
    }
    public function userManagement()
    {
        $customerModel = User::class;
        return view('superadmin.users', compact('customerModel'));
    }


    public function productionCompanies()
    {
        $companies = ProductionCompany::all();
        return view('superadmin.production_companies', compact('companies'));
    }

    public function approveProductionCompanies()
    {
        $companies = ProductionCompany::where('is_verified', false)->get();
        return view('superadmin.production_companies_approve', compact('companies'));
    }

    public function designerManagement()
    {
        $designers = Designer::all();
        return view('superadmin.designers', compact('designers'));
    }
    public function approveDesigners()
    {
        $designers = Designer::where('is_verified', false)->get();
        return view('superadmin.designers_approve', compact('designers'));
    }

    public function orders()
    {
        $orders = Order::all();
        return view('superadmin.orders', compact('orders'));
    }

    public function reports()
    {
        $report = Report::all();
        return view('superadmin.reports', compact('report'));
    }
}
