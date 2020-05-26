<?php

namespace App\Http\Controllers\Api;

use Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Account\ChangePasswordRequest;
use App\Http\Requests\Api\Account\UpdateRequest;
use Covid\Base\Format\UserFormat;
use Covid\Base\User as UserRepository;
use Illuminate\Validation\ValidationException;

class AccountController extends Controller
{
    protected $userRepo;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function show()
    {
        return response()->json([
            'error' => false,
            'data' => [
                'account' => Auth::user()->format(UserFormat::DETAIL),
            ]
        ]);
    }

    public function update(UpdateRequest $request)
    {
        $standardizedData = $request->standardize()->all();

        try {
            $this->userRepo->update(Auth::user(), $standardizedData);
        } catch (ValidationException $exception) {
            return response()->json([
                'error' => true,
                'errors' => $exception->errors(),
            ]);
        }

        return response()->json([
            'error' => false,
            'data' => [
                'account' => Auth::user()->format(UserFormat::STANDARD)
            ]
        ]);
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $standardizedData = $request->standardize()->all();

        try {
            $this->userRepo->update(Auth::user(), $standardizedData);
        } catch (ValidationException $exception) {
            return response()->json([
                'error' => true,
                'errors' => $exception->errors(),
            ]);
        }

        return response()->json([
            'error' => false,
            'data' => [
                'account' => Auth::user()->format(UserFormat::STANDARD)
            ]
        ]);
    }
}
