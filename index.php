<?php

require_once("../../global/library.php");
ft_init_module_page();

$folder = dirname(__FILE__);
require_once("$folder/library.php");

if (isset($_POST["update"]))
{
  list($g_success, $g_message) = text_override_update_strings($_POST);
}

// ------------------------------------------------------------------------------------------------

$page_vars = array();
$page_vars["head_string"] = "<script type=\"text/javascript\" src=\"global/scripts/text_override.js?v=2\"></script>";
$page_vars["overridden_strings"] = text_override_get_strings();

ft_display_module_page("templates/index.tpl", $page_vars);