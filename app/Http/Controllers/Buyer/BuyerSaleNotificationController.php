<?php

namespace App\Http\Controllers\Buyer;

use App\Sale;
use App\User;
use App\Buyer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Notifications\NewOrder;
use App\Notifications\OrderPlaced;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Notification;

class BuyerSaleNotificationController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Buyer $buyer, Sale $sale)
    {
        retry(5, function() use ($buyer, $sale) {
           $buyer->notify(new OrderPlaced($sale));
        }, 100);

        $users = User::where('admin', 'true')->get();
        retry(5, function() use ($users, $sale) {
           Notification::send($users, new NewOrder($sale));
        }, 100);
    }
}
