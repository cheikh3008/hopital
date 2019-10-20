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
      <div class="panel-heading">DONNER UN RENDEZ-VOUS A UN PATIENT</div>
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
                $res = $req->selectWithCondition('patient','id_secretaire',$_GET['id']);
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
    <div class="panel-group col-md-8">
    <div class="panel panel-primary">
      <div class="panel-heading">LISTE DES PATIENT</div>
      <div class="panel-body">
       <!-- Liste des medecins -->
       <?php
       if(isset($_GET['id'])){
        $id =  $_GET['id']; 
        }
        $bdd = new ConnexionDB();
        $req = new Requette();
        $user = $req->selectAllCondition('patient','rendez_vous','secretaire','rendez_vous.id_patient','patient.id_patient','rendez_vous.id_secretaire',$id);
        
         echo "
         <table class=\"table\" >
         <thead class='thead-dark'>
           <tr>
             <th scope=\"col\">Numéro rv</th>
             <th scope=\"col\">Prenom</th>
             <th scope=\"col\">Nom</th>
             <th scope=\"col\">Age</th>
             <th scope=\"col\">Adresse</th>
             <th scope=\"col\">Telephone</th>
             <th scope=\"col\">Date rv</th>
             <th scope=\"col\">Heure debut</th>
             <th scope=\"col\">Heure fin</th>
             <th scope=\"col\">Actions</th>
           </tr>
         </thead>
         ";
        
         foreach($user as $val){
             echo"<tbody>";
             echo "<tr>
             <td>".$val['num_rv']."</td>
             <td>".$val['prenom']."</td>
             <td>".$val['nom']."</td>
             <td>".$val['age']."</td>
             <td>".$val['adresse']."</td>
             <td>".$val['telephone']."</td>
             <td>".$val['date']."</td>
             <td>".$val['heure_debut']."</td>
             <td>".$val['heure_fin']."</td>";
             echo "
             <td><a class='btn btn-primary'href='editrv.php?id=".$val['num_rv']."'><em class=\"far fa-edit\"></em></a> 
                 <a class='btn btn-danger' href='delrv.php?id=".$val['num_rv']."' onclick=\"return confirm('êtes vous sure de vouloir supprimer cet enrégistrement ?')\";><em class=\"fas fa-trash-alt\"></em></a>
             </td>";
         }
         echo "</tbody>";
         echo "</table>";
       
        ?>
      </div>
 
    </div>
  </div>

</body>
</html>

</body>
</html>
