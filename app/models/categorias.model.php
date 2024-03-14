<?php

require_once 'app/models/model.php';

class CategoriasModel extends Model{

    function verRemeras(){

        $query= $this->db->prepare("SELECT * FROM tablaprendas WHERE categoria LIKE 'R%'");
        $query->execute();

        $prendas = $query->fetchAll(PDO::FETCH_OBJ);

        return $prendas;
    }

    function verPantalones(){

        $query= $this->db->prepare("SELECT * FROM tablaprendas WHERE categoria LIKE 'P%'");
        $query->execute();

        $prendas = $query->fetchAll(PDO::FETCH_OBJ);

        return $prendas;
    }

    function verBuzos(){

        $query= $this->db->prepare("SELECT * FROM tablaprendas WHERE categoria LIKE 'B%'");
        $query->execute();

        $prendas = $query->fetchAll(PDO::FETCH_OBJ);

        return $prendas;
    }
    
}

?>