<?php
session_start();
  if(isset($_POST['submit'])){
    if(empty($_POST['email']) && empty($_POST['passwd'])){
      $errreur = '<p class="alert alert-danger">Tous les champs doivent être remplis.</p>';
    }else{
      $email = $_POST['email'];
      $passwd = $_POST['passwd'];
      if($email == 'admin@gmail.com' && $passwd == 'admin123') {
        $_SESSION['email'] = $email;
        header('location:homeadmin.php');
      }else{
        $errreur2 = '<p class="alert alert-danger">Adresse email ou mot de passse incorrect.</p>';
      }
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
    <title>COMPTE ADMIN</title>
</head>
<body>

  <div class="modal-dialog text-center" > 
      <div class="col-sm-8 main-section">
        <div class="modal-content">
          <div class="col-12 user-img" >
            <img src="../../img/users.png" alt="user">
          </div>
          <form class="col-12" action="" method="post">
            <div class="form-group"> <em class="fas fa-user fasi"></em>
              <input type="text" class="form-control" name="email" placeholder="Entrez votre email">
            </div>
            <div class="form-group"><em class="fas fa-lock fasi"></em>
              <input type="password" class="form-control" name="passwd" placeholder="Entrez votre mot de passe">
            </div>
            <em class="fas fa-sign-in-alt"></em> <input type="submit" class="btn button" value="Connecter" name="submit">
          </form>
        </div> 
        <div>
          <?php if(isset($errreur)) {echo $errreur;}?>
          <?php if(isset($errreur2)) {echo $errreur2;}?>
        </div>
      </div>
  </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
