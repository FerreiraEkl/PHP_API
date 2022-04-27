<?php
    namespace App\Models;

    use App\Models\Permissions;

    class User
    {
        private static $table = 'users';

        private static $key = '123456';

        // TODO: criptografar a senha antes de armazenar
        public static function authenticate($data){
            $connPdo = new \PDO(DBDRIVE.': host='.DBHOST.'; dbname='.DBNAME, DBUSER, DBPASS);
            $sql = 'SELECT userLogin FROM '.self::$table.' WHERE userLogin = :login and userPassword = :password';
            $stmt = $connPdo->prepare($sql);
            $stmt->bindValue(':login', $data['login']);
            $stmt->bindValue(':password', $data['password']);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $user = $stmt->fetch(\PDO::FETCH_ASSOC);

                //Header Token
                $header = [
                    'typ' => 'JWT',
                    'alg' => 'HS256'
                ];

                //Payload - Content
                $payload = $user;

                //JSON
                $header = json_encode($header);
                $payload = json_encode($payload);

                //Base 64
                $header = self::base64UrlEncode($header);
                $payload = self::base64UrlEncode($payload);

                //Sign
                $sign = hash_hmac('sha256', $header . "." . $payload, self::$key, true);
                $sign = self::base64UrlEncode($sign);

                //Token
                $token = 'bearer ' . $header . '.' . $payload . '.' . $sign;

                return $token;
            } else {
                throw new \Exception("Nenhum usuário encontrado!");
            }
        }

        public static function checkAuth()
        {
            $http_header = apache_request_headers();

            if (isset($http_header['Authorization']) && $http_header['Authorization'] != null) {
                $bearer = explode (' ', $http_header['Authorization']);
                $token = explode('.', $bearer[1]);
                $header = $token[0];
                $payload = base64_decode($token[1]);
                $sign = $token[2];

                //Conferir Assinatura
                $valid = hash_hmac('sha256', $header . "." . $payload, self::$key, true);
                $valid = self::base64UrlEncode($valid);
                
                $data = json_decode($payload);

                //if ($sign === $valid) {
                    $connPdo = new \PDO(DBDRIVE.': host='.DBHOST.'; dbname='.DBNAME, DBUSER, DBPASS);
                    $sql = 'SELECT id, userName FROM '.self::$table.' WHERE userLogin = :login';
                    $stmt = $connPdo->prepare($sql);
                    $stmt->bindValue(':login',  $data->userLogin);
                    $stmt->execute();

                    if ($stmt->rowCount() > 0) {
                        $user = $stmt->fetch(\PDO::FETCH_ASSOC);
                        $user['permissions'] = Permissions::getForUser($user['id']);
                        return $user;
                    }                    
                //}
            }

            throw new \Exception("Não authenticado!");
        }

        private static function base64UrlEncode($data)
        {
            $b64 = base64_encode($data);
            if ($b64 === false) {return false;}
            $url = strtr($b64, '+/', '-_');
            return rtrim($url, '=');
        }
    }