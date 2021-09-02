<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use Illuminate\Database\Eloquent\Collection;

class CurrencyController extends Controller
{
    /**
     * @param Currency $currency
     * @return Currency[]|Collection
     */
    public function index(Currency $currency)
    {
        return $currency->all();
    }

    public function show($id, Currency $currency)
    {
        return $currency->find($id) ?? abort(404);
    }
}
