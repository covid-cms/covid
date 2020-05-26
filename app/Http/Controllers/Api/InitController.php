<?php

namespace App\Http\Controllers\Api;

use Auth;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Covid\Base\Models\User;
use Covid\Base\Format\UserFormat;
use Validator;
use Illuminate\Http\Request;

class InitController extends Controller
{
    public function index()
    {
        $account = null;

        if (Auth::check()) {
            $account = Auth::user()->format(UserFormat::DETAIL);
        }

        return response()->json([
            'error' => false,
            'data' => [
                'account' => $account,
            ]
        ]);
    }
}
