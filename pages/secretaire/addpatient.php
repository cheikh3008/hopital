<?php
    require_once '../classes/ConnexionDB.php';
    require_once '../classes/Requette.php';
    require_once '../classes/Formulaire.php';
    if(isset($_POST['submit'])){
        $prenom = $_POST['prenom'];
        $nom = $_POST['nom'];
        $age = $_POST['age'];
        $telephone = $_POST['telephone'];
        $adresse = $_POST['adresse'];
        $secretaire [] = $_POST['secretaire'];
        if(!empty($prenom) && !empty($nom) && !empty($telephone) && !empty($age) && !empty($adresse) && !empty($secretaire)){
            if(preg_match('#^(77||78||76||70)[0-9]{7}$#',  $telephone)){
                if(is_numeric($age) && $age > 0 && $age <=100){
                    foreach ($secretaire as $value) {
                    $value = intval($value);
                    $donnees = ['prenom'=>$prenom, 'nom'=>$nom, 'age'=>$age, 'telephone'=>$telephone, 'adresse'=>$adresse, 'id_secretaire'=>$value];
                    $add = new Requette();
                    $res =  $add->insert($donnees,'patient');
                    if($res){
                        echo ' super ça marche';
                    }else{
                        echo 'impossible';
                    }
                    
                    }
                }else{
                    $errormail = "<p class=\alert alert-danger \ role=\alert\> Veuillez entrez un age valide. </p>";
                }
            }else{
                $errornumb = "<p class=\"alert alert-danger \" role=\"alert\"> Veuillez entrez un numéro de téléphone valide. </p>";
            }
        }else{
            $errochamp = "<p class=\"alert alert-danger \" role=\"alert\"> Veuillez remplir tous les champs . </p>";
        }
        
    }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="../../css/main.css"> -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.9.0/css/all.css">
    <title>AJOUTER UN PATIENT</title>
</head>
<body>
<div class="container">
    <h1>Ajouter un patient</h1>
    <form action="" method="post">
    <!-- <div class="alert alert-danger " role="alert"> -->
        <?php
        if(isset($errormail)){echo $errormail;}
        if(isset($errornumb)){echo $errornumb;}
        if(isset($errochamp)){echo $errochamp;} 
        ?>
    <!-- </div> -->
        <div class="form-group ">
            <?php
                $forms = new Formulaire();
                $req = new Requette();
                echo $forms->formInput('Prenom','text','prenom','Entrez le prénom');
                echo $forms->formInput('Nom ','text','nom','Entrez le nom ');
                echo $forms->formInput('Age','text','age','Entrez l\'age');
                echo $forms->formInput('Telephone','tel','telephone','Entrez le numero de telephone');
                echo $forms->formInput('Adresse ','text','adresse','Entrez l\'adresse email');
                $res = $req->selectAll('secretaire');
                $liste_option= "";
                foreach ($res as $value) {

                    $liste_option .= '<option>'.$value['id_secretaire'].' - '.$value['prenom'].' - '.$value['nom'].'</option>';
                }
                echo $forms->selectList('Choisissez le secretaire ','secretaire',$liste_option);
            ?>
            </div>

        <?php echo $forms->formSubmit('submit','Enrégister'); ?>
   
    </form>
</div>  

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
