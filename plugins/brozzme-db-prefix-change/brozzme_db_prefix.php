<?php
/*
Plugin Name: Brozzme DB Prefix change and DB Tools addon
Plugin URI: https://brozzme.com/
Description: Easily change your WordPress DB prefix, save time, increase security.
Version: 1.3.4
Author: Benoti
Author URI: https://brozzme.com
Text Domain: brozzme-db-prefix-change

*/

if ( ! defined( 'ABSPATH' ) ) exit;

class brozzme_db_prefix{

    /**
     * brozzme_db_prefix constructor.
     */
    public function __construct()
    {
        // Define plugin constants
        $this->basename = plugin_basename(__FILE__);
        $this->directory_path = plugin_dir_path(__FILE__);
        $this->directory_url = plugins_url(dirname($this->basename));

        // group menu ID
        $this->plugin_dev_group = 'Brozzme';
        $this->plugin_dev_group_id = 'brozzme-plugins';

        // plugin info
        $this->plugin_name = 'Brozzme DB Prefix';
        $this->plugin_slug = 'brozzme-db-prefix-change';
        $this->settings_page_slug = 'brozzme-db-prefix';
        $this->plugin_version = '1.3.2';
        $this->plugin_txt_domain = 'brozzme-db-prefix-change';

        $this->_define_constants();

        // Run our activation and deactivation hooks
        register_activation_hook(__FILE__, array($this, 'activate'));
        register_deactivation_hook( __FILE__, array($this, 'deactivate') );
        register_uninstall_hook(    __DIR__ .'/uninstall.php', 'brozzme_db_prefix_plugin_uninstall' );

        /* init */
        add_action( 'admin_enqueue_scripts', array( $this, '_add_settings_styles') );

        $this->_init();

    }

    /**
     *
     */
    public function _define_constants(){
        defined('BFSL_PLUGINS_DEV_GROUPE')    or define('BFSL_PLUGINS_DEV_GROUPE', $this->plugin_dev_group);
        defined('BFSL_PLUGINS_DEV_GROUPE_ID') or define('BFSL_PLUGINS_DEV_GROUPE_ID', $this->plugin_dev_group_id);
        defined('BFSL_PLUGINS_URL') or define('BFSL_PLUGINS_URL', $this->directory_url);
        defined('BFSL_PLUGINS_SLUG') or define('BFSL_PLUGINS_SLUG', $this->plugin_slug);

        defined('B7EDBP')    or define('B7EDBP', $this->plugin_name);
        defined('B7EDBP_BASENAME')    or define('B7EDBP_BASENAME', $this->basename);
        defined('B7EDBP_DIR')    or define('B7EDBP_DIR', $this->directory_path);
        defined('B7EDBP_DIR_URL')    or define('B7EDBP_DIR_URL', $this->directory_url);
        defined('B7EDBP_SETTINGS_SLUG')  or define('B7EDBP_SETTINGS_SLUG', $this->settings_page_slug);
        defined('B7EDBP_PLUGIN_SLUG')  or define('B7EDBP_PLUGIN_SLUG', $this->plugin_slug);
        defined('B7EDBP_VERSION')        or define('B7EDBP_VERSION', $this->plugin_version);
        defined('B7EDBP_TEXT_DOMAIN')    or define('B7EDBP_TEXT_DOMAIN', $this->plugin_txt_domain);
    }

    /**
     *
     */
    public function _init(){

        load_plugin_textdomain($this->plugin_txt_domain, false, $this->plugin_slug . '/languages');

        add_action('admin_enqueue_scripts', array($this, '_enqueue_ressources') );
        // Add Menu
        add_filter('plugin_action_links_' . plugin_basename(__FILE__), array($this, 'add_action_links'));

        $this->_admin_page();
    }

    /**
     * @param $hook
     */
    public function _enqueue_ressources($hook){
            if($hook != 'tools_page_brozzme-db-prefix') {
                return;
            }
            wp_register_script('jquery.validate',plugins_url('js/jquery.validate.min.js',__FILE__),array('jquery'), false, false);
            wp_enqueue_script('jquery.validate');
            wp_register_script('util',plugins_url('js/util.js',__FILE__),array('jquery'), false, false);
            wp_enqueue_script('util');

    }

    /**
     *
     */
    public function _admin_page(){

        include_once $this->directory_path . 'includes/brozzme_db_prefix_core.php';
        include_once $this->directory_path . 'includes/brozzmeDbPSettings.php';
        new brozzmeDbPSettings();
    }

    /**
     * @param $hook
     */
    public function _add_settings_styles($hook){
        if($hook == 'toplevel_page_' . $this->plugin_dev_group_id || $hook == 'tools_page_brozzme-db-prefix'){
            wp_enqueue_style( $this->plugin_txt_domain, plugin_dir_url( __FILE__ ) . 'css/brozzme-admin-css.css');
        }
        if($hook == 'tools_page_brozzme-db-prefix') {
            wp_enqueue_style( 'bdbstyle', plugin_dir_url( __FILE__ ) . 'css/style.css');
        }
    }

    /**
     * @param $links
     * @return array
     */
    public function add_action_links($links)
    {
        $mylinks = array(
            '<a href="' . admin_url('admin.php?page='. $this->settings_page_slug) . '">' . __('Settings', B7EDBP_TEXT_DOMAIN) . '</a>',
        );
        return array_merge($links, $mylinks);
    }


    /**
     * Check if wp-config is writable & if the table prefix is not empty
     */
    public function activate(){
        global $wpdb;

        if ( !is_writable(get_home_path() .'wp-config.php')){
            deactivate_plugins(B7EDBP_BASENAME);
            wp_die( "<strong>".$this->plugin_slug."</strong> requires <strong>a writable wp-config.php</strong>, and has been deactivated! Please change file permission and try again.<br /><br />Back to the WordPress <a href='".get_admin_url(null, 'plugins.php')."'>Plugins page</a>." );
        }
        if(empty($wpdb->prefix)){
            deactivate_plugins(B7EDBP_BASENAME);
            wp_die( "<strong>".$this->plugin_slug."</strong> requires <strong>your WordPress to have a table prefix</strong>, and has been deactivated! Please change file permission and try again.<br /><br />Back to the WordPress <a href='".get_admin_url(null, 'plugins.php')."'>Plugins page</a>." );
        }
    }

    /**
     *
     */
    public function deactivate(){
        delete_option('dbprefix_old_dbprefix');
        delete_option('dbprefix_new');
    }
}

new brozzme_db_prefix();