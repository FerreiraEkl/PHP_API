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
                $queryString = filter_input(INPUT_SERVER, 'QUERY_STRING');

                parse_str($queryString, $parseQueryString);

                $result['rows'] = Chamado::selectAll($parseQueryString);       
                $result['count'] =  Chamado::selectCountAll();

                return $result ;
            }
        }

        public function post() 
        {
            User::checkAuth();

            $data = $_POST;    

            return Chamado::insert($data);            
        }
    }