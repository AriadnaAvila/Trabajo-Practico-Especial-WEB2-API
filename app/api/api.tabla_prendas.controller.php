<?php

include_once 'app/models/tabla_prendas.model.php';
include_once 'app/api/api.controller.php';
include_once 'app/helpers/api_auth_helper.php';

class ApiTablaPrendasController extends ApiController
{

    private $model;
    private $authHelper;
    function __construct()
    {
        parent::__construct();
        $this->model = new TablaPrendasModel();
        $this->authHelper = new ApiAuthHelper();
    }

    public function get($params = [])
    {

        /*
            Ordenar ASC o DESC
            api/prendas?sortby=costo&order=ASC 
            Si encuentra "sortby y order" entra
        */  
        if (isset($_GET['sortby']) && isset($_GET['order'])) {

            if (($_GET['sortby'] == 'id_prenda' || $_GET['sortby'] == 'prenda' || $_GET['sortby'] == 'categoria' || $_GET['sortby'] == 'costo' || $_GET['sortby'] == 'rebaja')
                && ($_GET['order'] == 'ASC' || $_GET['order'] == 'DESC')
            ) {

                $prendas = $this->model->ordenar($_GET['sortby'], $_GET['order']);

                return $this->view->response($prendas, 200);
            } else {

                return $this->view->response("Los campos son inválidos", 400);
            }
        }

        /**
         *  Pregunto si no pasó parámetros el usuario, si no lo hizo, quiere decir que quiere ver todas las prendas
         *  TRAER TODAS LAS PRENDAS
         *  api/prendas 
         */

        if (empty($params)) {
            /**
             * Si quiere ver todas las prendas, quizás quiera paginar, por ende antes pregunto si existe "page". 
             * Si no existe, muestro todas las prendas
             * api/prendas?page=NUMERO
             */
            if(isset($_GET['page'])){
                $num = ($_GET['page']) ? (int)$_GET['page'] : 1;
                $page = $num > 0? $num : 1;
                $tabla = $this->model->paginado($page);
            }else{
                $tabla = $this->model->ver();
            }

            if (empty($tabla)) {

                $this->view->response($tabla, 404);
            } else {

                $this->view->response($tabla, 200);
            }
        } else { 
            /**
             * TRAER UNA PRENDA POR ID
             * 
             * Si existe un parámetro pasado por el usuario, llamo a verPrenda y muestro por ID en específico.
             * api/prendas/ID
             */
            $prenda = $this->model->verPrenda($params[':ID']);

            if (!empty($prenda)) {

                $this->view->response($prenda, 200);
            } else {

                $this->view->response('La prenda con el id=' . $params[':ID'] . ' no existe', 404);
            }
        }
    }

    function delete($params = [])
    {

        $user = $this->authHelper->currentUser();
        if (!$user) {
            $this->view->response('Unauthorized', 401);
            return;
        }

        $id_prenda = $this->model->eliminar($params[':ID']);

        if (empty($id_prenda)) {

            $this->view->response('La prenda con el id=' . $params[':ID'] . ' no existe', 404);
        } else {

            $this->view->response('La prenda con el id=' . $params[':ID'] . ' fue borrada con éxito', 200);
        }
    }

    function add($params = [])
    {

        $user = $this->authHelper->currentUser();
        if (!$user) {
            $this->view->response('Unauthorized', 401);
            return;
        }

        $body = $this->getData();

        $prenda = $body->prenda;
        $categoria = $body->categoria;
        $costo = $body->costo;
        $rebaja = $body->rebaja;


        if (empty($prenda) || empty($categoria) || empty($costo) || empty($rebaja)) {

            $this->view->response('Complete todos los campos correctamente para crear la prenda', 400);
            return;
        } else {

            $id = $this->model->insertar($prenda, $categoria, $costo, $rebaja);
            $this->view->response('La prenda ha sido creada con exito con el siguiente id:' . $id, 201);
        }
    }

    function update($params = [])
    {

        $user = $this->authHelper->currentUser();
        if (!$user) {
            $this->view->response('Unauthorized', 401);
            return;
        }
        // Para editar necesito saber sobre qué ID de prenda, entonces agarro ese id del router_api
        $id_prenda = $params[':ID'];

        $prenda = $this->model->verPrenda($params[':ID']);

        if (!$prenda) {

            $this->view->response('No existe ninguna prenda con el id:' . $id_prenda, 404);
        } else {

            $body = $this->getData();

            $prendaEdit = $body->prenda;
            $categoriaEdit = $body->categoria;
            $costoEdit = $body->costo;
            $rebajaEdit = $body->rebaja;

            if (empty($prendaEdit) || empty($categoriaEdit) || empty($costoEdit) || empty($rebajaEdit)) {

                $this->view->response('Complete todos los campos correctamente para actualizar la prenda', 400);
            } else {

                $this->model->actualizar($id_prenda, $prendaEdit, $categoriaEdit, $costoEdit, $rebajaEdit);

                $this->view->response('Se ha actualizado la informacion de la siguiente prenda con id:' . $id_prenda, 200);
            }
        }
    }

    function filter($params = [])
    {
        /**
         * Primero pregunto si el usuario escribió "costo" para ingresar al filter. 
         */
        if (isset($_GET['costo'])) {
            // Guardo el valor que ingresó el usuario y lo mando al model como parámetro y filtro por costo menor a $costo
            $costo = $_GET['costo'];
            $prendas = $this->model->filtrarCosto($costo);
            // Pregunto si está vacío el arreglo de objetos que guardé en mi variable $prendas
            if (empty($prendas)) {

                $this->view->response('No se encontro ninguna prenda por debajo del valor ingresado', 404);
            } else {
                $this->view->response($prendas, 200);
            }
        } else {

            $this->view->response('Campo invalido', 400);
        }
    }
}
