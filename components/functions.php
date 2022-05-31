<?php

    function getAllMarque(): array
    {
        global $db;
        
        $query = <<<SQL
            SELECT marque.id, marque.name from marque
            LEFT JOIN moto ON marque.id = moto.marque_id
            WHERE moto.marque_id IS NOT NULL
            GROUP BY moto.marque_id
        SQL;

        $stmt = $db->query($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    function getAllType(): array
    {
        global $db;
        
        $query = <<<SQL
            SELECT type.id, type.name from type
            LEFT JOIN moto ON type.id = moto.type_id
            WHERE moto.type_id IS NOT NULL
            GROUP BY moto.type_id
        SQL;

        $stmt = $db->query($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    function getAllCylindre(): array
    {
        global $db;

        $query = <<<SQL
                SELECT cylindre_global from moto
                GROUP BY cylindre_global
            SQL;

        $stmt = $db->query($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    function getCardMoto(string $order = null, int $limit = null, string $type = null, string $marque = null, string $cylindreGlobal = null): ?array
    {
        global $db;

        $query = <<<SQL
            SELECT moto.id, moto.name, moto.released_in, moto.price, moto.thumbnail, marque.name as marque
            FROM moto
            LEFT JOIN marque ON marque.id = moto.marque_id
            LEFT JOIN type ON type.id = moto.type_id
        SQL;


        $clauses = [];

        if($type){
            $clauses[] = " moto.type_id = :type ";
        }

        if ($marque) {
            $clauses[] = " moto.marque_id = :marque ";
        }

        if ($cylindreGlobal) {
            $clauses[] = " moto.cylindre_global = :cylindreGlobal ";
        }

        if (count($clauses) > 0) {
            $query .= ' WHERE ' . implode(' AND ', $clauses);
        }

        if($order === 'rand'){
            $query .= " ORDER BY RAND()";
        }

        if($order === 'marque'){
            $query .= " ORDER BY moto.marque_id, moto.name";
        }
        if($limit){
            $query .= " LIMIT :limit";
        }
        
        $stmt = $db->prepare($query);

        if ($type) {
            $stmt->bindValue('type', $type, PDO::PARAM_INT);
        }

        if ($marque) {
            $stmt->bindValue('marque', $marque, PDO::PARAM_INT);
        }

        if ($cylindreGlobal) {
            $stmt->bindValue('cylindreGlobal', $cylindreGlobal, PDO::PARAM_INT);
        }

        if ($limit) {
            $stmt->bindValue('limit', $limit, PDO::PARAM_INT);
        }

        $stmt->execute();
        return $stmt->fetchAll();
    }

    function findMotoById(int $id): ?array
    {
        global $db;
        $query = <<<SQL
            SELECT moto.id, moto.name, moto.slogan, moto.accroche, moto.banner, moto.picture, moto.price, moto.released_in, technical_profil.cylindre, technical_profil.moteur, technical_profil.puissance, technical_profil.couple, technical_profil.démarrage, marque.name as marque 
            FROM moto
            LEFT JOIN marque ON marque.id = moto.marque_id
            LEFT JOIN technical_profil ON technical_profil.id = moto.technical_profil_id
            WHERE moto.id = :moto_id
        SQL;

        $stmt = $db->prepare($query);
        $stmt->bindValue('moto_id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $moto = $stmt->fetch();

        if($moto){
            return $moto;
        } else {
            return null;
        }
    }

    function findModuleByMoto(int $id): ?array
    {
        global $db;
        $query = <<<SQL
            SELECT * FROM module 
            WHERE module.moto_id = :moto_id
        SQL;

        $stmt = $db->prepare($query);
        $stmt->bindValue('moto_id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $modules = $stmt->fetchAll();

        if($modules){
            return $modules;
        } else {
            return null;
        }
    }

    // ----- Utils -----
    function formatedDate(string $date, string $format): string
    {      
        $date = new DateTime($date); 
        return $date->format($format);
    }
?>