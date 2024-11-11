## Integrantes:
- Manuel Gil 39555887
- Facundo Alejo Barrio 46429582

## Creación esquema

Primero, creamos una tabla de usuarios que representa los usuarios del sistema, la cual incluye un identificador único, un nombre, un apellido y un correo. Luego, creamos una tabla de viajes que representa los viajes realizados por cada usuario, la cual incluye un identificador único, un país, una ciudad, una fecha de inicio, una fecha de finalización, y además, una clave foránea que establece la relación entre cada registro de usuario y su respectivo viaje.

## API

### GET /trips

Devuelve el listado de los viajes.

#### Parámetros

Listado de parámetros opcionales:

- **orderBy**: Permite ordenar el listado por cualquiera de los siguientes campos:

    - **pais**: País origen del viaje
    - **pais_destino**: País destino del viaje
    - **ciudad**: Ciudad origen del viaje
    - **ciudad_destino**: Ciudad destino del viaje
    - **fecha_ini**: Fecha de inicio del viaje
    - **fecha_fin**: Fecha de finalizacion del viaje
    - **nombre**: Nombre del pasajero del viaje
    - **apellido**: Apellido del pasajero del viaje

- **order**: Permite indicarle el orden de visualización del listado cuando se hace uso del parámetro orderBy. Este campo puede ser ASC o DESC indicando si se quiere mostrar de forma ascendente o descendente. Por defecto su valor es ASC.

- **limit**: Este campo permite limitar la cantidad de elementos que devuelve la solicitud. Su valor por defecto es 100.

- **page**: Este campo permite indicar el número de página del listado de elementos que queremos obtener. Por defecto su valor es 1.

### POST /trips

Permite agregar un viaje nuevo.

Es necesario autenticarse para dar de alta un viaje. Para ello se debe enviar en el header el par:

```
Key: Authorization
Value: Bearer {token}
```

#### Body de la solicitud

En el cuerpo de la solicitud es necesario pasarle los siguientes campos:

- **pais**: País origen del viaje
- **pais_destino**: País destino del viaje
- **ciudad**: Ciudad origen del viaje
- **ciudad_destino**: Ciudad destino del viaje
- **fecha_ini**: Fecha de inicio del viaje
- **fecha_fin**: Fecha de finalizacion del viaje
- **user_id**: Id del pasajero del viaje

#### Ejemplo de alta de viaje

Petición POST a ```/api/trips```

Con el body:

```json
{
    "pais": "China",
    "pais_destino": "Japon",
    "ciudad": "Shangai",
    "ciudad_destino": "Tokio",
    "fecha_ini": "2026-01-01",
    "fecha_fin": "2026-02-01",
    "user_id": 1
}
```

### GET /trips/:id

Devuelve el viaje correspondiente al id = :id

### PUT /trips/:id

Edita el viaje correspondiente al id = :id

Es necesario autenticarse para realizar la edición. Para ello se debe enviar en el header el par:

```
Key: Authorization
Value: Bearer {token}
```

#### Body de la solicitud

En el cuerpo de la solicitud es necesario pasarle los siguientes campos:

- **pais**: País origen del viaje
- **pais_destino**: País destino del viaje
- **ciudad**: Ciudad origen del viaje
- **ciudad_destino**: Ciudad destino del viaje
- **fecha_ini**: Fecha de inicio del viaje
- **fecha_fin**: Fecha de finalizacion del viaje
- **user_id**: Id del pasajero del viaje

#### Ejemplo de edición del viaje con ID=2

Petición PUT a ```/api/trips/2```

Con el body:

```json
{
    "pais": "Chile",
    "pais_destino": "Argentina",
    "ciudad": "Santiago",
    "ciudad_destino": "Buenos Aires",
    "fecha_ini": "2026-10-01",
    "fecha_fin": "2026-10-05",
    "user_id": 1
}
```

### GET /users/token

Permite obtener el token de autenticación del usuario.

Para ello es necesario seleccionar, en la solapa Authorization de postman, el Auth Type: Basic Auth. 

Luego se deben cargar los datos de login del usuario:

```
Username: webadmin
Password: admin
```