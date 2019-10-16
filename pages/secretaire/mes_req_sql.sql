afficher tous les patients ajouter par secretaire = ?
SELECT DISTINCT patient.prenom,patient.nom,patient.age,patient.telephone,patient.adresse, secretaire.prenom as 'prenom secretaire',secretaire.nom as 'nom secretaire' FROM secretaire,patient WHERE secretaire.id_secretaire = 1  AND patient.id_secretaire = 1;
