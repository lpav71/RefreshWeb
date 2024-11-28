<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class StoreOperationType extends Model
{
    use HasFactory;

    protected $table      = 'store_operation_type';
    public    $timestamps = false;

    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        return DB::table('store_operation_type')->get();
    }
}
