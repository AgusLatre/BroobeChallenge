# Broobe Prueba Tecnica

## Aclaración
Es necesario contar con npm, PHP 8.1 y Laravel 10.x para la instalación del proyecto.

## Instalación
1. Clonar el repositorio:
  ```bash
   git clone <https://github.com/AgusLatre/BroobeChallenge.gitl>
   cd BroobeChallenge
  ```
2. Instala dependencias:
  ```bash
  composer install
  npm install
  npm run dev
  ```

3. Configura las variables de entorno:

  Copia el .env.example al .env y completar con tu API KEY.

4. Ejecutar migrations y seeders:
  ```bash
  php artisan migrate --seed
  ```

5. Correr el server local:
  ```bash
  php artisan serve
  ```

## Uso
Visite la página de inicio para introducir una URL y seleccionar categorías y estrategias para obtener métricas.

Guarde las métricas obtenidas en la base de datos.

Ver el historial de ejecuciones de métricas.

## Aclaraciones importantes.
El código no se encuentra completo por falta de tiempo, los errores que me encontré con el siguiente error:

1. El contenido del array categories[] no se ve reflejado en las categories del response ```$data['lighthouseResult']['categories']``` 

Durante las últimas horas de desarrollo del proyecto me dedique al debug del error, pero por falta de tiempo no pude concluir.


## License
This project is open-source and licensed under the [MIT](https://choosealicense.com/licenses/mit/) License.