<?php

if (!defined('ABSPATH')) {
    exit;
}

class Live_Sales_Notifications_Admin
{
    function __construct()
    {

        add_action('admin_menu', array($this, 'menu_page'));
        add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_scripts'), 99999);
        add_action('init', array($this, 'includes'));

    }

    public function includes()
    {
        include_once LIVE_SALES_NOTIFICATIONS_ABSPATH . 'includes/admin/class-live-sales-notifications-admin-actions.php';
        include_once LIVE_SALES_NOTIFICATIONS_ABSPATH . 'includes/admin/class-live-sales-notifications-admin-settings.php';


    }

    /**
     * Init Script in Admin
     */
    public function admin_enqueue_scripts()
    {
        $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : '';
        if ($page == 'live-sales-notifications') {
            global $wp_scripts;
            $scripts = $wp_scripts->registered;
            //			print_r($scripts);
            foreach ($scripts as $k => $script) {
                preg_match('/^\/wp-/i', $script->src, $result);
                if (count(array_filter($result)) < 1) {
                    wp_dequeue_script($script->handle);
                }
            }

            /*Stylesheet*/
            wp_enqueue_style('live-sales-notifications-image', live_sales_notifications_instance()->plugin_url() . '/assets/css/' . 'live-sales-notifications.admin.lib.css');
            wp_enqueue_style('live-sales-notifications-transition', live_sales_notifications_instance()->plugin_url() . '/assets/css/' . 'transition.min.css');


            wp_enqueue_style('live-sales-notifications-front', live_sales_notifications_instance()->plugin_url() . '/assets/css/' . 'live-sales-notifications.css');
            wp_enqueue_style('live-sales-notifications-admin', live_sales_notifications_instance()->plugin_url() . '/assets/css/' . 'live-sales-notifications-admin.css');
            wp_enqueue_style('select2', live_sales_notifications_instance()->plugin_url() . '/assets/css/' . 'select2.min.css');

            wp_enqueue_script('select2-v4', live_sales_notifications_instance()->plugin_url() . '/assets/js/' . 'select2.js', array('jquery'), '4.0.3');

            /*Script*/
            wp_enqueue_script('live-sales-notifications-dependsOn', live_sales_notifications_instance()->plugin_url() . '/assets/js/' . 'dependsOn-1.0.2.min.js', array('jquery'));
            wp_enqueue_script('live-sales-notifications-transition', live_sales_notifications_instance()->plugin_url() . '/assets/js/' . 'transition.min.js', array('jquery'));
            wp_enqueue_script('live-sales-notifications-dropdown', live_sales_notifications_instance()->plugin_url() . '/assets/js/' . 'dropdown.js', array('jquery'));
            wp_enqueue_script('live-sales-notifications-tab', live_sales_notifications_instance()->plugin_url() . '/assets/js/' . 'tab.js', array('jquery'));
            wp_enqueue_script('live-sales-notifications-address', live_sales_notifications_instance()->plugin_url() . '/assets/js/' . 'jquery.address-1.6.min.js', array('jquery'));
            wp_enqueue_script('live-sales-notifications-admin', live_sales_notifications_instance()->plugin_url() . '/assets/js/' . 'live-sales-notifications-admin.js', array('jquery'));

            /*Color picker*/
            wp_enqueue_script('iris', admin_url('js/iris.min.js'), array(
                'jquery-ui-draggable',
                'jquery-ui-slider',
                'jquery-touch-punch'
            ), false, 1);

            /*Custom*/
            $product_color = live_sales_notifications_get_field('product_color');
            $text_color = live_sales_notifications_get_field('text_color');
            $background_color = live_sales_notifications_get_field('background_color');
            $custom_css = "
                #sales-notification{
                        background-color: {$background_color};
                        color:{$text_color};
                }
                 #sales-notification a{
                        color:{$product_color};
                }
                ";
            wp_add_inline_style('live-sales-notifications', $custom_css);

        }
    }


    /**
     * Register a custom menu page.
     */
    public function menu_page()
    {
        add_menu_page(
            esc_html__('Sales Notification', 'live-sales-notifications'),
            esc_html__('Sales Notification', 'live-sales-notifications'),
            'manage_options', 'live-sales-notifications', array(
            'Live_Sales_Notifications_Admin_Settings',
            'setting_page'
        ), 'dashicons-format-status', 2);

    }

}

return new Live_Sales_Notifications_Admin();