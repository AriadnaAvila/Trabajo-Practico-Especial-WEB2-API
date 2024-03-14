<?php

require_once 'app/models/model.php';

class TablaPrendasModel extends Model{

    function ver() {
        
        //Envio la consulta y después la ejecuto
        $query= $this->db->prepare('SELECT * FROM tablaprendas');
        $query->execute();

        //Obtengo la respuesta de la consulta con un FetchAll y lo devuelve en formato arreglo
        $tabla= $query->fetchAll(PDO::FETCH_OBJ);

        return $tabla;

    }

    function paginado($page = 1) {
        
        // Limito el paginado para que me traiga 5 prendas por página
        $query= $this->db->prepare('SELECT * FROM tablaprendas LIMIT 5 OFFSET '.(($page-1)*5));
        $query->execute();

        //Obtengo la respuesta de la consulta con un FetchAll y lo devuelve en formato arreglo
        $tabla= $query->fetchAll(PDO::FETCH_OBJ);

        return $tabla;

    }

    function insertar($prenda,$categoria,$costo,$rebaja){

        $query= $this->db->prepare('INSERT INTO tablaprendas (prenda, categoria, costo, rebaja) VALUES(?,?,?,?)');
        $query->execute([$prenda,$categoria,$costo,$rebaja]);
        // devuelvo el id generado
        return $this->db->lastInsertId();      

    }

    function eliminar($id){

        $query_tabla2= $this->db->prepare('DELETE FROM  tabladetalles WHERE id_prenda=?');
        $query_tabla2->execute([$id]);

        $query= $this->db->prepare('DELETE FROM tablaprendas WHERE id_prenda=?');
        $query->execute([$id]);

        // Devolver la cant de columnas afectadas, sino borro ninguna nos devuelve 0, por ende da false
        return $query->rowCount();

    }

    function actualizar($id,$prendaEdit,$categoriaEdit,$costoEdit,$rebajaEdit){

        $query= $this->db->prepare('UPDATE tablaprendas SET prenda=?, categoria=?, costo=?, rebaja=? WHERE tablaprendas.id_prenda =?');
        $query->execute([$prendaEdit,$categoriaEdit,$costoEdit,$rebajaEdit,$id]);

        return $query->rowCount();


    }
    
    function tomarIdPrenda(){

        $query= $this->db->prepare('SELECT id_prenda FROM tablaprendas');
        $query->execute();

        $tomado= $query->fetchAll(PDO::FETCH_OBJ);

        return $tomado;

    }

    function verPrenda($id_item) {

        //Envio la consula y después la ejecuto
        $query= $this->db->prepare('SELECT * FROM tablaprendas WHERE id_prenda=?');
        $query->execute([$id_item]);
 
        //Obtengo la respues de la consulta con un Fecthall y lo devuelve en formato arreglo
        $item= $query->fetch(PDO::FETCH_OBJ);
 
        return $item;

    }

    function ordenar($sortby, $order){

       $query= $this->db->prepare("SELECT * FROM tablaprendas ORDER BY $sortby $order");
       $query->execute();

       $tabla= $query->fetchAll(PDO::FETCH_OBJ);

       return $tabla;

    }

    function filtrarCosto($costo){

        $query= $this->db->prepare("SELECT * FROM tablaprendas WHERE costo < ?");
        $query->execute([$costo]);

        $prendas= $query->fetchAll(PDO::FETCH_OBJ);

        return $prendas;

    }
}

?>