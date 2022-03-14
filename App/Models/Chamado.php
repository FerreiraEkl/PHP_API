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

            $sql = 'SELECT * FROM '.self::$table.' LIMIT 10';
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
            $sql = 'INSERT INTO '.self::$table.' (email, password, name) VALUES (:em, :pa, :na)';
            $stmt = $connPdo->prepare($sql);
            $stmt->bindValue(':em', $data['email']);
            $stmt->bindValue(':pa', $data['password']);
            $stmt->bindValue(':na', $data['name']);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return 'Chamado inserido com sucesso!';
            } else {
                throw new \Exception("Falha ao inserir chamado!");
            }
        }
    }

    // $connPdo = new \PDO(DBDRIVE.': host='.DBHOST.'; dbname='.DBNAME, DBUSER, DBPASS);

    //         // LISTANDO AS PROPRIEDADES DO OBJETO RECEBIDO
    //         // $array = get_object_vars($data);
    //         //$properties = array_keys($array);

    //         return $data

    //         // PREPARANDO PARA ALTERAÇÃO
    //         // $propertiesToInsert = '';
    //         // $propertiesToReplace = '';

    //         // // CONSTRUINDO VARIÁVEIS
    //         // for ($i = 0; $i < count($properties); $i++) {
    //         //     $key = $properties[$i];
    //         //     $propertiesToInsert = $propertiesToInsert + $key
    //         //     $propertiesToReplace = $propertiesToReplace + ':'.$key 
                
    //         //     if($i < (count($properties) -1)){
    //         //         $propertiesToInsert = $propertiesToInsert + ','
    //         //         $propertiesToReplace = $propertiesToReplace + ','
    //         //     }
    //         // }

    //         // return $propertiesToReplace

    //         // PREPARANDO SQL
    //         // $sql = 'INSERT INTO '.self::$table.' '.$propertiesToInsert.' VALUES ('.$propertiesToReplace.')';

    //         // // CRIANDO A CONEXÃO
    //         // $stmt = $connPdo->prepare($sql);

    //         // // PASSANDO OS PARâMETROS
    //         // for ($i = 0; $i < count($properties); $i++) {
    //         //     $key = $properties[$i];
    //         //     $stmt->bindValue(':'.$key, $data[$key]);          
    //         // }

    //         // // EXECUTANDO SQL
    //         // $stmt->execute();

    //         // if ($stmt->rowCount() > 0) {
    //         //     return 'Registro inserido com sucesso!';
    //         // } else {
    //         //     throw new \Exception("Falha ao inserir registro!");
    //         // }