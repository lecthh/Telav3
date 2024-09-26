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
