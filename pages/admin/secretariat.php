<?php
session_start();
require_once '../classes/ConnexionDB.php';
require_once '../classes/Requette.php';
require_once '../classes/Formulaire.php';
if(isset($_SESSION['email'])){
  $session = $_SESSION['email'];
}
if(isset($_POST['submit'])){
  $prenom = $_POST['prenom'];
  $nom = $_POST['nom'];
  $telephone = $_POST['telephone'];
  $email = $_POST['email'];
  $mdp = sha1($_POST['mdp']);
  $service [] = $_POST['service'];
  $req = new ConnexionDB();
  $add = new Requette();
  if(!empty($prenom) && !empty($nom) && !empty($telephone) && !empty($email) && !empty($mdp) && !empty($service)){
      if(preg_match('#^(77||78||76||70)[0-9]{7}$#',  $telephone)){
        
          if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            $nbemail  = $req->connect()->prepare("SELECT COUNT(*) as nbemail FROM secretaire WHERE email = :email");
            $nbemail->execute(array('email'=>$email));
            while($email_verify = $nbemail->fetch()){
              if($email_verify['nbemail'] != 0){
                $errormailnb = "<p class=\"alert alert-danger \" role=\"alert\"> Cette adresse email existe déja. </p>";
            }else{
              foreach ($service as $value) {
                $value = intval($value);
                $donnees = ['prenom'=>$prenom, 'nom'=>$nom, 'telephone'=>$telephone, 'email'=>$email, 'mdp'=>$mdp, 'prenom'=>$prenom,'id_service'=>$value];
                $res =  $add->insert($donnees,'secretaire');
                if($res){
                    header('location:secretariat.php');
                }else{
                    echo 'impossible';
                }
                
                }
            }
          }
          }else{
              $errormail = "<p class=\"alert alert-danger \" role=\"alert\"> Veuillez entrez une adresse email valide. </p>";
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
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.9.0/css/all.css">
  <link rel="stylesheet" href="../../css/menu.css">
  <link rel="stylesheet" href="../../js/app.js">
  <title>SECRETARIAT</title>
</head>
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
              <li class="connect"><?php if(isset( $session)){echo $session;}?></li>
                <li><a href="deconnectadmin.php"><span class="glyphicon glyphicon-log-in"></span> DECONNEXION</a></li>
              </ul>
            </div>
          </nav>

<div class="container-fluid">
  
  <div class="panel-group col-md-4">
    <div class="panel panel-primary">
      <div class="panel-heading">Ajouter un sécretaire</div>
      <div class="panel-body">
      <form action="" method="post">
        <?php
        if(isset($errormail)){echo $errormail;}
        if(isset($errormailnb)){echo $errormailnb;} 
        if(isset($errornumb)){echo $errornumb;}
        if(isset($errochamp)){echo $errochamp;} 
        ?>
      
        <div class="form-group ">
            <?php
                $forms = new Formulaire();
                $req = new Requette();
                echo $forms->formInput('Prenom','text','prenom','Entrez le prénom');
                echo $forms->formInput('Nom ','text','nom','Entrez le nom ');
                echo $forms->formInput('Telephone','tel','telephone','Entrez le numero de telephone');
                echo $forms->formInput('Adresse email','email','email','Entrez l\'adresse email');
                echo $forms->formInput('Mot de passe','password','mdp','Entrez le mot de passe');
                $res = $req->selectAll('services');
                $liste_option= "";
                foreach ($res as $value) {

                    $liste_option .= "<option value=".$value['id_service'].">" .$value['id_service'].' - '.$value['nom_service']."</option>";
                }
                echo $forms->selectList('Choisissez un service','service',$liste_option);
            ?>
        </div>

        <?php echo $forms->formSubmit('submit','Enrégister'); ?>
   
        
      </form>
      </div>
 
    </div>
  </div>
  <div class="panel-group col-md-8">
    <div class="panel panel-primary">
      <div class="panel-heading">Ajouter un sécretaire</div>
      <div class="panel-body">
        <!-- la liste des secretaire -->

        <?php
        $req = new Requette();
        $res = $req->selectAll('secretaire');
        echo "
        <table class=\"table\">
        <thead class='thead-dark'>
          <tr>
            <th scope=\"col\">#</th>
            <th scope=\"col\">Prenom</th>
            <th scope=\"col\">Nom</th>
            <th scope=\"col\">telephone</th>
            <th scope=\"col\">Email</th>
            <th scope=\"col\">Service</th>
            <th scope=\"col\">Actions</th>
          </tr>
        </thead>
        ";
        foreach($res as $val){
            echo"<tbody>";
            echo "<tr>
            <td>".$val['id_secretaire']."</td>
            <td>".$val['prenom']."</td>
            <td>".$val['nom']."</td>
            <td>".$val['telephone']."</td>
            <td>".$val['email']."</td>

            <td>".$val['id_service']."</td>";
            echo "
            <td><a class='btn btn-primary' href='editsecretaire.php?id=".$val['id_secretaire']."'><em class=\"far fa-edit\"></em></a> 
                <a class='btn btn-danger'  href='delsecretaire.php?id=".$val['id_secretaire']."' onclick=\"return confirm('êtes vous sure de vouloir supprimer cet enrégistrement ?')\";><em class=\"fas fa-trash-alt\"></em></a>
            </td>";
        }
        echo "</tbody>";
         echo "</table>";
        ?>
      </div>
 
    </div>
  </div>
</div>
</body>
</html>
