<?php
/**
 * Abstract Compatibility.
 *
 * Handles generic compatibility interaction which is implemented by
 * the different data store classes.
 *
 * @class       Live_Sales_Notifications_Compatibility
 * @version 1.0.0
 * @package     Live_Sales_Notifications/Classes
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Abstract Live_Sales_Notifications_Compatibility
 *
 * Implemented by classes using the same CRUD(s) pattern.
 *
 * @version 1.0.0
 * @package  Live_Sales_Notifications/Abstracts
 */
abstract class Live_Sales_Notifications_Compatibility
{
    public $store_specific_keys = array(

        'order_statuses'
    );

    public $id = 'woocommerce';

    public function __construct()
    {

    }

    abstract function version_check();

    abstract function get_all_order_status();

    abstract function get_product($settings = array());

    abstract function is_product();

    abstract function search_product();

}
