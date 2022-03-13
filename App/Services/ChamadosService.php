<?php
    namespace App\Services;

    use App\Models\Chamado;

    class ChamadosService
    {
        public function get($id = null) 
        {
            if ($id) {
                return Chamado::select($id);
            } else {
                return Chamado::selectAll();
            }
        }

        public function post() 
        {
            $data = $_POST;

            return Chamado::insert($data);
        }
    }