<?php

namespace App\Http\Controllers;

class PaymentWidgetController extends Controller
{
    public function index(int $client_id, int $summa)
    {
        return view('payment_widget.index', compact('summa', 'client_id'));
    }
}
