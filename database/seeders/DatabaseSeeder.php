<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        DB::table('apparel_types')->insert([
            [
                'name' => 'Jersey',
                'img' => 'imgs/apparelCategory/jersey.png',
            ],
            [
                'name' => 'Polo Shirt',
                'img' => 'imgs/apparelCategory/poloshirt.png',
            ],
            [
                'name' => 'T-shirt',
                'img' => 'imgs/apparelCategory/tshirt.png',
            ],
            [
                'name' => 'Hoodie',
                'img' => 'imgs/apparelCategory/hoodie.png',
            ],
        ]);

        DB::table('production_types')->insert([
            // [
            //     'name' => 'Screen Printing',
            // ],
            // [
            //     'name' => 'Direct to Garment',
            // ],
            [
                'name' => 'Sublimation',
                'img' => 'imgs/productionType/sublimation.png',
            ],
            [
                'name' => 'Heat Transfer',
                'img' => 'imgs/productionType/heat.png',
            ],
            [
                'name' => 'Embroidery',
                'img' => 'imgs/productionType/embroidery.png',
            ],
        ]);

        DB::table('production_companies')->insert([
            [
                'company_name' => 'EchoPoint Productions',
                'company_logo' => 'imgs/companyLogo/random.png',
                'production_type' => json_encode([1, 2, 3]),
                'address' => '1234 Main St, City, State, 12345',
                'phone' => '123-456-7890',
                'avg_rating' => 4.5,
                'apparel_type' => json_encode([1, 2, 3, 4]),
                'review_count' => 10,
            ],
            [
                'company_name' => 'Piku Prints',
                'company_logo' => 'imgs/companyLogo/pikuprint.png',
                'production_type' => json_encode([1, 2, 3]),
                'address' => '1234 Main St, City, State, 12345',
                'phone' => '123-456-7890',
                'avg_rating' => 4.5,
                'apparel_type' => json_encode([1, 2, 3, 4]),
                'review_count' => 10,
            ],
            [
                'company_name' => 'H & M',
                'company_logo' => 'imgs/companyLogo/hm.png',
                'production_type' => json_encode([1, 2, 3]),
                'address' => '1234 Main St, City, State, 12345',
                'phone' => '123-456-7890',
                'avg_rating' => 4.2,
                'apparel_type' => json_encode([1, 2, 3, 4]),
                'review_count' => 4,
            ],
            [
                'company_name' => 'Pull & Bear',
                'company_logo' => 'imgs/companyLogo/pb.png',
                'production_type' => json_encode([1, 2, 3]),
                'address' => '1234 Main St, City, State, 12345',
                'phone' => '123-456-7890',
                'apparel_type' => json_encode([1, 2, 3, 4]),
                'avg_rating' => 3,
                'review_count' => 8,
            ],
            [
                'company_name' => 'EchoPoint Productions',
                'company_logo' => 'imgs/companyLogo/random.png',
                'production_type' => json_encode([1, 2, 3]),
                'address' => '1234 Main St, City, State, 12345',
                'phone' => '123-456-7890',
                'avg_rating' => 4.5,
                'apparel_type' => json_encode([1, 2, 3, 4]),
                'review_count' => 10,
            ],
            [
                'company_name' => 'Pull & Bear',
                'company_logo' => 'imgs/companyLogo/pb.png',
                'production_type' => json_encode([1, 2, 3]),
                'address' => '1234 Main St, City, State, 12345',
                'phone' => '123-456-7890',
                'avg_rating' => 3,
                'apparel_type' => json_encode([1, 2, 3, 4]),
                'review_count' => 8,
            ],
            [
                'company_name' => 'Piku Prints',
                'company_logo' => 'imgs/companyLogo/pikuprint.png',
                'production_type' => json_encode([1, 2, 3]),
                'address' => '1234 Main St, City, State, 12345',
                'phone' => '123-456-7890',
                'avg_rating' => 4.5,
                'apparel_type' => json_encode([1, 2, 3, 4]),
                'review_count' => 10,
            ],
            [
                'company_name' => 'H & M',
                'company_logo' => 'imgs/companyLogo/hm.png',
                'production_type' => json_encode([1, 2, 3]),
                'address' => '1234 Main St, City, State, 12345',
                'phone' => '123-456-7890',
                'avg_rating' => 4.2,
                'apparel_type' => json_encode([1, 2, 3, 4]),
                'review_count' => 4,
            ],
        ]);
    }
}
