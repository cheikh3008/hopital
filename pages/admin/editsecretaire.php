<?php
    require_once '../classes/ConnexionDB.php';
    require_once '../classes/Requette.php';
    require_once '../classes/Formulaire.php';
    if(isset($_GET['id'])){
      $id =$_GET['id'];
      $forms = new Requette();
      $result = $forms->selectOne('secretaire','id_secretaire',$id);
      if(isset($_POST['submit'])){
        $prenom = $_POST['prenom'];
        $nom = $_POST['nom'];
        $telephone = $_POST['telephone'];
        $email = $_POST['email'];
        $mdp = sha1($_POST['mdp']);
        $service [] = $_POST['services'];
        if(!empty($prenom) && !empty($nom) && !empty($telephone) && !empty($email) && !empty($mdp) && !empty($service)){
            if(preg_match('#^(77||78||76||70)[0-9]{7}$#',  $telephone)){
                if(filter_var($email, FILTER_VALIDATE_EMAIL)){
                  foreach ($service as $value) {
                    $value = intval($value);
                    $donnees = ['prenom'=>$prenom, 'nom'=>$nom, 'telephone'=>$telephone,'email'=>$email, 'mdp'=>$mdp,'id_service'=>$value];
                    $add = new Requette();
                    $res =  $add->update($donnees,$id,'secretaire','id_secretaire');
                    if($res){
                      header('location:secretariat.php');
                    }else{
                        echo 'impossible';
                    }
                  } 
    
                }else{
                    $errormail = "<p class=\alert alert-danger \ role=\alert\"> Veuillez entrez une adresse email valide. </p>";
                }
            }else{
                $errornumb = "<p class=\"alert alert-danger \" role=\"alert\"> Veuillez entrez un numéro de téléphone valide. </p>";
            }
        }else{
            $errochamp = "<p class=\"alert alert-danger \" role=\"alert\"> Veuillez remplir tous les champs . </p>";
        }
        
    }
    } 
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.9.0/css/all.css">
  <link rel="stylesheet" href="../../css/menu.css">
  <title>MODIFIER UN SECRETAIRE</title>
<body>
    <nav class="navbar navbar-inverse">
            <div class="container-fluid">
              <ul class="nav navbar-nav">
                <li class="active"><a href="homeadmin.php">ACCUEIL</a></li>
                <li><a href="secretariat.php">SECRETARIAT</a></li>
                <li><a href="medecine.php">MEDECINE</a></li>
                <li><a href="services.php">SERVICES</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                <li><a href="deconnectadmin.php"><span class="glyphicon glyphicon-log-in"></span> DECONNEXION</a></li>
              </ul>
            </div>
          </nav>
<div class="container-fluid">
  
  <div class="panel-group col-md-4">
    <div class="panel panel-primary">
      <div class="panel-heading">Modifier un sécretaire</div>
      <div class="panel-body">
      <form action="" method="post">
        <?php
        if(isset($errormail)){echo $errormail;}
        if(isset($errornumb)){echo $errornumb;}
        if(isset($errochamp)){echo $errochamp;} 
        ?>
        <div class="form-group ">
            <?php
                $forms = new Formulaire();
                $req = new Requette();
                echo $forms->formInput('Prenom','text','prenom','Entrez le prénom',$result['prenom']);
                echo $forms->formInput('Nom ','text','nom','Entrez le nom ',$result['nom']);
                echo $forms->formInput('Telephone','tel','telephone','Entrez le numero de telephone',$result['telephone']);
                echo $forms->formInput('Adresse email','email','email','Entrez l\'adresse email',$result['email']);
                echo $forms->formInput('','hidden','mdp','Entrez le mot de passe',$result['mdp']);
                $res = $req->selectAll('services');
                $liste_option= "";
                foreach ($res as $value) {

                    $liste_option .= "<option value=".$value['id_service'].">" .$value['id_service'].' - '.$value['nom_service']."</option>";
                }
                echo $forms->selectList('Choisissez un service','services',$liste_option);
            ?>
        </div>

        <?php echo $forms->formSubmit('submit','Enrégister'); ?>
   
        
      </form>
      </div>
 
    </div>
  </div>
</body>
</html>
