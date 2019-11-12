<?php
session_start();
    require_once '../classes/ConnexionDB.php';
    require_once '../classes/Requette.php';
    require_once '../classes/Formulaire.php';
    if(isset($_GET['id'])){
    $id = $_GET['id'];
    }
    if(isset($_POST['submit'])){
        $dates = $_POST['dates'];
        $heure = $_POST['heure'];
        $secretaire = $_POST['secretaire'];
        $horaire[] = $_POST['horaire'];
        $medecin[] = $_POST['medecin'];
        $patient[] = $_POST['patient'];
        if(!empty($dates) && !empty($heure)  && !empty($horaire) && !empty($secretaire)&& !empty($medecin) && !empty($patient)){
        $donnees = [ 'dates'=>$dates,'heure'=>$heure,'id_secretaire'=>$secretaire,'id_horaire'=>$horaire,'id_medecin'=>$medecin,'id_patient'=>$patient ];
        $datenow = new DateTime();
        $req = new ConnexionDB();
       
        if ($datenow <= DateTime::createFromFormat('Y-m-d', $dates) ){
            if(isset($_SESSION['id_secretaire'])){
                $id_secretaire = $_SESSION['id_secretaire'];
            }
            $nbheure  = $req->connect()->prepare("SELECT COUNT(dates) as dates ,  COUNT(heure) as heure  FROM `rendez_vous` WHERE dates = :dates AND heure = :heure AND id_secretaire = $id_secretaire" );
                $nbheure->execute(array('heure'=>$heure,'dates'=>$dates));
                while($heure_verify = $nbheure->fetch()){
                    if($heure_verify['heure'] == 0 && $heure_verify['dates'] == 0){
                        $weekDay = date('w', strtotime($dates));
                        if($weekDay != 0 && $weekDay != 6) {
                            if(preg_match('/^([0-9]){1,2}+:([0-9]){1,2}+$/', $heure)){
                                $explode= explode(":", $heure);
                                $heures= $explode[0];
                                $minute= $explode[1];
                                if($heures >=8 && $heures <=17){
                                foreach ($horaire as $horaire) {
                                    $horaire = intval($horaire);
                                    
                                }
                                foreach ($medecin as $medecin) {
                                    $medecin = intval($medecin);
                                }
                                foreach ($patient as $patient) {
                                    $patient = intval($patient);
                                }
                                $donnees = ['dates'=>$dates,'heure'=>$heure,'id_secretaire'=>$secretaire,'id_horaire'=>$horaire, 'id_medecin'=>$medecin,'id_patient'=>$patient];
                                $add = new Requette();
                                $res =  $add->insert($donnees,'rendez_vous');
                                if($res){
                                   header('location:rv.php?id='.$_SESSION['id_secretaire']);
                                }else{
                                    echo 'impossible';
                                }
                                    
                                }else{
                                    $errorheure_int = "<p class=\"alert alert-danger \" role=\"alert\">Impossible de réserver pour cette heure. </p>"; 
                                }
                            }else{
                                $errorheure = "<p class=\"alert alert-danger \" role=\"alert\"> L'heure n\'est pas valide. </p>"; 
                            }
                        }else{
                            $errorweek = "<p class=\"alert alert-danger \" role=\"alert\"> Impossible de réserver les week_end. </p>"; 
                        }
                }else{
                    $errorheure_reserv = "<p class=\"alert alert-danger \" role=\"alert\"> Cette heure est déja réservée. </p>";
                }
            }
        }
        else{
            $error_date = "<p class=\"alert alert-danger \" role=\"alert\"> La date est passée. </p>";
        } 
        }else{
            $error_champ = "<p class=\"alert alert-danger \" role=\"alert\"> Tous les champs doivent être remplis. </p>";
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
            <li class="connect"><?php if(isset( $_SESSION['prenom'])&& $_SESSION['prenom']){echo $_SESSION['prenom']." " .$_SESSION['nom'];}?></li>
            <li><a href="deconnexion.php"><span class="glyphicon glyphicon-log-in"></span> DECONNEXION</a></li>
            </ul>
        </div>
        </nav>
        <div class="container-fluid">
  
  <div class="panel-group col-md-2">
    <div class="panel panel-primary">
      <div class="panel-heading">DONNER UN RV</div>
      <div class="panel-body">
        <?php
        if(isset($error_champ)){echo $error_champ;} 
        if(isset($error_date)){echo $error_date;}  
        if(isset($errorheure_reserv)){echo $errorheure_reserv;} 
        if(isset($errorweek)){echo $errorweek;}    
        if(isset($errorheure_int)){echo $errorheure_int;}   
        ?>
    <form action="" method="post">
        <div class="form-group ">
            <?php
                $forms = new Formulaire();
                $req = new Requette();
                echo $forms->formInput('Date','date','dates','Entrez la date');
                echo $forms->formInput('Heure  ','time','heure','');
                echo $forms->formInput('','hidden','secretaire','',$_GET['id']);
                $res = $req->selectAll('plage_horaire');
                $liste_option= "";
                if(!empty($res)){
                foreach ($res as $value) {

                        $liste_option .= "<option value=".$value['id_horaire']."> ".$value['dates']."</option>";
                    }
                }else{
                    echo "<p class=\"alert alert-danger \" role=\"alert\"> La table est vide    . </p>";
                }
                echo $forms->selectList('Choisissez une horaire','horaire',$liste_option);

                if(isset($_SESSION['id_service'])){
                    $id_service = $_SESSION['id_service'];
                }    
                $res = $req->selectWithCondition('medecin','id_service',$id_service);
                $liste_option= "";
                if(!empty($res)){
                foreach ($res as $value) {

                    $liste_option .= "<option value=".$value['id_medecin'].">" .$value['id_medecin'].' - '.$value['prenom'].' - '.$value['nom']."</option>";
                }
                }else{
                    echo "<p class=\"alert alert-danger \" role=\"alert\"> La table est vide. </p>";
                }
                echo $forms->selectList('Choisissez un medecin','medecin',$liste_option);
                $res = $req->selectWithCondition('patient','id_secretaire',$_GET['id']);
                $liste_option= "";
                if(!empty($res)){
                foreach ($res as $value) {

                    $liste_option .= "<option value=".$value['id_patient'].">" .$value['id_patient'].' - '.$value['prenom'].' - '.$value['nom']."</option>";
                }
                }else{
                    echo "<p class=\"alert alert-danger \" role=\"alert\"> La table est vide. </p>";
                }
                echo $forms->selectList('Choisissez un patient','patient',$liste_option);
            ?>
            </div> 
            <?php echo $forms->formSubmit('submit','Enrégister'); ?>
        </form>
        </div>
        </div>
    </div>
    <div class="panel-group col-md-10">
    <div class="panel panel-primary">
      <div class="panel-heading">LISTE DES RENDEZ-VOUS</div>
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
         <table class=\"table\" align=\"center\" >
         <thead class='thead-dark' align=\"center\">
           <tr>
             <th scope=\"col\">Numéro RV</th>
             <th scope=\"col\">Prenom</th>
             <th scope=\"col\">Nom</th>
             <th scope=\"col\">Age</th>
             <th scope=\"col\">Adresse</th>
             <th scope=\"col\">Telephone</th>
             <th scope=\"col\">Date rv</th>
             <th scope=\"col\">Heure rv</th>
             <th scope=\"col\">Actions</th>
           </tr>
         </thead>
         ";
        if(!empty($user)){
         foreach($user as $val){
             echo"<tbody>";
             echo "<tr>
            <td>".$val['num_rv']."</td>
            <td>".$val['prenom']."</td>
            <td>".$val['nom']."</td>
            <td>".$val['age']."</td>
            <td>".$val['adresse']."</td>
            <td>".$val['telephone']."</td>
            <td>".$val['dates']."</td>
            <td>".$val['heure']."</td>";
             echo "
            <td><a class='btn btn-primary'href='editrv.php?id=".$val['num_rv']."'><em class=\"far fa-edit\"></em></a> 
                 <a class='btn btn-danger' href='delrv.php?id=".$val['num_rv']."' onclick=\"return confirm('êtes vous sure de vouloir supprimer cet enrégistrement ?')\";><em class=\"fas fa-trash-alt\"></em></a>
             </td>";
         }
         echo "</tbody>";
         echo "</table>";
        }else{
            echo "<p class=\"alert alert-danger \" role=\"alert\"> Le tableau ne contient aucun élément. </p>";
        }
        ?>
      </div>
 
    </div>
  </div>

</body>
</html>

</body>
</html>
