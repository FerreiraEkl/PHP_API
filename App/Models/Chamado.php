<?php
    namespace App\Models;

    class Chamado
    {
        private static $table = 'chamados';

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

        public static function selectAll($data) {
            $connPdo = new \PDO(DBDRIVE.': host='.DBHOST.'; dbname='.DBNAME, DBUSER, DBPASS);

            $limit = $data['pageSize'];

            $offset = ($data['page'] -1) * $limit;

            $sql = 'SELECT * FROM '.self::$table.' LIMIT '.$limit.' OFFSET '.$offset;
            $stmt = $connPdo->prepare($sql);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return $stmt->fetchAll(\PDO::FETCH_ASSOC);
            } else {
                throw new \Exception("Nenhum chamado encontrado!");
            }
        }

        public static function selectCountAll() {
            $connPdo = new \PDO(DBDRIVE.': host='.DBHOST.'; dbname='.DBNAME, DBUSER, DBPASS);

            $sql = 'SELECT COUNT(*) AS total FROM '.self::$table;
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

            $stmt->bindValue(':chamadoAssunto', $data['chamadoAssunto']);
            $stmt->bindValue(':chamadoDescricao', $data['chamadoDescricao']);
            $stmt->bindValue(':chamadoAlocar', $data['chamadoAlocar']);
            $stmt->bindValue(':chamadoPrazo', $data['chamadoPrazo']);
            $stmt->bindValue(':chamadoStatus', $data['chamadoStatus']);
            $stmt->bindValue(':chamadoDataDoAtendimento', $data['chamadoDataDoAtendimento']);
            $stmt->bindValue(':chamadoObservacoes', $data['chamadoObservacoes']);
            $stmt->bindValue(':chamadoLocalizacao', $data['chamadoLocalizacao']);
            $stmt->bindValue(':chamadoObservacaoFinal', $data['chamadoObservacaoFinal']);
            $stmt->bindValue(':chamadoComRetrabalho', $data['chamadoComRetrabalho']);
            $stmt->bindValue(':createdAt', $data['createdAt']);
            $stmt->bindValue(':updatedAt', $data['updatedAt']);
            $stmt->bindValue(':usuarioId', $data['usuarioId']);
            $stmt->bindValue(':atendenteId', $data['atendenteId']);
            $stmt->bindValue(':encerradorId', $data['encerradorId']);

            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return 'Chamado inserido com sucesso!';
            } else {
                throw new \Exception("Falha ao inserir chamado!");
            }
        }
    }
                                             