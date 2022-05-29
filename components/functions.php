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

    function getCardMoto(string $order = null, int $limit = null): ?array
    {
        global $db;

        $query = <<<SQL
            SELECT moto.id, moto.name, moto.released_in, moto.price, moto.thumbnail, marque.name as marque
            FROM moto
            LEFT JOIN marque ON marque.id = moto.marque_id
        SQL;


        if($order === 'rand'){
            $query .= " ORDER BY RAND()";
        }
        if($limit){
            $query .= " LIMIT :limit";
        }
        
        $stmt = $db->prepare($query);
        
        $stmt->bindValue('limit', $limit, PDO::PARAM_INT);
        
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