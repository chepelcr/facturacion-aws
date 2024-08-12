<?php
// la variable controller guarda el nombre del controlador y action guarda la acción por ejemplo registrar 
//si la variable controller y action son pasadas por la url desde layout.php entran en el if

#require_once 'Core/Config/Routes.php';
require_once 'vendor/autoload.php';

use Core\Config\Routes;

/**Guarda el nombre del controlador por defecto */
$default_controller = 'Inicio';

/**Guarda el nombre de la funcion que se llamara si no hay una definida */
$default_action = 'index';

//Ocultar errores
error_reporting(0);

ini_set('display_errors', 0);

/**Crear instancia de la clase rutas */
$app = new Routes();

$app->setDefault($default_controller, $default_action);

/**Realizar una solicitud a la aplicacion */
$app->llamar();

?>


