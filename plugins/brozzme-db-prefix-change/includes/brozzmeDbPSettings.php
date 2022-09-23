<?php

/**
 * Created by PhpStorm.
 * User: admin
 * Date: 14/06/2017
 * Time: 21:14
 */

if ( ! defined( 'ABSPATH' ) ) exit;

class brozzmeDbPSettings
{

    public function __construct()
    {
        add_action('admin_menu', array($this, 'add_admin_pages'), 110);
        add_action('admin_init', array($this, 'settings_fields'));
        add_action( 'wp_ajax_get_tables', array( $this, 'get_tables' ) );
    }

    /**
     *
     */
    public function add_admin_pages()
    {
        add_submenu_page(BFSL_PLUGINS_DEV_GROUPE_ID,
            __('DB PREFIX', 'brozzme-db-prefix-change'),
            __('DB PREFIX', 'brozzme-db-prefix-change'),
            'manage_options',
            B7EDBP_SETTINGS_SLUG,
            array($this, 'settings_page')
        );

        add_submenu_page('tools.php',
            __('DB PREFIX', 'brozzme-db-prefix-change'),
            __('DB PREFIX', 'brozzme-db-prefix-change'),
            'manage_options',
            B7EDBP_SETTINGS_SLUG,
            array($this, 'settings_page')
        );
    }

    /**
     *
     */
    public function settings_page(){
        global $wpdb;

        if(!isset($_GET['tab']) || $_GET['tab']==='general_settings') {
            if(!isset($_GET['tab']) || ( isset($_GET['tab']) && $_GET['tab'] !== 'mysql_dump') ){

                if((isset($_POST['dbprefix_hidden'])) && $_POST['dbprefix_hidden'] == 'Y' &&
                    (isset($_POST['Submit']) && trim($_POST['Submit'])==__('Change DB Prefix', 'brozzme-db-prefix-change' ))) {
                    if ( ! isset( $_POST['db_prefix_change_nonce_field'] )
                        || ! wp_verify_nonce( $_POST['db_prefix_change_nonce_field'], 'db_prefix_change_action' )
                    ) {
                        print 'Sorry, your nonce did not verify.';
                        exit;
                    } else {
                        // process form data
                        $old_dbprefix = sanitize_text_field($_POST['dbprefix_old_dbprefix']);
                        update_option('dbprefix_old_dbprefix', $old_dbprefix);

                        $dbprefix_new = sanitize_text_field($_POST['dbprefix_new']);
                        update_option('dbprefix_new', $dbprefix_new);

                        $wpdb =& $GLOBALS['wpdb'];

                        $new_prefix = preg_replace("/[^0-9a-zA-Z_]/", "", $dbprefix_new);

                        $bprefix_Message = '';

                        if(isset($_POST['dbprefix_new']) && $_POST['dbprefix_new'] ==='' || strlen($_POST['dbprefix_new']) < 2 )
                        {
                            $bprefix_Message .= esc_html__('Please provide a proper table prefix.', 'brozzme-db-prefix-change');
                        }
                        elseif ($new_prefix == $old_dbprefix) {
                            $bprefix_Message .= esc_html__('No change! Please provide a new table prefix.', 'brozzme-db-prefix-change');
                        }
                        elseif (strlen($new_prefix) < strlen($dbprefix_new)){
                            $bprefix_Message .= esc_html__('You have used some characters disallowed for the table prefix. please use another prefix', 'brozzme-db-prefix-change') .' <b>'. $dbprefix_new .'</b>';
                        }
                        else
                        {
                            $tables = brozzme_db_prefix_core::dbprefix_getTablesToAlter();
                            if (empty($tables))
                            {
                                $bprefix_Message .= brozzme_db_prefix_core::dbprefix_eInfo(esc_html__('There are no tables to rename!', 'brozzme-db-prefix-change'));
                            }
                            else
                            {
                                $result = brozzme_db_prefix_core::dbprefix_renameTables($tables, $old_dbprefix, $dbprefix_new);
                                // check for errors
                                if (!empty($result))
                                {
                                    $bprefix_Message .= esc_html__('All tables have been successfully updated with prefix', 'brozzme-db-prefix-change') .' '.$dbprefix_new.' !';
                                    // try to rename the fields
                                    $bprefix_Message .= brozzme_db_prefix_core::dbprefix_renameDbFields($old_dbprefix, $dbprefix_new);

                                    $dbprefix_wpConfigFile = $this->get_wp_config_file();

                                    if (brozzme_db_prefix_core::dbprefix_updateWpConfigTablePrefix($dbprefix_wpConfigFile, $old_dbprefix, $dbprefix_new))
                                    {
                                        $bprefix_Message .= esc_html__('The wp-config file has been successfully updated with prefix', 'brozzme-db-prefix-change') . ''.$dbprefix_new.' !';
                                    }
                                    else {
                                        $bprefix_Message .= esc_html__('The wp-config file could not be updated! You have to manually update the table_prefix variable to the one you have specified:', 'brozzme-db-prefix-change'). ' '.$dbprefix_new;
                                    }
                                }// End if tables successfully renamed
                                else {
                                    $bprefix_Message .= esc_html__('An error has occurred and the tables could not be updated!', 'brozzme-db-prefix-change');
                                }
                                $_POST['dbprefix_hidden'] = 'n';

                                $new_updated_prefix = get_option('dbprefix_new');
                            }
                        }
                    }

                } else {
                    $bprefix_Message = '';
                }
                if(isset($new_updated_prefix) && $new_updated_prefix != null && $wpdb->prefix != $new_updated_prefix){
                    $input_prefix = $new_updated_prefix;
                }
                else{
                    $input_prefix = $wpdb->prefix;
                }
            }
        }
        ?>
        <div class="wrap">
            <h2>Brozzme DB PREFIX</h2>
            <?php
            $active_tab = isset( $_GET[ 'tab' ] ) ? sanitize_text_field($_GET[ 'tab' ]) : 'general_settings';
            ?>

            <h2 class="nav-tab-wrapper">
                <a href="?page=<?php echo esc_html(B7EDBP_SETTINGS_SLUG .'&tab=general_settings');?>" class="nav-tab <?php echo $active_tab == 'general_settings' ? 'nav-tab-active' : ''; ?>"><?php esc_html_e( 'Change DB Prefix', 'brozzme-db-prefix-change' );?></a>
                <a href="?page=<?php echo esc_html(B7EDBP_SETTINGS_SLUG .'&tab=help_options');?>" class="nav-tab <?php echo $active_tab == 'help_options' ? 'nav-tab-active' : ''; ?>"><?php esc_html_e( 'Help', 'brozzme-db-prefix-change' );?></a>
                  </h2>

            <?php
            if($active_tab === sanitize_text_field('help_options')){
                $this->_help_tab();
            }
            elseif($active_tab === sanitize_text_field('brozzme') ){

            }
            else{
               ?>
                <div id="cdtp" class="brozzme-info postbox">
                    <form id="dbprefix_form" name="dbprefix_form" method="post" action="" >
                        <input type="hidden" name="dbprefix_hidden" value="Y">
                        <?php wp_nonce_field( 'db_prefix_change_action', 'db_prefix_change_nonce_field' ); ?>
                        <h3 class="hndle" style="cursor: default;"><span><?php esc_html_e('Database Prefix Settings', 'brozzme-db-prefix-change');?></span></h3>
                        <div class="inside">
                            <div class="cdp">
                                <h4 style="margin-top: 15px;"><?php esc_html_e('Before execute this plugin:', 'brozzme-db-prefix-change'); ?></h4>
                                <ul class="cdp-data" style="margin-top: 20px;">
                                    <li><?php esc_html_e('Make sure your wp-config.php file is writable.', 'brozzme-db-prefix-change');?></li>
                                    <li><?php esc_html_e('And check the database has ALTER rights.', 'brozzme-db-prefix-change');?></li>
                                </ul>
                            </div><!-- cdp div -->
                            <div class="success">
                                <?php echo esc_html($bprefix_Message);?>
                            </div><!-- success div -->
                            <?php if(isset($_POST['dbprefix_hidden']) && $_POST['dbprefix_hidden'] === 'Y') { ?>
                                <div class="updated">
                                    <p><strong><?php esc_html_e('Options saved.' ); ?></strong></p>
                                </div><!-- updated div -->
                            <?php } ?>
                            <div class="cdp-container">
                                <label for="dbprefix_old_dbprefix" class="label01">
                                        <span class="ttl02"><?php esc_html_e('Existing Prefix: ', 'brozzme-db-prefix-change' );?>
                                            <span class="required">*</span></span>
                                    <input type="text" disabled name="dbprefix_old_dbprefix_show" id="dbprefix_old_dbprefix_show" value="<?php echo esc_html($input_prefix); ?>" size="20" required>
                                    <input type="hidden" name="dbprefix_old_dbprefix" id="dbprefix_old_dbprefix" value="<?php echo esc_html($input_prefix); ?>" size="20" >
                                    <?php esc_html_e(' ex: wp_', 'brozzme-db-prefix-change' ); ?><span class="error"></span>
                                </label><br/>
                                <label for="dbprefix_new" class="label01"> <span class="ttl02"><?php esc_html_e('New Prefix: ', 'brozzme-db-prefix-change' ); ?>
                                        <span class="required">*</span></span>
                                    <input type="text" name="dbprefix_new" value="<?php echo esc_html($this->keygen());?>" size="20" id="dbprefix_new" required>
                                    <?php esc_html_e(' ex: uniquekey_', 'brozzme-db-prefix-change' ); ?>
                                </label>
                                <p class="margin-top:10px"><?php esc_html_e('Allowed characters: all latin alphanumeric as well as the <strong>_</strong> (underscore).', 'brozzme-db-prefix-change');?></p>
                                <p class="submit">
                                    <input type="submit" name="Submit" class="button button-primary" value="<?php esc_html_e('Change DB Prefix', 'brozzme-db-prefix-change' ); ?>" />
                                </p>
                            </div><!-- container div -->
                        </div><!-- inside div -->
                    </div><!-- postbox div -->
                </form>
                <?php
            }?></div>
            <?php
    }

    /**
     * @param int $length
     * @return string
     */
    public function keygen($length=4){

        $length = rand(3,6);
        $key = '';
        list($usec, $sec) = explode(' ', microtime());
        mt_srand((int) $sec + ((int) $usec * 100000));

        $inputs = array_merge(range('z','a'),range(0,9));

        for($i=0; $i<$length; $i++)
        {
            $key .= $inputs[mt_rand(0,35)];
        }

        if(strlen($key)< 3){
            $add = array_rand(range('z','a'));
            $key = $key.$add;
        }
        return $key .'_';
    }

    /**
     * @return string
     */
    public function get_wp_config_file() {

        if ( file_exists(get_home_path() .'wp-config.php')){
            return get_home_path() .'wp-config.php';
        }

        return dirname(ABSPATH) . '/wp-config.php';
    }

    /**
     *
     */
    public function settings_fields(){


    }

    /**
     *
     */
    public function _help_tab(){
        ?>
        <h2><?php esc_html_e('FAQ & HELP', 'brozzme-db-prefix-change');?></h2>
        <p><a class="doc_toggle">DB Prefix</a> - <a class="doc_toggle">DB Dump</a></p>
        <div id="db-prefix">
            <p><b><?php esc_html_e('Why do I need to change the WordPress database prefix ?', 'brozzme-db-prefix-change');?></b></p>
            <blockquote><?php esc_html_e('WordPress Database is like the heart for your WordPress site, as the database runs for every single information store, you need to protect it against hackers and spammers that could run automated code for SQL injections.
Many people forget to change the database prefix in the install wizard. This makes it easier for hackers to plan a mass attack by targeting the default prefix wp_. 
To avoid them, you can protect your database by changing the database prefix which is really easy with Brozzme DB Prefix. It takes a few seconds to change the prefix.', 'brozzme-db-prefix-change');?></blockquote>
            <p><b><?php esc_html_e('What do I need to verify before changes ?', 'brozzme-db-prefix-change');?></b></p>
            <h3><?php esc_html_e('MAKE SURE YOU HAVE A DATABASE BACKUP BEFORE USING THIS TOOL.', 'brozzme-db-prefix-change');?></h3>
            <blockquote><?php esc_html_e('You just need to verify: ', 'brozzme-db-prefix-change');?>
                <ul><li>- <?php esc_html_e('wp-config.php is writable on your server.', 'brozzme-db-prefix-change');?></li>
                    <li>- <?php esc_html_e('that mySQL ALTER rights are enable.', 'brozzme-db-prefix-change');?></li>
                </ul>
            </blockquote>
            <p><b><?php esc_html_e('What can I do if the process fails ?', 'brozzme-db-prefix-change');?></b></p>
            <blockquote><?php esc_html_e('Depending on where the fail occurs: ', 'brozzme-db-prefix-change');?>
                <ul><li><?php esc_html_e('Compare prefix in the wp-config.php and in phpmyAdmin, depending on the the situation, ', 'brozzme-db-prefix-change');?></li>
                    <li>- <?php esc_html_e('change manually $table_prefix value in wp-config.php.', 'brozzme-db-prefix-change');?></li>
                    <li>- <?php esc_html_e('suppress all tables and import the backup in phpmyAdmin.', 'brozzme-db-prefix-change');?></li>
                    <li><b><?php esc_html_e('Verify all the pre-requisite point in the previous question before processing once again.', 'brozzme-db-prefix-change');?></b></li>
                </ul></blockquote>
            <p><b><?php esc_html_e('Why can I not do it manually?', 'brozzme-db-prefix-change');?></b></p>
            <blockquote><?php esc_html_e('Of course you can, but there\'s many occurences to modify to make it works. Not only the tables name need to be modify.', 'brozzme-db-prefix-change');?>
                <ul><li><?php esc_html_e('Here is the exhaustive list of what to change, ', 'brozzme-db-prefix-change');?></li>
                    <li>- <?php esc_html_e('Tables names,', 'brozzme-db-prefix-change');?></li>
                    <li>- <?php esc_html_e('table options: {old_prefix}user_roles option name,', 'brozzme-db-prefix-change');?></li>
                    <li><?php esc_html_e('table usermeta, for each registered user, {old_prefix}capabilities and {old_prefix}user_level, option names', 'brozzme-db-prefix-change');?></li>
                    <li><?php esc_html_e('if exists you\'ll need to also modify {old_prefix}dashboard_quick_press_last_post_id option name', 'brozzme-db-prefix-change');?></li>
                    <li><?php esc_html_e('', 'brozzme-db-prefix-change');?></li>
                </ul></blockquote>
            <p><b><?php esc_html_e('I can\'t delete, edit anymore using phpmyAdmin with MAMP...', 'brozzme-db-prefix-change');?></b></p>
            <blockquote>
                <ul><li><?php esc_html_e('Only use lower-case characters to solve this.', 'brozzme-db-prefix-change');?></li></ul>
            </blockquote>
        </div>

        <div id="db-dump" style="display:none;">
            <p><b><?php esc_html_e('How to make and verify your mysql dump ?', 'brozzme-db-prefix-change');?></b></p>

            <blockquote>
                <?php esc_html_e('Make a new dump of the database:', 'brozzme-db-prefix-change');?>
                <ul>
                    <li><?php esc_html_e('If you want a copy of all tables, with structure and datas, just press Export database tables.', 'brozzme-db-prefix-change');?></li>
                    <li><b><?php esc_html_e('Use options if needed', 'brozzme-db-prefix-change');?></b>
                        <ul style="padding-left: 15px;list-style: circle;">
                            <li><?php esc_html_e('Include or exclude tables: add table with select by typing hint to find table name and add it to your list, choose by checking radio box (include or exclude).', 'brozzme-db-prefix-change'); ?></li>
                            <li><?php esc_html_e('Check Table strucuture only, if you do not want to dump datas.', 'brozzme-db-prefix-change'); ?></li>
                        </ul>
                    </li>
                </ul>
                <b><?php esc_html_e('Add more options', 'brozzme-db-prefix-change');?></b>
                <ul>
                    <li><?php esc_html_e('Use the filter b7e_dump_settings to modifiy settings', 'brozzme-db-prefix-change');?>
                        <ul style="padding-left: 15px;list-style: circle;">
                            <li><?php esc_html_e('How set the settings array with the b7e_dump_settings filter', 'brozzme-db-prefix-change');?></li>
                            <li><code>add_filter('b7e_dump_settings', 'b7e_dump_settings');<br><br>

                                function b7e_dump_settings($settings){<br>

                                &nbsp;&nbsp;&nbsp;&nbsp;$settings['compress'] = 'GZIP'; // BZIP2,  default: NONE<br>
                                    &nbsp;&nbsp;&nbsp;&nbsp;$settings['reset-auto-increment'] = true;<br>

                                    &nbsp;&nbsp;&nbsp;&nbsp;return $settings;<br>
                                }</code></li>
                            <li><?php esc_html_e('Available settings and defaults ', 'brozzme-db-prefix-change');?> <a href="https://github.com/ifsnop/mysqldump-php#dump-settings" target="_blank">ifsnop/mysqldump-php</a></li>
                        </ul>
                    </li>

                </ul>

                <b><?php esc_html_e('Verify dump of the database:', 'brozzme-db-prefix-change');?></b>
                <ul>
                    <li><?php esc_html_e('Go to phpmyadmin', 'brozzme-db-prefix-change');?></li>
                    <li><?php esc_html_e('If you can test the dump on other database, use the Import tab and choose the exported file.', 'brozzme-db-prefix-change');?></</li>
                    <li>
                        <ul style="padding-left: 15px;list-style: circle;">
                            <li><?php esc_html_e('Go to', 'brozzme-db-prefix-change'); ?> <a href="<?php echo esc_url(admin_url() .'/admin.php?page=brozzme-db-prefix&tab=general_settings')?>"><?php _e('Change DB Prefix', 'brozzme-db-prefix-change'); ?></a> <?php esc_html_e('tab and modify your prefix.', 'brozzme-db-prefix-change'); ?></li>
                            <li><?php esc_html_e('Go to phpmyadmin, use the Import tab and choose the exported file.', 'brozzme-db-prefix-change'); ?></li>
                        </ul>
                    </li>
                </ul>

            </blockquote>
        </div>


        <script>
            jQuery(document).ready(function($){
                $(document).ready(function(){
                    $(".doc_toggle").click(function(){
                        $("#db-prefix").toggle();
                        $("#db-dump").toggle();
                    });
                });
            });
        </script>
        <?php
    }


    /* since 1.2 */
    // mysql dump adds
    /**
     * @param string $path
     * @return mixed
     */
    public function _abs_path_to_url($path = '' ) {
        $url = str_replace(
            wp_normalize_path( untrailingslashit( ABSPATH ) ),
            site_url(),
            wp_normalize_path( $path )
        );
        return esc_url_raw( $url );
    }

    /**
     * @return array
     */
    public function _tables_list(){
        global $wpdb;

        $dbname = $wpdb->dbname;

        $result = $wpdb->get_results( 'SHOW TABLE STATUS', ARRAY_A );
        $rows = count( $result );
        // Get Database Size
        $dbsize = 0;

        if ( $wpdb->num_rows > 0 ) {
            foreach ( $result as $row ) {

                $tables_list[] = array('id'=>$row['Name'], 'label'=> round((($row[ "Data_length" ] + $row[ "Index_length" ]) / 1024 / 1024), 2));
            }
        }
        return $tables_list;
    }

    /**
     *
     */
    public function get_tables(){
	    if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( esc_attr( $_POST['nonce'] ), 'accepted_tables' ) ) {
		    return false;
	    }

        $tables = $this->_tables_list();
        foreach ($tables as $table){
            if(strpos($table['id'],  sanitize_text_field($_GET['q'])) !== false){
                $results[] = array('id'=> $table['id'], 'label'=> $table['label']);
            }
        }
        echo json_encode( $results );
	    wp_die();
    }
}