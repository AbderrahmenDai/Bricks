<?php
include('cnx/cnx.php');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insérer un nouveau Bien</title>
    <link rel="stylesheet" href="ergonomie/css/style.css">
</head>
<body>
<article>
    <section>
        <form action="" method="post" enctype="multipart/form-data">
            <h1>Insérer un Bien</h1>
            <?php
            if(isset($_POST['envoyer'])) { // Si le formulaire est validé .DEBUT

                if(empty($_POST['bien'])) { // Si le champ BIEN est vide .DEBUT
                    echo '<div class="error">Merci de nommer le Bien</div>';
                } else { // Si le champ BIEN est vide .SUITE
                    if(empty($_FILES['monImage']['tmp_name'])) { // Si l'image est vide .DEBUT
                        echo '<div class="error">Merci d\'envoyer une image</div>';
                    } else { // Si l'image est vide .SUITE
                        $dossierTempo = $_FILES['monImage']['tmp_name'];
                        $dossierSite  = 'ergonomie/images/'.$_FILES['monImage']['name'];

                        $extension = strrchr($_FILES['monImage']['name'], '.');
                        $autorise  = ['.jpg','.JPG'];
                        if(in_array($extension, $autorise)) { // Si l'extension est autorisée .DEBUT
                            $deplacer = move_uploaded_file($dossierTempo, $dossierSite);

                            $sql    = 'INSERT INTO bien
                          (bien, image) VALUES (:bien, :image)';
                            $req    = $cnx->prepare($sql);
                            $retour = $req->execute( array(
                                ':bien' => $_POST['bien'],
                                ':image'=> $_FILES['monImage']['name']
                            ));
                            if($retour) {
                                echo '<div class="success">Le Bien a été inséré</div>';
                            } else {
                                echo '<div class="error">Le Bien n\'a pas pu être inséré</div>';
                            }

                        } else { // Si l'extension est autorisée .SUITE
                            echo '<div class="error">Cette extension d\'image n\'est pas autorisée</div>';
                        } // Si l'extension est autorisée .FIN
                    } // Si l'image est vide .FIN
                } // Si le champ BIEN est vide .FIN

            } // Si le formulaire est validé .FIN
            ?>

            <input type="text" name="bien" placeholder="Nom du Bien">
            <p>Envoyer une image</p>
            <div id="download">
                <input type="file" name="monImage" id="fichier">
                <label for="fichier">
                    <div>
                        <i class="fa-solid fa-download"></i>
                    </div>
                </label>
            </div>
            <input type="submit" name="envoyer" value="Insérer">
        </form>
    </section>
</article>

<script src="https://kit.fontawesome.com/50786edb2e.js" crossorigin="anonymous"></script>
</body>
</html>