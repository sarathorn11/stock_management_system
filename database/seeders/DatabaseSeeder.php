<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            SupplierSeeder::class,
            PurchaseOrderSeeder::class,
            ReceivingSeeder::class,
            BackOrderSeeder::class,
            ItemSeeder::class,
            PoItemSeeder::class,
            BoItemSeeder::class,
            StockSeeder::class,
            ReturnListSeeder::class,
            SaleSeeder::class,
        ]);
    }
}
