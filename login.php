<?php
require_once './components/init.php';
require_once './components/head.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $user = findUserByEmail($email);
    if ($user === null) {
        $errors[] = 'Informations incorrectes';
    } else if (password_verify($password, $user['password'])) {
        login($user);
        addFlash('success', 'Vous êtes bien connecté');
        header('Location: http://localhost/D%C3%A9veloppement/Amigraf_PHP/Projets/Techmoto');
        die();
    } else {
        $errors[]  = 'Informations incorrectes';
    }
}
?>
<section class="container">
    <h2 class="txt-center">Connexion</h2>

    <div>
        <?php foreach ($errors as $error) { ?>
            <p class="flash-error"><?php echo $error ?></p>
        <?php } ?>
    </div>
    <form action="" method="POST" class="login">
        <div class="form_field">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value=<?php echo $email ?? ''; ?>>
        </div>

        <div class="form_field">
            <label for="password">Mot de passe</label>
            <input type="password" name="password" id="password">
        </div>

        <button class="btn btn-red">Connexion</button>
    </form>
</section>
<?php
require_once './components/footer.php';
?>