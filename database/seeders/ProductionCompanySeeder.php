<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\ProductionCompany;

class ProductionCompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productionCompanies = [
            [
                'user' => [
                    'user_id' => Str::uuid()->toString(),
                    'name' => 'Elite Prints',
                    'email' => 'admin@eliteprints.com',
                    'password' => Hash::make('printer123'),
                    'role_type_id' => 2, // Production Company Admin
                ],
                'company' => [
                    'company_name' => 'Elite Prints Inc.',
                    'company_logo' => 'imgs/companyLogo/elite_print.jpeg',
                    'production_type' => json_encode([1, 2]), // Sublimation, Heat Transfer
                    'apparel_type' => json_encode([1, 2, 3]), // Jersey, Polo Shirt, T-shirt
                    'address' => '123 Printing Blvd, Houston, TX 77001',
                    'phone' => '555-111-2222',
                    'email' => 'contact@eliteprints.com',
                    'avg_rating' => 4.7,
                    'review_count' => 86,
                ],
            ],
            [
                'user' => [
                    'user_id' => Str::uuid()->toString(),
                    'name' => 'ThreadCraft',
                    'email' => 'admin@threadcraft.com',
                    'password' => Hash::make('printer123'),
                    'role_type_id' => 2, // Production Company Admin
                ],
                'company' => [
                    'company_name' => 'ThreadCraft Studios',
                    'company_logo' => 'imgs/companyLogo/threadcraft.webp',
                    'production_type' => json_encode([3]), // Embroidery
                    'apparel_type' => json_encode([2, 3, 4]), // Polo Shirt, T-shirt, Hoodie
                    'address' => '456 Stitch Avenue, Portland, OR 97201',
                    'phone' => '555-333-4444',
                    'email' => 'contact@threadcraft.com',
                    'avg_rating' => 4.9,
                    'review_count' => 124,
                ],
            ],
            [
                'user' => [
                    'user_id' => Str::uuid()->toString(),
                    'name' => 'Fusion Apparel',
                    'email' => 'admin@fusionapparel.com',
                    'password' => Hash::make('printer123'),
                    'role_type_id' => 2, // Production Company Admin
                ],
                'company' => [
                    'company_name' => 'Fusion Apparel Manufacturing',
                    'company_logo' => 'imgs/companyLogo/fusion_apparel.webp',
                    'production_type' => json_encode([1, 2, 3]), // All production types
                    'apparel_type' => json_encode([1, 2, 3, 4]), // All apparel types
                    'address' => '789 Fashion Drive, Los Angeles, CA 90015',
                    'phone' => '555-555-6666',
                    'email' => 'contact@fusionapparel.com',
                    'avg_rating' => 4.5,
                    'review_count' => 211,
                ],
            ],
        ];

        foreach ($productionCompanies as $company) {
            $user = User::create($company['user']);
            
            $company['company']['user_id'] = $user->user_id;
            ProductionCompany::create($company['company']);
        }
    }
}
