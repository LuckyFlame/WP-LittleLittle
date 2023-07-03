<?php 

/**
 * WP List Table
 */

if(!class_exists('WP_List_Table')) {
    require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}

/**
 * Get Class Package
 */

class WP_Custom_Package extends WP_List_Table {
    
}

?>