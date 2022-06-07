<?php
require_once './components/init.php';
require_once './components/head.php';

if (!isLoggedIn() || !isAdmin()) {
    header('Location: http://localhost/D%C3%A9veloppement/Amigraf_PHP/Projets/Techmoto');
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    var_dump($_POST);
    $name = htmlspecialchars($_POST['name']) ?? '';
    $slogan = htmlspecialchars($_POST['slogan']) ?? '';
    $accroche = htmlspecialchars($_POST['accroche']) ?? '';
    $banner = htmlspecialchars($_POST['banner']) ?? '';
    $thumbnail = htmlspecialchars($_POST['thumbnail']) ?? '';
    $picture = htmlspecialchars($_POST['picture']) ?? '';
    $released_in = htmlspecialchars($_POST['releasedIn']) ?? '';
    $price = htmlspecialchars($_POST['price']) ?? '';
    $type = htmlspecialchars($_POST['type']) ?? '';
    $marque = htmlspecialchars($_POST['marque']) ?? '';
    $cylindreGlobal = htmlspecialchars($_POST['cylindreGlobal']) ?? '';
    $cylindre = htmlspecialchars($_POST['cylindre']) ?? '';
    $moteur = htmlspecialchars($_POST['moteur']) ?? '';
    $puissance = htmlspecialchars($_POST['puissance']) ?? '';
    $couple = htmlspecialchars($_POST['couple']) ?? '';
    $demarrage = htmlspecialchars($_POST['demarrage']) ?? '';

    $errors = checkInsertionMotoData($name, $slogan, $accroche, $banner, $thumbnail, $picture, $released_in, $price, $type, $marque, $cylindreGlobal, $cylindre, $moteur, $puissance, $couple, $demarrage);


    if (count($errors) === 0) 
    {
        if(insertTechnicalProfil($cylindre, $moteur, $puissance, $couple, $demarrage))
        {
            $idTechnicalProfil = lastTechnicalProfil();
            
            if(insertMoto($idTechnicalProfil,$name, $slogan, $accroche, $banner, $thumbnail, $picture, $released_in, $price, $type, $marque, $cylindreGlobal))
            {
                addFlash('success', 'Véhicule ajouté');
                header('Location: http://localhost/D%c3%a9veloppement/Amigraf_PHP/Projets/Techmoto');
            } else {
                $errors[] = 'Une erreur est survenue, lors de insertion moto.'; 
            }
        } else {
            $errors[] = 'Une erreur est survenue, lors de insertion profil technique.';
        }
        
    } 
}



?>

<section class="container">
    <h1 class="mt-25 txt-center bold">Ajouter un véhicule</h1>
    <div>
        <?php foreach ($errors as $error) { ?>
            <p class="flash-error"><?php echo $error ?></p>
        <?php } ?>
    </div>
</section>


<section class='form p-10'>
    <form method="POST">
        <!-- name -->
        <div class="form_field">
            <label for="name">Nom: </label>
            <input required type="text" name="name" id="name"></input>
        </div>

        <!-- slogan -->
        <div class="form_field">
            <label for="slogan">Slogan: </label>
            <input required type="text" name="slogan" id="slogan"></input>
        </div>

        <!-- accroche -->
        <div class="form_field">
            <label for="accroche">Accroche: </label>
            <input required type="text" name="accroche" id="accroche"></input>
        </div>

        <!-- banner -->
        <div class="form_field">
            <label for="banner">Bannière: </label>
            <input required type="text" name="banner" id="banner"></input>
        </div>

        <!-- thumbnail -->
        <div class="form_field">
            <label for="thumbnail">Miniature: </label>
            <input required type="text" name="thumbnail" id="thumbnail"></input>
        </div>

        <!-- picture -->
        <div class="form_field">
            <label for="picture">Image: </label>
            <input required type="text" name="picture" id="picture"></input>
        </div>

        <!-- Released_in -->
        <div class="form_field">
            <label for="releasedIn">Sorti: </label>
            <input required type="date" name="releasedIn" id="releasedIn"></input>
        </div>

        <!-- Price -->
        <div class="form_field">
            <label for="price">Prix: </label>
            <input required type="number" name="price" id="price"></input>
        </div>

        <!-- Type -->
        <div class="form_field">
            <label for="type">Type:</label>
            <select name="type" id="type">
                <?php foreach (getAllType() as $type) { ?>
                    <option value="<?php echo $type['id'] ?>"><?php echo $type['name'] ?></option>
                <?php } ?>
            </select>
        </div>

        <!-- Marque -->
        <div class="form_field">
            <label for="marque">Marque:</label>
            <select name="marque" id="marque">
                <?php foreach (getAllMarque() as $marque) { ?>
                    <option value="<?php echo $marque['id'] ?>"><?php echo $marque['name'] ?></option>
                <?php } ?>
            </select>
        </div>

        <!-- CylindreGlobal -->
        <div class="form_field">
            <label for="cylindreGlobal">Cylindre Global:</label>
            <input required type="number" name="cylindreGlobal" id="cylindreGlobal"></input>
        </div>

        <!-- Cylindre -->
        <div class="form_field">
            <label for="cylindre">Cylindre:</label>
            <input required type="number" name="cylindre" id="cylindre"></input>
        </div>

        <!-- moteur -->
        <div class="form_field">
            <label for="moteur">Moteur: </label>
            <input required type="text" name="moteur" id="moteur"></input>
        </div>

        <!-- puissance -->
        <div class="form_field">
            <label for="puissance">Puissance: </label>
            <input required type="text" name="puissance" id="puissance"></input>
        </div>

        <!-- couple -->
        <div class="form_field">
            <label for="couple">Couple: </label>
            <input required type="text" name="couple" id="couple"></input>
        </div>

        <!-- demarrage -->
        <div class="form_field">
            <label for="demarrage">Démarrage: </label>
            <input required type="text" name="demarrage" id="demarrage"></input>
        </div>
        <button class="btn btn-red">Vrooom</button>
    </form>
</section>




<?php
require_once './components/footer.php';
?>