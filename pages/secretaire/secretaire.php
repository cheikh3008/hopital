<?php
session_start();
require_once '../classes/ConnexionDB.php';
if (isset($_POST['submit'])) {
  if(!empty($_POST['email']) && !empty($_POST['mdp'])){
    $email=$_POST['email'];
    $mdp=sha1($_POST['mdp']);
    $req = new ConnexionDB();
    $res = $req->connect()->prepare("SELECT * FROM secretaire WHERE email= :email AND mdp= :mdp");
    $res->execute(array('email'=>$email,'mdp'=>$mdp));
    $requser = $res->rowCount();
    if($requser == 1 ){
      $infouser = $res->fetch();
      $_SESSION['id_secretaire'] = $infouser['id_secretaire'];
      $_SESSION['prenom'] = $infouser['prenom'];
      $_SESSION['nom'] = $infouser['nom'];
      header('location:profile.php?id='.$_SESSION['id_secretaire']);
    }else{
      echo 'mot de passe ou email incorrect !';
    }
       
       
    
    
  }else{
   $error = "<p class=\"alertalert-danger\"> Tous les champs doivent être remplis ! </p>";
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
    <link rel="stylesheet" href="../../css/main.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.9.0/css/all.css">
    <title>COMPTE SECRETAIRE</title>
</head>
<body>

  <div class="modal-dialog text-center" > 
      <div class="col-sm-8 main-section">
        <div class="modal-content">
          <div class="col-12 user-img" >
            <img src="../../img/login.png" alt="">
          </div>
          <form class="col-12" action="" method="post">
            <div class="form-group"> <em class="fas fa-user fasi"></em>
              <input  type="text" class="form-control" name="email" placeholder="Entrez votre email">
            </div>
            <div class="form-group"><em class="fas fa-lock fasi"></em>
              <input type="password" class="form-control" name="mdp" placeholder="Entrez votre mot de passe">
            </div>
            <em class="fas fa-sign-in-alt"></em> <input type="submit" class="btn button" value="Connecter" name="submit">
          </form>
        </div> 

      </div>
  </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>