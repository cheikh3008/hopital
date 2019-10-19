<?php
session_start();
    require_once '../classes/ConnexionDB.php';
    require_once '../classes/Requette.php';
    require_once '../classes/Formulaire.php';
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $req = new Requette();
        $result = $req->delete('patient','id_patient',$id);
        if($result){
            header('location:profile.php?id='.$id);
        }else{
            echo 'erreur de suppression';
        }
    }   
    
?>
