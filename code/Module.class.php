<?php

namespace FormTools\Modules\TextOverride;

use FormTools\Core;
use FormTools\Hooks;
use FormTools\Module as FormToolsModule;
use PDOException;


class Module extends FormToolsModule
{
    protected $moduleName = "Text Override";
    protected $moduleDesc = "Override virtually any string that appears in the Form Tools UI, while preserving compatibility with upgrading.";
    protected $author = "Ben Keen";
    protected $authorEmail = "ben.keen@gmail.com";
    protected $authorLink = "https://formtools.org";
    protected $version = "2.0.2";
    protected $date = "2018-01-30";
    protected $originLanguage = "en_us";

    protected $jsFiles = array("scripts/text_override.js");

    protected $nav = array(
        "module_name" => array("index.php", false),
        "word_help"   => array("help.php", true)
    );

    public function install($module_id)
    {
        $db = Core::$db;

        try {
            $db->query("
                CREATE TABLE {PREFIX}module_text_override_fields (
                    id MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                    lang_placeholder VARCHAR(255) NOT NULL,
                    original_string MEDIUMTEXT NOT NULL,
                    overridden_string MEDIUMTEXT NOT NULL
                )
            ");
            $db->execute();
        } catch (PDOException $e) {
            return array(false, "Failed Query: " . $e->getMessage());
        }

        $this->resetHooks();

        return array(true, "");
    }


    public function uninstall($module_id)
    {
        $db = Core::$db;
        $db->query("DROP TABLE {PREFIX}module_text_override_fields");
        $db->execute();

        return array(true, "");
    }


    public function upgrade($module_id, $old_module_version)
    {
        $this->clearHooks();
        $this->resetHooks();
    }


    public function resetHooks()
    {
        // This adds the POTENTIAL for the module to be called in those functions. The text_override_replace function
        // does the job of processing the user-defined list of parsing rules, as entered via the UI. If there are no
        // rules, nothing happens
        Hooks::registerHook("code", "text_override", "main", "FormTools\\Themes::displayPage", "replaceStrings");
    }


    /**
     * Our code hook function. This does the job of actually overriding the strings.
     */
    public function replaceStrings($info)
    {
        $overridden_smarty_obj = $info["smarty"];

        $vars = $overridden_smarty_obj->getTemplateVars();
        $LANG = $vars["LANG"];

        // now override those strings that the user requested
        $strings = $this->getStrings();
        foreach ($strings as $string_info) {
            $placeholder       = $string_info["lang_placeholder"];
            $overridden_string = $string_info["overridden_string"];
            $LANG[$placeholder] = $overridden_string;
        }

        $overridden_smarty_obj->assign("LANG", $LANG);

        $info = array();
        $info["smarty"] = $overridden_smarty_obj;

        return $info;
    }

    /**
     * Called on form submit. This stores all the overridden string information for use by the hook function.
     */
    public function updateStrings($info)
    {
        $db = Core::$db;
        $L = $this->getLangStrings();

        $num_rows     = $info["num_rows"];
        $deleted_rows = explode(",", $info["deleted_rows"]);

        // delete all the old overridden strings
        $db->query("DELETE FROM {PREFIX}module_text_override_fields");
        $db->execute();

        for ($i=1; $i<=$num_rows; $i++) {
            if (in_array($i, $deleted_rows)) {
                continue;
            }

            // if there's no placeholder, ignore the row. Note: we DON'T ignore the row if there's no overridden string. It's quite
            // possible that sometimes someone will want to simply remove a string
            if (!isset($info["placeholder_$i"])) {
                continue;
            }

            $db->query("
                INSERT INTO {PREFIX}module_text_override_fields (lang_placeholder, original_string, overridden_string)
                VALUES (:lang_placeholder, :original_string, :overridden_string)
            ");
            $db->bindAll(array(
                "lang_placeholder" => $info["placeholder_$i"],
                "original_string" => $info["string_$i"],
                "overridden_string" => $info["overridden_string_$i"]
            ));
            $db->execute();
        }

        return array(true, $L["notify_strings_updated"]);
    }

    /**
     * Returns all overridden string in the database ordered by id.
     */
    public function getStrings()
    {
        $db = Core::$db;

        $db->query("
            SELECT *
            FROM   {PREFIX}module_text_override_fields
            ORDER BY id
        ");
        $db->execute();

        return $db->fetchAll();
    }
}
