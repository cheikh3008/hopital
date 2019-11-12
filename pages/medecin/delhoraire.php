<?php
session_start();
    require_once '../classes/ConnexionDB.php';
    require_once '../classes/Requette.php';
    require_once '../classes/Formulaire.php';
    if(isset($_SESSION['id_medecin'])){
        echo $_SESSION['id_medecin'];
    }
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $req = new Requette();
        $result = $req->delete('plage_horaire','id_horaire',$id);
        if($result){
            header('location:profile.php?id='.$_SESSION['id_medecin']);
        }else{
            echo 'erreur de suppression';
        }
    }   
    
?>
