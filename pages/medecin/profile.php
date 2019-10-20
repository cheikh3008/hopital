<?php
session_start();
if(isset($_SESSION['prenom'])){
    echo $_SESSION['prenom'];
}
?>