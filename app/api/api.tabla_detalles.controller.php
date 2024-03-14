<?php

include_once 'app/models/tabla_detalles.model.php';
include_once 'app/api/api.controller.php';
include_once 'app/helpers/api_auth_helper.php';

class ApiTablaDetallesController extends ApiController
{

    private $model;
    private $authHelper;
    function __construct()
    {
        parent::__construct();
        $this->model = new TablaDetallesModel();
        $this->authHelper = new ApiAuthHelper();
    }

    public function get($params = []){

        // Si no encuentra "sortby y order", pregunto si no pasó parámetros el usuario, sino pasó entonces entra al if

        // ORDENAR ASC O DESC
        if (isset($_GET['sortby']) && isset($_GET['order'])) { 

            if (($_GET['sortby'] == 'id_detalles' || $_GET['sortby'] == 'talle' || $_GET['sortby'] == 'stock' || $_GET['sortby'] == 'categoria' || $_GET['sortby'] == 'id_prenda')
            &&($_GET['order']== 'ASC' || $_GET['order']== 'DESC')){

              $detalles = $this->model->ordenar($_GET['sortby'], $_GET['order']);

              return $this->view->response($detalles, 200);

            }else{

              return $this->view->response("Los campos son inválidos", 400);

            }

        } 

        //?sortby=&order=ASC
        
        if (empty($params)) {

            /*
                Ahora pregunto si el usuario escribió "page". Si lo hizo, que vaya al paginado,
                sino, que muestre todos los detalles 
            */
            if(isset($_GET['page'])){
                $num = ($_GET['page']) ? (int)$_GET['page'] : 1;
                $page = $num > 0? $num : 1;
                $tabla = $this->model->paginado($page);
            }else{
                $tabla = $this->model->ver2();
            }

            if (empty($tabla)) {

                $this->view->response($tabla, 404);

            } else {

                $this->view->response($tabla, 200);

            }
        } else { // TRAER UN DETALLE POR ID

            $detalle = $this->model->verItem($params[':ID']);

            if (!empty($detalle)) {

                $this->view->response($detalle, 200);

            } else {

                $this->view->response('El detalle con el id=' . $params[':ID'] . ' no existe', 404);
            
            }
        }
    }

    function delete($params = [])
    {

        $user = $this->authHelper->currentUser();
        if(!$user){
            $this->view->response('Unauthorized', 401);
            return;
        }

        $id_detalle = $this->model->eliminarDetalles($params[':ID']);

        if (empty($id_detalle)) {

            $this->view->response('El detalle con el id=' . $params[':ID'] . ' no existe', 404);
        } else {

            $this->view->response('El detalle con el id=' . $params[':ID'] . ' fue borrada con éxito', 200);
        }
    }

    function add($params = [])
    {

        $user = $this->authHelper->currentUser();
        if(!$user){
            $this->view->response('Unauthorized', 401);
            return;
        }

        $body = $this->getData();

        $talle = $body->talle;
        $stock = $body->stock;
        $categoria = $body->categoria;
        $id_prenda = $body->id_prenda;


        if (empty($talle) || empty($stock) || empty($categoria) || empty($id_prenda)) {

            $this->view->response('Complete todos los campos correctamente para crear el detalle', 400);
        } else {

            $id = $this->model->insertarDetalles($talle, $stock, $categoria, $id_prenda);
            $this->view->response('El detalle ha sido creada con exito con el siguiente id:' . $id, 201);
        }
    }

    function update($params = [])
    {

        $user = $this->authHelper->currentUser();
        if(!$user){
            $this->view->response('Unauthorized', 401);
            return;
        }

        $id_detalle = $params[':ID'];

        $detalle = $this->model->verItem($params[':ID']);

        if (!$detalle) {

            $this->view->response('No existe ningun detalle con el id:' . $id_detalle, 404);
        } else {

            $body = $this->getData();

            $talleEdit = $body->talle;
            $stockEdit = $body->stock;
            $categoriaEdit = $body->categoria;
            

            if (empty($talleEdit) || empty($stockEdit ) || empty($categoriaEdit)) {

                $this->view->response('Complete todos los campos correctamente para actualizar el detalle', 400);
            } else {

                $this->model->actualizarDetalles($id_detalle, $talleEdit, $stockEdit, $categoriaEdit);

                $this->view->response('Se ha actualizado la informacion de el siguiente detalle con id:' . $id_detalle, 200);
            }
        }
    }

    function filter($params = [])
    {

        if(isset($_GET['stock'])){

            $stock= $_GET['stock'];
            $detalles= $this->model->filtrarStock($stock);

            if(empty($detalles)){

                $this->view->response('No se encontro ningun stock por debajo del numero ingresado', 404);
            }else{
                $this->view->response($detalles, 200);
            }

        }else{

            $this->view->response('Campo invalido', 400);
        }
        
    }
    

}