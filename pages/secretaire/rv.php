<?php
session_start();
    require_once '../classes/ConnexionDB.php';
    require_once '../classes/Requette.php';
    require_once '../classes/Formulaire.php';
    if(isset($_GET['id'])){
    $id = $_GET['id'];
    
        if(isset($_SESSION['id_secretaire'])){
            //
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
  <title>RENDEZ-VOUS</title>
</head>
<body>
<nav class="navbar navbar-inverse">
        <div class="container-fluid">
            <ul class="nav navbar-nav">
                <?php
                if(isset($_SESSION['id_secretaire'])){
                    $s = $_SESSION['id_secretaire'];
                
                ?>
            <li><a href='profile.php?id=<?php echo $s ;?>' > PATIENT</a></li>
                <li><a href="">RENDEZ-VOUS</a></li><?php } ?>
            </ul>
            <ul class="nav navbar-nav navbar-right">
            <li class="connect"><?php if(isset( $session)){echo $session;}?></li>
            <li><a href="deconnexion.php"><span class="glyphicon glyphicon-log-in"></span> DECONNEXION</a></li>
            </ul>
        </div>
        </nav>
        <div class="container-fluid">
  
  <div class="panel-group col-md-4">
    <div class="panel panel-primary">
      <div class="panel-heading">Ajouter un medecin</div>
      <div class="panel-body">
        <?php
        if(isset($error_age)){echo $error_age;}
        if(isset($error_champ)){echo $error_champ;} 
        if(isset($error_numb)){echo $error_numb;}
        ?>
    <form action="" method="post">
    <div class="form-group ">
        <?php
            $forms = new Formulaire();
            $req = new Requette();
            echo $forms->formInput('Date','date','dates','Entrez la date');
            echo $forms->formInput('Heure début ','time','hdebut','');
            echo $forms->formInput('Heure fin ','time','hfin','');
            echo $forms->formInput('','hidden','secretaire','',$_GET['id']);
            $res = $req->selectAll('plage_horaire');
            $liste_option= "";
            foreach ($res as $value) {

                $liste_option .= "<option value=".$value['id_horaire'].">" .$value['id_horaire'].' - '.$value['date']."</option>";
            }
            echo $forms->selectList('Choisissez une horaire','horaire',$liste_option);
            $res = $req->selectAll('medecin');
            $liste_option= "";
            foreach ($res as $value) {

                $liste_option .= "<option value=".$value['id_medecin'].">" .$value['id_medecin'].' - '.$value['prenom'].' - '.$value['nom']."</option>";
            }
            echo $forms->selectList('Choisissez un medecin','medecin',$liste_option);
            $res = $req->selectAll('patient');
            $liste_option= "";
            foreach ($res as $value) {

                $liste_option .= "<option value=".$value['id_patient'].">" .$value['id_patient'].' - '.$value['prenom'].' - '.$value['nom']."</option>";
            }
            echo $forms->selectList('Choisissez un patient','patient',$liste_option);
        ?>
        </div>
    
        <?php echo $forms->formSubmit('submit','Enrégister'); ?>
   
    
    </form>
      </div>
 
    </div>
  </div>

</body>
</html>
