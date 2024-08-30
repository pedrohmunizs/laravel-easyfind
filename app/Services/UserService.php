<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    private $model;

    public function __construct(User $user) {
        $this->model = $user;
    }

    public function store($data, $id = null)
    {
        if($id){
            $user = $this->model::find($id);
        }else{
            $user = $this->model;
            $user->password = Hash::make($data['password']);
            $user->type = $data['type'];
        }

        $user->fill($data);
        $user->save();

        return $user;
    }

    public function destroy($id)
    {
        $user = $this->model::find($id);
        $user->delete();
    }
}