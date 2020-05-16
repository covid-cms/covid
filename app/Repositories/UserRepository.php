<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\ModelRepository;
use Illuminate\Database\Eloquent\Model;
use Hash;
use Illuminate\Validation\ValidationException;
use Validator;

class UserRepository extends ModelRepository
{
    protected function define()
    {
        $this->model = User::class;
    }

    protected function validateUpdateData(User $user, array $data)
    {
        $validator = Validator::make($data, [
            'name' => 'sometimes|required|string',
            'password' => 'sometimes|required|string|min:6'
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }

    public function update(Model $user, array $data)
    {
        $this->validateUpdateData($user, $data);

        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        if (!empty($data['name'])) {
            $user->name = $data['name'];
        }

        return $user->save();
    }
}
