<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = ['Pending', 'Packing', 'Delivery', 'Delivered', 'Canceled'];

        foreach ($statuses as $status) {
            DB::table('orders')->insert(['status' => $status]);
        }
    }
}
