<?php

/**
 * Created by PhpStorm.
 * User: admin
 * Date: 14/06/2017
 * Time: 22:00
 */

if ( ! defined( 'ABSPATH' ) ) exit;

class brozzme_db_prefix_core
{

    /**
     * @param $wpConfigFilePath
     * @return bool
     */
    public static function dbprefix_wpConfigCheckPermissions($wpConfigFilePath)
    {
        if (!is_writable($wpConfigFilePath)) {
            return false;
        }
        // We use these functions later to access the wp-config file
        // so if they're not available we stop here
        if (!function_exists('file') || !function_exists('file_get_contents') || !function_exists('file_put_contents'))
        {
            return false;
        }
        return true;
    }

    /**
     * @param $dbprefix_wpConfigFile
     * @param $oldPrefix
     * @param $newPrefix
     * @return bool|int
     */
    public static function dbprefix_updateWpConfigTablePrefix($dbprefix_wpConfigFile, $oldPrefix, $newPrefix)
    {
        // Check file' status's permissions
        if (!is_writable($dbprefix_wpConfigFile))
        {
            return -1;
        }

        if (!function_exists('file')) {
            return -1;
        }

        // Try to update the wp-config file
        $lines = file($dbprefix_wpConfigFile);
        $fcontent = '';
        $result = -1;
        foreach($lines as $line)
        {
            $line = ltrim($line);
            if (!empty($line)){
                if (strpos($line, '$table_prefix') !== false){
                    $line = preg_replace("/=(.*)\;/", "= '".$newPrefix."';", $line);
                }
            }
            $fcontent .= $line;
        }
        if (!empty($fcontent)){
            // Save wp-config file
            $result = file_put_contents($dbprefix_wpConfigFile, $fcontent);
        }

        return $result;
    }

    /**
     * @return mixed
     */
    public static function dbprefix_getTablesToAlter()
    {
        global $wpdb;
        return $wpdb->get_results("SHOW TABLES LIKE '".$GLOBALS['table_prefix']."%'", ARRAY_N);
    }

    /**
     * @param $tables
     * @param $currentPrefix
     * @param $newPrefix
     * @return array
     */
    public static function dbprefix_renameTables($tables, $currentPrefix, $newPrefix)
    {
        global $wpdb;
        $changedTables = array();
        foreach ($tables as $k=>$table)	{
            $tableOldName = $table[0];
            // Hide errors
            $wpdb->hide_errors();

            // To rename the table
            $tableNewName = substr_replace($tableOldName, $newPrefix, 0, strlen($currentPrefix));
            $wpdb->query("RENAME TABLE `{$tableOldName}` TO `{$tableNewName}`");
            array_push($changedTables, $tableNewName);

        }
        return $changedTables;
    }

    /**
     * @param $oldPrefix
     * @param $newPrefix
     * @return string
     */
    public static function dbprefix_renameDbFields($oldPrefix, $newPrefix)
    {
        global $wpdb;
        /*
         * usermeta table
         *===========================
         wp_*
        * options table
        * ===========================
        wp_user_roles
        */
        $str = '';
        if (false === $wpdb->query("UPDATE {$newPrefix}options SET option_name='{$newPrefix}user_roles' WHERE option_name='{$oldPrefix}user_roles';")) {
            $str .= '<br/>Changing value: '.$newPrefix.'user_roles in table <strong>'.$newPrefix.'options</strong>:  <span style="color: #ff0000">Failed</span>';
        }
        $query = 'update '.$newPrefix.'usermeta set meta_key = CONCAT(replace(left(meta_key, ' . strlen($oldPrefix) . "), '{$oldPrefix}', '{$newPrefix}'), SUBSTR(meta_key, " . (strlen($oldPrefix) + 1) . ")) where meta_key in ('{$oldPrefix}autosave_draft_ids', '{$oldPrefix}capabilities', '{$oldPrefix}metaboxorder_post', '{$oldPrefix}user_level', '{$oldPrefix}usersettings','{$oldPrefix}usersettingstime', '{$oldPrefix}user-settings', '{$oldPrefix}user-settings-time', '{$oldPrefix}dashboard_quick_press_last_post_id')";
        if (false === $wpdb->query($query)) {
            $str .= '<br/>Changing values in table <strong>'.$newPrefix.'usermeta</strong>: <span style="color: #ff0000">Failed</span>';
        }
        if (!empty($str)) {
            $str = '<br/><p>Changing database prefix:</p><p>'.$str.'</p>';
        }
        return $str;
    }
}