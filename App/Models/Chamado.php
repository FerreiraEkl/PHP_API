<?php
    namespace App\Models;

    class Chamado
    {
        private static $table = 'chamado';

        public static function select(int $id) {
            $connPdo = new \PDO(DBDRIVE.': host='.DBHOST.'; dbname='.DBNAME, DBUSER, DBPASS);

            $sql = 'SELECT * FROM '.self::$table.' WHERE chamado_numero = :id';
            $stmt = $connPdo->prepare($sql);
            $stmt->bindValue(':id', $id);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return $stmt->fetch(\PDO::FETCH_ASSOC);
            } else {
                throw new \Exception("Nenhum chamado encontrado!");
            }
        }

        public static function selectAll() {
            $connPdo = new \PDO(DBDRIVE.': host='.DBHOST.'; dbname='.DBNAME, DBUSER, DBPASS);

            $sql = 'SELECT * FROM '.self::$table;
            $stmt = $connPdo->prepare($sql);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return $stmt->fetchAll(\PDO::FETCH_ASSOC);
            } else {
                throw new \Exception("Nenhum chamado encontrado!");
            }
        }

        public static function insert($data)
        {
            $connPdo = new \PDO(DBDRIVE.': host='.DBHOST.'; dbname='.DBNAME, DBUSER, DBPASS);

            // LISTANDO AS PROPRIEDADES DO OBJETO RECEBIDO
            $array = get_object_vars($data);
            $properties = array_keys($array);

            // PREPARANDO PARA ALTERAÇÃO
            $propertiesToInsert = [];
            $propertiesToReplace = [];

            // CONSTRUINDO VARIÁVEIS
            for ($i = 0; $i < count($properties); $i++) {
                $key = $properties[$i];
                array_push($propertiesToInsert, $key);
                array_push($propertiesToReplace, ':'.$key);            
            }

            // PREPARANDO SQL
            $sql = 'INSERT INTO '.self::$table.' '.$propertiesToInsert.' VALUES ('.$propertiesToReplace.')';

            // CRIANDO A CONEXÃO
            $stmt = $connPdo->prepare($sql);

            // PASSANDO OS PARâMETROS
            for ($i = 0; $i < count($properties); $i++) {
                $key = $properties[$i];
                $stmt->bindValue(':em', $data['email']);          
            }

            // EXECUTANDO SQL
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return 'Chamado inserido com sucesso!';
            } else {
                throw new \Exception("Falha ao inserir chamado!");
            }
        }
    }