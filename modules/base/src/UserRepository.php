<?php

namespace Covid\Base;

use Hash;
use Covid\Base\Models\User as UserModel;
use Covid\Framework\Model\Repository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;
use Validator;

class UserRepository extends Repository
{
    protected function define()
    {
        $this->model = UserModel::class;
    }

    protected function validateUpdateData(UserModel $user, array $data)
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
