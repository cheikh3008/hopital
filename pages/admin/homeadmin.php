<?php
session_start();
    require_once '../classes/ConnexionDB.php';
    require_once '../classes/Requette.php';
    require_once '../classes/Formulaire.php';
    require_once '../classes/Menu.php';
    if(isset($_SESSION['email'])){
      $session = $_SESSION['email'];
    

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
  <link rel="stylesheet" href="../../css/admin.css">
  <title>ACCUEIL</title>
</head>

<body>

  <!-- Navigation -->
  <div class="container-fluid">
  <nav class="navbar navbar-inverse">
            
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
           
          </nav>
      <div class="bloc_card">
          <div class="new1">
            <img src="../../img/sec.jpg" alt="Domaine"   >
            <h1>SECRETARIAT</h1>
            <p> Le secrétaire médical veille au bon fonctionnement du cabinet médical. Il tient le standard téléphonique, répond aux demandes des patients, les informe des horaires de visites au cabinet ou à domicile.Il prend les rendez-vous avec le ou les médecins composant le cabinet médical, gère leurs agendas et doit savoir juger de l’urgence d’une situation.
            </p>
            <h2><?php 
              $req = new ConnexionDB();
              $secretaire  = $req->connect()->query("SELECT COUNT(*) FROM secretaire ");
              $secretaire = $secretaire->fetchColumn();
              echo '<h3> Nombre de secretaires : '. $secretaire.'</h3>';
              
            ?></h2>
            </div>
          <div class="new1">
            <img src="../../img/medec.jpg" alt="Domaine">
            
           <h1>MEDECINE</h1>
            <p>  Le Médecin connaît parfaitement les besoins de chaque patient en fonction de son profil et sera parfaitement capable d’adapter les traitement pour un jeune enfant ou une personne âgée. Parfait connaisseur du corps humain, il est aussi bien capable de repérer une angine que de déceler des troubles cardio-vasculaires. 
            </p>
            <h2><?php 
              $req = new ConnexionDB();
              $medecin  = $req->connect()->query("SELECT COUNT(*) FROM medecin ");
              $medecin = $medecin->fetchColumn();
              echo '<h3> Nombre de medecins : '. $medecin.'</h3>';
     
            ?></h2>
        </div>
        <div class="new1">
            <img src="../../img/ser.jpg" alt="Domaine"  >
            
            <h1>SERVICES</h1>
            <p>Opérateur de la régulation,  le service médical de l’Assurance Maladie  exerce une mission de service public et concourt, avec les professionnels de santé, à un meilleur fonctionnement du système de santé. <br>
              Il contribue à assurer, avec l'ensemble de l'Assurance Maladie, l'accès de tous à des soins de qualité au meilleur coût.
            </p>
            <h2><?php 
              $req = new ConnexionDB();
              $nbservice  = $req->connect()->query("SELECT COUNT(*) FROM services ");
              $nbservice = $nbservice->fetchColumn();
              echo '<h3> Nombre de services : '. $nbservice.'</h3>';
       
            ?></h2>
        </div>
        </div>
        </div>
</body>
</html>

<?php
}else{
  header('location:admin.php');
}
?>