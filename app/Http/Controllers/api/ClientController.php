<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Club;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    public function register(Request $request)
    {
        $login = $request->login;
        $pass = $request->pass;
        $lastName = $request->lastName;
        $firstName = $request->firstName;
        $patronymic = $request->patronymic;
        $bday = $request->bday;
        $phone = $request->phone;
        $address = $request->address;
        $email = $request->email;
        $vkId = $request->vkId;
        $club_id = $request->club_id;

        $apiKey = Club::where('id', $club_id)->first()->api_key;

        $fields = array(
            "login" => $login,
            "password" => $pass,
            "role" => "user",
            "phone" => $phone,
            "email" => $email,
            "icon" => "",
            "fullName" => $firstName." ".$lastName." ".$patronymic,
            "amount" => 0,
            "bonus" => 0,
            "totalTime" => 0,
            "statusActive" => true,
            "telegramId" => "string",
            "vkId" => $vkId,
            "bDay" => $bday,
            "verify" => true,
            "verifyDt" => null,
            "name" => $firstName,
            "surName" => $lastName,
            "middleName" => $patronymic,
            "apiKey" => $apiKey
        );
        $fieldsJson = json_encode($fields);
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://194.87.144.7:6150/api/clients/register',
            //CURLOPT_URL => 'https://localhost:7161/api/clients/register',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $fieldsJson,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0
        ));

        $response = curl_exec($curl);
        if (curl_errno($curl)) {
            $error_msg = curl_error($curl);
        }
        $info = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        return $info;
    }

    public function getClients(Request $request)
    {
        $clientData = DB::table('clients')
            ->where('club_id', $request->club_id)
            ->get();
        return $clientData;
    }
}
