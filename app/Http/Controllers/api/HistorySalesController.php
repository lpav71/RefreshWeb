<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Cashbox;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class HistorySalesController extends Controller
{
    protected Cashbox $cashbox;

    /**
     * @param Cashbox $cashbox
     */
    public function __construct(Cashbox $cashbox)
    {
        $this->cashbox = $cashbox;
    }

    public function getsales(Request $request)
    {
        $club_id = $request->club_id;
        return $this->cashbox->getsalesCashBox($club_id);
    }

    public function sale(Request $request): Collection
    {
        $id = $request->id;
        return $this->cashbox->saleCashBox($id);
    }
}
