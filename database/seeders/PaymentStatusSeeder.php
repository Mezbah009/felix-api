<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = ['Paid', 'Unpaid'];

        foreach ($statuses as $status) {
            DB::table('orders')->insert(['payment_status' => $status]);
        }
    }
}
