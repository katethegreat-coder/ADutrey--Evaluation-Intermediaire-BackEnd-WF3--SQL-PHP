<?php

    // Connect to the DB
    require_once('inc/connect.php');                           

    // Deal with the SQL query: execute and fetch all datas
    $sql='SELECT * FROM `logement` ORDER BY `titre` ASC ;';    
    $query=$db->query($sql);      
    $ads=$query->fetchAll(PDO::FETCH_ASSOC);                           

    // Disconnect from the DB
    require_once('inc/close.php');  

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Annonces</title>
</head>
<body>
    <h1>Liste des annonces</h1>
    <table>
        <thead>
            <th>ID</th>
            <th>Titre</th>
            <th>Type</th>
            <th>Surface</th>
            <th>Prix</th>
            <th>Adresse</th>
            <th>Code postal</th>
            <th>Ville</th>
            <th>Description</th>
            <th>Photo</th>
            <th>Action</th>
        </thead>
        <tbody>
            <?php
                foreach($ads as $ad):?>
                    <tr>     
                        <td><?=$ad['id']?></td>    
                        <td><?=$ad['titre']?></td>
                        <td><?=$ad['type']?></td>
                        <td><?=$ad['surface']?></td>
                        <td><?=$ad['prix']?></td>
                        <td><?=$ad['adresse']?></td>
                        <td><?=$ad['cp']?></td>
                        <td><?=$ad['ville']?></td>
                        <!-- Description and photo are not compulsory items -->
                        <?php 
                            if ($ad['description'] == null) {
                        ?><td>Aucune description fournie</td>
                        <?php 
                            } else {
                        ?>
                        <td><?=substr(strip_tags($ad['description']), 0, 50).'...'?></td>
                        <?php 
                            } 
                            ?>
                        <?php
                            if($ad['photo'] != null):
                                $picture = pathinfo($ad['photo'], PATHINFO_FILENAME);
                                $extension = pathinfo($ad['photo'], PATHINFO_EXTENSION);  
                        ?>
                        <td><img style="width:10%" src="uploads/<?=$picture. '.' . $extension?>" alt="<?=$ad['titre']?>"></td>
                        <?php 
                            endif; 
                        ?>
                        <td>
                            <a href="ad.php?id=<?=$ad['id']?>">Accéder</a> 
                        </td>
                    </tr> 
                <?php endforeach; ?>
        </tbody>
    </table>
    <a href="add_lgt.php">Ajouter une annonce</a>
</body>
</html>