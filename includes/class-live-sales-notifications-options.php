<?php

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Get  Notification Data Setting
 * Class class Live_Sales_Notifications_Options
 */
class Live_Sales_Notifications_Options
{
    private $params;

    public $store_specifc_params;

    public $store_type = 'woocommerce';

    /**
     *
     * Init setting
     */
    public function __construct()
    {
        global $live_sales_notifications_settings;

        $live_sales_notifications_settings = get_option('live_sales_notifications_params', array());

        $this->params = $live_sales_notifications_settings;

        $args = array(
            'store_type' => 'woocommerce',
            'enable' => 0,
            'enable_mobile' => 0,
            'enable_rtl' => 0,
            'product_color' => '#212121',
            'text_color' => '#212121',
            'background_color' => '#ffffff',
            'background_image' => 0,
            'image_position' => 0,
            'position' => 0,
            'border_radius' => 0,
            'show_close_icon' => 0,
            'time_close' => 0,
            'image_redirect' => 0,
            'image_redirect_target' => 0,
            'message_display_effect' => 'fade-in',
            'message_hidden_effect' => 'fade-out',
            'custom_css' => '',
            'message_purchased' => array(),
            'custom_shortcode' => '{number} people seeing this product right now',
            'min_number' => '100',
            'max_number' => '200',
            'show_product_option' => 0,
            'select_categories' => array(),
            'cate_exclude_products' => array(),
            'limit_product' => 50,
            'exclude_products' => array(),
            'order_threshold_num' => 30,
            'order_threshold_time' => 0,
            'order_statuses' => array('wc-processing', 'wc-completed'),
            'archive_products' => array(),
            'virtual_name' => '',
            'virtual_time' => 10,
            'country' => 0,
            'virtual_city' => '',
            'virtual_country' => '',
            'ipfind_auth_key' => '',
            'product_sizes' => 'shop_thumbnail',
            'non_ajax' => 0,
            'enable_single_product' => 0,
            'enable_out_of_stock_product' => 0,
            'notification_product_show_type' => 0,
            'show_variation' => 0,
            'loop' => 0,
            'next_time' => 0,
            'notification_per_page' => 30,
            'initial_delay_random' => 0,
            'initial_delay_min' => 0,
            'initial_delay' => 0,
            'display_time' => 0,
            'audio_enable' => 0,
            'audio' => 'cool.mp3',
            'is_home' => 0,
            'is_checkout' => 0,
            'is_cart' => 0,
            'key' => '',
            'product_link' => 0,
        );
        $this->params = apply_filters('live_sales_notifications_settings_args', wp_parse_args($this->params, $args));

        if (isset($this->params['store_type'])) {
            $this->store_type = $this->params['store_type'];
        }
        $this->store_specifc_params = $this->get_storewise_options();
    }

    private function get_params($key)
    {
        $storewise_params = $this->get_storewise_options($this->params);

        $store_type = $this->store_type;

        $return_value = '';
        if (isset($storewise_params[$key])) {
            $return_value = $storewise_params[$key];
        }
        if (isset($storewise_params[$store_type . '_' . $key])) {
            $return_value = $storewise_params[$store_type . '_' . $key];
        }


        return $return_value;
    }

    public function get_storewise_options($datas = array())
    {

        if (count($datas) < 1) {

            $datas = $this->params;
        }
        $storewise_options = array();

        $store_type = $this->store_type;

        $store_instance = live_sales_notifications_instance()->compatibility($store_type);

        foreach ($datas as $data_key => $data_value) {


            if ($this->is_store_specific_key($store_instance, $data_key)) {

                $storewise_options[$store_type . '_' . $data_key] = $data_value;

            } else {

                $storewise_options[$data_key] = $data_value;

            }
        }

        return $storewise_options;


    }

    public function is_store_specific_key($store_instance, $key)
    {


        $store_specific_keys = $store_instance->store_specific_keys;

        if (!in_array($key, $store_specific_keys)) {

            return false;
        }
        return true;
    }

    /**
     * Get time close cookie
     * @return mixed|void
     */
    public function get_time_close()
    {
        return apply_filters('live_sales_notifications_get_time_close', $this->get_params('time_close'));
    }

    /**
     * Get time close cookie
     * @return mixed|void
     */
    public function get_store_type()
    {
        return apply_filters('live_sales_notifications_get_store_type', $this->store_type);
    }

    /**
     * Enable RTL
     * @return mixed|void
     */
    public function enable_rtl()
    {
        return is_rtl();
    }

    /**
     * Check External product
     * @return mixed|void
     */
    public function product_link()
    {
        return apply_filters('live_sales_notifications_product_link', $this->get_params('product_link'));
    }

    /**
     * Check enable plugin
     * @return mixed|void
     */
    public function enable()
    {
        return apply_filters('live_sales_notifications_enable', $this->get_params('enable'));
    }

    /**
     * Check enable mobile
     * @return mixed|void
     */
    public function enable_mobile()
    {
        return apply_filters('live_sales_notifications_enable_mobile', $this->get_params('enable_mobile'));
    }

    /**
     * Get Highlight Color
     * @return mixed|void
     */
    public function get_product_color()
    {
        return apply_filters('live_sales_notifications_get_product_color', $this->get_params('product_color'));
    }

    /**
     * Get Text Color
     * @return mixed|void
     */
    public function get_text_color()
    {
        return apply_filters('live_sales_notifications_get_text_color', $this->get_params('text_color'));
    }

    /**
     * Get Background Color
     * @return mixed|void
     */
    public function get_background_color()
    {
        return apply_filters('live_sales_notifications_get_background_color', $this->get_params('background_color'));
    }

    /**
     * Get Background Image
     * @return mixed|void
     */
    public function get_background_image()
    {
        return apply_filters('live_sales_notifications_get_background_image', $this->get_params('background_image'));
    }

    /**
     * Get Image Position
     * @return mixed|void
     */
    public function get_image_position()
    {
        return apply_filters('live_sales_notifications_get_image_position', $this->get_params('image_position'));
    }

    /**
     * Get position
     * @return mixed|void
     */
    public function get_position()
    {
        return apply_filters('live_sales_notifications_get_position', $this->get_params('position'));
    }

    /**
     * Get border radius
     * @return mixed|void
     */
    public function get_border_radius()
    {
        return apply_filters('live_sales_notifications_get_border_radius', $this->get_params('border_radius'));
    }

    /**
     * Check show close icon
     * @return mixed|void
     */
    public function show_close_icon()
    {
        return apply_filters('live_sales_notifications_image_redirect', $this->get_params('show_close_icon'));
    }

    /**
     * Check image clickable
     * @return mixed|void
     */
    public function image_redirect()
    {
        return apply_filters('live_sales_notifications_image_redirect', $this->get_params('image_redirect'));
    }

    public function image_redirect_target()
    {
        return apply_filters('live_sales_notifications_image_redirect_target', $this->get_params('image_redirect_target'));
    }

    /**
     * Get Display Effect
     * @return mixed|void
     */
    public function get_display_effect()
    {
        return apply_filters('live_sales_notifications_get_message_display_effect', $this->get_params('message_display_effect'));
    }

    /**
     * Get Hidden Effect
     * @return mixed|void
     */
    public function get_hidden_effect()
    {
        return apply_filters('live_sales_notifications_get_message_hidden_effect', $this->get_params('message_hidden_effect'));
    }

    /**
     * Get custom CSS
     * @return mixed|void
     */
    public function get_custom_css()
    {
        return apply_filters('live_sales_notifications_get_custom_css', $this->get_params('custom_css'));
    }

    /**
     * Get message purchased with shortcode
     * @return mixed|void
     */
    public function get_message_purchased()
    {
        return apply_filters('live_sales_notifications_get_message_purchased', $this->get_params('message_purchased'));
    }

    /**
     * Get custom shortcode
     * @return mixed|void
     */
    public function get_custom_shortcode()
    {

        return apply_filters('live_sales_notifications_get_custom_shortcode', $this->get_params('custom_shortcode'));
    }

    /**
     * Get min number in shortcode
     * @return mixed|void
     */
    public function get_min_number()
    {
        return apply_filters('live_sales_notifications_get_min_number', $this->get_params('min_number'));
    }

    /**
     * Get max number in shortcode
     * @return mixed|void
     */
    public function get_max_number()
    {
        return apply_filters('live_sales_notifications_get_max_number', $this->get_params('max_number'));
    }

    /**
     * Check notification data type to get
     * @return mixed|void
     */
    public function show_product_option()
    {
        return apply_filters('live_sales_notifications_get_show_product_option', $this->get_params('show_product_option'));
    }

    /**
     * Get list categories
     * @return mixed|void
     */
    public function get_categories()
    {
        return apply_filters('live_sales_notifications_get_select_categories', $this->get_params('select_categories'));
    }

    /**
     * Get exclude products of Categories
     * @return mixed|void
     */
    public function get_cate_exclude_products()
    {
        return apply_filters('live_sales_notifications_get_cate_exclude_products', $this->get_params('cate_exclude_products'));
    }

    /**
     * Get limit products
     * @return mixed|void
     */
    public function get_limit_product()
    {
        return apply_filters('live_sales_notifications_get_limit_product', $this->get_params('limit_product'));
    }

    /**
     * Get exclude products of get product from billing
     * @return mixed|void
     */
    public function get_exclude_products()
    {
        return apply_filters('live_sales_notifications_get_exclude_products', $this->get_params('exclude_products'));
    }

    /**
     * Get threshold number
     * @return mixed|void
     */
    public function get_order_threshold_num()
    {
        return apply_filters('live_sales_notifications_get_order_threshold_num', $this->get_params('order_threshold_num'));
    }

    /**
     * Get threshold type
     * @return mixed|void
     */
    public function get_order_threshold_time()
    {
        return apply_filters('live_sales_notifications_get_order_threshold_time', $this->get_params('order_threshold_time'));
    }

    /**
     * Get order status
     * @return mixed|void
     */
    public function get_order_statuses()
    {
        return apply_filters('live_sales_notifications_get_order_statuses', $this->get_params('order_statuses'));
    }

    /**
     * Get list products
     * @return mixed|void
     */
    public function get_products()
    {
        return apply_filters('live_sales_notifications_get_archive_products', $this->get_params('archive_products'));
    }

    /**
     * Check address type
     * @return mixed|void
     */
    public function country()
    {
        return apply_filters('live_sales_notifications_country', $this->get_params('country'));
    }

    /**
     * Get Virtual Time
     * @return mixed|void
     */
    public function get_virtual_name()
    {
        return apply_filters('live_sales_notifications_get_virtual_name', $this->get_params('virtual_name'));
    }

    /**
     * Get Virtual Time
     * @return mixed|void
     */
    public function get_virtual_time()
    {
        return apply_filters('live_sales_notifications_get_virtual_time', $this->get_params('virtual_time'));
    }

    /**
     * Get Virtual City
     * @return mixed|void
     */
    public function get_virtual_city()
    {


        return apply_filters('live_sales_notifications_get_virtual_city', $this->get_params('virtual_city'));
    }

    /**
     * Get Virtual Country
     * @return mixed|void
     */
    public function get_virtual_country()
    {


        return apply_filters('live_sales_notifications_get_virtual_country', $this->get_params('virtual_country'));
    }


    /**
     * Get product image size
     * @return mixed|void
     */
    public function get_product_sizes()
    {
        return apply_filters('live_sales_notifications_get_product_sizes', $this->get_params('product_sizes'));
    }

    /**
     * Check turn off Ajax
     * @return mixed|void
     */
    public function non_ajax()
    {
        return apply_filters('live_sales_notifications_non_ajax', $this->get_params('non_ajax'));
    }

    /**
     * Enable notification in single product page
     * @return mixed|void
     */
    public function enable_single_product()
    {
        return apply_filters('live_sales_notifications_enable_single_product', $this->get_params('enable_single_product'));
    }

    public function enable_out_of_stock_product()
    {
        return apply_filters('live_sales_notifications_enable_out_of_stock_product', $this->get_params('enable_out_of_stock_product'));
    }

    /**
     * Get notification type show in single product
     * @return mixed|void
     */
    public function get_notification_product_show_type()
    {
        return apply_filters('live_sales_notifications_get_notification_product_show_type', $this->get_params('notification_product_show_type'));
    }

    /**
     * Check show variation
     * @return mixed|void
     */
    public function show_variation()
    {
        return apply_filters('live_sales_notifications_show_variation', $this->get_params('show_variation'));
    }

    /**
     * Check loop
     * @return mixed|void
     */
    public function loop()
    {
        return apply_filters('live_sales_notifications_loop', $this->get_params('loop'));
    }

    /**
     * Get next time.
     * @return mixed|void
     */
    public function get_next_time()
    {
        return apply_filters('live_sales_notifications_get_next_time', $this->get_params('next_time'));
    }

    /**
     * Get notification show on page
     * @return mixed|void
     */
    public function get_notification_per_page()
    {
        return apply_filters('live_sales_notifications_get_notification_per_page', $this->get_params('notification_per_page'));
    }

    /**
     * Check random init time
     * @return mixed|void
     */
    public function initial_delay_random()
    {
        return apply_filters('live_sales_notifications_initial_delay_random', $this->get_params('initial_delay_random'));
    }

    /**
     * Get time delay minimum. It will random from initial_delay_min to initial_delay.
     * @return mixed|void
     */
    public function get_initial_delay_min()
    {
        return apply_filters('live_sales_notifications_get_initial_delay_min', $this->get_params('initial_delay_min'));
    }

    /**
     * Get time delay to display notification
     * @return mixed|void
     */
    public function get_initial_delay()
    {
        return apply_filters('live_sales_notifications_get_initial_delay', $this->get_params('initial_delay'));
    }

    /**
     * Get time display of notification
     * @return mixed|void
     */
    public function get_display_time()
    {
        return apply_filters('live_sales_notifications_get_display_time', $this->get_params('display_time'));
    }

    /**
     * Check enable audio
     * @return mixed|void
     */
    public function audio_enable()
    {
        return apply_filters('live_sales_notifications_audio_enable', $this->get_params('audio_enable'));
    }

    /**
     * Get Audio file
     * @return mixed|void
     */
    public function get_audio()
    {
        return apply_filters('live_sales_notifications_get_audio', $this->get_params('audio'));
    }

    /**
     * Check hidden on Homepage
     * @return mixed|void
     */
    public function is_home()
    {
        return apply_filters('live_sales_notifications_is_home', $this->get_params('is_home'));
    }

    /**
     * Check hidden on Checkout page
     * @return mixed|void
     */
    public function is_checkout()
    {
        return apply_filters('live_sales_notifications_is_checkout', $this->get_params('is_checkout'));
    }

    /**
     * Check hidden on Cart page
     * @return mixed|void
     */
    public function is_cart()
    {
        return apply_filters('live_sales_notifications_is_cart', $this->get_params('is_cart'));
    }


    /**
     * Get purchased code
     * @return mixed|void
     */
    public function get_geo_api()
    {
        return apply_filters('live_sales_notifications_get_key', $this->get_params('key'));
    }


}