<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ProductionCompany;
use App\Models\ProductionType;
use App\Models\ApparelType;
use App\Models\ProductionCompanyPricing;
use Illuminate\Support\Facades\DB;

class ProductionCompaniesComponent extends Component
{
    public $selectedProductionType = [];
    public $selectedApparelType = [];
    public $priceRange = 5000; // Default max price
    public $maxPriceLimit = 10000; // Maximum allowed price
    public $sortBy = ''; // Default sort option
    public $selectedProductionCompany = null;

    public function mount()
    {
        // Find the highest price in the system to set a realistic max price limit
        $highestPrice = ProductionCompanyPricing::max('base_price');
        if ($highestPrice) {
            $this->maxPriceLimit = ceil($highestPrice / 1000) * 1000; // Round up to the nearest thousand
            $this->priceRange = $this->maxPriceLimit; // Start with maximum range
        }

        // Fetch first 3 non-blocked companies for logging
        $companies = ProductionCompany::where('status', '!=', 'blocked')->take(3)->get();

        foreach ($companies as $index => $company) {
            \Illuminate\Support\Facades\Log::info("Company {$index} Data Structure", [
                'company_name' => $company->company_name,
                'production_type' => $company->production_type,
                'apparel_type' => $company->apparel_type,
                'production_type_type' => gettype($company->production_type),
                'apparel_type_type' => gettype($company->apparel_type),
                'production_type_raw' => DB::table('production_companies')
                    ->where('id', $company->id)
                    ->value('production_type'),
                'apparel_type_raw' => DB::table('production_companies')
                    ->where('id', $company->id)
                    ->value('apparel_type'),
            ]);
        }
    }


    public function selectProductionCompany($id)
    {
        $this->selectedProductionCompany = $id;
    }

    public function resetFilters()
    {
        $this->selectedProductionType = [];
        $this->selectedApparelType = [];
        $this->priceRange = $this->maxPriceLimit;
        $this->sortBy = '';
    }

    public function render()
    {
        // Get all apparel and production types for filters
        $apparelTypes = ApparelType::all();
        $productionTypes = ProductionType::all();

        // Build a map of production type IDs to names for display
        $productionTypeNames = $productionTypes->pluck('name', 'id')->toArray();

        // Start building the query
        $query = ProductionCompany::query()
            ->where('status', '!=', 'blocked')
            ->where('is_verified', '!=', 0);

        // Join with pricing table to get price information and to filter by price
        $query->leftJoin('production_company_pricing', 'production_companies.id', '=', 'production_company_pricing.production_company_id')
            ->select('production_companies.*')
            ->groupBy('production_companies.id');

        // Apply filters
        // Modified filtering approach for JSON arrays
        if (!empty($this->selectedProductionType)) {
            $query->where(function ($subQuery) {
                foreach ($this->selectedProductionType as $productionTypeId) {
                    // Handle both possible JSON formats: integer and string
                    $subQuery->orWhere('production_companies.production_type', 'LIKE', '%' . $productionTypeId . '%')
                        ->orWhere('production_companies.production_type', 'LIKE', '%"' . $productionTypeId . '"%');
                }
            });
        }

        if (!empty($this->selectedApparelType)) {
            $query->where(function ($subQuery) {
                foreach ($this->selectedApparelType as $apparelTypeId) {
                    // Handle both possible JSON formats: integer and string
                    $subQuery->orWhere('production_companies.apparel_type', 'LIKE', '%' . $apparelTypeId . '%')
                        ->orWhere('production_companies.apparel_type', 'LIKE', '%"' . $apparelTypeId . '"%');
                }
            });
        }

        if ($this->priceRange < $this->maxPriceLimit) {
            $query->whereExists(function ($subQuery) {
                $subQuery->select(DB::raw(1))
                    ->from('production_company_pricing')
                    ->whereColumn('production_company_pricing.production_company_id', 'production_companies.id')
                    ->where('production_company_pricing.base_price', '<=', $this->priceRange);
            });
        }

        // Apply sorting
        switch ($this->sortBy) {
            case 'name_asc':
                $query->orderBy('production_companies.company_name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('production_companies.company_name', 'desc');
                break;
            case 'price_asc':
                $query->orderBy(
                    ProductionCompanyPricing::select(DB::raw('MIN(base_price)'))
                        ->whereColumn('production_company_id', 'production_companies.id')
                        ->limit(1),
                    'asc'
                );
                break;
            case 'price_desc':
                $query->orderBy(
                    ProductionCompanyPricing::select(DB::raw('MAX(base_price)'))
                        ->whereColumn('production_company_id', 'production_companies.id')
                        ->limit(1),
                    'desc'
                );
                break;
            default:
                $query->orderBy('production_companies.company_name', 'asc');
        }

        // Get the production companies
        $productionCompanies = $query->get();

        // Debug: Log the structure of production_type and apparel_type for the first company
        if ($productionCompanies->isNotEmpty()) {
            $firstCompany = $productionCompanies->first();
            \Illuminate\Support\Facades\Log::info('Company Data Structure', [
                'company_name' => $firstCompany->company_name,
                'production_type' => $firstCompany->production_type,
                'apparel_type' => $firstCompany->apparel_type,
                'production_type_type' => gettype($firstCompany->production_type),
                'apparel_type_type' => gettype($firstCompany->apparel_type),
            ]);
        }

        // Add price information to each production company for display
        foreach ($productionCompanies as $company) {
            $pricingQuery = ProductionCompanyPricing::where('production_company_id', $company->id);
            $company->lowestPrice = $pricingQuery->min('base_price');
            $company->highestPrice = $pricingQuery->max('base_price');
        }

        return view('livewire.production-companies-component', [
            'productionCompanies' => $productionCompanies,
            'apparelTypes' => $apparelTypes,
            'productionTypes' => $productionTypes,
            'productionTypeNames' => $productionTypeNames,
        ]);
    }
}
