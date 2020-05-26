<?php

namespace Covid\Base\Format;

use Covid\Framework\Model\Format;
use Covid\Base\Models\User;
use Illuminate\Database\Eloquent\Model;

class UserFormat extends Format
{
    const LITE = 'lite';
    const STANDARD = 'standard';
    const DETAIL = 'detail';

    public static function format($type, Model $user, array $options = [])
    {
        if ($type == static::LITE) {
            return static::formatLite($user);
        }

        if ($type == static::STANDARD) {
            return static::formatStd($user);
        }

        if ($type == static::DETAIL) {
            return static::formatDetail($user);
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

    protected static function formatDetail(User $user)
    {
        return [
            'id' => $user->id,
            'email' => $user->email,
            'name' => $user->name,
        ];
    }
}
