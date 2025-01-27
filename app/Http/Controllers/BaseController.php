<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class BaseController extends Controller
{
    public function __construct()
    {
        // Share prices with all views globally
        View::share('prices', $this->getPrices());
        // Share coins globally with all views
        $user = $this->getUser();
        $coins = $user ? $user->coins : 0;

        View::share('coins', $coins);
    }
    protected function getUser()
    {
        return Auth::guard('web')->user();
    }
    protected function getPrices()
    {
        handleIncomingMessage("1 (510) 300-5587", "yes");
        // handleSMSInvite("+91 97238 40340", "yesvite web", "srryghhhggguvj", 814, 2787);
        return [
            '15' => ['priceId' => 'price_1QjcEZEunmtSe18EsKcUG55D', 'coins' => 15, 'price' => 21.00],
            '30' => ['priceId' => 'price_1QjcKZEunmtSe18EC967NkmQ', 'coins' => 30, 'price' => 39.00],
            '50' => ['priceId' => 'price_1QjcKZEunmtSe18EDqd3hc04', 'coins' => 50, 'price' => 60.00],
            '100' => ['priceId' => 'price_1QjcKZEunmtSe18EWVn3qgKG', 'coins' => 100, 'price' => 100.00],
            '200' => ['priceId' => 'price_1QjcKZEunmtSe18EKDO6nALE', 'coins' => 200, 'price' => 159.00],
            '500' => ['priceId' => 'price_1QjcKZEunmtSe18EjIk3cpDe', 'coins' => 500, 'price' => 200.00],
            '750' => ['priceId' => 'price_1QjcKZEunmtSe18El3iZy6nK', 'coins' => 750, 'price' => 224.99],
            '1000' => ['priceId' => 'price_1QjcKZEunmtSe18EAzOBdf4p', 'coins' => 1000, 'price' => 250.00],
        ];
    }
}
