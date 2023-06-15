<?php 

/*
 * Plugin Name: WP Plugin Application 
 * Plugin URI: 
 * Description: A Plugin For Wordpress CRUD (Create | Read | Update | Delete) Application Using Ajax and WP List Table
 * Author: Asuka Tanaka
 * 
 * Version: 1.0.0
 */

/* 
 * Check Defined ABSPATH
 */

if(!defined('ABSPATH')) exit;

/*
 * Define Root
 */

define('ROOT__PLUGIN__URI', plugin_dir_url(__FILE__));
define('ROOT__PLUGIN__PATH', plugin_dir_path(__FILE__));
define('ROOT__PLUGIN__FILE', __FILE__);
define('ROOT__PLUGIN__VERSION', '1.0.0');
define('ROOT__PLUGIN__CLASS', 'GET__PLUGIN__FUNCTION');

/* 
 * Create Class Name GetPluginFunction
 */

Class GET__PLUGIN__FUNCTION {
    
    /*
     * Add and Remove Table
     */

    public static function AddTable() {
        // Call wpdb
        global $wpdb;

        // Charset
        $charset_collate = $wpdb->get_charset_collate();

        // Form 
        $form_contact_table = $wpdb->prefix . "contact";
        $form_category_table = $wpdb->prefix . "category";
        $form_event_table = $wpdb->prefix . "event";
        $form_cateEvent_table = $wpdb->prefix . "cate_event";
        $form_package_table = $wpdb->prefix . "package";
        $form_ticket_table = $wpdb->prefix . "ticket";
        // $form_payment_table = $wpdb->prefix . "payment";
        $form_bill_table = $wpdb->prefix . "bill";

        // SQL
        $form_contact_sql = "CREATE TABLE $form_contact_table(
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `name` varchar(25) NOT NULL,
            `email` varchar(50) NOT NULL,
            `phone` varchar(10) NOT NULL,
            `address` varchar(255) NOT NULL,
            `comment` text,
            `status` boolean,
            `create_at` varchar(255),
            `update_at` varchar(255),
            PRIMARY KEY (id)
        ) $charset_collate;";

        $form_category_sql = "CREATE TABLE $form_category_table(
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `category` varchar(50) NOT NULL,
            `content` text,
            `create_at` varchar(255),
            `update_at` varchar(255),
            PRIMARY KEY (id)
        ) $charset_collate;";

        $form_event_sql = "CREATE TABLE $form_event_table(
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `title` varchar(50) NOT NULL,
            `address` varchar(255) NOT NULL,
            `start_date` varchar(100) NOT NULL,
            `end_date` varchar(100) NOT NULL,
            `balance` float NOT NULL,
            `images` text NOT NULL,
            `thumbnail` text NOT NULL,
            `content` text NOT NULL,
            `create_at` varchar(255),
            `update_at` varchar(255),
            PRIMARY KEY (id) 
        ) $charset_collate;";

        $form_cateEvent_sql = "CREATE TABLE $form_cateEvent_table(
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `create_at` varchar(255),
            `update_at` varchar(255),
            `event_id` int(11) NOT NULL,
            `category_id` int(11) NOT NULL,
            PRIMARY KEY (id),
            FOREIGN KEY (event_id) REFERENCES $form_event_table(id),
            FOREIGN KEY (category_id) REFERENCES $form_category_table(id)
        ) $charset_collate;";

        $form_package_sql = "CREATE TABLE $form_package_table(
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `package` varchar(50) NOT NULL,
            `price` int,
            `create_at` varchar(255),
            `update_at` varchar(255),
            PRIMARY KEY (id)
        ) $charset_collate;";

        $form_ticket_sql = "CREATE TABLE $form_ticket_table(
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `fullname` varchar(25) NOT NULL,
            `email` varchar(50) NOT NULL,
            `phone` varchar(10) NOT NULL,
            `amount` int NOT NULL,
            `start_date` varchar(255) NOT NULL,
            `status` boolean NOT NULL,
            `base64_code` text NOT NULL,
            `create_at` varchar(255),
            `update_at` varchar(255),
            `package_id` int(11) NOT NULL,
            PRIMARY KEY (id),
            FOREIGN KEY (package_id) REFERENCES $form_package_table(id)
        ) $charset_collate;";


        // $form_payment_sql = "CREATE TABLE $form_payment_table(
            
        // ) $charset_collate;";

        $form_bill_sql = "CREATE TABLE $form_bill_table(
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `qrcode` text NOT NULL,
            `start_date` varchar(255) NOT NULL,
            `email` varchar(50) NOT NULL,
            `ticket_id` int(11) NOT NULL,
            PRIMARY KEY (id),
            FOREIGN KEY (ticket_id) REFERENCES $form_ticket_table(id)
        ) $charset_collate;";

        /* Require ABSPATH */
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        dbDelta( $form_contact_sql );
        dbDelta( $form_category_sql );
        dbDelta( $form_event_sql );
        dbDelta( $form_cateEvent_sql );
        dbDelta( $form_package_sql );
        dbDelta( $form_ticket_sql );
        dbDelta( $form_bill_sql );
    }

    public static function RemoveTable() {
        global $wpdb;

        /* 
         * Delete Foreign Key First
         */
        $tableArray = [
            $wpdb->prefix . "bill",
            $wpdb->prefix . "ticket",
            $wpdb->prefix . "cate_event",
            $wpdb->prefix . "event",
            $wpdb->prefix . "package",
            $wpdb->prefix . "contact",
            $wpdb->prefix . "category",
        ];

        foreach ($tableArray as $tablename) {
            $sql = $wpdb->query("DROP TABLE IF EXISTS $tablename");
        }

        $wpdb->query( $sql );

    }
}

/* Get Activation */
register_activation_hook(ROOT__PLUGIN__FILE, array(ROOT__PLUGIN__CLASS, 'AddTable'));

/* Get Deactivation */
register_deactivation_hook(ROOT__PLUGIN__FILE, array(ROOT__PLUGIN__CLASS, 'RemoveTable'));

?>