<?php
    namespace App\Services;

    use App\Models\User;

    class AuthService
    {
        public function post() 
        {
            $data = $_POST;
            return User::authenticate($data);          
        }
    }

    