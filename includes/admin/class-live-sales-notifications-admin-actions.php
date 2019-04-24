<?php

if (!defined('ABSPATH')) {
    exit;
}

class Live_Sales_Notifications_Admin_Actions
{

    public function __construct()
    {

        add_action('live_sales_notifications_before_admin_setting', array($this, 'save'));
        add_action('wp_ajax_live_sales_notifications_search_product', array($this, 'search_product'));
        add_action('wp_ajax_live_sales_notifications_search_cate', array($this, 'search_cate'));
    }

    /**
     * Search product category ajax
     */
    public function search_cate()
    {
        if (!current_user_can('manage_options')) {
            return;
        }

        ob_start();

        $keyword = filter_input(INPUT_GET, 'keyword', FILTER_SANITIZE_STRING);

        if (empty($keyword)) {
            die();
        }
        $categories = get_terms(
            array(
                'taxonomy' => 'product_cat',
                'orderby' => 'name',
                'order' => 'ASC',
                'search' => $keyword,
                'number' => 100
            )
        );
        $items = array();
        if (count($categories)) {
            foreach ($categories as $category) {
                $item = array(
                    'id' => $category->term_id,
                    'text' => $category->name
                );
                $items[] = $item;
            }
        }
        wp_send_json($items);
        die;
    }

    /*Ajax Product Search*/
    public function search_product($x = '', $post_types = array('product'))
    {

        $main_instance = live_sales_notifications_instance();

        $main_instance->compatibility()->search_product();

        die;
    }

    /**
     * Get files in directory
     *
     * @param $dir
     *
     * @return array|bool
     */

    private function stripslashes_deep($value)
    {
        $value = is_array($value) ? array_map('stripslashes_deep', $value) : stripslashes($value);

        return $value;
    }

    /**
     * Save post meta
     *
     * @param $post
     *
     * @return bool
     */
    public function save()
    {
        if (!isset($_POST['_live_sales_notifications_nonce']) || !isset($_POST['live_sales_notifications_params'])) {
            return false;
        }
        if (!wp_verify_nonce($_POST['_live_sales_notifications_nonce'], 'live_sales_notifications_save_email_settings')) {
            return false;
        }
        if (!current_user_can('manage_options')) {
            return false;
        }
        $data = $_POST['live_sales_notifications_params'];
        $data ['virtual_name'] = sanitize_text_field($this->stripslashes_deep($data['virtual_name']));
        $data ['virtual_city'] = sanitize_text_field($this->stripslashes_deep($data['virtual_city']));
        $data ['custom_css'] = sanitize_text_field($this->stripslashes_deep($data['custom_css']));
        $data ['virtual_country'] = sanitize_text_field($this->stripslashes_deep($data['virtual_country']));
        update_option('_live_sales_notifications_prefix', substr(md5(date("YmdHis")), 0, 10));
        if (isset($data['check_key'])) {
            unset($data['check_key']);
            delete_transient('_site_transient_update_plugins');
        }
        $instance_of_main = live_sales_notifications_instance();
        $options = $instance_of_main->options;

        update_option('live_sales_notifications_params', $options->get_storewise_options($data));

        if (is_plugin_active('wp-fastest-cache/wpFastestCache.php')) {
            $cache = new WpFastestCache();
            $cache->deleteCache(true);
        }
        $instance_of_main->load_options(true);
    }


}

new Live_Sales_Notifications_Admin_Actions();