<?php
if (!defined('GLPI_ROOT')) {
   die("Sorry. You can't access directly to this file");
}

include_once (GLPI_ROOT . "/inc/includes.php");

function plugin_custom_install() {
   global $DB;

   if (!TableExists('glpi_plugin_custom_tabs')) {
      $query = "CREATE TABLE `glpi_plugin_custom_tabs` (
         `id` INT(11) NOT NULL AUTO_INCREMENT,
         `name` VARCHAR(255)  collate utf8_unicode_ci NOT NULL,
         `itemtype` VARCHAR(255) NOT NULL DEFAULT 0,
         `tab` VARCHAR(255) NOT NULL DEFAULT 0,
         `color` VARCHAR(255) NOT NULL DEFAULT 0,
         PRIMARY KEY (`id`)
      ) ENGINE = MYISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
      $DB->query($query);
   }   

   if (!TableExists('glpi_plugin_custom_defaulttabs')) {
      $query = "CREATE TABLE `glpi_plugin_custom_defaulttabs` (
         `id` INT(11) NOT NULL AUTO_INCREMENT,
         `name` VARCHAR(255)  collate utf8_unicode_ci NOT NULL,
         `itemtype` VARCHAR(255) NOT NULL DEFAULT 0,
         `tab` VARCHAR(255) NOT NULL DEFAULT 0,
         PRIMARY KEY (`id`)
      ) ENGINE = MYISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
      $DB->query($query);
   }

   if (!TableExists('glpi_plugin_custom_styles')) {
      $query = "CREATE TABLE `glpi_plugin_custom_styles` (
         `id` INT(11) NOT NULL AUTO_INCREMENT,
         `body` VARCHAR(7) NOT NULL DEFAULT '#dfdfdf',
         `link_color` VARCHAR(7) NOT NULL DEFAULT '#659900',
         `link_hover_color` VARCHAR(7) NOT NULL DEFAULT '#000000',
         `menu_link` VARCHAR(7) NOT NULL DEFAULT '#000000',
         `ssmenu1_link` VARCHAR(7) NOT NULL DEFAULT '#666666',
         `ssmenu2_link` VARCHAR(7) NOT NULL DEFAULT '#000000',
         `th` VARCHAR(7) NOT NULL DEFAULT '#e1cc7b',
         `tab_bg_1` VARCHAR(7) NOT NULL DEFAULT '#f2f2f2',
         `tab_bg_1_2` VARCHAR(7) NOT NULL DEFAULT '#cf9b9b',
         `tab_bg_2` VARCHAR(7) NOT NULL DEFAULT '#f2f2f2',
         `tab_bg_2_2` VARCHAR(7) NOT NULL DEFAULT '#cf9b9b',
         `tab_bg_3` VARCHAR(7) NOT NULL DEFAULT '#e7e7e2',
         `tab_bg_4` VARCHAR(7) NOT NULL DEFAULT '#e4e4e2',
         `tab_bg_5` VARCHAR(7) NOT NULL DEFAULT '#f2f2f2',
         PRIMARY KEY (`id`)
      ) ENGINE = MYISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
      $DB->query($query);
   }

   if (!TableExists('glpi_plugin_custom_profiles')) {
      $query = "CREATE TABLE `glpi_plugin_custom_profiles` (
         `id` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
         `profiles_id` VARCHAR(45) NOT NULL,
         `view_color` CHAR(1),
         `add_tabs` CHAR(1),
         PRIMARY KEY (`id`)
      )
      ENGINE = MYISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
      $DB->query($query);
   }

   include_once (GLPI_ROOT."/plugins/custom/inc/profile.class.php");
   PluginCustomProfile::createFirstAccess($_SESSION['glpiactiveprofile']['id']);

   //create plugin file dir
   if (!is_dir(CUSTOM_FILES_DIR))
      mkdir(CUSTOM_FILES_DIR);

   touch(CUSTOM_FILES_DIR."glpi_style.css");


   return true;
}

function plugin_custom_uninstall() {
   global $DB;

   //Delete plugin's table
   $tables = array (
      'glpi_plugin_custom_tabs',
      'glpi_plugin_custom_defaulttabs',
      'glpi_plugin_custom_styles',
      'glpi_plugin_custom_profiles'
   );
   foreach ($tables as $table)
      $DB->query("DROP TABLE IF EXISTS `$table`");

   //delete plugin files dir
   Toolbox::deleteDir(CUSTOM_FILES_DIR);


   return true;
}

?>
