<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        $suppliers = [
            [
                'name' => 'PT Elektronik Rexxa', // Elektronik
                'address' => 'Jl. Industri No. 10, Jakarta',
                'phone' => '021-5551234',
                'email' => 'contact@sumberelektronik.co.id',
            ],
            [
                'name' => 'CV Busana Nusantara', // Pakaian
                'address' => 'Jl. Raya Bandung No. 25, Bandung',
                'phone' => '022-5556789',
                'email' => 'info@busananusantara.co.id',
            ],
            [
                'name' => 'PT Sumber Pangan Jaya', // Makanan
                'address' => 'Jl. Diponegoro No. 5, Surabaya',
                'phone' => '031-5559876',
                'email' => 'sales@sumberpangan.co.id',
            ],
            [
                'name' => 'CV Alat Tulis Mandiri', // Alat Tulis Kantor
                'address' => 'Jl. Sudirman No. 88, Semarang',
                'phone' => '024-5553321',
                'email' => 'order@atkmandiri.co.id',
            ],
            [
                'name' => 'PT Perabot Rumah Sentosa', // Perabotan Rumah Tangga
                'address' => 'Jl. Gatot Subroto No. 45, Yogyakarta',
                'phone' => '0274-5557788',
                'email' => 'cs@perabotsentosa.co.id',
            ],
        ];

        foreach ($suppliers as $supplier) {
            Supplier::updateOrCreate(
                ['name' => $supplier['name']],
                $supplier
            );
        }
    }
}