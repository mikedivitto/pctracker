<?php
include_once("config.php");
if($showErrors) {error_reporting(E_ALL); ini_set('display_errors', 1);}

switch($_REQUEST['action'])
{
    case "modifyView":
        loadView("views/modify.php");
        break;
    case "deleteView":
        loadView("views/delete.php");
        break;
    case "admin":
        loadView("views/default.php");
        break;
    default:
        loadView("views/main.php");
        break;
}

function loadView($view)
{
    include_once("views/header.php");
    include_once($view);
    include_once("views/footer.php");
}