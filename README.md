# code_challenge-version-1 backend

Este proyecto es la parte backend del proyecto frontend [FrontEnd](https://github.com/javiersaavedraalcala/code_challenge-version-1-frontend)

## Instrucciones para ejecutar

1. Clonar/Descargar este repositorio
2. Ejecutar el siguiente comando:
   ````bash
   composer install
3. Renombrar archivo .env-example por .env:
   1. Dentro de este archivo se debe configurar la base de datos que se va a utilizar, para fines practicos se recomienda usar sqlite.
4. Correr las migraciones con el siguiente comando:
   ````bash
   php artisan migrate
5. Por último solo falta levantar el servicio con el comando:
   ````bash
   php artisan serve
   
Como se comentó anteriormente este proyecto es parte del otro proyecto [FrontEnd](https://github.com/javiersaavedraalcala/code_challenge-version-1-frontend) por lo que se recomienda descarlo y seguir las instrucciones de instalación.

> **Importante:** Por default el servicio backend se levanta en en la url http://localhost:8000/ si deseas cambiarlo es importante que también vayas a /src/api/config.js y ahí también lo modifiques para que funcione correctamente la aplicación.
