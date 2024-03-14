# **PRADO **

Temática: Tienda de ropa

## - Descripción

Este Proyecto se basa en una tienda de ropa donde se utiliza una API RESTful fácil de usar que permite utilizar los servicios para un ABM, un filtrado y un ordenamiento de prendas y sus detalles mediante una base de datos.

La base de datos cuenta con dos tablas:

*tablaprendas*: Esta tabla consta de 5 columnas:
                *id_prenda:se utiliza para identificar a cada prenda la cual va a tener un ID único y se autoincrementa a medida que se agregar mas prendas.
                *prenda:se utiliza para poner el nombre a la prenda.
                *categoria:se utiliza para darle una categoria a nuestras prndas, en este caso consta con 3 tipos de categoria (REMERA,PANTALÓn,BUZO).
                *costo:se utiliza para darle el valor a la prenda ya asignada.
                *rebaja:se utliza en caso de que una prenda conste con una rebaja.

*detallesprenda*: Esta tabla consta de 5 columnas y depende especificamente de nuestra Tabla de Prendas, ya que se trata de poder ver detalles de las mismas:
                *id_detalles:se utiliza para identificar a cada detalle la cual va a tener un ID único y se autoincrementa a medida que se agregar mas detalles.
                *talle:se utliza para saber en que talle esta disponible la prenda que decidimos ver.
                *stock:se utiliza para saber cuantas prendas hay disponibles.
                *categoria:se utila para saber a que categoria pertenece la prenda.
                *id_prenda:se utiliza para identificar la prenda de la cual queremos saber los detalles.

Se utilizan los siguiente códigos de respuesta:

    200 => "OK"
    201 => "Created"
    400 => "Bad Request"
    401 => "Unauthorized"
    404 => "Not found"
    500 => "Internal Server Error"

## - ¿Cómo utilizar?

Para utilizar esta API, es necesario importar la base de datos a phpmyadmin desde la carpeta *db*. 
Se recomienda utilizar POSTMAN para probar cada endpoint a continuación. 

## API Endpoints

### - Obtener ambas tablas con toda su información

En este caso utilizaríamos un Endpoint GET para ver toda la tabla:
```
    tablaprendas: http://localhost/TP-WEB-2-FINAL-LIBRE/api/prendas

    detallesprenda: http://localhost/TP-WEB-2-FINAL-LIBRE/api/detalles 
```

### - Obtener por ID específico

En este caso utilizaríamos un Endpoint GET para ver una prenda o detalle por un ID específico:
```
    tablaprendas: http://localhost/TP-WEB-2-FINAL-LIBRE/api/prendas/id

    detallesprenda: http://localhost/TP-WEB-2-FINAL-LIBRE/api/detalles/id 
```

Un ejemplo de cada uno seria:
```
    http://localhost/TP-WEB-2-FINAL-LIBRE/api/prendas/29
    http://localhost/TP-WEB-2-FINAL-LIBRE/api/detalles/5
```

### - Eliminar por ID específico

En este caso utilizaríamos un Endpoint DELETE para eliminar una prenda o detalle por un ID específico:

```
    tablaprendas: http://localhost/TP-WEB-2-FINAL-LIBRE/api/prendas/id

    detallesprenda: http://localhost/TP-WEB-2-FINAL-LIBRE/api/detalles/id 
```

Un ejemplo de cada uno seria:
```
    http://localhost/TP-WEB-2-FINAL-LIBRE/api/prendas/29
    http://localhost/TP-WEB-2-FINAL-LIBRE/api/detalles/5
```

### - Agregar una prenda o un detalle de una prenda

En este caso utilizaríamos un Endpoint POST para agregar una prenda o un detalle de una prenda (no es necesario agregar un id ya todavía no se creó el mismo):

```
    tablaprendas: http://localhost/TP-WEB-2-FINAL-LIBRE/api/prendas

Por ejemplo:
    {
        "prenda": "Remera Sentinels",   
        "categoria": "remera",
        "costo": 9200,
        "rebaja": 24
    }

    tabladetalles: http://localhost/TP-WEB-2-FINAL-LIBRE/api/detalles

Por ejemplo:
    {
    "talle": "S",
    "stock": 15,
    "categoria": "remera",
    "id_prenda": 30
    }
```

### - Editar una prenda o un detalle

En este caso utilizaríamos un Endpoint PUT Para editar la prenda o el detalle (lo único que no se podrá editar son los ID):

```
    tablaprendas: http://localhost/TP-WEB-2-FINAL-LIBRE/api/prendas/id

Por ejemplo:

    http://localhost/TP-WEB-2-FINAL-LIBRE/api/prendas/29

    {
        "prenda": "Remera Sentinels",
        "tipo": "Remera",
        "costo": 9200,
        "rebaja": 24
    }

    tablaprendas: http://localhost/TP-WEB-2-FINAL-LIBRE/api/detalles/id

Por ejemplo:

    http://localhost/TP-WEB-2-FINAL-LIBRE/api/detalles/5

    {
    "talle": "S",
    "stock": 15,
    "categoria": "remera",
    }
```


### - Ordenar los campos de manera ascendente o descendente

_En este caso utilizaríamos un Endpoint GET para ordenar de manera ascendente o descendente por cualquier campo.

```
tablaprendas: http://localhost/TP-WEB-2-FINAL-LIBRE-API/api/prendas?sortby=(CAMPO)&order=(ASC O DESC)

Por ejemplo¨: http://localhost/TP-WEB-2-FINAL-LIBRE-API/api/prendas?sortby=rebaja&order=(ASC)

-------------------------------------------------------------------------------------------------------------

detallesprenda: http://localhost/TP-WEB-2-FINAL-LIBRE-API/api/detalles?sortby=(CAMPO)&order=(ASC O DESC)

Por ejemplo:detallesprenda: http://localhost/TP-WEB-2-FINAL-LIBRE-API/api/detalles?sortby=categoria&order=(DESC)
```

### - Filtrar por costo o stock

_En este caso utilizaríamos un Endpoint GET para filtrar por costo o stock.

```
El filtro en tablaprendas se hace para saber el costo de qué prendas están por debajo del precio (número) indicado:

tablaprendas: http://localhost/TP-WEB-2-FINAL-LIBRE-API/api/prendas/filtro/costos?costo=NUMERO

Por ejemplo:

tablaprendas: http://localhost/TP-WEB-2-FINAL-LIBRE-API/api/prendas/filtro/costos?costo=50000

El filtro en detallesprenda se hace para saber cuáles stocks están por debajo del número indicado.

detallesprenda: http://localhost/TP-WEB-2-FINAL-LIBRE-API/api/detalles/filtro/stocks?stock=NUMERO

Por ejemplo:

detallesprenda: http://localhost/TP-WEB-2-FINAL-LIBRE-API/api/detalles/filtro/stocks?stock=10
```

### - Paginado

_En este caso utilizaríamos un Endpoint GET para poder paginar. Se van a mostrar 5 prendas o detalles por cada paginado.

```
tablaprendas: http://localhost/TP-WEB-2-FINAL-LIBRE-API/api/prendas?page=NUMERO

Por ejemplo:

tablaprendas: http://localhost/TP-WEB-2-FINAL-LIBRE-API/api/prendas?page=2

-------------------------------------------------------------------------------

detallesprenda: http://localhost/TP-WEB-2-FINAL-LIBRE-API/api/detalles?page=NUMERO

Por ejemplo:

detallesprenda: http://localhost/TP-WEB-2-FINAL-LIBRE-API/api/detalles?page=1
```

###  - Autorización con Token

_Para poder identificarnos y lograr ser autorizados para hacer algún cambio en la API, debemos utilizar el metodo GET y cambiar nuestro endpoint.

```
http://localhost/TP-WEB-2-FINAL-LIBRE-API/api/user/token Luego con nuestro usuario y contraseña en Basic Auth con POSTMAN, accedemos para poder recibir un token. Este token es el que nos da la autorización para poder insertar, editar o eliminar ya sea prendas o detalles de estas. El token va a durar 1 hora y se pega el token en "Authorization" => Bearer Token.
```


