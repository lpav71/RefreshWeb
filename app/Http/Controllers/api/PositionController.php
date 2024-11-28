<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Position;
use App\Models\User;
use App\Models\UserSetting;
use App\Providers\UserCommon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class PositionController extends Controller
{
    protected UserSetting $userSetting;
    protected User        $user;
    protected UserCommon  $userCommon;
    protected Position    $position;

    /**
     * @param UserSetting $userSetting
     * @param User $user
     * @param Position $position
     */
    public function __construct(UserSetting $userSetting, User $user, UserCommon $userCommon, Position $position)
    {
        $this->userSetting = $userSetting;
        $this->user        = $user;
        $this->userCommon  = $userCommon;
        $this->position    = $position;
    }


    public function getPermisions(Request $request)
    {
        $permissions = UserCommon::getPermissions($request->user_id, $request->club_id);
        return $permissions;
    }

    public function getUsers(Request $request)
    {
        $club_id = $request->club_id;
        return $this->user->getUserAndPosition($club_id);
    }

    public function getPositions(Request $request)
    {
        $club_id = $request->club_id;
        return $this->position->getAllPositions($club_id);
    }

    public function SendInvitation(Request $request)
    {
        $club_id         = $request->club_id;
        $email           = $request->email;
        $rate            = $request->rate;
        $rate_percent    = $request->rate_percent;
        $work_experience = $request->work_experience;

        $userSettings  = $this->userSetting->addUserSetting($email, $club_id, $work_experience, $rate, $rate_percent);
        $idUserSetting = $userSettings->id;
        $url           = URL::temporarySignedRoute('registration', now()->addMinutes(60), ['idUserSetting' => $idUserSetting, 'email' => $email]);

        $body     = [
            "cmd"   => "sendmail",
            "email" => $email,
            "link"  => $url
        ];
        $bobyJson = json_encode($body);
        $curl     = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL            => 'http://45.135.165.89:8082',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING       => '',
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_TIMEOUT        => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => 'POST',
            CURLOPT_POSTFIELDS     => $bobyJson,
            CURLOPT_HTTPHEADER     => [
                'Content-Type: application/json'
            ],
        ]);
        $response = curl_exec($curl);
        curl_close($curl);
        return [
            'status' => 'OK'
        ];
    }
}
