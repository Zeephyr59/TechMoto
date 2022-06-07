<?php
require_once './components/init.php';
require_once './components/head.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstname = htmlspecialchars($_POST['firstname']) ?? '';
    $lastname = htmlspecialchars($_POST['lastname']) ?? '';
    $email = htmlspecialchars($_POST['email']) ?? '';
    $password = htmlspecialchars($_POST['password']) ?? '';
    $cgu = isset($_POST['cgu']);

    $errors = checkRegisterData($firstname, $lastname, $email, $password, $cgu);

    if (count($errors) === 0) {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        if (insertUser($firstname, $lastname, $email, $hashed)) {
            addFlash('success', 'Votre compte a bien été créé');
            header('Location: http://localhost/D%c3%a9veloppement/Amigraf_PHP/Projets/Techmoto');
            die();
        } else {
            $errors[] = 'Une erreur est survenue, veuillez réessayer ultérieurement.';
        }
    }
}

?>
<section class="container">
    <h2 class="txt-center">Rejoignez la communauté</h2>
    <div>
        <?php foreach ($errors as $error) { ?>
            <p class="flash-error"><?php echo $error ?></p>
        <?php } ?>
    </div>
    <form action="" method="POST">
        <div class="form-field pb-10">
            <label for="firstname">Prénom</label>
            <input type="text" name="firstname" id="firstname" value=<?php echo $firstname ?? ''; ?>>
        </div>

        <div class="form-field pb-10">
            <label for="lastname">Nom</label>
            <input type="text" name="lastname" id="lastname" value=<?php echo $lastname ?? ''; ?>>
        </div>

        <div class="form-field pb-10">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value=<?php echo $email ?? ''; ?>>
        </div>

        <div class="form-field pb-10">
            <label for="password">Mot de passe</label>
            <input type="password" name="password" id="password">
        </div>

        <div class="form-field pb-10">
            <input type="checkbox" name="cgu" id="cgu" <?php echo !empty($cgu) ? 'checked' : '' ?>>
            <label for="cgu">J'accepte les conditions d'utilisations</label>
        </div>

        <button class="btn btn-red">S'inscrire</button>
    </form>
</section>
<?php
require_once './components/footer.php';
?>