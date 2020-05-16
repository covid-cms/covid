<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;
use Validator;
use App\Http\Controllers\Controller;
use App\Format\UserFormat;
use Auth;

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
