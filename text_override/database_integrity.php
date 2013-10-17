<?php

$HOOKS = array();
$HOOKS["1.1.1"] = array(
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