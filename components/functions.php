<?php

function getAllExistMarque(): array
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

function getAllExistType(): array
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

function getAllMarque(): array
{
    global $db;

    $query = <<<SQL
            SELECT marque.id, marque.name from marque
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

    if ($type) {
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

    if ($order === 'rand') {
        $query .= " ORDER BY RAND()";
    }

    if ($order === 'marque') {
        $query .= " ORDER BY moto.marque_id, moto.name";
    }
    if ($limit) {
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

    if ($moto) {
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

    if ($modules) {
        return $modules;
    } else {
        return null;
    }
}

// ----- CRUD Moto -----
function checkInsertionMotoData($name, string $slogan, string $accroche, string $banner, string $thumbnail, string $picture, string $released_in, int $price, int $type, int $marque, int $cylindreGlobal, int $cylindre, string $moteur, string $puissance, string $couple, string $demarrage ): array
{
    $errors = [];

    if (strlen($name) < 2) {
        $errors[] = 'Le nom du modèle doit contenir au moins 2 caractère';
    }

    if (strlen($slogan) < 15) {
        $errors[] = 'Le slogan doit contenir au moins 15 caractère';
    }

    if (strlen($accroche) < 15) {
        $errors[] = 'L\'accroche doit contenir au moins 15 caractère';
    }

    if (strlen($price) < 0) {
        $errors[] = 'Le prix ne peux être négatif';
    }

    if (strlen($cylindre) < 0) {
        $errors[] = 'La cylindré ne peux être négatif';
    }

    if (strlen($cylindreGlobal) < 0) {
        $errors[] = 'La cylindré global ne peux être négatif';
    }

    if (strlen($moteur) < 5) {
        $errors[] = 'Les spécifications moteur doivent être indiquées (minimum 5 caractères)';
    }

    if (strlen($puissance) < 5) {
        $errors[] = 'Les spécifications de puissance doivent être indiquées (minimum 5 caractères)';
    }

    if (strlen($couple) < 5) {
        $errors[] = 'Les spécifications de couple doivent être indiquées (minimum 5 caractères)';
    }

    if (strlen($demarrage) < 5) {
        $errors[] = 'Les spécifications de démarrage doivent être indiquées (minimum 5 caractères)';
    }

    if ($banner == "") {
        $errors[] = 'Veuillez indiqué un nom de fichier pour la bannière';
    }

    if ($thumbnail == "") {
        $errors[] = 'Veuillez indiqué un nom de fichier pour la miniature';
    }

    if ($picture == "") {
        $errors[] = 'Veuillez indiqué un nom de fichier pour l\'image';
    }

    return $errors;
}

function insertTechnicalProfil($cylindre, $moteur, $puissance, $couple, $demarrage){
    global $db;

    $query = <<<SQL
        INSERT INTO technical_profil (cylindre, moteur, puissance, couple, démarrage) 
        VALUES (:cylindre, :moteur, :puissance,:couple, :demarrage);
    SQL;

    $stmt = $db->prepare($query);

    $stmt->bindValue('cylindre', $cylindre);
    $stmt->bindValue('moteur', $moteur);
    $stmt->bindValue('puissance', $puissance);
    $stmt->bindValue('couple', $couple);
    $stmt->bindValue('demarrage', $demarrage);

    try {
        $stmt->execute();
        return true;
    } catch (exception $e) {
        return false;
    }
}

function lastTechnicalProfil(): ?array
{
    global $db;

    $query = <<<SQL
        SELECT id FROM `technical_profil` ORDER BY id DESC LIMIT 1
    SQL;

    $stmt = $db->query($query);
    $stmt->execute();
    return $stmt->fetch();
}

function insertMoto($idTechnicalProfil, $name, $slogan, $accroche, $banner, $thumbnail, $picture, $released_in, $price, $type, $marque, $cylindreGlobal)
{
    global $db;

    $query = <<<SQL
        INSERT INTO moto (name, slug, released_in, price, cylindre_global, slogan, accroche, banner, thumbnail, picture, technical_profil_id, marque_id, type_id) 
        VALUES (:name, :slug, :released_in, :price, :cylindre_global, :slogan, :accroche, :banner, :thumbnail, :picture, :technical_profil_id, :marque_id, :type_id);
    SQL;

    $stmt = $db->prepare($query);

    $slug = $name . $idTechnicalProfil['id'];

    $stmt->bindValue('name', $name);
    $stmt->bindValue('slug', $slug);
    $stmt->bindValue('released_in', $released_in);
    $stmt->bindValue('price', $price);
    $stmt->bindValue('cylindre_global', $cylindreGlobal);
    $stmt->bindValue('slogan', $slogan);
    $stmt->bindValue('accroche', $accroche);
    $stmt->bindValue('banner', $banner);
    $stmt->bindValue('thumbnail', $thumbnail);
    $stmt->bindValue('picture', $picture);
    $stmt->bindValue('technical_profil_id', $idTechnicalProfil['id']);
    $stmt->bindValue('marque_id', $marque);
    $stmt->bindValue('type_id', $type);

    try {
        $stmt->execute();
        return true;
    } catch (exception $e) {
        return false;
    }
}


// ----- Utils -----
function formatedDate(string $date, string $format): string
{
    $date = new DateTime($date);
    return $date->format($format);
}


// ----- Flash Message -----
function addFlash(string $type, string $message): void
{
    $messages = $_SESSION['messages'] ?? [];

    $messages[] = [
        'type' => $type,
        'content' => $message,
    ];

    $_SESSION['messages'] = $messages;
}

function getFlashMsg(): array
{
    $messages = $_SESSION['messages'] ?? [];
    unset($_SESSION['messages']);
    return $messages;
}


// ----- Profil User -----
function buildUserPictureName(array $user): string
{
    return md5($user['id'] . '_' . $user['firstname']);
}

function getUserPicture(array $user, bool $withDefault = true): ?string
{
    $name = buildUserPictureName($user);
    $files = scandir('image/profile');

    foreach ($files as $file) {
        if (strstr($file, $name) !== false) {
            return 'image/profile/' . $file;
        }
    }

    if ($withDefault) {
        return 'image/profile/default.jpg';
    }

    return null;
}



// ----- Security -----
function findUserByEmail(string $email): ?array
{
    global $db;

    $query = <<<SQL
            SELECT * FROM user WHERE email = :email;
        SQL;

    $stmt = $db->prepare($query);
    $stmt->bindValue('email', $email);
    $stmt->execute();

    $user = $stmt->fetch();

    if ($user === false) {
        return null;
    } else {
        return $user;
    }
}

function findUserById(int $id): ?array
{
    global $db;

    $query = <<<SQL
            SELECT * FROM user WHERE id = :id;
        SQL;

    $stmt = $db->prepare($query);
    $stmt->bindValue('id', $id, PDO::PARAM_INT);
    $stmt->execute();

    $user = $stmt->fetch();

    if ($user === false) {
        return null;
    } else {
        return $user;
    }
}

function login(array $user): void
{
    $_SESSION['authenticated'] = true;
    $_SESSION['userId'] = $user['id'];
    $_SESSION['admin'] = $user['is_admin'];
}

function logout(): void
{
    $_SESSION['authenticated'] = false;
    unset($_SESSION['userId']);
    unset($_SESSION['admin']);
}

function isLoggedIn(): bool
{
    return isset($_SESSION['authenticated']) && $_SESSION['authenticated'] === true;
}

function isAdmin(): bool
{
    if($_SESSION['admin'] == 1) { 
        return true;
    } else {
        return false;
    };
}

function reloadUserFormDatabase(): ?array
{
    if (empty($_SESSION['userId'])) {
        return null;
    }

    return findUserById($_SESSION['userId']);
}

function checkRegisterData(string $firstname, string $lastname, string $email, string $password, bool $cgu): array
{
    $errors = [];

    //Check Username
    if (strlen($firstname) < 2) {
        $errors[] = 'Votre prénom doit contenir au moins 2 caractère';
    }

    if (strlen($lastname) < 2) {
        $errors[] = 'Votre nom doit contenir au moins 2 caractère';
    }

    if (!ctype_alnum($firstname)) {
        $errors[] = 'Votre prénom doit contenir uniquement des caractères alphanumériques';
    }

    if (!ctype_alnum($lastname)) {
        $errors[] = 'Votre nom doit contenir uniquement des caractères alphanumériques';
    }


    //Check Email
    if (empty($email)) {
        $errors[] = 'Veuillez saisir votre adresse email';
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Veuillez saisir une adresse email valide';
    } else if (checkExistingUserEmail($email)) {
        $errors[] = 'Cette adresse email est déjà utilisée';
    }


    //Check Password
    if (strlen($password) < 8 || strlen($password) > 30) {
        $errors[] = 'Votre mot de passe doit contenir entre 8 et 30 caractères';
    }

    $regex = '/(?=.{0,}[a-z])(?=.{0,}[^a-zA-Z0-9])(?=.{0,}\d)/';
    if (preg_match($regex, $password) === 0) {
        $errors[] = 'Votre mot de passe doit contenir au moins un chiffre, une lettre et un caractère spécial';
    }


    //Check CGU
    if (!$cgu) {
        $errors[] = 'Veuillez accepter les conditions d\'utilisations';
    }

    return $errors;
}

function checkExistingUserEmail(string $email): bool
{
    global $db;

    $query = <<<SQL
        SELECT count(email) as counterEmail FROM user
        WHERE email = :email;
    SQL;

    $stmt = $db->prepare($query);
    $stmt->bindValue('email', $email);
    $stmt->execute();

    //Permet de récupéré directement le résultat du de la colonne (ici count) au lieu d'un tableau de résultat
    $result = $stmt->fetchColumn();

    if ($result == 0) {
        return false;
    }

    return true;
}

function insertUser(string $firstname, string $lastname, string $email, string $password): bool
{
    global $db;

    $query = <<<SQL
        INSERT INTO user (firstname, lastname, email, password, is_admin, created_at) 
        VALUES (:firstname, :lastname, :email, :password, 0, NOW());
    SQL;

    $stmt = $db->prepare($query);

    $stmt->bindValue('firstname', $firstname);
    $stmt->bindValue('lastname', $lastname);
    $stmt->bindValue('email', $email);
    $stmt->bindValue('password', $password);

    try {
        $stmt->execute();
        return true;
    } catch (exception $e) {
        return false;
    }
}
?>