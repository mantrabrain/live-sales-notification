<?php
/**
 * Live Sales Notification Compatibility EDD.
 *
 * @package Live Sales Notification/Classes
 * @version 1.0.0
 */

defined('ABSPATH') || exit;

class Live_Sales_Notifications_Compatibility_EDD extends Live_Sales_Notifications_Compatibility
{

    public function __construct()
    {
        $this->id = 'edd';

        add_action('woocommerce_order_status_completed', array($this, 'order_completed'));
        add_action('woocommerce_order_status_pending', array($this, 'order_completed'));
    }

    public function version_check()
    {

        return true;
    }

    public function get_all_order_status()
    {
        return array(
            'edd-pending' => __('EDD Pending', 'live-sales-notifications'),
            'edd-processing' => __('EDD Processing', 'live-sales-notifications'),
            'edd-on-hold' => __('EDD on hold', 'live-sales-notifications'),
        );
    }

    function order_completed($order_id)
    {
        // TODO: Implement order_completed() method.
    }

    function get_product1($settings = array())
    {
        // TODO: Implement get_product() method.

        $product = array(

            array(
                "thumb" => "https://mantrabrain.com/wp-content/uploads/2019/01/mantranews-banner-1024x768.png",
                "title" => "Mantranews WordPress Theme",
                "url" => "https://mantrabrain.com/downloads/mantranews-wordpress-news-theme/",
                "first_name" => "Nabin",
                "city" => "Kathmandu",
                "state" => "Bagmati",
                "country" => "Nepal",
                'time' => live_sales_notifications_time_subsctract('2019-04-17 15:15:30'),
            )
        );
        return $product;

    }

    function get_product($settings = array())
    {
        // TODO: Implement get_product() method.
        $enable_single_product = false;//$settings->enable_single_product();
        $notification_product_show_type = true;//$settings->get_notification_product_show_type();
        $products = array();
        $product_link = $settings->product_link();
        $product_thumb = $settings->get_product_sizes();
        $show_product_option = $settings->show_product_option();
        $prefix = live_sales_notifications_prefix();

        /*Check Single Product page*/
        if ($enable_single_product && is_edd_product_single_page()) {


            $product_id = get_the_ID();
            if (!$product_id) {
                return;
            }

            $products = get_transient($prefix . 'live_sales_notifications_product_child' . $product_id);
            if (is_array($products) && count($products)) {
                return $products;
            }
            $product = new EDD_Download($product_id);

            /* Only show current product*/
            if (!$notification_product_show_type) {
                /*Show variation products*/
                $enable_variable = true;//$settings->show_variation();


                if ($product->has_variable_prices() && $enable_variable) {
                    $temp_p = delete_transient('live_sales_notifications_product_child' . $product->ID);

                    if (is_array($temp_p) && count($temp_p)) {
                        return $temp_p;
                    } else {
                        //$temp_p = $product->get_children();

                        /*if (count($temp_p)) {
                            foreach ($temp_p as $key => $the_product) {
                                $product_variation = wc_get_product($the_product);

                                if (!$product_variation->is_in_stock() && !$settings->enable_out_of_stock_product()) {
                                    unset($temp_p[$key]);
                                } else {
                                    if ($product_variation->get_catalog_visibility() == 'hidden') {
                                        continue;
                                    }

                                    // do stuff for everything else
                                    $link = $product_variation->get_permalink();


                                    $product_tmp = array(
                                        'title' => $product_variation->get_name(),
                                        'url' => $link,
                                        'thumb' => has_post_thumbnail($product->get_id()) ? get_the_post_thumbnail_url($product->get_id(), $product_thumb) : (has_post_thumbnail($product_id) ? get_the_post_thumbnail_url($product_id, $product_thumb) : ''),
                                    );

                                    if (!$show_product_option) {
                                        $orders = $this->get_orders_by_product($product_id);
                                        if (is_array($orders) && count($orders)) {
                                            foreach ($orders as $order) {
                                                $order_infor = array(
                                                    'time' => live_sales_notifications_time_subsctract($order->get_date_created()->date_i18n("Y-m-d H:i:s")),
                                                    'time_org' => $order->get_date_created()->date_i18n("Y-m-d H:i:s"),
                                                    'first_name' => ucfirst(get_post_meta($order->get_id(), '_billing_first_name', true)),
                                                    'last_name' => ucfirst(get_post_meta($order->get_id(), '_billing_last_name', true)),
                                                    'city' => ucfirst(get_post_meta($order->get_id(), '_billing_city', true)),
                                                    'state' => ucfirst(get_post_meta($order->get_id(), '_billing_state', true)),
                                                    'country' => ucfirst(WC()->countries->countries[get_post_meta($order->get_id(), '_billing_country', true)])
                                                );
                                                $products[] = array_merge($product_tmp, $order_infor);
                                            }
                                        }
                                    } else {
                                        $products[] = $product_tmp;
                                    }
                                }
                            }
                        }*/
                    }
                } else {

                    return false;

                }
            } else {
                /* Show products in the same category*/
                $cates_obj = get_the_terms($product_id, 'download_category');
                $cates = wp_list_pluck($cates_obj, 'term_id');
                $args = array(
                    'post_type' => 'download',
                    'post_status' => 'publish',
                    'posts_per_page' => 50,
                    'orderby' => 'rand',
                    'post__not_in' => array($product_id),
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'download_category',
                            'field' => 'id',
                            'terms' => $cates,
                            'include_children' => false,
                            'operator' => 'IN'
                        )
                    )
                );


                $the_query = new WP_Query($args);

                if ($the_query->have_posts()) {

                    while ($the_query->have_posts()) {
                        $the_query->the_post();
                        $product = new EDD_Download(get_the_ID());


                        // do stuff for everything else
                        $link = get_the_permalink();


                        $product_tmp = array(
                            'title' => get_the_title(),
                            'url' => $link,
                            'thumb' => has_post_thumbnail() ? get_the_post_thumbnail_url('', $product_thumb) : '',
                        );

                        $products[] = $product_tmp;
                    }

                }

                // Reset Post Data
                wp_reset_postdata();


            }

            if (is_array($products) && count($products)) {

                set_transient($prefix . 'live_sales_notifications_product_child' . $product->ID, $products, 3600);

                return $products;
            } else {
                return false;
            }
            // Reset Post Data
        }

        /*Get All page*/
        /*Check with Product get from Billing*/
        $limit_product = $settings->get_limit_product();
        $show_product_option = 0;
        if ($show_product_option > 0) {
            $products = array();
            /* $products = get_transient($prefix);
             if (is_array($products) && count($products)) {
                 return $products;
             } else {
                 $products = array();
             }*/
            switch ($show_product_option) {
                case 1:
                    /*Select Products*/
                    /*Params from Settings*/
                    $archive_products = $settings->get_products();
                    $archive_products = is_array($archive_products) ? $archive_products : array();

                    if (count(array_filter($archive_products)) < 1) {
                        $args = array(
                            'post_type' => 'download',
                            'post_status' => 'publish',
                            'posts_per_page' => 50,
                            'orderby' => 'rand',

                        );


                    } else {
                        $args = array(
                            'post_type' => array('download'),
                            'post_status' => 'publish',
                            'posts_per_page' => '50',
                            'orderby' => 'rand',
                            'post__in' => $archive_products,

                        );

                    }
                    break;
                case 2:
                    /*Latest Products*/
                    /*Params from Settings*/
                    $args = array(
                        'post_type' => 'download',
                        'post_status' => 'publish',
                        'posts_per_page' => $limit_product,
                        'orderby' => 'date',
                        'order' => 'DESC',
                    );

                    break;
                case 4:
                    $viewed_products = !empty($_COOKIE['live_sales_notifications_recently_viewed_product']) ? (array)explode('|', wp_unslash($_COOKIE['live_sales_notifications_recently_viewed_product'])) : array(); // @codingStandardsIgnoreLine
                    $viewed_products = array_reverse(array_filter(array_map('absint', $viewed_products)));

                    if (empty($viewed_products)) {
                        $args = array(
                            'post_type' => 'download',
                            'post_status' => 'publish',
                            'posts_per_page' => '50',
                            'orderby' => 'rand',


                        );
                    } else {
                        $args = array(
                            'posts_per_page' => $limit_product,
                            'no_found_rows' => 1,
                            'post_status' => 'publish',
                            'post_type' => 'download',
                            'post__in' => $viewed_products,
                            'orderby' => 'post__in',
                        ); // WPCS: slow query ok.
                    }

                    break;
                default:
                    /*Select Categories*/
                    $cates = $settings->get_categories();
                    if (count($cates)) {
                        $categories = get_terms(
                            array(
                                'taxonomy' => 'download_category',
                                'include' => $cates
                            )
                        );

                        $categories_checked = array();
                        if (count($categories)) {
                            foreach ($categories as $category) {
                                $categories_checked[] = $category->term_id;
                            }
                        } else {
                            return false;
                        }

                        /*Params from Settings*/
                        $cate_exclude_products = $settings->get_cate_exclude_products();

                        if (!is_array($cate_exclude_products)) {
                            $cate_exclude_products = array();
                        }

                        $args = array(
                            'post_type' => 'download',
                            'post_status' => 'publish',
                            'posts_per_page' => $limit_product,
                            'orderby' => 'rand',
                            'post__not_in' => $cate_exclude_products,
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'download_category',
                                    'field' => 'id',
                                    'terms' => $categories_checked,
                                    'include_children' => false,
                                    'operator' => 'IN'
                                ),
                            )
                        );

                    } else {
                        $args = array(
                            'post_type' => 'download',
                            'post_status' => 'publish',
                            'posts_per_page' => '50',
                            'orderby' => 'rand',


                        );

                    }
            }

            $the_query = new WP_Query($args);


            if ($the_query->have_posts()) {

                while ($the_query->have_posts()) {
                    $the_query->the_post();
                    $product = new EDD_Download(get_the_ID());


                    // do stuff for everything else
                    $link = get_the_permalink();


                    $product_tmp = array(
                        'title' => get_the_title(),
                        //						'id'    => get_the_ID(),
                        'url' => $link,
                        'thumb' => has_post_thumbnail() ? get_the_post_thumbnail_url('', $product_thumb) : '',
                    );

                    $products[] = $product_tmp;
                }

            }
            // Reset Post Data
            wp_reset_postdata();
            if (count($products)) {

                set_transient($prefix, $products, 3600);

                return $products;
            } else {
                return false;
            }
        } else {


            /*Get from billing*/
            /*Parram*/
            $order_threshold_num = $settings->get_order_threshold_num();
            $order_threshold_time = $settings->get_order_threshold_time();
            $exclude_products = $settings->get_exclude_products();
            $order_statuses = $settings->get_order_statuses();
            if (!is_array($exclude_products)) {
                $exclude_products = array();
            }
            $current_time = '';
            if ($order_threshold_num) {
                switch ($order_threshold_time) {
                    case 1:
                        $time_type = 'days';
                        break;
                    case 2:
                        $time_type = 'minutes';
                        break;
                    default:
                        $time_type = 'hours';
                }
                $current_time = strtotime("-" . $order_threshold_num . " " . $time_type);
            }
            $args = array(
                'post_type' => 'edd_payment',
                'post_status' => array('pending'),//$order_statuses,
                'posts_per_page' => '100',
                'orderby' => 'date',
                'order' => 'DESC'
            );
            if ($current_time) {
                $args['date_query'] = array(
                    array(
                        'after' => array(
                            'year' => date("Y", $current_time),
                            'month' => date("m", $current_time),
                            'day' => date("d", $current_time),
                            'hour' => date("H", $current_time),
                            'minute' => date("i", $current_time),
                            'second' => date("s", $current_time),
                        ),
                        'inclusive' => true,
                        //(boolean) - For after/before, whether exact value should be matched or not'.
                        'compare' => '<=',
                        //(string) - Possible values are '=', '!=', '>', '>=', '<', '<=', 'LIKE', 'NOT LIKE', 'IN', 'NOT IN', 'BETWEEN', 'NOT BETWEEN', 'EXISTS' (only in WP >= 3.5), and 'NOT EXISTS' (also only in WP >= 3.5). Default value is '='
                        'column' => 'post_date',
                        //(string) - Column to query against. Default: 'post_date'.
                        'relation' => 'AND',
                        //(string) - OR or AND, how the sub-arrays should be compared. Default: AND.
                    ),
                );
            }

            $my_query = new WP_Query($args);

            $products = array();
            if ($my_query->have_posts()) {

                while ($my_query->have_posts()) {
                    $my_query->the_post();
                    $order = edd_get_payment(get_the_ID());
                    $order_meta = edd_get_payment_meta_downloads(get_the_ID());
                    $order_meta_user_info = edd_get_payment_meta_user_info(get_the_ID());


                    /*    echo '<pre>';
                        print_r($order);
                        print_r($order_meta);
                        print_r($order_meta_user_info);exit;*/

                    foreach ($order_meta as $item) {
                        if (in_array($item['id'], $exclude_products)) {
                            continue;
                        }
                        if (isset($item['id']) && $item['id']) {
                            $p_data = new EDD_Download($item['id']);


                            if ($p_data->post_status != 'publish') {
                                continue;
                            }


                            // do stuff for everything else
                            $link = get_permalink($item['id']);


                            $item_meta = edd_get_payment_meta($item['id']);


                            $product_tmp = array(
                                'title' => get_the_title($p_data->ID),
                                'url' => $link,
                                'thumb' => has_post_thumbnail($p_data->ID) ? get_the_post_thumbnail_url($p_data->ID, $product_thumb) : '',
                                'time' => live_sales_notifications_time_subsctract($item_meta['date']),
                                'time_org' => $item_meta['date'],
                                'first_name' => ucfirst($order_meta_user_info['first_name']),
                                'last_name' => ucfirst($order_meta_user_info['last_name']),
                                'city' => '',
                                'state' => '',
                                'country' => ''
                            );


                            $products[] = $product_tmp;

                        }
                    }
                    $products = array_map("unserialize", array_unique(array_map("serialize", $products)));
                    $products = array_values($products);
                    if (count($products) >= 100) {
                        break;
                    }
                }

            }
            // Reset Post Data
            wp_reset_postdata();
            if (count($products)) {

                return $products;

            } else {
                return false;
            }


        }
    }

    public function is_product()
    {
        return false;
    }

    public function search_product()
    {
        $post_types = array('download');

        if (!current_user_can('manage_options')) {
            return;
        }

        ob_start();

        $keyword = filter_input(INPUT_GET, 'keyword', FILTER_SANITIZE_STRING);

        if (empty($keyword)) {
            die();
        }
        $arg = array(
            'post_status' => 'publish',
            'post_type' => $post_types,
            'posts_per_page' => 50,
            's' => $keyword

        );
        $the_query = new WP_Query($arg);
        $found_products = array();
        if ($the_query->have_posts()) {
            while ($the_query->have_posts()) {
                $the_query->the_post();
                $product_id = get_the_ID();
                $product_title = get_the_title();
                $product = array('id' => $product_id, 'text' => $product_title);
                $found_products[] = $product;

            }
        }
        wp_send_json($found_products);
        die;
    }

    public function product_query($product_ids = array(), $post_type = array())
    {
        if (count($post_type) < 1) {
            $post_type = array('download');
        }
        $args_p = array(
            'post_type' => $post_type,
            'post_status' => 'publish',
            'post__in' => $product_ids,
            'posts_per_page' => -1,
        );
        $product_data = array();
        $the_query_p = new WP_Query($args_p);
        if ($the_query_p->have_posts()) {
            $products = $the_query_p->posts;
            foreach ($products as $product) {

                $product_id = $product->ID;
                $product_data[] = array(
                    'product_id' => $product_id,
                    'product_name' => $product->post_title

                );
            }
        }
        return $product_data;
    }

    public function get_product_by_id($product_id)
    {
        $updated_product = new stdClass();
        $_product = wc_get_product($product_id);
        $updated_product->type = $_product->get_type();
        if ($updated_product->type == 'variation') {
            $updated_product->parent_id = $_product->get_parent_id();
        }
        return $updated_product;
    }

}