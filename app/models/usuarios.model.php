<?php

require_once 'app/models/model.php';

class UsuariosModel extends Model{

    function obtenerEmail($email){

        $query = $this->db->prepare('SELECT * FROM usuarios WHERE email=?');
        $query->execute([$email]);

        return $query->fetch(PDO::FETCH_OBJ);

    }

}

?>