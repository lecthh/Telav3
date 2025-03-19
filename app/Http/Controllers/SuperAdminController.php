<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ProductionCompany;

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
        $users = User::all();
        return view('superadmin.users', compact('users'));
    }

    public function productionCompanies()
    {
        $companies = ProductionCompany::all();
        return view('superadmin.production_companies', compact('companies'));
    }
}

