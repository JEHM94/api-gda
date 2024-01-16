# API Prueba Técnica  GDA
_Servicio de API para el Registro de Clientes con información de sus Regiones y Comunas_
# :page_facing_up:Guía de Instalación

### :information_source:Requerimientos previos
- **PHP.**
- **Composer.**
- **Algún gestor de bases de datos (MySQL Workbench, phpMyAdmin, Tableplus, etc).**
- **_Opcional:_ Postman o alguna otra herramienta para probar APIs**

### :small_blue_diamond:Paso 1. Instalar las dependencias
- Instalar las dependencias de la aplicación Laravel abriendo una terminal y ejecutando el comando ``` composer install ```

### :small_blue_diamond:Paso 2. Crear una base de datos
- Crear una base de datos mediante el uso de cualquier herramienta de administración de bases de datos, como MySQL Workbench, phpMyAdmin, Tableplus, etc.
- Renombar el archivo ```.env.example``` a ```.env```
- Configurar los ajustes de conexión de la base de datos en el archivo ```.env```de la aplicación. Por ejemplo:

  ```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=mydb
    DB_USERNAME=root
    DB_PASSWORD=mypassword
    ```
### :small_blue_diamond:Paso 3. Ejecutar la migración
- Ejecutar la migración de la aplicación abriendo una terminal e ingresando el comando ``` php artisan migrate ```
- Opcionalmente puede ejecutar el comando ``` php artisan db:seed ``` para proveer a la base de datos una serie de registros de prueba para las Regiones y Comunas.

### :small_blue_diamond:Paso 4. Ejecutar la aplicación
- Es hora de ejecutar la aplicación, ingresar el comando ``` php artisan serve ``` en la terminal para iniciar el servicio de API
- Una vez que el servicio esté en funcionamiento, puedes probarla utilizando herramientas como Postman.

Por ejemplo, para obtener una lista de todas las regiones, puedes utilizar la siguiente solicitud HTTP:
```
   GET http://localhost:8000/api/regions
```
### :information_source:Configuración adicional
- La aplicación almacena Logs de entrada y salida de información los cuales pueden ser consultados en el archivo ``` storage\logs\laravel.log ```. La aplicación puede ser configurada para almacenar únicamente los Logs de entrada realizando el siguiente cambio ``` LOG_LEVEL=info ``` en el archivo ``` .env ```

# Documentación

## Métodos

| Método | Descripción |
|---|---|
| :green_circle:GET | Obtiene un recurso |
| :large_blue_circle:POST | Crea un recurso |
| :red_circle:DELETE | Elimina un recurso |

# Rutas
> [!IMPORTANT]
> - Las rutas con autenticación de tipo "Auth" requieren de un Bearer Token que debe ser ingresado por medio de los headers de la solicitud.
> - El body de la solicitud debe contener los parámetros de entrada requeridos por la ruta.

## :diamond_shape_with_a_dot_inside:Usuarios
| Ruta | Método | Descripción | Autenticación |
|---|---|---|---|
| /api/registro | :large_blue_circle:POST | Registra un nuevo usuario | Guest |
| /api/login | :large_blue_circle:POST | Autentica un usuario | Guest |
| /api/logout | :large_blue_circle:POST | Autentica un usuario | Auth |

#### :small_blue_diamond:Parámetros de entrada

| Ruta | Método | Parámetro | Descripción |
|---|---|---|---|
| /api/registro| :large_blue_circle:POST | name | Nombre del usuario |
||| email | Correo electrónico |
||| password | Contraseña (Mínimo 8 caracteres) |
||| password_confirmation | Confirmación de contraseña |


| Ruta | Método | Parámetro | Descripción |
|---|---|---|---|
| /api/login| :large_blue_circle:POST | email | Correo electrónico |
||| password | Contraseña |

| Ruta | Método | Parámetro | Descripción |
|---|---|---|---|
| /api/logout| :large_blue_circle:POST | Bearer Token | Token de autenticación |

#### :small_blue_diamond:Parámetros de salida

| Ruta | Método | Parámetro | Descripción |
|---|---|---|---|
| /api/registro| :large_blue_circle:POST | token | Token de autenticación |
||| user | Usuario autenticado |
||| success | Solicitud completada (_true_), Error en pámetros (_false_) |
||| errors | Lista de errores con los parámetros incorrectos. |

| Ruta | Método | Parámetro | Descripción |
|---|---|---|---|
| /api/login| :large_blue_circle:POST |token | Token de autenticación |
||| user | Usuario autenticado |
||| success | Solicitud completada (_true_), Error en pámetros (_false_) |
||| errors | Lista de errores con los parámetros incorrectos. |

| Ruta | Método | Parámetro | Descripción |
|---|---|---|---|
| /api/logout| :large_blue_circle:POST | message | Mensaje de confirmación ó Solicitud no autenticada |
||| user | Usuario null |
||| success | Solicitud completada (_true_) |

## :diamond_shape_with_a_dot_inside:Clientes
| Ruta | Método | Descripción | Autenticación |
|---|---|---|---|
| /api/customers | :green_circle:GET | Muestra todos los clientes activos | Auth |
| /api/customers | :large_blue_circle:POST | Registra un nuevo cliente | Auth |
| /api/customers/{identifier} | :green_circle:GET | Muestra un cliente por su DNI o Email | Auth |
| /api/customers/{identifier} | :red_circle:DELETE | Elimina un cliente por su DNI o Email | Auth |

#### :small_blue_diamond:Parámetros de entrada

| Ruta | Método | Parámetro | Descripción |
|---|---|---|---|
| /api/customers | :green_circle:GET | Bearer Token | Token de autenticación |

| Ruta | Método | Parámetro | Descripción |
|---|---|---|---|
| /api/customers| :large_blue_circle:POST | Bearer Token | Token de autenticación |
||| dni | DNI del cliente |
||| email | Correo electrónico |
||| name | Nombre del cliente |
||| last_name | Apellido del cliente |
||| address | Dirección del cliente |
||| region_id | ID de la región |
||| commune_id | ID de la comuna |

| Ruta | Método | Parámetro | Descripción |
|---|---|---|---|
| /api/customers/{identifier}| :green_circle:GET / :red_circle:DELETE | Bearer Token | Token de autenticación |
||| {identifier} | DNI o Email del cliente |

#### :small_blue_diamond:Parámetros de salida

| Ruta | Método | Parámetro | Descripción |
|---|---|---|---|
| /api/customers | :green_circle:GET | data | Lista de clientes activos |
||| success | Solicitud completada (_true_) |
||| message | Mensaje solicitud no autenticada |

| Ruta | Método | Parámetro | Descripción |
|---|---|---|---|
| /api/customers | :large_blue_circle:POST | success | Solicitud completada (_true_), Error en pámetros (_false_) |
||| errors | Lista de errores con los parámetros incorrectos. |
||| message | Mensaje solicitud no autenticada |

| Ruta | Método | Parámetro | Descripción |
|---|---|---|---|
| /api/customers/{identifier} | :green_circle:GET | customer | Información del cliente encontrado |
||| success | Solicitud completada (_true_), Error en pámetros (_false_) |
||| errors | Lista de errores con los parámetros incorrectos. |
||| message | Mensaje solicitud no autenticada |

| Ruta | Método | Parámetro | Descripción |
|---|---|---|---|
| /api/customers/{identifier} | :red_circle:DELETE | success | Solicitud completada (_true_), Registro no existente (_false_) |
||| errors | Lista de errores |
||| message | Mensaje de Registro eliminado ó Solicitud no autenticada |

## :diamond_shape_with_a_dot_inside:Regiones
| Ruta | Método | Descripción | Autenticación |
|---|---|---|---|
| /api/regions | :green_circle:GET | Muestra todos las Regiones activas | Auth |
| /api/regions | :large_blue_circle:POST | Registra una nueva Región | Auth |
| /api/regions/{identifier} | :red_circle:DELETE | Elimina una Región por su ID | Auth |

#### :small_blue_diamond:Parámetros de entrada

| Ruta | Método | Parámetro | Descripción |
|---|---|---|---|
| /api/regions | :green_circle:GET | Bearer Token | Token de autenticación |

| Ruta | Método | Parámetro | Descripción |
|---|---|---|---|
| /api/regions | :large_blue_circle:POST | Bearer Token | Token de autenticación |
||| description | Descripción de la Región |

| Ruta | Método | Parámetro | Descripción |
|---|---|---|---|
| /api/regions/{identifier} | :red_circle:DELETE | Bearer Token | Token de autenticación |
||| {identifier} | ID de la Región |

#### :small_blue_diamond:Parámetros de salida

| Ruta | Método | Parámetro | Descripción |
|---|---|---|---|
| /api/regions | :green_circle:GET | data | Lista de regiones activas |
||| success | Solicitud completada (_true_) |
||| message | Mensaje solicitud no autenticada |

| Ruta | Método | Parámetro | Descripción |
|---|---|---|---|
| /api/regions | :large_blue_circle:POST | success | Solicitud completada (_true_), Error en pámetros (_false_) |
||| errors | Lista de errores con los parámetros incorrectos. |
||| message | Mensaje solicitud no autenticada |

| Ruta | Método | Parámetro | Descripción |
|---|---|---|---|
| /api/regions/{identifier} | :red_circle:DELETE | success | Solicitud completada (_true_), Registro no existente (_false_) |
||| errors | Lista de errores |
||| message | Mensaje de Registro eliminado ó Solicitud no autenticada |

## :diamond_shape_with_a_dot_inside:Comunas
| Ruta | Método | Descripción | Autenticación |
|---|---|---|---|
| /api/communes | :green_circle:GET | Muestra todos las Comunas activas | Auth |
| /api/communes | :large_blue_circle:POST | Registra una nueva Comuna | Auth |
| /api/communes/{identifier} | :red_circle:DELETE | Elimina una Comuna por su ID | Auth |

#### :small_blue_diamond:Parámetros de entrada

| Ruta | Método | Parámetro | Descripción |
|---|---|---|---|
| /api/communes | :green_circle:GET | Bearer Token | Token de autenticación |

| Ruta | Método | Parámetro | Descripción |
|---|---|---|---|
| /api/communes | :large_blue_circle:POST | Bearer Token | Token de autenticación |
||| region_id | ID de Región al que pertenece la Comuna |
||| description | Descripción de la Comuna |

| Ruta | Método | Parámetro | Descripción |
|---|---|---|---|
| /api/communes/{identifier} | :red_circle:DELETE | Bearer Token | Token de autenticación |
||| {identifier} | ID de la Comuna |

#### :small_blue_diamond:Parámetros de salida

| Ruta | Método | Parámetro | Descripción |
|---|---|---|---|
| /api/communes | :green_circle:GET | data | Lista de Comunas activas |
||| success | Solicitud completada (_true_) |
||| message | Mensaje solicitud no autenticada |

| Ruta | Método | Parámetro | Descripción |
|---|---|---|---|
| /api/communes | :large_blue_circle:POST | success | Solicitud completada (_true_), Error en pámetros (_false_) |
||| errors | Lista de errores con los parámetros incorrectos. |
||| message | Mensaje solicitud no autenticada |

| Ruta | Método | Parámetro | Descripción |
|---|---|---|---|
| /api/communes/{identifier} | :red_circle:DELETE | success | Solicitud completada (_true_), Registro no existente (_false_) |
||| errors | Lista de errores |
||| message | Mensaje de Registro eliminado ó Solicitud no autenticada |

# Ejemplo
- Para registrar un nuevo cliente debemos enviar una solicitud de método ``` POST ``` a la ruta ``` /api/customers ``` y construimos la consulta con los parámetros de entrada requeridos por el servicio de la siguiente forma.
```
headers: {
    Authorization: `Bearer PU100RI9gv9179uId0QFkmkU5TVMdsUq0KK1S3yX7c1e4bd1`,
},
body:{
    "dni": "52930150",
    "email": "jose@email.com",
    "name": "Jose",
    "last_name": "Pérez",
    "address": "Calle 32 #09",
    "region_id": "1",
    "commune_id": "2",
}
```
donde ```headers``` contiene la información del token de autenticación el cuál lo provee el servicio de autenticación de usuarios a través de las rutas ``` /api/registro ``` y ``` /api/login ```; y ``` body ``` contiene los parámetros requerios por el servicio para ingresar la información a la base de datos.
