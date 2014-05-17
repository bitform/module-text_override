<?php

$STRUCTURE = array();
$STRUCTURE["tables"] = array();
$STRUCTURE["tables"]["module_text_override_fields"] = array(
  array(
    "Field"   => "id",
    "Type"    => "mediumint(8) unsigned",
    "Null"    => "NO",
    "Key"     => "PRI",
    "Default" => ""
  ),
  array(
    "Field"   => "lang_placeholder",
    "Type"    => "varchar(255)",
    "Null"    => "NO",
    "Key"     => "",
    "Default" => ""
  ),
  array(
    "Field"   => "original_string",
    "Type"    => "mediumtext",
    "Null"    => "NO",
    "Key"     => "",
    "Default" => ""
  ),
  array(
    "Field"   => "overridden_string",
    "Type"    => "mediumtext",
    "Null"    => "NO",
    "Key"     => "",
    "Default" => ""
  )
);

$HOOKS = array(
  array(
    "hook_type"       => "code",
    "action_location" => "main",
    "function_name"   => "ft_display_page",
    "hook_function"   => "text_override_replace",
    "priority"        => "50"
  ),
  array(
    "hook_type"       => "code",
    "action_location" => "main",
    "function_name"   => "ft_display_module_page",
    "hook_function"   => "text_override_replace",
    "priority"        => "50"
  )
);

$FILES = array(
  "database_integrity.php",
  "global/",
  "global/scripts/",
  "global/scripts/text_override.js",
  "help.php",
  "images/",
  "images/icon_text_override.gif",
  "index.php",
  "lang/",
  "lang/en_us.php",
  "library.php",
  "module.php",
  "module_config.php",
  "templates/",
  "templates/help.tpl",
  "templates/index.tpl"
);