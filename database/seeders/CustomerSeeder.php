<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\AddressInformation;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = [
            [
                'user_id' => Str::uuid()->toString(),
                'name' => 'John Smith',
                'email' => 'john.smith@example.com',
                'password' => Hash::make('password123'),
                'role_type_id' => 1, // Customer
                'address' => [
                    'address' => '123 Main St',
                    'state' => 'California',
                    'city' => 'Los Angeles',
                    'zip_code' => '90001',
                    'phone_number' => '555-123-4567',
                ],
            ],
            [
                'user_id' => Str::uuid()->toString(),
                'name' => 'Sarah Johnson',
                'email' => 'sarah.johnson@example.com',
                'password' => Hash::make('password123'),
                'role_type_id' => 1, // Customer
                'address' => [
                    'address' => '456 Elm St',
                    'state' => 'New York',
                    'city' => 'New York',
                    'zip_code' => '10001',
                    'phone_number' => '555-987-6543',
                ],
            ],
            [
                'user_id' => Str::uuid()->toString(),
                'name' => 'Michael Chen',
                'email' => 'michael.chen@example.com',
                'password' => Hash::make('password123'),
                'role_type_id' => 1, // Customer
                'address' => [
                    'address' => '789 Oak St',
                    'state' => 'Texas',
                    'city' => 'Austin',
                    'zip_code' => '78701',
                    'phone_number' => '555-456-7890',
                ],
            ],
            [
                'user_id' => Str::uuid()->toString(),
                'name' => 'Jessica Patel',
                'email' => 'jessica.patel@example.com',
                'password' => Hash::make('password123'),
                'role_type_id' => 1, // Customer
                'address' => [
                    'address' => '101 Pine St',
                    'state' => 'Florida',
                    'city' => 'Miami',
                    'zip_code' => '33101',
                    'phone_number' => '555-789-0123',
                ],
            ],
            [
                'user_id' => Str::uuid()->toString(),
                'name' => 'David Lee',
                'email' => 'david.lee@example.com',
                'password' => Hash::make('password123'),
                'role_type_id' => 1, // Customer
                'address' => [
                    'address' => '202 Maple St',
                    'state' => 'Illinois',
                    'city' => 'Chicago',
                    'zip_code' => '60601',
                    'phone_number' => '555-234-5678',
                ],
            ],
            [
                'user_id' => Str::uuid()->toString(),
                'name' => 'Alexis Customer',
                'email' => 'dev.lecth@gmail.com',
                'password' => Hash::make('password123'),
                'role_type_id' => 1, // Customer
                'address' => [
                    'address' => 'Honey St',
                    'state' => 'Cebu',
                    'city' => 'Cebu City',
                    'zip_code' => '6000',
                    'phone_number' => '534-254-5628',
                ],
            ],
        ];

        foreach ($customers as $customer) {
            $address = $customer['address'];
            unset($customer['address']);
            
            $user = User::create($customer);
            
            AddressInformation::create([
                'user_id' => $user->user_id,
                'address' => $address['address'],
                'state' => $address['state'],
                'city' => $address['city'],
                'zip_code' => $address['zip_code'],
                'phone_number' => $address['phone_number'],
            ]);
        }
    }
}
