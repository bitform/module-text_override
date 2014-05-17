<?php


/**
 * Returns all overridden string in the database ordered by id.
 */
function text_override_get_strings()
{
  global $g_table_prefix;

  $query = mysql_query("
    SELECT *
    FROM   {$g_table_prefix}module_text_override_fields
    ORDER BY id
      ");

  $info = array();

  while ($row = mysql_fetch_assoc($query))
  {
    $info[] = $row;
  }

  return $info;
}


/**
 * Called on form submit. This stores all the overridden string information for use by the hook function.
 */
function text_override_update_strings($info)
{
  global $g_table_prefix, $L;

  $info = ft_sanitize($info);

  $num_rows     = $info["num_rows"];
  $deleted_rows = explode(",", $info["deleted_rows"]);

  // delete all the old overridden strings
  mysql_query("DELETE FROM {$g_table_prefix}module_text_override_fields");

  for ($i=1; $i<=$num_rows; $i++)
  {
    if (in_array($i, $deleted_rows))
      continue;

    // if there's no placeholder, ignore the row. Note: we DON'T ignore the row if there's no overridden string. It's quite
    // possible that sometimes someone will want to simply remove a string
    if (!isset($info["placeholder_$i"]))
      continue;

    $placeholder       = $info["placeholder_$i"];
    $original_string   = $info["string_$i"];
    $overridden_string = $info["overridden_string_$i"];

    mysql_query("
      INSERT INTO {$g_table_prefix}module_text_override_fields (lang_placeholder, original_string, overridden_string)
      VALUES ('$placeholder', '$original_string', '$overridden_string')
        ");
  }

  return array(true, $L["notify_strings_updated"]);
}


/**
 * Our code hook function. This does the job of actually overriding the strings.
 */
function text_override_replace($info)
{
  $overridden_smarty_obj = $info["g_smarty"];

  $LANG = $overridden_smarty_obj->_tpl_vars["LANG"];

  // now override those strings that the user requested
  $strings = text_override_get_strings();
  foreach ($strings as $string_info)
  {
    $placeholder       = $string_info["lang_placeholder"];
    $overridden_string = $string_info["overridden_string"];
    $LANG[$placeholder] = $overridden_string;
  }

  $overridden_smarty_obj->_tpl_vars["LANG"] = $LANG;

  $info = array();
  $info["g_smarty"] = $overridden_smarty_obj;

  return $info;
}


function text_override__install($module_id)
{
  global $g_table_prefix, $L;

  $queries = array();
  $queries[] = "
    CREATE TABLE {$g_table_prefix}module_text_override_fields (
     id MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
     lang_placeholder VARCHAR(255) NOT NULL,
     original_string MEDIUMTEXT NOT NULL,
     overridden_string MEDIUMTEXT NOT NULL
    ) TYPE=MyISAM";

  foreach ($queries as $query)
  {
  	$result = mysql_query($query);

  	if (!$result)
  	  return array(false, "Failed Query: " . mysql_error());
  }

  // register the hooks. This simply adds the POTENTIAL for the module to be called in those
  // functions. The text_override_replace function does the job of processing the user-defined list of
  // parsing rules, as entered via the UI. If there are no rules, nothing happens
  ft_register_hook("code", "text_override", "main", "ft_display_page", "text_override_replace");
  ft_register_hook("code", "text_override", "main", "ft_display_module_page", "text_override_replace");

  return array(true, "");
}


function text_override__uninstall($module_id)
{
  global $g_table_prefix;
  @mysql_query("DROP TABLE {$g_table_prefix}module_text_override_fields");

  return array(true, "");
}

function text_override__upgrade($old_version, $new_version)
{
	global $g_table_prefix;

  $old_version_info = ft_get_version_info($old_version);

  if ($old_version_info["release_date"] < 20100911)
  {
  	@mysql_query("ALTER TABLE {$g_table_prefix}module_text_override_fields TYPE=MyISAM");
  }
}
