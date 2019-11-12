<?php
session_start();
    require_once '../classes/ConnexionDB.php';
    require_once '../classes/Requette.php';
    require_once '../classes/Formulaire.php';
    require_once '../classes/Menu.php';
    
    if(isset($_GET['id'])){
    $id =$_GET['id'];
    if(isset($_SESSION['id_secretaire'])){
        $id_secretaire = $_SESSION['id_secretaire'];
    $req = new ConnexionDB();
    $add = new Requette();
    $result = $add->selectOne('patient','id_patient',$id);
    if(isset($_POST['submit'])){
        $prenom = $_POST['prenom'];
        $nom = $_POST['nom'];
        $telephone = $_POST['telephone'];
        $age = $_POST['age'];
        $adresse = $_POST['adresse'];
        $secretaire = $_POST['secretaire'];
        if(!empty($prenom) && !empty($nom) && !empty($telephone) && !empty($age) && !empty($adresse)){
           if(is_numeric($age) && $age > 0){
              if(preg_match('#^(77||78||76||70)[0-9]{7}$#', $telephone)){
                $donnees = ['prenom'=>$prenom,'nom'=>$nom,'age'=>$age,'adresse'=>$adresse,'telephone'=>$telephone,'id_secretaire'=>$secretaire];
                $res = $add->update($donnees,$id,'patient','id_patient');
                if($res){
                   if(isset($_SESSION['id_secretaire'])){
                header('location:profile.php?id='.$_SESSION['id_secretaire']);
            }
                }else{
                    echo 'ca ne marche pas';
                }
              }else{
                $error_numb = "<p class=\"alert alert-danger \" role=\"alert\"> Veuillez saisir un numero valide . </p>";
              }
           }else{
            $error_age = "<p class=\"alert alert-danger \" role=\"alert\"> Veuillez saisir un age valide . </p>";
           }
        }else{
            $error_champ = "<p class=\"alert alert-danger \" role=\"alert\"> Veuillez remplir tous les champs . </p>";
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
  <title>PATIENT</title>
</head>
<body>
<nav class="navbar navbar-inverse">
            <div class="container-fluid">
              <ul class="nav navbar-nav">
                <li><a href="">PATIENT</a></li>
                <?php
                    if(isset($_SESSION['id_secretaire'])){
                        $s = $_SESSION['id_secretaire'];
                  ?>
                <li><a href='rv.php?id=<?php echo $s ;?>'>RENDEZ-VOUS</a>
              </li> <?php } ?>
              </ul>
              <ul class="nav navbar-nav navbar-right">
              <li class="connect"><?php if(isset( $_SESSION['prenom'])&& $_SESSION['prenom']){echo $_SESSION['prenom']." " .$_SESSION['nom'];}?></li>
                <li><a href="deconnexion.php"><span class="glyphicon glyphicon-log-in"></span> DECONNEXION</a></li>
              </ul>
            </div>
          </nav>
<div class="container-fluid">
  
  <div class="panel-group col-md-4">
    <div class="panel panel-primary">
      <div class="panel-heading">AJOUTER UN PATIENT</div>
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
            echo $forms->formInput('Prenom','text','prenom','Entrez le prénom',$result['prenom']);
            echo $forms->formInput('Nom ','text','nom','Entrez le nom ',$result['nom']);
            echo $forms->formInput('Age','text','age','Entrez l\'age',$result['age']);
            echo $forms->formInput('adresse','text','adresse','Entrez l\'adresse ',$result['adresse']);
            echo $forms->formInput('Telephone','tel','telephone','Entrez le numero ',$result['telephone']);
            echo $forms->formInput('','hidden','secretaire','',$id_secretaire);
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