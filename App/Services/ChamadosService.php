<?php
    namespace App\Services;

    use App\Models\Chamado;

    use App\Models\User;

    class ChamadosService
    {
        public function get($id = null) 
        {
            User::checkAuth();
            
            if ($id) {
                return Chamado::select($id);
            } else {
                return Chamado::selectAll();
            }
        }

        public function post() 
        {
            User::checkAuth();

            $data = $_POST;    

            return Chamado::insert($data);            
        }
    }