<?php

    // Check if we have an ad with the such ID
    if(isset($_GET['id']) && !empty($_GET ['id'])) {

        // Get the ID
        $id=$_GET['id'];

        // Connect to the DB
        require_once('inc/connect.php');

        // Deal with the SQL query: prepare, bind values, execute and fetch
        $sql='SELECT * FROM `logement` WHERE `id`=:id ;';

        $query=$db->prepare($sql);
        $query->bindvalue(':id', $id, PDO::PARAM_INT);
        $query->execute();
        $ad=$query->fetch(PDO::FETCH_ASSOC);

        // Disconnect from the DB
        require_once('inc/close.php');

        if(!$ad) {                         
            echo "Nous n'avons pas trouvé l'annonce";
            die;
        }

    } else {
        // If no ID, get back to admin page
        header('Location: admin_lgt.php');
    }

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$ad['titre'] ?></title>
</head>
<body>
    <article>
        <h1><?=$ad['titre']?></h1>
        <p>publié dans <?=strtoupper($ad['type'])?></p>
        <?php 
            // Check if the ad has an image
            if($ad['photo']!=null):  
                $picture = pathinfo($ad['photo'], PATHINFO_FILENAME);
                $extension = pathinfo($ad['photo'], PATHINFO_EXTENSION);  
            ?>       
            <!--display the picture-->
            <img style="width:10%" src="uploads/<?=$picture. '.' . $extension?>" alt="<?=$ad['titre']?>">   
        <?php
            endif;
        ?>
        <p style="font-weight:bold">Prix : <?= $ad['prix']?> €</p>
        <p style="font-weight:bold">Surface : <?= $ad['surface']?> m2</p>
        <p><?=$ad ['description'] ?></p>
        <p style="font-weight:bold">Adresse :</p>
        <p><?= $ad['adresse']?></p>
        <p><?= $ad['cp']?></p>
        <p><?= $ad['ville']?></p>
        <a href="<?=$_SERVER['HTTP_REFERER'];?>">Retour</a>
    </article>
</body>
</html>