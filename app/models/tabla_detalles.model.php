<?php

require_once 'app/models/model.php';

class TablaDetallesModel extends Model{

    function ver2() {
        
        //Envio la consulta y después la ejecuto
        $query= $this->db->prepare('SELECT * FROM tabladetalles');
        $query->execute();

        //Obtengo la respuesta de la consulta con un FetchAll y lo devuelvo en un arreglo de objetos
        $tabla= $query->fetchAll(PDO::FETCH_OBJ);

        return $tabla;

    }

    function paginado($page = 1) {
        
        //Envio la consulta y después la ejecuto
        $query= $this->db->prepare('SELECT * FROM tabladetalles LIMIT 5 OFFSET '.(($page-1)*5));
        $query->execute();

        //Obtengo la respuesta de la consulta con un FetchAll y lo devuelve en formato arreglo
        $tabla= $query->fetchAll(PDO::FETCH_OBJ);

        return $tabla;

    }


    function verItem($id_item) {

        //Envio la consula y después la ejecuto
        $query= $this->db->prepare('SELECT * FROM tabladetalles WHERE id_detalles=?');
        $query->execute([$id_item]);
 
        //Obtengo la respues de la consulta con un Fecthall y lo devuelve en formato arreglo
        $item= $query->fetch(PDO::FETCH_OBJ);
 
        return $item;

    }

    function insertarDetalles($talle, $stock, $categoria, $id_prenda){

        $query= $this->db->prepare('INSERT INTO tabladetalles (talle, stock, categoria, id_prenda) VALUES(?,?,?,?)');
        $query->execute([$talle,$stock,$categoria,$id_prenda]);

        return $this->db->lastInsertId();      

    }

    function actualizarDetalles($id, $talleEdit, $stockEdit, $categoriaEdit){

        $query= $this->db->prepare('UPDATE tabladetalles SET talle=?, stock=?, categoria=? WHERE tabladetalles.id_detalles =?');
        $query->execute([$talleEdit,$stockEdit,$categoriaEdit,$id]);

        return $query->rowCount();


    }

    function eliminarDetalles($id){

        $query= $this->db->prepare('DELETE FROM tabladetalles WHERE id_detalles=?');
        $query->execute([$id]);

        // Devolver la cant de columnas afectadas, sino borro ninguna nos devuelve 0, por ende da false
        return $query->rowCount();

    }

    function ordenar($sortby, $order){

        $query= $this->db->prepare("SELECT * FROM tabladetalles ORDER BY $sortby $order");
        $query->execute();
 
        $tabla= $query->fetchAll(PDO::FETCH_OBJ);
 
        return $tabla;
 
    }
 
     function filtrarStock($stock){
 
         $query= $this->db->prepare("SELECT * FROM tabladetalles WHERE stock < ?");
         $query->execute([$stock]);
 
         $detalles= $query->fetchAll(PDO::FETCH_OBJ);
 
         return $detalles;
 
    }
    
}

?>