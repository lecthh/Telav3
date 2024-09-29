<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProductionCompanyController extends Controller
{
    //#[Rule('required')]
    protected $company_name;

    protected $company_logo;

    //#[Rule('required')]
    protected $production_type;

    //#[Rule('required')]
    protected $address;

   // #[Rule('required')]
    protected $phone;

    protected $avg_rating;

    protected $review_count;
}
