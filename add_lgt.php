<?php

    // Connect to the DB
    require_once('inc/connect.php');

    // Check the form whether variables exists and are not empty
    if(isset($_POST) && !empty($_POST)) {

        // Connect to the lib file to call the checkForm function
        require_once('inc/lib/checkForm.php');

        // Check if postal code (string) has the right length, max 5 digits
        $postalcode=strip_tags($_POST['postalcode']);
        if(strlen($postalcode)>5){
            echo 'Le code postal ne peut contenir que jusqu\'à 5 chiffres';
            die;
        }
        
        // Call the checkForm function
        if(checkForm($_POST, ['title', 'address', 'postalcode', 'town', 'sqrmeter', 'price', 'type', 'description'])) {
            // Prevent XSS vulnerabilities et get variables' content
            $title=strip_tags($_POST['title']);
            $address=strip_tags($_POST['address']);
            $town=strip_tags($_POST['town']);
            $sqrmeter=strip_tags($_POST['sqrmeter']);
            $price=strip_tags($_POST['price']);
            $type=$_POST['type'];
            $description=strip_tags($_POST['description'], '<div><p><h1><h2><strong><img><a>');

        
            // Check if there is a picture & exclude error 4 (no file)
            if(isset($_FILES['picture']) && !empty($_FILES['picture']) && $_FILES ['picture']['error'] !=4){
                // Get picture's information
                $picture=$_FILES['picture'];

                // In case transfer did not go through i.e.'error'!=0
                if($picture['error']!=0) {
                    echo 'Le téléchargement de la photo a échoué';
                    die;
                } 

                // Limit to jpg pictures & Check if the uploaded file complies the limitation
                $pictype=['image/jpeg'];
                if(!in_array($picture['type'], $pictype)) {
                    echo 'La photo doit être en jpg';
                    header('Location:add_lgt.php');
                    die;
                }

                // Limit the file size to 3Mo max
                if($picture['size'] > 3e+6) {
                    echo 'La taille de la photo dépasse la limite de 3Mo';
                    die;
                }
                
                // Picture uploaded, Allocate a name to the picture and move the temp image
                // Get the file extension in lowercase
                $extension =strtolower(pathinfo($picture['name'], PATHINFO_EXTENSION));
                // Generate a name logement_timestampunix.jpg
                $name= 'logement_'.time().'.'.$extension;
                // Generate the entire name with the absolute path & the name
                $entireName= __DIR__ . '/uploads/' . $name;   

                // move the file from the temporary folder to the destination
                if(!move_uploaded_file($picture['tmp_name'], $entireName)) {   
                    echo "Le transfert du fichier a échoué";
                    die;
                }
            }

            // Launch the query to insert retrieved datas
            $sql='INSERT INTO `logement`(`titre`,`adresse`, `cp`, `ville`, `surface`, `prix`, `type`, `description`, `photo`) VALUES (:title, :address, :postalcode, :town, :sqrmeter, :price, :type, :description, :picture);';

            $query=$db->prepare($sql);

            $query->bindValue(':title', $title, PDO::PARAM_STR);
            $query->bindValue(':address', $address, PDO::PARAM_STR);
            $query->bindValue(':postalcode', $postalcode, PDO::PARAM_STR);
            $query->bindValue(':town', $town, PDO::PARAM_STR);
            $query->bindValue(':sqrmeter', $sqrmeter, PDO::PARAM_INT);
            $query->bindValue(':price', $price, PDO::PARAM_INT);
            $query->bindValue(':type', $type, PDO::PARAM_STR);
            $query->bindValue(':description', $description, PDO::PARAM_STR);
            $query->bindValue(':picture', $name, PDO::PARAM_STR);

            $query->execute();
            
            // disconnect from the DB
            require_once('inc/close.php');

        } else {
            echo 'Merci de remplir tous les champs non facultatifs';
            die;
        }
        // Redirection to admin page
        header('Location: admin_lgt.php'); 
    } 
    
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un logement</title>
</head>
<body>
    <h1>Ajoutez une annonce pour un logement</h1>
    <form method="post" enctype="multipart/form-data">
        <div>
            <label for="title">Titre de l'annonce : </label>
            <input type="text" name="title" id="title">
        </div>
        <div>
            <label for="address">Adresse : </label>
            <input type="text" name="address" id="address">
        </div>
        <div>
            <label for="postalcode">Code postal :</label>
            <input type="text" name="postalcode" id="postalcode">
        </div>
        <div>
            <label for="town">Ville :</label>
            <input type="text" name="town" id="town">
        </div>
        <div>
            <label for="sqrmeter">Surface en m2 :</label>
            <input type="number" name="sqrmeter" id="sqrmeter">
        </div>
        <div>
            <label for="price">Prix :</label>
            <input type="number" name="price" id="price">
        </div>
        <div>
            <label for="picture">Photo (facultative-3Mo max-jpg) :</label>
            <input type="file" name="picture" id="picture" multiple>
        </div>
        <div>
            <label for="type">Type :</label>
            <select name="type" id="type">
                <option value="location">location</option>
                <option value="vente">vente</option>
            </select>
        </div>
        <label for="description">Description (facultatif) :</label>
        <div>
            <textarea name="description" id="description" cols="30" rows="10"></textarea>
        </div>
        <button>Valider</button>
    </form>
</body>
</html>