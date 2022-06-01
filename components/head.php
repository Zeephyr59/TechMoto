<!doctype html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <link href="https://fonts.googleapis.com/css2?family=Dosis:wght@300;500&display=swap" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <title>TechMoto | Ride free or die !</title>

</head>

<body>
    <header class="bg-dark">
        <nav class="navbar container">
            <a href="index.php" class="logo"><img src="image/logo/Logo-white.png" alt="logo Techmoto">
                <h2>TechMoto</h2>
            </a>
            <input type="checkbox" id="toggler">
            <label for="toggler"><i class="fa-solid fa-bars"></i></label>
            <div class="menu">
                <ul class="list">
                    <li><a href="index.php">Accueil</a></li>
                    <?php if (isLoggedIn()) { ?>
                        <?php if (isAdmin()) { ?>
                            <li>Administration Moto
                                <ul>
                                    <li><a href="insert_moto.php">Ajout</a></li>
                                    <li><a href="#">Listing</a></li>
                                </ul>
                            </li>
                        <?php } ?>
                        <li><a href="profile.php"><?php echo $connectedUser['firstname'] . ' ' . $connectedUser['lastname'] ?></a></li>
                        <li class="pt-25-sm"><a href="logout.php">Déconnexion</a></li>

                    <?php } else { ?>
                        <li class="pt-25-sm"><a href="register.php">Inscription</a></li>
                        <li><a href="login.php">Connexion</a></li>
                    <?php } ?>
                </ul>
            </div>
        </nav>
        <div class="container">
            <?php
            foreach (getFlashMsg('success') as $flash) {
                echo '<p class="container pt-10 flash flash-' . $flash['type'] . '">' . $flash['content'] . '</p>';
            };
            ?>
        </div>
    </header>

    <main>