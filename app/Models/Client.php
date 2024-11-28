<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class Client extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * @param Request $request
     * @return Collection
     */
    public function clients(int $club_id): Collection
    {
        return DB::table('clients')
                 ->where('club_id', '=', $club_id)
                 ->get();
    }

    public function clients2(int $club_id): Collection
    {
        return Client::where('club_id', $club_id)->get();
    }

    /**
     * @param mixed $user_id
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Query\Builder|object|null
     */
    public function login(mixed $user_id)
    {
        return DB::table('clients')
                 ->where('id', $user_id)
                 ->first('login');
    }

    /**
     * @param int $id
     * @return mixed
     */
    function getClientById(int $id)
    {
        return Client::where('id', $id)->first();
    }

    /**
     * @param array $ids
     * @return mixed
     */
    public function getAllClientsByIds(array $ids)
    {
        return Client::whereIn('id', $ids)->get();
    }

    /**
     * @param int $userId
     * @param float $summa
     * @return void
     */
    public function addAmount(int $client_id, float $summa)
    {
        $client         = $this->find($client_id);
        $client->amount += $summa;
        $client->save();
    }

    /**
     * @param mixed $login
     * @return mixed
     */
    public function getByLogin(mixed $login)
    {
        return Client::where('login', $login)->first();
    }

    /**
     * @param mixed $ageString
     * @return Collection
     */
    public function getAgeFilter(mixed $ageString): Collection
    {
        $ageRanges = [
            "0-12"   => ["<", 12],
            "12-16"  => [">=", 12, "<=", 16],
            "16-18"  => [">=", 16, "<=", 18],
            "18-24"  => [">=", 18, "<=", 24],
            "25-29"  => [">=", 25, "<=", 29],
            "30-999" => [">", 30],
        ];

        if (!isset($ageRanges[$ageString])) {
            return collect(); // Возвращаем пустую коллекцию, если фильтр не найден
        }

        $query = Client::query();

        if (count($ageRanges[$ageString]) == 2) {
            [$operator, $age] = $ageRanges[$ageString];
            $query->whereRaw("age(bday) $operator '$age years'");
        } else {
            [$startOperator, $startAge, $endOperator, $endAge] = $ageRanges[$ageString];
            $query->whereRaw("age(bday) $startOperator '$startAge years'")
                  ->whereRaw("age(bday) $endOperator '$endAge years'");
        }

        return $query->get();
    }
}
