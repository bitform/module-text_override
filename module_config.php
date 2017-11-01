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
    "code",
    "code/Module.class.php",
    "images/",
    "images/icon_text_override.gif",
    "lang/",
    "lang/en_us.php",
    "scripts/",
    "scripts/text_override.js",
    "templates/",
    "templates/help.tpl",
    "templates/index.tpl",
    "help.php",
    "index.php",
    "library.php",
    "LICENSE",
    "module_config.php",
    "README.md"
);
