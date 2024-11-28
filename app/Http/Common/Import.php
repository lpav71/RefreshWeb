<?php

namespace App\Http\Common;

use App\Models\Client;
use Carbon\Carbon;

class Import
{
    /**
     * @param bool $file
     * @param array $clientsFromFile
     * @param array $ids
     * @return array
     */
    public function readCSVFile(mixed $file, array &$clientsFromFile, array &$ids): array
    {
        while (($line = fgetcsv($file, 0, ';')) !== false) {
            $clientsFromFile[] = $line;
            $ids[]             = (int)$line[0];
        }
        return [$clientsFromFile, $ids];
    }

    /**
     * @param array $clientsFromFile
     * @param mixed $clients
     * @return void
     */
    public function insertNewRecords(array $clientsFromFile, mixed $clients): void
    {
        foreach ($clientsFromFile as $clientFromFile) {
            if (!$clients->contains($clientFromFile[0])) {
                // Создание нового клиента на основе данных из $clientFromFile
                $group_create = $clientFromFile[24] ?? null;
                if ($group_create != '') {
                    $group_create = Carbon::parse($clientFromFile[24]);
                }
                $client                = new Client;
                $client->club_id       = $clientFromFile[1];
                $client->login         = $clientFromFile[2];
                $client->password      = $clientFromFile[3];
                $client->phone         = $clientFromFile[4];
                $client->email         = $clientFromFile[5];
                $client->icon          = $clientFromFile[6];
                $client->amount        = (double)$clientFromFile[7];
                $client->bonus         = (double)$clientFromFile[8];
                $client->total_time    = $clientFromFile[9] != '' ? $clientFromFile[9] : 0;
                $client->full_name     = $clientFromFile[10];
                $client->status_active = $clientFromFile[11] == 1;
                $client->telegram_id   = $clientFromFile[12];
                $client->vk_id         = $clientFromFile[13];
                $client->reg_date      = $clientFromFile[14] == '' ? null : Carbon::parse($clientFromFile[14]);
                $client->bday          = $clientFromFile[15] == '' ? null : Carbon::parse($clientFromFile[15]);
                $client->verify        = $clientFromFile[16] == 1;
                $client->verify_dt     = $clientFromFile[17] == '' ? null : Carbon::parse($clientFromFile[17]);
                $client->name          = $clientFromFile[18];
                $client->surname       = $clientFromFile[19];
                $client->middle_name   = $clientFromFile[20];
                $client->group_id      = $clientFromFile[21];
                $client->group_amount  = $clientFromFile[22];
                $client->group_create  = $group_create;
                $client->save();
            }
        }
    }
}
