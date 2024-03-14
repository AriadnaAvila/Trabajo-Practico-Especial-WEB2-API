<?php

//funciones: manejar codigo de respuesta y devolver json. Hacemos una APIview genérica
class APIview{

    // le pasamos un parámetro $data para que lo convierta a json
    public function response($data, $status){
        // para que el cliente-servidor sepan en qué lenguaje están trabajando
        header("Content-Type: application/json");
        header("HTTP/1.1  " . $status . " " . $this->requestStatus($status));
        echo json_encode($data);
    }

    private function requestStatus($code){
        $status = array(
            200 => "OK",
            201 => "Created",
            400 => "Bad Request",
            401 => "Unauthorized",
            404 => "Not found",
            500 => "Internal Server Error"
        );
        return (isset($status[$code]))? $status[$code] : $status[500];
    }

}

?>