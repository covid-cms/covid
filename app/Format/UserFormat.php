<?php

namespace App\Format;

use App\Format\ModelFormat;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class UserFormat extends ModelFormat
{
    const LITE = 'lite';
    const STANDARD = 'standard';

    public static function format($type, Model $user, array $options = [])
    {
        if ($type == static::LITE) {
            return static::formatLite($user);
        }

        if ($type == static::STANDARD) {
            return static::formatStd($user);
        }
    }

    protected static function formatLite(User $user)
    {
        return [
            'id' => $user->id,
            'email' => $user->email,
            'name' => $user->name,
        ];
    }

    protected static function formatStd(User $user)
    {
        return [
            'id' => $user->id,
            'email' => $user->email,
            'name' => $user->name,
        ];
    }
}
