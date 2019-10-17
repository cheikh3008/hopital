<?php
class Requette extends ConnexionDB{

    /**
     * Méthode qui permet de selectionner tous les informations d'une table.
     */
    public function selectAll($nomtable){
        $sql = "SELECT * FROM $nomtable";
        $res = $this->connect()->query($sql);
        if($res->rowCount() > 0){
            while($ligne  = $res->fetch()){
                $d []= $ligne;

            }
        }
        return $d;
    }

     /**
     * Méthode qui permet d'ajouter des informations dans une table de la base de données.
     */
    public function insert($fields,$nomtable){
        $cle = implode(', ',array_keys($fields));

        $valeur = implode(", :",array_keys($fields));

        $sql = "INSERT INTO $nomtable ($cle) VALUES (:".$valeur.")";

        $req = $this->connect()->prepare($sql);

        foreach($fields as $key => $value){
            $req->bindValue(':'.$key,$value);
        }
        $result = $req->execute();

        return $result;
    }


    /**
     * Méthode qui permet de supprimer un champs .
     */
    public function delete($nomtable,$nom_id_table,$id){
        $sql = "DELETE FROM $nomtable WHERE $nom_id_table = :id";
        $req = $this->connect()->prepare($sql);
        $req->bindValue(':id', $id);
        $result = $req->execute();
        return $result;
    }

    /**
     * Méthode qui permet selectionner un champs .
     */
    public function selectOne($nomtable,$nom_id_table,$id){
        $sql = "SELECT * FROM $nomtable WHERE $nom_id_table = :id";
        $req = $this->connect()->prepare($sql);
        $req->bindValue(':id', $id);
        $req->execute();
        $result = $req->fetch(PDO::FETCH_ASSOC);
        return $result;
        
    }

    public function verfifyemail($nomtable,$email){
        $sql = "SELECT count(*) as nbemail FROM $nomtable WHERE email = :eamil";
        $req = $this->connect()->prepare($sql);
        $req->bindValue(':email', $email);
        $req->execute(array($email));
        while($email_verify  = $req->fetch()){
            if(isset($email_verify['nbemail']) != 0){
               echo 'Cette email est déja utlisé !';
            }
        }
      
    }
}
