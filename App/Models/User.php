<?php
    namespace App\Models;

    class User
    {
        private static $table = 'usuario';

        public static function authenticate($data){
            $connPdo = new \PDO(DBDRIVE.': host='.DBHOST.'; dbname='.DBNAME, DBUSER, DBPASS);
            $sql = 'SELECT us_nome FROM '.self::$table.' WHERE us_nome = :login';
            $stmt = $connPdo->prepare($sql);
            $stmt->bindValue(':login', $data['login']);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return $stmt->fetch(\PDO::FETCH_ASSOC);
            } else {
                throw new \Exception("Nenhum usuário encontrado!");
            }
        }
    }