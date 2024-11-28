<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Cashbox;
use Illuminate\Http\Request;

class HistoryDepositsController extends Controller
{
    protected Cashbox $cashbox;

    /**
     * @param Cashbox $cashboxModel
     */
    public function __construct(Cashbox $cashbox)
    {
        $this->cashbox = $cashbox;
    }

    public function getDeposits(Request $request)
    {
        $club_id = $request->club_id;

        return $this->cashbox->getCashBoxCollection($club_id);
    }


}
