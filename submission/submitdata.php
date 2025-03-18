<?php
require_once '../route/session.php';

require __DIR__ . '/../vendor/autoload.php';

$method_name = $_GET['method'];
$object_name = $_GET['classname'];
$arguments = $_GET['args'];

$object_name = "\\College\\Ddcollege\\Controller\\" . $object_name;

$class = "\College\Ddcollege\Model\database";
$function = new $class();
$object = new $object_name();
if (is_array($_GET['args'])) {
    $args = $_GET['args']; // If it's already an array, use it directly
} else {
    $argsString = $_GET['args']; // Get the arguments as a single string
    // Explode the arguments string into an array
    $args = explode(',', $argsString);

}
if ($object_name == "\College\Ddcollege\Controller\settingcontroller" && $method_name == "updatesetting") {
    $arr = array();
    $tabname = $args[0];
    array_shift($args);
    for ($i = 0; $i < count($args); $i+=2) {
        $key = $args[$i];
        $value = $args[$i + 1];
        $arr[$key] = $value;
    }

    header('Content-Type: application/json');
    echo json_encode((new \College\Ddcollege\Controller\settingcontroller())->updatesetting($tabname,$arr));
    exit();

}

$function = $function->callFunction($object, $method_name, ...$args);
header('Content-Type: application/json');
echo json_encode($function);
exit();