<?php
require_once './components/init.php';
require_once './components/head.php';

if (!isLoggedIn()) {
    header('Location: http://localhost/D%C3%A9veloppement/Amigraf_PHP/Projets/Techmoto');
}

$errors = [];

if (isset($_FILES['picture'])) {
    if ($_FILES['picture']['error'] === UPLOAD_ERR_OK) { //UPLOAD_ERR_OK = 0

        $maxSize = 2000000; //2 Mo
        if ($_FILES['picture']['size'] < $maxSize) {

            $allowedMimeTypes = ['image/jpeg', 'image/png'];
            if (in_array($_FILES['picture']['type'], $allowedMimeTypes)) {

                $oldPicture = getUserPicture($connectedUser, false);
                if ($oldPicture !== null) {
                    unlink($oldPicture);
                }

                $explodedName = explode('.', $_FILES['picture']['name']);
                $fileExt = strtolower(end($explodedName));

                $name = buildUserPictureName($connectedUser);
                $path = 'image/profile/' . $name . '.' . $fileExt;

                move_uploaded_file($_FILES['picture']['tmp_name'], $path);

                addFlash('success', 'Votre image a bien été téléchargée');
                header('Location: ' . $_SERVER['REQUEST_URI']);
                die();
            } else {
                $errors[] = 'Votre image doit être au format jpeg ou png';
            }
        } else {
            $errors[] = 'Votre image ne doit pas dépasser 2MO';
        }
    } else if ($_FILES['picture']['error'] === UPLOAD_ERR_NO_FILE) {
        $errors[] = 'Veuillez sélectionner un fichier';
    } else {
        $errors[] = 'Une erreur est survenue, veuillez réessayer';
    }
} 

?>
<section class="container">
    <h2 class="txt-center">Profil</h2>

    <div>
        <?php foreach ($errors as $error) { ?>
            <p class="flash-error"><?php echo $error ?></p>
        <?php } ?>
    </div>

    <form class="profil" method="post" enctype="multipart/form-data">
        <div class="form-field pb-10">
            <label for="picture">
                <img src="<?php echo getUserPicture($connectedUser); ?>" alt="<?php echo $connectedUser['firstname']; ?>">
            </label>
            <input class="mt-10" type="file" name="picture" id="picture" accept="image/jpeg,image/png">
        </div>
        <button class="btn btn-red mt-10">Uploader</button>
    </form>

</section>
<?php
require_once './components/footer.php';
?>