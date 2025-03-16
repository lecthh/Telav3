<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProductionCompany;
use App\Models\ProductionCompanyPricing;

class ProductionCompanyPricingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all production companies
        $productionCompanies = ProductionCompany::all();

        foreach ($productionCompanies as $company) {
            // Get the production types and apparel types for this company
            $productionTypes = json_decode($company->production_type);
            $apparelTypes = json_decode($company->apparel_type);

            // For each apparel type and production type combination, create pricing
            foreach ($apparelTypes as $apparelType) {
                foreach ($productionTypes as $productionType) {
                    // Base prices vary by company, apparel type, and production type
                    switch ($company->company_name) {
                        case 'Elite Prints Inc.':
                            $basePrice = $this->getElitePrintsPricing($apparelType, $productionType);
                            break;
                        case 'ThreadCraft Studios':
                            $basePrice = $this->getThreadCraftPricing($apparelType, $productionType);
                            break;
                        case 'Fusion Apparel Manufacturing':
                            $basePrice = $this->getFusionApparelPricing($apparelType, $productionType);
                            break;
                        default:
                            $basePrice = ['base' => 500, 'bulk' => 350];
                    }

                    ProductionCompanyPricing::create([
                        'production_company_id' => $company->id,
                        'apparel_type' => $apparelType,
                        'production_type' => $productionType,
                        'base_price' => $basePrice['base'],
                        'bulk_price' => $basePrice['bulk'],
                    ]);
                }
            }
        }
    }

    /**
     * Get Elite Prints pricing based on apparel and production type
     */
    private function getElitePrintsPricing($apparelType, $productionType)
    {
        $pricingMatrix = [
            // Apparel Type 1 (Jersey)
            1 => [
                // Production Type 1 (Sublimation)
                1 => ['base' => 800, 'bulk' => 600],
                // Production Type 2 (Heat Transfer)
                2 => ['base' => 650, 'bulk' => 450],
                // Production Type 3 (Embroidery) - Not offered by Elite for Jerseys
                3 => ['base' => 0, 'bulk' => 0],
            ],
            // Apparel Type 2 (Polo Shirt)
            2 => [
                1 => ['base' => 600, 'bulk' => 400],
                2 => ['base' => 550, 'bulk' => 350],
                3 => ['base' => 0, 'bulk' => 0],
            ],
            // Apparel Type 3 (T-shirt)
            3 => [
                1 => ['base' => 450, 'bulk' => 300],
                2 => ['base' => 400, 'bulk' => 250],
                3 => ['base' => 0, 'bulk' => 0],
            ],
            // Apparel Type 4 (Hoodie) - Not offered by Elite
            4 => [
                1 => ['base' => 0, 'bulk' => 0],
                2 => ['base' => 0, 'bulk' => 0],
                3 => ['base' => 0, 'bulk' => 0],
            ],
        ];

        return $pricingMatrix[$apparelType][$productionType] ?? ['base' => 500, 'bulk' => 350];
    }

    /**
     * Get ThreadCraft pricing based on apparel and production type
     */
    private function getThreadCraftPricing($apparelType, $productionType)
    {
        $pricingMatrix = [
            // Apparel Type 1 (Jersey) - Not offered by ThreadCraft
            1 => [
                1 => ['base' => 0, 'bulk' => 0],
                2 => ['base' => 0, 'bulk' => 0],
                3 => ['base' => 0, 'bulk' => 0],
            ],
            // Apparel Type 2 (Polo Shirt)
            2 => [
                1 => ['base' => 0, 'bulk' => 0],
                2 => ['base' => 0, 'bulk' => 0],
                3 => ['base' => 700, 'bulk' => 500],
            ],
            // Apparel Type 3 (T-shirt)
            3 => [
                1 => ['base' => 0, 'bulk' => 0],
                2 => ['base' => 0, 'bulk' => 0],
                3 => ['base' => 550, 'bulk' => 375],
            ],
            // Apparel Type 4 (Hoodie)
            4 => [
                1 => ['base' => 0, 'bulk' => 0],
                2 => ['base' => 0, 'bulk' => 0],
                3 => ['base' => 850, 'bulk' => 650],
            ],
        ];

        return $pricingMatrix[$apparelType][$productionType] ?? ['base' => 500, 'bulk' => 350];
    }

    /**
     * Get Fusion Apparel pricing based on apparel and production type
     */
    private function getFusionApparelPricing($apparelType, $productionType)
    {
        $pricingMatrix = [
            // Apparel Type 1 (Jersey)
            1 => [
                1 => ['base' => 900, 'bulk' => 650],
                2 => ['base' => 750, 'bulk' => 550],
                3 => ['base' => 1050, 'bulk' => 800],
            ],
            // Apparel Type 2 (Polo Shirt)
            2 => [
                1 => ['base' => 650, 'bulk' => 450],
                2 => ['base' => 600, 'bulk' => 400],
                3 => ['base' => 750, 'bulk' => 550],
            ],
            // Apparel Type 3 (T-shirt)
            3 => [
                1 => ['base' => 500, 'bulk' => 350],
                2 => ['base' => 450, 'bulk' => 300],
                3 => ['base' => 600, 'bulk' => 400],
            ],
            // Apparel Type 4 (Hoodie)
            4 => [
                1 => ['base' => 800, 'bulk' => 600],
                2 => ['base' => 750, 'bulk' => 550],
                3 => ['base' => 900, 'bulk' => 700],
            ],
        ];

        return $pricingMatrix[$apparelType][$productionType] ?? ['base' => 500, 'bulk' => 350];
    }
}
