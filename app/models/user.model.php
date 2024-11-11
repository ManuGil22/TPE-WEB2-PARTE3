<?php
require_once "db.model.php";
class UserModel extends dbModel {
 
    public function getUserByUsername($username) {    
        $query = $this->db->prepare("SELECT * FROM acceso_usuarios WHERE username = ?");
        $query->execute([$username]);
    
        $user = $query->fetch(PDO::FETCH_OBJ);
    
        return $user;
    }
}