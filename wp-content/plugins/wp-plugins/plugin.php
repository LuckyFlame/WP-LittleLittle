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

/* Admin Menu */

add_action('admin_menu', 'AddContactMenu');
add_action('admin_menu', 'AddEventMenu');
add_action('admin_menu', 'AddTicketMenu');

function AddContactMenu() {
    add_menu_page(__('Contact', 'Contact'), 'Liên Hệ', 'manage_options', 'con_view', 'OPContactView');
    add_submenu_page(null, __('Contact', 'Contact'), 'Xem', 'manage_options', 'con_detail', 'OPContactDetail');
}

function AddEventMenu() {
    add_menu_page(__('Event', 'Event'), 'Sự Kiện', 'manage_options', 'eve_view', 'OPEventView');
    add_submenu_page(null, __('Event', 'Event'), 'Thêm', 'manage_options', 'eve_create', 'OPEventCreate');
    add_submenu_page(null, __('Event', 'Event'), 'Cập Nhật', 'manage_options', 'eve_update', 'OPEventUpdate');
    add_submenu_page(null, __('Event', 'Event'), 'Chi Tiết', 'manage_options', 'eve_detail', 'OPEventDetail');
}

function AddTicketMenu() {
    /* Ticket */
    add_menu_page(__('Ticket', 'Ticket'), 'Vé', 'manage_options', 'tic_view', '');
    add_submenu_page('ticket', __('Ticket', 'Ticket'), 'Trạng Thái', 'manage_options', 'tic_status', 'OPTicketStatus');
    add_submenu_page('ticket', __('Bill', 'Bill'), 'Xem', 'manage_options', 'bill_view', 'OPBillView');
    add_submenu_page(null, __('Bill', 'Bill'), 'Chi Tiết', 'manage_options', 'bill_detail', 'OPBillDetail');

    /* Package */
    add_submenu_page('ticket', __('Package', 'Package'), 'Loại Gói', 'manage_options', 'pac_view', 'OPPackageView');
    add_submenu_page(null, __('Package', 'Package'), 'Thêm', 'manage_options', 'pac_create', 'OPPackageCreate');
    add_submenu_page(null, __('Package', 'Package'), 'Cập Nhật', 'manage_options', 'pac_update', 'OPPackageUpdate');

}

/**
 * File Exists Output
 */

/* Contact */
function OPContactView() {
    if(file_exists(ROOT__PLUGIN__PATH . '/view/class-contact-view.php')) {
        require_once(ROOT__PLUGIN__PATH . '/view/class-contact-view.php');
    }
}

function OPContactDetail() {
    if(file_exists(ROOT__PLUGIN__PATH . '/view/class-contact-detail.php')) {
        require_once(ROOT__PLUGIN__PATH . '/view/class-contact-detail.php');
    }
}

/* Event */
function OPEventView() {
    if(file_exists(ROOT__PLUGIN__PATH . '/view/class-event-view.php')) {
        require_once(ROOT__PLUGIN__PATH . '/view/class-event-view.php');
    }
}

function OPEventCreate() {
    if(file_exists(ROOT__PLUGIN__PATH . '/view/class-event-create.php')) {
        require_once(ROOT__PLUGIN__PATH . '/view/class-event-create.php');
    }
}

function OPEventUpdate() {
    if(file_exists(ROOT__PLUGIN__PATH . '/view/class-event-update.php')) {
        require_once(ROOT__PLUGIN__PATH . '/view/class-event-update.php');
    }
}

function OPEventDetail() {
    if(file_exists(ROOT__PLUGIN__PATH . '/view/class-event-detail.php')) {
        require_once(ROOT__PLUGIN__PATH . '/view/class-event-detail.php');
    }
}

// Package
function OPPackageView() {
    if(file_exists(ROOT__PLUGIN__PATH . '/view/class-package-view.php')) {
        require_once(ROOT__PLUGIN__PATH . '/view/class-package-view.php');
    }
}

function OPPackageCreate() {
    if(file_exists(ROOT__PLUGIN__PATH . '/view/class-package-create.php')) {
        require_once(ROOT__PLUGIN__PATH . '/view/class-package-create.php');
    }
}

function OPPackageUpdate() {
    if(file_exists(ROOT__PLUGIN__PATH . '/view/class-package-update.php')) {
        require_once(ROOT__PLUGIN__PATH . '/view/class-package-update.php');
    }
}

function OPPackageDetail() {
    if(file_exists(ROOT__PLUGIN__PATH . '/view/class-package-detail.php')) {
        require_once(ROOT__PLUGIN__PATH . '/view/class-package-detail.php');
    }
}

// Ticket

function OPBillView() {
    if(file_exists(ROOT__PLUGIN__PATH . '/view/class-bill-view.php')) {
        require_once(ROOT__PLUGIN__PATH . '/view/class-bill-view.php');
    }
}

function OPBillDetail() {
    if(file_exists(ROOT__PLUGIN__PATH . '/view/class-bill-detail.php')) {
        require_once(ROOT__PLUGIN__PATH . '/view/class-bill-detail.php');
    }
}

function OPTicketStatus() {
    if(file_exists(ROOT__PLUGIN__PATH . '/view/class-ticket-status.php')) {
        require_once(ROOT__PLUGIN__PATH . '/view/class-ticket-status.php');
    }
}

function OPScan() {
    if(file_exists(ROOT__PLUGIN__PATH . '/'))
    {
        require_once(ROOT__PLUGIN__PATH . '/');
    }
}

function OPChart() {
    if(file_exists(ROOT__PLUGIN__PATH . '/'))
    {
        require_once(ROOT__PLUGIN__PATH . '/');
    }
}

/**
 * CSS & JavaScript File
 */

add_action('admin_enqueue_scripts', 'CUSAdminCSS');
add_action('admin_enqueue_scripts', 'CUSAdminJS');

function CUSAdminCSS() {
    wp_enqueue_style('boxicons', 'https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css', array(), false);
}

function CUSAdminJS() {
    wp_enqueue_script('jquery', 'https://code.jquery.com/jquery-3.2.1.min.js', array());
    wp_enqueue_script('jquery-ui-js', 'https://code.jquery.com/ui/1.13.2/jquery-ui.js', array());
}

?>