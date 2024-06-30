<?php

namespace App\Services;

use App\Models\User;
use App\Models\Usuario;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function store($usuario){
        try{
            $user = new User();
            $user->fill($usuario);
            $user->password = Hash::make($usuario['password']);
            $user->save();
            return $user;
        }catch(QueryException $e){
            if($e->errorInfo[1] == 1062) {
                throw new Exception('O email informado já está em uso.', 409);
            }
        }
    }
}