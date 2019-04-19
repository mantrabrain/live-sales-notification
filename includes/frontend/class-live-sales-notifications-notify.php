<?php

/**
 * Class class Live_Sales_Notifications_Notify
 */
if (!defined('ABSPATH')) {
    exit;
}

class Live_Sales_Notifications_Notify
{
    protected $settings;

    protected $main_instance;

    protected $lang;

    public function __construct()
    {

        //$this->settings = new  Live_Sales_Notifications_Options();

        if (isset($_COOKIE['live_sales_notifications_close']) && $_COOKIE['live_sales_notifications_close'] && $this->settings->show_close_icon()) {
            return;

        }

        add_action('init', array($this, 'init'), 11);
        add_action('wp_enqueue_scripts', array($this, 'init_scripts'));

        add_action('wp_footer', array($this, 'wp_footer'));

        add_action('wp_ajax_nopriv_live_sales_notifications_get_product', array($this, 'product_html'));
        add_action('wp_ajax_live_sales_notifications_get_product', array($this, 'product_html'));

        /*Update Recent visited products*/
        add_action('template_redirect', array($this, 'track_product_view'), 21);

    }

    public function init()
    {
        $this->main_instance = live_sales_notifications_instance();

        $this->settings = $this->main_instance->options;
    }

    /**
     * Track product views.
     */
    public function track_product_view()
    {
        if ($this->settings->show_product_option() != 4) {
            return;
        }

        if (!is_singular('product')) {
            return;
        }
        if (is_active_widget(false, false, 'live_sales_notifications_recently_viewed_product_products', true)) {
            return;
        }

        global $post;

        if (empty($_COOKIE['live_sales_notifications_recently_viewed_product'])) { // @codingStandardsIgnoreLine.
            $viewed_products = array();
        } else {
            $viewed_products = wp_parse_id_list((array)explode('|', wp_unslash($_COOKIE['live_sales_notifications_recently_viewed_product']))); // @codingStandardsIgnoreLine.
        }

        // Unset if already in viewed products list.
        $keys = array_flip($viewed_products);

        if (isset($keys[$post->ID])) {
            unset($viewed_products[$keys[$post->ID]]);
        }

        $viewed_products[] = $post->ID;

        if (count($viewed_products) > 15) {
            array_shift($viewed_products);
        }
        // Store for session only.
        setcookie('live_sales_notifications_recently_viewed_product', implode('|', $viewed_products), 0, COOKIEPATH ? COOKIEPATH : '/', COOKIE_DOMAIN, false, false);
    }

    /**
     * Show HTML on front end
     */
    public function product_html()
    {
        $enable = $this->settings->enable();

        if ($enable) {
            $products = $this->get_product();
            if (is_array($products) && count($products)) {
                echo json_encode($products);
            }
        }

        die;
    }

    /**
     * Show product
     *
     * @param $product_id Product ID
     *
     */
    protected function show_product()
    {

        $image_position = $this->settings->get_image_position();
        $position = $this->settings->get_position();

        $class = array();
        $class[] = $image_position ? 'img-right' : '';
        $background_image = $this->settings->get_background_image();


        switch ($position) {
            case  1:
                $class[] = 'bottom_right';
                break;
            case  2:
                $class[] = 'top_left';
                break;
            case  3:
                $class[] = 'top_right';
                break;
        }

        $attachment_url = esc_url(wp_get_attachment_url($background_image));

        $css = 'display:none; ';
        if (!empty($attachment_url)) {
            $css .= 'background-image:url(' . $attachment_url . '); background-size:cover; display:none;';
        }


        if ($this->settings->enable_rtl()) {
            $class[] = 'live-sales-notifications-rtl';
        }
        ob_start();

        ?>
        <div id="sales-notification" class="umeshghimire <?php echo implode(' ', $class) ?>"
             style="<?php echo esc_attr($css); ?>">

        </div>
        <?php


        return ob_get_clean();
    }

    /**
     * Get virtual names
     *
     * @param int $limit
     *
     * @return array|mixed|void
     */
    public function get_names($limit = 0)
    {
        $virtual_name = $this->settings->get_virtual_name();

        if ($virtual_name) {
            $virtual_name = explode("\n", $virtual_name);
            $virtual_name = array_filter($virtual_name);
            if ($limit) {
                if (count($virtual_name) > $limit) {
                    shuffle($virtual_name);

                    return array_slice($virtual_name, 0, $limit);
                }
            }
        }

        return $virtual_name;
    }

    /**
     * Get virtual cities
     *
     * @param int $limit
     *
     * @return array|mixed|void
     */
    public function get_cities($limit = 0)
    {
        $detect_country = $this->settings->country();


        //		if ( ! $detect_country ) {
        //			$detect_data = $this->detect_country();
        //
        //			$city    = isset( $detect_data['city'] ) ? $detect_data['city'] : '';
        //		} else {
        $city = $this->settings->get_virtual_city();
        if ($city) {
            $city = explode("\n", $city);
            $city = array_filter($city);
            if ($limit) {
                if (count($city) > $limit) {
                    shuffle($city);

                    return array_slice($city, 0, $limit);
                }
            }
        }

        //		}
        return $city;
    }

    /**
     * Get all orders given a Product ID.
     *
     * @global        $wpdb
     *
     * @param integer $product_id The product ID.
     *
     * @return array An array of WC_Order objects.
     */


    /**
     * Process product
     * @return bool
     */
    protected function get_product()
    {
        $store = $this->main_instance->compatibility();

        $product = $store->get_product($this->settings);

        return $product;

    }


    /**
     *
     * @return mixed
     */
    protected function get_custom_shortcode()
    {
        $message_shortcode = $this->settings->get_custom_shortcode();
        $min_number = $this->settings->get_min_number();
        $max_number = $this->settings->get_max_number();

        $number = rand($min_number, $max_number);
        $message = preg_replace('/\{number\}/i', $number, $message_shortcode);

        return $message;
    }

    /**
     * Message purchased
     *
     * @param $product_id
     */
    protected function message_purchased()
    {

        $message_purchased = $this->settings->get_message_purchased();
        $show_close_icon = $this->settings->show_close_icon();
        $show_product_option = $this->settings->show_product_option();
        $product_link = $this->settings->product_link();
        $image_redirect = $this->settings->image_redirect();
        $image_redirect_target = $this->settings->image_redirect_target();
        if (is_array($message_purchased)) {
            $index = rand(0, count($message_purchased) - 1);
            $message_purchased = $message_purchased[$index];
        }
        $messsage = '';
        $keys = array(
            '{first_name}',
            '{last_name}',
            '{city}',
            '{state}',
            '{country}',
            '{product}',
            '{product_with_link}',
            '{time_ago}',
            '{custom}'
        );


        $product = $this->get_product();

        if ($product) {
            $product_id = $product['id'];
        } else {
            return false;
        }

        $first_name = trim($product['first_name']);
        $last_name = trim($product['last_name']);

        $city = trim($product['city']);
        $state = trim($product['state']);
        $country = trim($product['country']);
        $time = trim($product['time']);
        if (!$show_product_option) {
            $time = live_sales_notifications_time_subsctract($time);
        }

        $_product = $this->main_instance->compatibility()->get_product_by_id($product_id);

        $product = '<span class="live-sales-notifications-popup-product-title">' . esc_html(strip_tags(get_the_title($product_id))) . '</span>';


        if ($_product->type=='external' && $product_link) {
            // do stuff for simple products
            $link = get_post_meta($product_id, '_product_url', '#');
            if (!$link) {
                $link = get_permalink($product_id);
                $link = wp_nonce_url($link, 'wocommerce_notification_click', 'link');
            }
        } else {
            // do stuff for everything else
            $link = get_permalink($product_id);
            $link = wp_nonce_url($link, 'wocommerce_notification_click', 'link');
        }
        ob_start(); ?>
        <a <?php if ($image_redirect_target) {
            echo 'target="_blank"';
        } ?> href="<?php echo esc_url($link) ?>"><?php echo esc_html($product) ?></a>
        <?php $product_with_link = ob_get_clean();
        ob_start(); ?>
        <small><?php echo esc_html__('About', 'live-sales-notifications') . ' ' . esc_html($time) . ' ' . esc_html__('ago', 'live-sales-notifications') ?></small>
        <?php $time_ago = ob_get_clean();
        $product_thumb = $this->settings->get_product_sizes();

        if (has_post_thumbnail($product_id)) {
            if ($image_redirect) {
                $messsage .= '<a ' . ($image_redirect_target ? 'target="_blank"' : '') . ' href="' . esc_url($link) . '">';
            }
            $messsage .= '<img src="' . esc_url(get_the_post_thumbnail_url($product_id, $product_thumb)) . '" class="live-sales-notifications-product-image"/>';
            if ($image_redirect) {
                $messsage .= '</a>';
            }
        } elseif ($_product->type == 'variation') {


            if (isset($_product->parent_id)) {
                $parent_id = $_product->parent_id;
                $messsage .= '<a ' . ($image_redirect_target ? 'target="_blank"' : '') . ' href="' . esc_url($link) . '">';
            }
            $messsage .= '<img src="' . esc_url(get_the_post_thumbnail_url($parent_id, $product_thumb)) . '" class="live-sales-notifications-product-image"/>';
            if ($image_redirect) {
                $messsage .= '</a>';
            }
        }


        //Get custom shortcode
        $custom_shortcode = $this->get_custom_shortcode();
        $replaced = array(
            $first_name,
            $last_name,
            $city,
            $state,
            $country,
            $product,
            $product_with_link,
            $time_ago,
            $custom_shortcode
        );
        $messsage .= str_replace($keys, $replaced, '<p>' . strip_tags($message_purchased) . '</p>');
        ob_start();
        if ($show_close_icon) {
            ?>
            <span id="notify-close"></span>
            <?php
        }
        $messsage .= ob_get_clean();

        return $messsage;
    }

    /**
     * Show HTML code
     */
    public function wp_footer()
    {

        $enable = $this->settings->enable();
        $audio_enable = $this->settings->audio_enable();
        $audio = $this->settings->get_audio();
        $enable_mobile = $this->settings->enable_mobile();
        $is_home = $this->settings->is_home();
        $is_checkout = $this->settings->is_checkout();
        $is_cart = $this->settings->is_cart();
        // Include and instantiate the class.
        $detect = new Live_Sales_Notifications_Mobile_Detection;

        // Any mobile device (phones or tablets).
        if (!$enable_mobile && $detect->isMobile()) {
            return false;
        }
        /*Assign page*/
        if ($is_home && (is_home() || is_front_page())) {
            return;
        }
        if ($is_checkout && is_checkout()) {
            return;
        }
        if ($is_cart && is_cart()) {
            return;
        }


        if ($enable) {
            echo $this->show_product();
        }


        if ($audio_enable) { ?>
            <audio id="live-sales-notifications-audio">
                <source src="<?php echo esc_url(live_sales_notifications_instance()->plugin_url() . '/assets/audios/' . $audio) ?>">
            </audio>
        <?php }
    }

    /**
     * Add Script and Style
     */
    function init_scripts()
    {

        $this->lang = live_sales_notifications_get_language();
        $is_home = $this->settings->is_home();
        $is_checkout = $this->settings->is_checkout();
        $is_cart = $this->settings->is_cart();
        $prefix = live_sales_notifications_prefix();


        /*Assign page*/
        if ($is_home && (is_home() || is_front_page())) {
            return;
        }
        if ($is_checkout && is_checkout()) {
            return;
        }
        if ($is_cart && is_cart()) {
            return;
        }


        wp_enqueue_style('live-sales-notifications', live_sales_notifications_instance()->plugin_url() . '/assets/css/' . 'live-sales-notifications.css', array(), LIVE_SALES_NOTIFICATIONS_VERSION);
        wp_enqueue_script('live-sales-notifications', live_sales_notifications_instance()->plugin_url() . '/assets/js/' . 'live-sales-notifications.js', array('jquery'), LIVE_SALES_NOTIFICATIONS_VERSION);

        $options_array = get_transient($prefix . '_head' . $this->lang);
        $non_ajax = $this->settings->non_ajax();
        $archive = $this->settings->show_product_option();
        if (!is_array($options_array) || count($options_array) < 1) {
            $options_array = array(
                'str_about' => __('About', 'live-sales-notifications'),
                'str_ago' => __('ago', 'live-sales-notifications'),
                'str_day' => __('day', 'live-sales-notifications'),
                'str_days' => __('days', 'live-sales-notifications'),
                'str_hour' => __('hour', 'live-sales-notifications'),
                'str_hours' => __('hours', 'live-sales-notifications'),
                'str_min' => __('minute', 'live-sales-notifications'),
                'str_mins' => __('minutes', 'live-sales-notifications'),
                'str_secs' => __('secs', 'live-sales-notifications'),
                'str_few_sec' => __('a few seconds', 'live-sales-notifications'),
                'time_close' => $this->settings->get_time_close(),
                'show_close' => $this->settings->show_close_icon()
            );


            /*Notification options*/
            $loop = $this->settings->loop();
            $options_array['loop'] = $loop;


            $initial_delay = $this->settings->get_initial_delay();
            $initial_delay_random = $this->settings->initial_delay_random();
            if ($initial_delay_random) {
                $initial_delay_min = $this->settings->get_initial_delay_min();
                $initial_delay = rand($initial_delay_min, $initial_delay);
            }
            $options_array['initial_delay'] = $initial_delay;

            $display_time = $this->settings->get_display_time();
            $options_array['display_time'] = $display_time;

            $next_time = $this->settings->get_next_time();
            $options_array['next_time'] = $next_time;

            $notification_per_page = $this->settings->get_notification_per_page();
            $options_array['notification_per_page'] = $notification_per_page;

            $message_display_effect = $this->settings->get_display_effect();
            $options_array['display_effect'] = $message_display_effect;

            $message_hidden_effect = $this->settings->get_hidden_effect();
            $options_array['hidden_effect'] = $message_hidden_effect;

            $target = $this->settings->image_redirect_target();
            $options_array['redirect_target '] = $target;

            $image_redirect = $this->settings->image_redirect();
            $options_array['image'] = $image_redirect;

            $message_purchased = $this->settings->get_message_purchased();
            if (!is_array($message_purchased)) {
                $message_purchased = array($message_purchased);
            }
            $options_array['messages'] = $message_purchased;
            $options_array['message_custom'] = $this->settings->get_custom_shortcode();
            $options_array['message_number_min'] = $this->settings->get_min_number();
            $options_array['message_number_max'] = $this->settings->get_max_number();

            /*Autodetect*/
            $detect = $this->settings->country();
            $options_array['detect'] = $detect;
            /*Check get from billing*/

            /*Current products*/
            $enable_single_product = $this->settings->enable_single_product();

            $notification_product_show_type = $this->settings->get_notification_product_show_type();
            if ($archive || ($notification_product_show_type && is_product() && $enable_single_product)) {
                $virtual_time = $this->settings->get_virtual_time();
                $options_array['time'] = $virtual_time;

                $names = $this->get_names(50);
                if (is_array($names) && count($names)) {
                    $options_array['names'] = $names;
                }
                if ($detect) {
                    $cities = $this->get_cities(50);
                    if (is_array($cities) && count($cities)) {
                        $options_array['cities'] = $cities;
                    }
                    $options_array['country'] = $this->settings->get_virtual_country();
                }

                $options_array['billing'] = 0;

            } else {
                $options_array['billing'] = 1;

                if (!$non_ajax && !is_product()) {
                    $options_array['ajax_url'] = admin_url('admin-ajax.php');
                }
            }

            if ($notification_product_show_type && is_product() && $enable_single_product) {
                $options_array['in_the_same_cate'] = 1;
            } else {
                $options_array['in_the_same_cate'] = 0;
            }
            set_transient($prefix . '_head' . $this->lang, $options_array, 86400);
        }

        /*Process products, address, time */
        /*Load products*/
        if ($archive || $non_ajax || is_product()) {
            $products = $this->get_product();
        } else {
            $products = array();
        }
        if (is_array($products) && count($products)) {
            $options_array['products'] = $products;

        }
         /*echo '<pre>';
         //print_r($this->settings);
         var_dump(!$archive);
         var_dump(!$non_ajax);
         var_dump(!is_product());
         exit;*/
        if ($archive && !$non_ajax && !live_sales_notifications_instance()->compatibility()->is_product()) {
            $options_array['ajax_url'] = admin_url('admin-ajax.php');
        }

        wp_localize_script('live-sales-notifications', '_live_sales_notifications_params', $options_array);
        /*Custom*/

        $product_color = $this->settings->get_product_color();
        $text_color = $this->settings->get_text_color();
        $background_color = $this->settings->get_background_color();
        $custom_css_setting = $this->settings->get_custom_css();
        $background_image = $this->settings->get_background_image();


        $border_radius = $this->settings->get_border_radius() . 'px';


        $custom_css = "
                #sales-notification{
                        background-color: {$background_color};                       
                        color:{$text_color} !important;
                        border-radius:{$border_radius} ;
                }
                #sales-notification img{
                       border-radius:{$border_radius} 0 0 {$border_radius};
                }
                 #sales-notification a, #sales-notification p{
                        color:{$text_color} !important;
                }
                 #sales-notification a, #sales-notification p span{
                        color:{$product_color} !important;
                }
                
                " . $custom_css_setting;
        if ($background_image) {
            $background_image = wp_get_attachment_url($background_image);
            $custom_css .= "#sales-notification.live-sales-notifications-extended::before{
				background-image: url('{$background_image}'); background-size:cover;  
				 border-radius:{$border_radius};
			}";
        }
        wp_add_inline_style('live-sales-notifications', $custom_css);


    }
}

new Live_Sales_Notifications_Notify();