<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 21/06/2017
 * Time: 10:09
 */


if ( !defined( 'WP_UNINSTALL_PLUGIN' ) )
    exit();

function brozzme_db_prefix_plugin_uninstall(){
    delete_option('dbprefix_old_dbprefix');
    delete_option('dbprefix_new');
}