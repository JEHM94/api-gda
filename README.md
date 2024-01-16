# API Prueba Técnica  GDA

# Guía de Instalación

### :small_blue_diamond:Paso 1. Instalar las dependencias
- Instalar las dependencias de la aplicación Laravel abriendo una terminal y ejecutando el comando ``` composer install ```

### :small_blue_diamond:Paso 2. Crear una base de datos
- Crear una base de datos mediante el uso de cualquier herramienta de administración de bases de datos, como MySQL Workbench, phpMyAdmin o Tableplus.
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
- Opcionalmente puede ejecutar el comando ``` php artisan db:seed ``` para proveer a la base de datos una serie de registros de prueba para las Regiones y Comunas

### :small_blue_diamond:Paso 4. Ejecutar la aplicación
- Es hora de ejecutar la aplicación, ingresar el comando ``` php artisan serve ``` en la terminal para iniciar el servicio de API
- Una vez que el servicio esté en funcionamiento, puedes probarla utilizando herramientas como Postman.

Por ejemplo, para obtener una lista de todas las regiones, puedes utilizar la siguiente solicitud HTTP:
```
   GET http://localhost:8000/api/regions
```

# Documentación

## Métodos

| Método | Descripción |
|---|---|
| GET | Obtiene un recurso |
| POST | Crea un recurso |
| DELETE | Elimina un recurso |

# Rutas
> [!IMPORTANT]
> - Las rutas con autenticación de tipo "Auth" requieren de un Bearer Token que debe ser ingresado por medio de los headers de la solicitud.
> - El body de la solicitud debe contener los parámetros de entrada requeridos por el endpoint.

## :arrow_right:Usuarios
| Ruta | Método | Descripción | Autenticación |
|---|---|---|---|
| /api/registro | POST | Registra un nuevo usuario | Guest |
| /api/login | POST | Autentica un usuario | Guest |
| /api/logout | POST | Autentica un usuario | Auth |

#### :small_blue_diamond:Parámetros de entrada

| Ruta | Parámetro | Descripción |
|---|---|---|
| /api/registro| name | Nombre del usuario |
|| email | Correo electrónico |
|| password | Contraseña (Mínimo 8 caracteres) |
|| password_confirmation | Confirmación de contraseña |


| Ruta | Parámetro | Descripción |
|---|---|---|
| /api/login| email | Correo electrónico |
|| password | Contraseña |

| Ruta | Parámetro | Descripción |
|---|---|---|
| /api/logout| Bearer Token | Token de autenticación |

#### :small_blue_diamond:Parámetros de salida

| Ruta | Parámetro | Descripción |
|---|---|---|
| /api/registro| token | Token de autenticación |
|| user | Usuario autenticado |
|| success | Solicitud completada (_true_), Error en pámetros (_false_) |
|| errors | Lista de errores con los parámetros incorrectos. |

| Ruta | Parámetro | Descripción |
|---|---|---|
| /api/login| token | Token de autenticación |
|| user | Usuario autenticado |
|| success | Solicitud completada (_true_), Error en pámetros (_false_) |
|| errors | Lista de errores con los parámetros incorrectos. |

| Ruta | Parámetro | Descripción |
|---|---|---|
| /api/logout| message | Mensaje de confirmación ó Solicitud no autenticada |
|| user | Usuario null |
|| success | Solicitud completada (_true_) |

## :arrow_right:Clientes
| Ruta | Método | Descripción | Autenticación |
|---|---|---|---|
| /api/customers | GET | Muestra todos los clientes activos | Auth |
| /api/customers | POST | Registra un nuevo cliente | Auth |
| /api/customers/{identifier} | GET | Muestra un cliente por su DNI o Email | Auth |
| /api/customers/{identifier} | DELETE | Elimina un cliente por su DNI o Email | Auth |

#### :small_blue_diamond:Parámetros de entrada

| Ruta | Método | Parámetro | Descripción |
|---|---|---|---|
| /api/customers | GET | Bearer Token | Token de autenticación |

| Ruta | Método | Parámetro | Descripción |
|---|---|---|---|
| /api/customers| POST | Bearer Token | Token de autenticación |
||| dni | DNI del cliente |
||| email | Correo electrónico |
||| name | Nombre del cliente |
||| last_name | Apellido del cliente |
||| address | Dirección del cliente |
||| region_id | ID de la región |
||| commune_id | ID de la comuna |

| Ruta | Método | Parámetro | Descripción |
|---|---|---|---|
| /api/customers/{identifier}| GET / DELETE | Bearer Token | Token de autenticación |
||| {identifier} | DNI o Email del cliente |

#### :small_blue_diamond:Parámetros de salida

| Ruta | Método | Parámetro | Descripción |
|---|---|---|---|
| /api/customers | GET | data | Lista de clientes activos |
||| success | Solicitud completada (_true_) |
||| message | Mensaje solicitud no autenticada |

| Ruta | Método | Parámetro | Descripción |
|---|---|---|---|
| /api/customers | POST | success | Solicitud completada (_true_), Error en pámetros (_false_) |
||| errors | Lista de errores con los parámetros incorrectos. |
||| message | Mensaje solicitud no autenticada |

| Ruta | Método | Parámetro | Descripción |
|---|---|---|---|
| /api/customers/{identifier} | GET | customer | Información del cliente encontrado |
||| success | Solicitud completada (_true_), Error en pámetros (_false_) |
||| errors | Lista de errores con los parámetros incorrectos. |
||| message | Mensaje solicitud no autenticada |

| Ruta | Método | Parámetro | Descripción |
|---|---|---|---|
| /api/customers/{identifier} | DELETE | success | Solicitud completada (_true_), Registro no existente (_false_) |
||| errors | Lista de errores |
||| message | Mensaje de Registro eliminado ó Solicitud no autenticada |

## :arrow_right:Regiones
| Ruta | Método | Descripción | Autenticación |
|---|---|---|---|
| /api/regions | GET | Muestra todos las Regiones activas | Auth |
| /api/regions | POST | Registra una nueva Región | Auth |
| /api/regions/{identifier} | DELETE | Elimina una Región por su ID | Auth |

#### :small_blue_diamond:Parámetros de entrada

| Ruta | Método | Parámetro | Descripción |
|---|---|---|---|
| /api/regions | GET | Bearer Token | Token de autenticación |

| Ruta | Método | Parámetro | Descripción |
|---|---|---|---|
| /api/regions | POST | Bearer Token | Token de autenticación |
||| description | Descripción de la Región |

| Ruta | Método | Parámetro | Descripción |
|---|---|---|---|
| /api/regions/{identifier} | DELETE | Bearer Token | Token de autenticación |
||| {identifier} | ID de la Región |

#### :small_blue_diamond:Parámetros de salida

| Ruta | Método | Parámetro | Descripción |
|---|---|---|---|
| /api/regions | GET | data | Lista de regiones activas |
||| success | Solicitud completada (_true_) |
||| message | Mensaje solicitud no autenticada |

| Ruta | Método | Parámetro | Descripción |
|---|---|---|---|
| /api/regions | POST | success | Solicitud completada (_true_), Error en pámetros (_false_) |
||| errors | Lista de errores con los parámetros incorrectos. |
||| message | Mensaje solicitud no autenticada |

| Ruta | Método | Parámetro | Descripción |
|---|---|---|---|
| /api/regions/{identifier} | DELETE | success | Solicitud completada (_true_), Registro no existente (_false_) |
||| errors | Lista de errores |
||| message | Mensaje de Registro eliminado ó Solicitud no autenticada |

## :arrow_right:Comunas
| Ruta | Método | Descripción | Autenticación |
|---|---|---|---|
| /api/communes | GET | Muestra todos las Comunas activas | Auth |
| /api/communes | POST | Registra una nueva Comuna | Auth |
| /api/communes/{identifier} | DELETE | Elimina una Comuna por su ID | Auth |

#### :small_blue_diamond:Parámetros de entrada

| Ruta | Método | Parámetro | Descripción |
|---|---|---|---|
| /api/communes | GET | Bearer Token | Token de autenticación |

| Ruta | Método | Parámetro | Descripción |
|---|---|---|---|
| /api/communes | POST | Bearer Token | Token de autenticación |
||| region_id | ID de Región al que pertenece la Comuna |
||| description | Descripción de la Comuna |

| Ruta | Método | Parámetro | Descripción |
|---|---|---|---|
| /api/communes/{identifier} | DELETE | Bearer Token | Token de autenticación |
||| {identifier} | ID de la Comuna |

#### :small_blue_diamond:Parámetros de salida

| Ruta | Método | Parámetro | Descripción |
|---|---|---|---|
| /api/communes | GET | data | Lista de Comunas activas |
||| success | Solicitud completada (_true_) |
||| message | Mensaje solicitud no autenticada |

| Ruta | Método | Parámetro | Descripción |
|---|---|---|---|
| /api/communes | POST | success | Solicitud completada (_true_), Error en pámetros (_false_) |
||| errors | Lista de errores con los parámetros incorrectos. |
||| message | Mensaje solicitud no autenticada |

| Ruta | Método | Parámetro | Descripción |
|---|---|---|---|
| /api/communes/{identifier} | DELETE | success | Solicitud completada (_true_), Registro no existente (_false_) |
||| errors | Lista de errores |
||| message | Mensaje de Registro eliminado ó Solicitud no autenticada |
