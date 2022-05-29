<?php
require_once './components/init.php';
require_once './components/head.php';
?>

<section class="container">
    <h1 class="mt-25 txt-center bold">Help Me Choose</h1>
    <p class="mt-10 txt-center bold">Lorem ipsum dolor amet consectetur adipisicing elit. Accusantium facere sapiente
        ratione
        totam explicabo a?
        Odit alias eius soluta accusantium, placeat repudiandae eos in doloremque voluptate ab.</p>
</section>


<section class='search_moto block p-10'>
    <form method="GET">
        <div class="form_field">
            <label for="searchType">Type:</label>
            <select name="searchType" id="searchType">
                <option value="">Toutes</option>
                <?php foreach(getAllType() as $type){ ?>
                <option value="<?php echo $type['id'] ?>"><?php echo $type['name'] ?></option>
                <?php }?>
            </select>
        </div>
        <div class="form_field">
            <label for="searchMarque">Marque:</label>
            <select name="searchMarque" id="searchMarque">
                <option value="">Toutes</option>
                <?php foreach(getAllMarque() as $marque){ ?>
                <option value="<?php echo $marque['id'] ?>"><?php echo $marque['name'] ?></option>
                <?php }?>
            </select>
        </div>
        <div class="form_field">
            <label for="searchCylindre">Cylindre:</label>
            <select name="searchCylindre" id="searchCylindre">
                <option value="">Toutes</option>
                <option value="+900">+900 cm3</option>
                <option value="900">900 cm3</option>
                <option value="700">700 cm3</option>
                <option value="600">600 cm3</option>
                <option value="500">500 cm3</option>
                <option value="400">400 cm3</option>
                <option value="125">125 cm3</option>
            </select>
        </div>
        <button class="btn-red">Vrooom</button>
    </form>
</section>

<section class='container flex-auto'>
    <?php foreach (getCardMoto('rand', 3) as $cardMoto) { ?>
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
    <?php } ?>
</section>


<?php
require_once './components/footer.php';
?>