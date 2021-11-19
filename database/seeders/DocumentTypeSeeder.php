<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DocumentType;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;


class DocumentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::transaction(function () {

            DocumentType::create([
                'name' => 'Payment Voucher',
                'prefix' => 'PV',
                'company_id' => session('company_id'),
            ]);
            DocumentType::create([
                'name' => 'Invoice Voucher',
                'prefix' => 'IV',
                'company_id' => session('company_id'),
            ]);
            DocumentType::create([
                'name' => 'Journal Voucher',
                'prefix' => 'JV',
                'company_id' => session('company_id'),
            ]);
            DocumentType::create([
                'name' => 'Reciept Voucher',
                'prefix' => 'RV',
                'company_id' => session('company_id'),
            ]);
            DocumentType::create([
                'name' => 'GatePass Voucher',
                'prefix' => 'GV',
                'company_id' => session('company_id'),
            ]);
        });

        return Redirect::back();
    }
}
