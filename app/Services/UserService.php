<?php

namespace App\Services;

use App\Models\Users;
use App\Models\Usuario;
use Exception;
use Illuminate\Database\QueryException;

class UserService
{
    public function store($usuario){
        try{
            $user = new Users();
            $user->fill($usuario);
            $user->save();
            return $user;
        }catch(QueryException $e){
            if($e->errorInfo[1] == 1062) {
                throw new Exception('O email informado já está em uso.', 409);
            }
        }
    }
}