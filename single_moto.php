<?php
require_once './components/init.php';
require_once './components/head.php';

$id_moto = (int) $_GET['id'] ?? 0;
$moto = findMotoById($id_moto);

if(!$moto){
    header('LOCATION: http://localhost/Développement/PHP/Projet TechMoto/index.php');
}


?>

<section class="banner txt-white">
    <img src="<?php echo 'image/banner/' . $moto['banner'] ?>" alt="">
    <div class="container">
        <h1 class="uppercase"><?php echo $moto['marque'] . ' - ' . $moto['name']; ?></h1>
        <h2 class="uppercase"><?php echo $moto['slogan']; ?></h2>
    </div>
</section>

<section class="container mt-25">
    <h3 class="txt-center uppercase"><?php echo $moto['accroche']; ?></h3>
    <div class="modules flex-auto">
        <?php foreach (findModuleByMoto($moto['id']) as $module) { ?>
        <div class="card-module block">
            <img src="<?php echo 'image/module/' . $module['picture'] ?>" alt="<?php echo $module['name'] ?>">
            <h4 class="p-10 txt-center"><?php echo $module['name'] ?></h4>
            <p class="p-10"><?php echo $module['description'] ?></p>
        </div>
        <?php } ?>
    </div>

    <div class="technical-profile block">
        <div class="table">
            <h4>Fiche Technique</h4>
            <table>
                <tr>
                    <th>Cylindre (cm3)</th>
                    <td><?php echo $moto['cylindre'] ?></td>
                </tr>
                <tr>
                    <th>Moteur</th>
                    <td><?php echo $moto['moteur'] ?></td>
                </tr>
                <tr>
                    <th>Puissance maxi</th>
                    <td><?php echo $moto['puissance'] ?></td>
                </tr>
                <tr>
                    <th>couple maxi</th>
                    <td><?php echo $moto['couple'] ?></td>
                </tr>
                <tr>
                    <th>Démarrage</th>
                    <td><?php echo $moto['démarrage'] ?></td>
                </tr>
                <tr>
                    <th>À partir de</th>
                    <td><?php echo $moto['price'] ?>€</td>
                </tr>
            </table>
            <p>Tarifs TTC en vigueur au 23.11.2021 dans la limite des stocks disponibles (tarifs valables en France
                métropolitaine et Corse uniquement - ne s'appliquent pas dans les DOM-TOM).</p>
            <a href="#" class="btn-red">Disponible en magasin</a>
        </div>
        <img src="<?php echo 'image/picture/' . $moto['picture'] ?>" alt="<?php echo $moto['name'] ?>">
    </div>
</section>



<?php
require_once './components/footer.php';
?>