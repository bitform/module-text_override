<?php

require_once("../../global/library.php");

use FormTools\Modules;

$module = Modules::initModulePage("admin");

$success = true;
$message = "";
if (isset($_POST["update"])) {
    list ($success, $message) = $module->updateStrings($_POST);
}

$page_vars = array(
    "g_success" => $success,
    "g_message" => $message,
    "overridden_strings" => $module->getStrings()
);

$module->displayPage("templates/index.tpl", $page_vars);
