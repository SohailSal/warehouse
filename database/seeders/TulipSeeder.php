<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Seeder;
use App\Models\AccountType;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Company;
use App\Models\Year;
use App\Models\Setting;

class TulipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::transaction(function () {
        //     $company = Company::create([
        //         'name' => 'TULIP INDUSTRIES',
        //         // 'address' => Request::input('address'),
        //         // 'email' => Request::input('email'),
        //         // 'web' => Request::input('web'),
        //         // 'phone' => Request::input('phone'),
        //         'fiscal' => 'June',
        //         // 'incorp' => Request::input('incorp'),
        //     ]);


        //     //Start Month & End Month
        //     $startMonth = Carbon::parse($company->fiscal)->month + 1;
        //     $endMonth = Carbon::parse($company->fiscal)->month;
        //     if ($startMonth == 13) {
        //         $startMonth = 1;
        //     }

        //     //Start Month Day & End Month Day
        //     $startMonthDays = 1;
        //     $endMonthDays = Carbon::create()->month($endMonth)->daysInMonth;

        //     // Year Get
        //     $today = Carbon::today();
        //     $startYear = 0;
        //     $endYear = 0;
        //     if ($startMonth == 1) {
        //         $startYear = $today->year;
        //         $endYear = $today->year;
        //     } else {
        //         $endYear = ($today->month >= $startMonth) ? $today->year + 1 : $today->year;
        //         $startYear = $endYear - 1;
        //     }


        //     $startDate = $startYear . '-' . '0' . $startMonth . '-' . $startMonthDays;
        //     $endDate = $endYear . '-' . '0' . $endMonth . '-' . $endMonthDays;


        //     $year = Year::create([
        //         'begin' => $startDate,
        //         'end' => $endDate,
        //         'company_id' => $company->id,
        //     ]);
        //     Setting::create([
        //         'key' => 'active_company',
        //         'value' => $company->id,
        //         'user_id' => Auth::user()->id,
        //     ]);

        //     Setting::create([
        //         'key' => 'active_year',
        //         'value' => $year->id,
        //         'user_id' => Auth::user()->id,
        //     ]);

        //     session(['company_id' => $company->id]);
        //     session(['year_id' => $year->id]);

        // });
    }
}
