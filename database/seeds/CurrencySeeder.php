<?php

use Illuminate\Database\Seeder;

use App\Currency;
use App\Http\Services\Curl;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $endpoint = env('CURRENCY_API_ENDPOINT').'symbols?access_key='.env('CURRENCY_API_KEY');
        $curl = new Curl($endpoint);
        $result = $curl->get();

        foreach ($result['symbols'] as $key => $country) {
            Currency::create([
                'currency' => $key,
                'country' => $country
            ]);
        }
    }
}
