<?php
    namespace App\Services;

    use App\Models\User;

    class UserService
    {
        public function authenticate($data = null) 
        {
            return User::authenticate($data);        
        }
    }