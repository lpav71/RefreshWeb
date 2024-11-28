<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Club;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SoundController extends Controller
{
    public function upload(Request $request)
    {
        $club_id = $request->club_id;
        $club    = Club::find($club_id);

        if ($club) {
            $sounds = [];

            for ($i = 1; $i <= 9; $i++) {
                $key = 'sound' . $i;
                if ($request->hasFile($key) && $request->file($key)->isValid()) {
                    // Сохраняем новый звук
                    $sounds[$key] = $request->file($key)->store('public/sounds');

                    // Удаляем старый звук, если он существует
                    $oldSound = $club->{$key};
                    if ($oldSound) {
                        Storage::delete($oldSound);
                    }
                }
            }

            // Обновляем клуб новыми звуками
            foreach ($sounds as $key => $sound) {
                $club->{$key} = $sound;
            }

            $club->save();

            return ['status' => 'OK'];
        }

        return response(['status' => 'Club not found'], 404);
    }
}
