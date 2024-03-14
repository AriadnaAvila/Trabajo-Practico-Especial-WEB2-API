<?php
include_once 'app/api/api.controller.php';
include_once 'app/helpers/api_auth_helper.php';
include_once 'app/models/usuarios.model.php';

class ApiUsuariosController extends ApiController
{
    private $model;
    private $authHelper;

    function __construct()
    {
        parent::__construct();
        $this->model = new UsuariosModel();
        $this->authHelper =  new ApiAuthHelper();
    }


    function getToken($params = [])
    {

        // Pedir encabezado basic que debería haber mandado el frontend
        $basic = $this->authHelper->getAuthHeaders();

        // Chekeamos que esté
        if (empty($basic)) {
            $this->view->response('No envió encabezados de autenticación', 401);
            return;
        }

        // Separamos el encabezado en 2 partes (método y contenido) 
        $basic = explode(" ", $basic); // ["Basic", "base64(usr:pass)]

        // Checkear que la autorización sea de tipo "Basic" 
        if ($basic[0] != "Basic") {
            $this->view->response('Los encabezados de autenticación son correctos', 200);
            return;
        }

        // Desglosar la estructura del "Basic" que es un base64 y una contraseña mediante un : 
        $userpass = base64_decode($basic[1]); // user:pass
        $userpass = explode(":", $userpass); // ["user", "pass"]

        $user = $userpass[0];
        $pass = $userpass[1];

        $usuario = $this->model->obtenerEmail($user);  // Llamar a la DB 

        if (empty($usuario)) {
            $this->view->response('El usuario no existe', 401);
            return;
        }

        // Verificamos que el usuario sea válido
        if (!password_verify($pass, $usuario->password)) {
            $this->view->response("La contraseña no es válida.", 401);
            return;
        }

        $token = $this->authHelper->createToken($usuario);
        $this->view->response($token, 200);
    }
}
