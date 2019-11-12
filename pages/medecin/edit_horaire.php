<?php
session_start();
require_once '../classes/ConnexionDB.php';
require_once '../classes/Requette.php';
require_once '../classes/Formulaire.php';
require_once '../classes/Menu.php';
$req = new ConnexionDB();
$add = new Requette();
if(isset($_SESSION['id_medecin'])){
  if(isset($_GET['id'])){
    $id =  $_GET['id']; 

    if(isset($_POST['submit'])){
      $dates = $_POST['dates'];
      $heured = $_POST['heured'];
      $heuref = $_POST['heuref'];
      $medecin = $_POST['medecin'];
      if(!empty($dates) && !empty($heured)  && !empty($heuref)){
        $datenow = new DateTime();
        $req = new ConnexionDB();
        if ($datenow <= DateTime::createFromFormat('Y-m-d', $dates)){
          if($heured == '08:00' && $heuref == '17:00' ){
            $weekDay = date('w', strtotime($dates));
            if($weekDay != 0 && $weekDay != 6){
              if(isset($_SESSION['id_medecin'])){
                $id_medecin = $_SESSION['id_medecin'];
              }
              $nbdate  = $req->connect()->prepare("SELECT COUNT(dates) as nbdate FROM plage_horaire WHERE dates = :dates AND id_medecin = $id_medecin" );
                $nbdate->execute(array('dates'=>$dates));
                while($dates_verify = $nbdate->fetch()){
                    
                  if($dates_verify['nbdate'] == 0 ){
                    $donnees = [ 'dates'=>$dates,'heure_debut'=>$heured,'heure_fin'=>$heuref,'id_medecin'=>$medecin ];
                    $add = new Requette();
                    $res =  $add->update($donnees,'plage_horaire',$id,'id_horaire');
                    if($res){
                       header('location:profile.php?id='.$id_medecin);
                    }else{
                        echo 'impossible';
                    }
                  }else{
                    $errordate_nb = "<p class=\"alert alert-danger \" role=\"alert\"> Cette date est déja prise. </p>"; 
                  }
                  
                }
            }else{
              $errorweek = "<p class=\"alert alert-danger \" role=\"alert\"> Impossible de pendre rendez-vous pour les week_end. </p>"; 
            }
          }else{
            $error_heuere = "<p class=\"alert alert-danger \" role=\"alert\"> impossible d'ajouter un cette  horaire. </p>";
          }
         
      }else{
        $error_date = "<p class=\"alert alert-danger \" role=\"alert\"> La date est passée. </p>";
      } 
    }  else{
      $error_champ = "<p class=\"alert alert-danger \" role=\"alert\"> Tous les champs doivent être remplis. </p>";
  } 
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
  <title>MEDECIN</title>
</head>
<body>
    <nav class="navbar navbar-inverse">
        <div class="container-fluid">
            <ul class="nav navbar-nav">
            <?php
                if(isset($_SESSION['id_medecin'])){
                    $s = $_SESSION['id_medecin'];
                ?>
            <li><a href='profile.php?id=<?php echo $s ;?>'>PLAGE HORAIRE</a></li>
        
           
            <li><a href='listrv.php?id=<?php echo $s ;?>'>RENDEZ-VOUS</a>
            </li> <?php } ?>
            </ul>
            <ul class="nav navbar-nav navbar-right">
            <li class="connect"><?php if(isset( $_SESSION['prenom'])&& $_SESSION['prenom']){echo $_SESSION['prenom']." " .$_SESSION['nom'];}?></li>
            <li><a href="deconnexion.php"><span class="glyphicon glyphicon-log-in"></span> DECONNEXION</a></li>
            </ul>
        </div>
    </nav>

    <div class="container">
  
  <div class="panel-group col-md-8">
    <div class="panel panel-primary">
      <div class="panel-heading">AJOUTER UN PLAGE HORAIRE</div>
      <div class="panel-body">
        <?php
        if(isset($error_date)){echo $error_date;}
        if(isset($error_champ)){echo $error_champ;} 
        if(isset($error_heuere)){echo $error_heuere;}
        if(isset($errorweek)){echo $errorweek;}
        if(isset($errordate_nb)){echo $errordate_nb;}
        ?>
    <form action="" method="post">
    <div class="form-group ">
        <?php
            $forms = new Formulaire();
            $req = new Requette();
            $result = $req->selectOne('plage_horaire','id_horaire',$id);
            echo $forms->formInput('Date','date','dates','Entrez la date',$result['dates']);
            echo $forms->formInput('Heure début ','time','heured','',$result['heure_debut']);
            echo $forms->formInput('Heure fin ','time','heuref','',$result['heure_fin']);
            echo $forms->formInput('','hidden','medecin','',$_SESSION['id_medecin']);
        ?>
    </div>
    
        <?php echo $forms->formSubmit('submit','Modifier'); ?>
   
    
    </form>
      </div>
 
    </div>
  </div>
  

</body>
</html>
<?php
}
?>