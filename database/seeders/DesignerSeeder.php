<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\ProductionCompany;
use App\Models\Designer;

class DesignerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // First, we'll create independent designers (freelancers)
        $independentDesigners = [
            [
                'user' => [
                    'user_id' => Str::uuid()->toString(),
                    'name' => 'Alex Rivera',
                    'email' => 'alex.rivera@example.com',
                    'password' => Hash::make('designer123'),
                    'role_type_id' => 3, // Designer Admin
                ],
                'designer' => [
                    'is_freelancer' => true,
                    'is_available' => true,
                    'production_company_id' => null,
                    'talent_fee' => 1500.00,
                    'max_free_revisions' => 3,
                    'addtl_revision_fee' => 250.00,
                    'designer_description' => 'Specialized in modern, minimalist designs for sports apparel with 5+ years experience.',
                    'order_history' => json_encode(78), // Convert to JSON
                    'average_rating' => 4.8,
                    'review_count' => 65,
                    'is_verified' => true,
                ],
            ],
            [
                'user' => [
                    'user_id' => Str::uuid()->toString(),
                    'name' => 'Morgan Taylor',
                    'email' => 'morgan.taylor@example.com',
                    'password' => Hash::make('designer123'),
                    'role_type_id' => 3, // Designer Admin
                ],
                'designer' => [
                    'is_freelancer' => true,
                    'is_available' => true,
                    'production_company_id' => null,
                    'talent_fee' => 1200.00,
                    'max_free_revisions' => 2,
                    'addtl_revision_fee' => 200.00,
                    'designer_description' => 'Creative designer with a background in illustration, specializing in unique, eye-catching designs for casual wear.',
                    'order_history' => json_encode(56), // Convert to JSON
                    'average_rating' => 4.7,
                    'review_count' => 48,
                    'is_verified' => true,
                ],
            ],
        ];

        foreach ($independentDesigners as $designer) {
            $user = User::create($designer['user']);
            
            $designer['designer']['user_id'] = $user->user_id;
            Designer::create($designer['designer']);
        }

        // Now, we'll create designers associated with production companies
        // First, get all production companies
        $productionCompanies = ProductionCompany::all();

        $companyDesigners = [
            // Elite Prints designers
            [
                'user' => [
                    'user_id' => Str::uuid()->toString(),
                    'name' => 'Jasmine Wong',
                    'email' => 'jasmine.wong@eliteprints.com',
                    'password' => Hash::make('designer123'),
                    'role_type_id' => 3, // Designer Admin
                ],
                'designer' => [
                    'is_freelancer' => false,
                    'is_available' => true,
                    'company_name' => 'Elite Prints Inc.',
                    'talent_fee' => 0.00, // Part of company
                    'max_free_revisions' => 3,
                    'addtl_revision_fee' => 0.00,
                    'designer_description' => 'Senior designer at Elite Prints specializing in sports jerseys and team apparel.',
                    'order_history' => json_encode(112), // Convert to JSON
                    'average_rating' => 4.9,
                    'review_count' => 95,
                    'is_verified' => true,
                ],
            ],
            [
                'user' => [
                    'user_id' => Str::uuid()->toString(),
                    'name' => 'Marcus Johnson',
                    'email' => 'marcus.johnson@eliteprints.com',
                    'password' => Hash::make('designer123'),
                    'role_type_id' => 3, // Designer Admin
                ],
                'designer' => [
                    'is_freelancer' => false,
                    'is_available' => true,
                    'company_name' => 'Elite Prints Inc.',
                    'talent_fee' => 0.00, // Part of company
                    'max_free_revisions' => 2,
                    'addtl_revision_fee' => 0.00,
                    'designer_description' => 'Graphic designer with a talent for bold, colorful designs for custom apparel.',
                    'order_history' => json_encode(87), // Convert to JSON
                    'average_rating' => 4.7,
                    'review_count' => 72,
                    'is_verified' => true,
                ],
            ],
            
            // ThreadCraft designers
            [
                'user' => [
                    'user_id' => Str::uuid()->toString(),
                    'name' => 'Emma Rodriguez',
                    'email' => 'emma.rodriguez@threadcraft.com',
                    'password' => Hash::make('designer123'),
                    'role_type_id' => 3, // Designer Admin
                ],
                'designer' => [
                    'is_freelancer' => false,
                    'is_available' => true,
                    'company_name' => 'ThreadCraft Studios',
                    'talent_fee' => 0.00, // Part of company
                    'max_free_revisions' => 3,
                    'addtl_revision_fee' => 0.00,
                    'designer_description' => 'Embroidery specialist with extensive experience in creating detailed designs for various apparel types.',
                    'order_history' => json_encode(145), // Convert to JSON
                    'average_rating' => 4.8,
                    'review_count' => 132,
                    'is_verified' => true,
                ],
            ],
            
            // Fusion Apparel designers
            [
                'user' => [
                    'user_id' => Str::uuid()->toString(),
                    'name' => 'Liam Patel',
                    'email' => 'liam.patel@fusionapparel.com',
                    'password' => Hash::make('designer123'),
                    'role_type_id' => 3, // Designer Admin
                ],
                'designer' => [
                    'is_freelancer' => false,
                    'is_available' => true,
                    'company_name' => 'Fusion Apparel Manufacturing',
                    'talent_fee' => 0.00, // Part of company
                    'max_free_revisions' => 5,
                    'addtl_revision_fee' => 0.00,
                    'designer_description' => 'Lead designer at Fusion Apparel with expertise in all production methods and apparel types.',
                    'order_history' => json_encode(203), // Convert to JSON
                    'average_rating' => 4.9,
                    'review_count' => 187,
                    'is_verified' => true,
                ],
            ],
            [
                'user' => [
                    'user_id' => Str::uuid()->toString(),
                    'name' => 'Sophia Kim',
                    'email' => 'sophia.kim@fusionapparel.com',
                    'password' => Hash::make('designer123'),
                    'role_type_id' => 3, // Designer Admin
                ],
                'designer' => [
                    'is_freelancer' => false,
                    'is_available' => true,
                    'company_name' => 'Fusion Apparel Manufacturing',
                    'talent_fee' => 0.00, // Part of company
                    'max_free_revisions' => 4,
                    'addtl_revision_fee' => 0.00,
                    'designer_description' => 'Fashion-forward designer specializing in trendy apparel designs for all types of garments.',
                    'order_history' => json_encode(176), // Convert to JSON
                    'average_rating' => 4.8,
                    'review_count' => 158,
                    'is_verified' => true,
                ],
            ],
        ];

        foreach ($companyDesigners as $designer) {
            $user = User::create($designer['user']);
            
            // Find the production company by name
            $company = $productionCompanies->where('company_name', $designer['designer']['company_name'])->first();
            
            if ($company) {
                $designer['designer']['user_id'] = $user->user_id;
                $designer['designer']['production_company_id'] = $company->id;
                unset($designer['designer']['company_name']);
                
                Designer::create($designer['designer']);
            }
        }
    }
}
