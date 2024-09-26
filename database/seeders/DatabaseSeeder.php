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

        DB::table('role_types')->insert([
            [
                'role_name' => 'Customer',
            ],
            [
                'role_name' => 'Production Company Admin',
            ],
            [
                'role_name' => 'Designer Admin',
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
                'email' => 'test1@gmail.com',
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
                'email' => 'test2@gmail.com',
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
                'email' => 'test3@gmail.com',
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
                'email' => 'test4@gmail.com',
                'apparel_type' => json_encode([1, 2, 3, 4]),
                'avg_rating' => 3,
                'review_count' => 8,
            ],
            [
                'company_name' => 'EchoPoints Productions',
                'company_logo' => 'imgs/companyLogo/random.png',
                'production_type' => json_encode([1, 2, 3]),
                'address' => '1234 Main St, City, State, 12345',
                'phone' => '123-456-7890',
                'avg_rating' => 4.5,
                'email' => 'test5@gmail.com',
                'apparel_type' => json_encode([1, 2, 3, 4]),
                'review_count' => 10,
            ],
            [
                'company_name' => 'Pulls & Bear',
                'company_logo' => 'imgs/companyLogo/pb.png',
                'production_type' => json_encode([1, 2, 3]),
                'address' => '1234 Main St, City, State, 12345',
                'phone' => '123-456-7890',
                'email' => 'test6@gmail.com',
                'avg_rating' => 3,
                'apparel_type' => json_encode([1, 2, 3, 4]),
                'review_count' => 8,
            ],
            [
                'company_name' => 'Pikus Prints',
                'company_logo' => 'imgs/companyLogo/pikuprint.png',
                'production_type' => json_encode([1, 2, 3]),
                'address' => '1234 Main St, City, State, 12345',
                'phone' => '123-456-7890',
                'email' => 'test7@gmail.com',
                'avg_rating' => 4.5,
                'apparel_type' => json_encode([1, 2, 3, 4]),
                'review_count' => 10,
            ],
            [
                'company_name' => 'H s& M',
                'company_logo' => 'imgs/companyLogo/hm.png',
                'production_type' => json_encode([1, 2, 3]),
                'address' => '1234 Main St, City, State, 12345',
                'phone' => '123-456-7890',
                'email' => 'test8@gmail.com',
                'avg_rating' => 4.2,
                'apparel_type' => json_encode([1, 2, 3, 4]),
                'review_count' => 4,
            ],
        ]);
        DB::table('order_statuses')->insert([
            ['name' => 'Order Placed'],
            ['name' => 'Design in Progress'],
            ['name' => 'Finalize Order'],
            ['name' => 'Awaiting Printing'],
            ['name' => 'Printing in Progress'],
            ['name' => 'Ready for Collection'],
        ]);
        DB::table('order_image_statuses')->insert([
            ['name' => 'Initial Design'],
            ['name' => 'Designer Design'],
            ['name' => 'Revision'],
            ['name' => 'Final Design'],
        ]);
    }
}
