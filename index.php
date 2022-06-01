<?php
require_once './components/init.php';
require_once './components/head.php';

if ($_GET) {
    $searchByType = $_GET['searchType'] === "" ? null : htmlspecialchars($_GET['searchType']);
    $searchByMarque = $_GET['searchMarque']  === "" ? null : htmlspecialchars($_GET['searchMarque']);
    $searchByCylindre = $_GET['searchCylindre'] === "" ? null : htmlspecialchars($_GET['searchCylindre']);

    $motos = getCardMoto('marque', null, $searchByType, $searchByMarque, $searchByCylindre);

}
else{
    $motos = getCardMoto('rand', 3);
}
?>

<section class="container">
    <h1 class="mt-25 txt-center bold">Help Me Choose</h1>
    <p class="mt-10 txt-center bold">Lorem ipsum dolor amet consectetur adipisicing elit. Accusantium facere sapiente
        ratione
        totam explicabo a?
        Odit alias eius soluta accusantium, placeat repudiandae eos in doloremque voluptate ab.</p>
</section>


<section class='form p-10'>
    <form method="GET">
        <div class="form_field">
            <label for="searchType">Type:</label>
            <select name="searchType" id="searchType">
                <option value="">Toutes</option>
                <?php foreach (getAllExistType() as $type) { ?>
                    <option value="<?php echo $type['id'] ?>" <?php if (isset($searchByType)) {
                                                                    echo $searchByType == $type['id'] ? "selected" : "";
                                                                } ?>><?php echo $type['name'] ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="form_field">
            <label for="searchMarque">Marque:</label>
            <select name="searchMarque" id="searchMarque">
                <option value="">Toutes</option>
                <?php foreach (getAllExistMarque() as $marque) { ?>
                    <option value="<?php echo $marque['id'] ?>" <?php if (isset($searchByMarque)) {
                                                                    echo $searchByMarque == $marque['id'] ? "selected" : "";
                                                                } ?>><?php echo $marque['name'] ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="form_field">
            <label for="searchCylindre">Cylindre:</label>
            <select name="searchCylindre" id="searchCylindre">
                <option value="">Toutes</option>
                <?php foreach (getAllCylindre() as $cylindre) { ?>
                    <option value="<?php echo $cylindre['cylindre_global'] ?>" <?php if (isset($searchByCylindre)) {
                                                                    echo $searchByCylindre == $cylindre['cylindre_global'] ? "selected" : "";
                                                                } ?>><?php echo $cylindre['cylindre_global'] ?></option>
                <?php } ?>
            </select>
        </div>
        <button class="btn-red">Vrooom</button>
    </form>
</section>


<section class='container flex-auto'>
    <?php if(!empty($motos)){
        foreach ($motos as $cardMoto) { ?>
            <div class="card-moto">
                <div class="card-top">
                    <img src="<?php echo 'image/thumbnail/' . $cardMoto['thumbnail'] ?>" alt="<?php echo $cardMoto['name'] ?>">
                    <p class="price"><?php echo $cardMoto['price'] ?>€</p>
                </div>
                <div class="card-bottom">
                    <h2><?php echo $cardMoto['name'] ?>
                        <span>(<?php echo formatedDate($cardMoto['released_in'], 'Y') ?>)</span>
                    </h2>
                    <h4><?php echo $cardMoto['marque'] ?></h4>
                    <a href="<?php echo 'single_moto.php?id=' . $cardMoto['id']; ?>" class="btn-red">Détails</a>
                </div>
            </div>
        <?php } 
    } else { ?>
        <p class="bold">Aucun véhicules ne correspond à vos critères.</p>
    <?php }?>
</section>


<?php
require_once './components/footer.php';
?>