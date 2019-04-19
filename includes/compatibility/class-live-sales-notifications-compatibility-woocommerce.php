<?php
/**
 * Live Sales Notification Compatibility WooCommerce.
 *
 * @package Live Sales Notification/Classes
 * @version 1.0.0
 */

defined('ABSPATH') || exit;

class Live_Sales_Notifications_Compatibility_WooCommerce extends Live_Sales_Notifications_Compatibility
{


    public function __construct()
    {

        $this->id = 'woocommerce';
        add_action('woocommerce_order_status_completed', array($this, 'order_completed'));
        add_action('woocommerce_order_status_pending', array($this, 'order_completed'));


    }

    public function version_check()
    {

        $version = '3.0.0';

        global $woocommerce;

        if (version_compare($woocommerce->version, $version, ">=")) {

            return true;
        }

        return false;
    }

    function get_all_order_status()
    {
        // TODO: Implement get_all_order_status() method.

        return wc_get_order_statuses();
    }

    public function order_completed($order_id)
    {
        $options = live_sales_notifications_instance()->options;
        $show_product_option = $options->show_product_option();
        if (!$show_product_option) {
            update_option('_live_sales_notifications_prefix', substr(md5(date("YmdHis")), 0, 10));
        }
    }

    public function get_product($settings = array())
    {
        // TODO: Implement get_product() method.
        $enable_single_product = $settings->enable_single_product();
        $notification_product_show_type = $settings->get_notification_product_show_type();
        $products = array();
        $product_link = $settings->product_link();
        $product_thumb = $settings->get_product_sizes();
        $show_product_option = $settings->show_product_option();
        $prefix = live_sales_notifications_prefix();

        /*Check Single Product page*/
        if ($enable_single_product && is_product()) {

            $product_id = get_the_ID();
            if (!$product_id) {
                return;
            }
            $products = get_transient($prefix . 'live_sales_notifications_product_child' . $product_id);
            if (is_array($products) && count($products)) {
                return $products;
            }
            $product = wc_get_product($product_id);

            /* Only show current product*/
            if (!$notification_product_show_type) {
                /*Show variation products*/
                $enable_variable = $settings->show_variation();
                if ($product->get_type() == 'variable' && $enable_variable) {
                    $temp_p = delete_transient('live_sales_notifications_product_child' . $product->get_id());

                    if (is_array($temp_p) && count($temp_p)) {
                        return $temp_p;
                    } else {
                        $temp_p = $product->get_children();

                        if (count($temp_p)) {
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
                        }
                    }
                } else {
                    if ($product->is_in_stock() || $settings->enable_out_of_stock_product()) {
                        if ($product->get_catalog_visibility() == 'hidden') {
                            return false;
                        }

                        // do stuff for everything else
                        $link = $product->get_permalink();


                        $product_tmp = array(
                            'title' => get_the_title(),
                            'url' => $link,
                            'thumb' => has_post_thumbnail($product->get_id()) ? get_the_post_thumbnail_url($product->get_id(), $product_thumb) : '',
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
                    } else {
                        return false;
                    }
                }
            } else {
                /* Show products in the same category*/
                $cates = $product->get_category_ids();
                $args = array(
                    'post_type' => 'product',
                    'post_status' => 'publish',
                    'posts_per_page' => 50,
                    'orderby' => 'rand',
                    'post__not_in' => array($product->get_id()),
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'product_cat',
                            'field' => 'id',
                            'terms' => $cates,
                            'include_children' => false,
                            'operator' => 'IN'
                        )
                    ),
                    'meta_query' => array(
                        array(
                            'key' => '_stock_status',
                            'value' => 'instock',
                            'compare' => '='
                        )
                    )
                );
                if ($settings->enable_out_of_stock_product()) {
                    unset($args['meta_query']);
                }
                $the_query = new WP_Query($args);

                if ($the_query->have_posts()) {
                    while ($the_query->have_posts()) {
                        $the_query->the_post();
                        $product = wc_get_product(get_the_ID());
                        if ($product->get_catalog_visibility() == 'hidden') {
                            continue;
                        }
                        if ($product->is_type('external') && $product_link) {
                            // do stuff for simple products
                            $link = get_post_meta($product_id, '_product_url', '#');
                            if (!$link) {
                                $link = get_the_permalink();


                            }
                        } else {
                            // do stuff for everything else
                            $link = get_the_permalink();


                        }

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

                set_transient($prefix . 'live_sales_notifications_product_child' . $product->get_id(), $products, 3600);

                return $products;
            } else {
                return false;
            }
            // Reset Post Data
        }

        /*Get All page*/
        /*Check with Product get from Billing*/
        $limit_product = $settings->get_limit_product();

        if ($show_product_option > 0) {
            $products = get_transient($prefix);
            if (is_array($products) && count($products)) {
                return $products;
            } else {
                $products = array();
            }
            switch ($show_product_option) {
                case 1:
                    /*Select Products*/
                    /*Params from Settings*/
                    $archive_products = $settings->get_products();
                    $archive_products = is_array($archive_products) ? $archive_products : array();

                    if (count(array_filter($archive_products)) < 1) {
                        $args = array(
                            'post_type' => 'product',
                            'post_status' => 'publish',
                            'posts_per_page' => '50',
                            'orderby' => 'rand',
                            'meta_query' => array(
                                array(
                                    'key' => '_stock_status',
                                    'value' => 'instock',
                                    'compare' => '='
                                ),
                            )

                        );


                    } else {
                        $args = array(
                            'post_type' => array('product', 'product_variation'),
                            'post_status' => 'publish',
                            'posts_per_page' => '50',
                            'orderby' => 'rand',
                            'post__in' => $archive_products,
                            'meta_query' => array(
                                array(
                                    'key' => '_stock_status',
                                    'value' => 'instock',
                                    'compare' => '='
                                ),
                            )

                        );

                    }
                    break;
                case 2:
                    /*Latest Products*/
                    /*Params from Settings*/
                    $args = array(
                        'post_type' => 'product',
                        'post_status' => 'publish',
                        'posts_per_page' => $limit_product,
                        'orderby' => 'date',
                        'order' => 'DESC',
                        'meta_query' => array(
                            array(
                                'key' => '_stock_status',
                                'value' => 'instock',
                                'compare' => '='
                            )
                        ),
                    );

                    break;
                case 4:
                    $viewed_products = !empty($_COOKIE['live_sales_notifications_recently_viewed_product']) ? (array)explode('|', wp_unslash($_COOKIE['live_sales_notifications_recently_viewed_product'])) : array(); // @codingStandardsIgnoreLine
                    $viewed_products = array_reverse(array_filter(array_map('absint', $viewed_products)));

                    if (empty($viewed_products)) {
                        $args = array(
                            'post_type' => 'product',
                            'post_status' => 'publish',
                            'posts_per_page' => '50',
                            'orderby' => 'rand',
                            'meta_query' => array(
                                array(
                                    'key' => '_stock_status',
                                    'value' => 'instock',
                                    'compare' => '='
                                ),
                            )

                        );
                    } else {
                        $args = array(
                            'posts_per_page' => $limit_product,
                            'no_found_rows' => 1,
                            'post_status' => 'publish',
                            'post_type' => 'product',
                            'post__in' => $viewed_products,
                            'orderby' => 'post__in',
                            'meta_query' => array(
                                array(
                                    'key' => '_stock_status',
                                    'value' => 'instock',
                                    'compare' => '='
                                ),
                            )
                        ); // WPCS: slow query ok.
                    }

                    break;
                default:
                    /*Select Categories*/
                    $cates = $settings->get_categories();
                    if (count($cates)) {
                        $categories = get_terms(
                            array(
                                'taxonomy' => 'product_cat',
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
                            'post_type' => 'product',
                            'post_status' => 'publish',
                            'posts_per_page' => $limit_product,
                            'orderby' => 'rand',
                            'post__not_in' => $cate_exclude_products,
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'product_cat',
                                    'field' => 'id',
                                    'terms' => $categories_checked,
                                    'include_children' => false,
                                    'operator' => 'IN'
                                ),
                            ),
                            'meta_query' => array(
                                array(
                                    'key' => '_stock_status',
                                    'value' => 'instock',
                                    'compare' => '='
                                ),
                            )
                        );

                    } else {
                        $args = array(
                            'post_type' => 'product',
                            'post_status' => 'publish',
                            'posts_per_page' => '50',
                            'orderby' => 'rand',
                            'meta_query' => array(
                                array(
                                    'key' => '_stock_status',
                                    'value' => 'instock',
                                    'compare' => '='
                                ),
                            )

                        );

                    }
            }
            /*Enable in stock*/
            if ($settings->enable_out_of_stock_product()) {
                unset($args['meta_query']);
            }
            $the_query = new WP_Query($args);


            if ($the_query->have_posts()) {
                while ($the_query->have_posts()) {
                    $the_query->the_post();
                    $product = wc_get_product(get_the_ID());
                    if ($product->get_catalog_visibility() == 'hidden') {
                        continue;
                    }
                    if ($product->is_type('external') && $product_link) {
                        // do stuff for simple products
                        $link = get_post_meta(get_the_ID(), '_product_url', '#');
                        if (!$link) {
                            $link = get_the_permalink();

                        }
                    } else {
                        // do stuff for everything else
                        $link = get_the_permalink();

                    }
                    $product_tmp = array(
                        'title' => get_the_title(),
                        //						'id'    => get_the_ID(),
                        'url' => $link,
                        'thumb' => has_post_thumbnail() ? get_the_post_thumbnail_url('', $product_thumb) : '',
                    );
                    if (!$product_tmp['thumb'] && $product->is_type('variation')) {
                        $parent_id = $product->get_parent_id();
                        if ($parent_id) {
                            $product_tmp['thumb'] = has_post_thumbnail($parent_id) ? get_the_post_thumbnail_url($parent_id, $product_thumb) : '';
                        }
                    }
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
                'post_type' => 'shop_order',
                'post_status' => $order_statuses,
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
                    $order = new WC_Order(get_the_ID());
                    $items = $order->get_items();

                    foreach ($items as $item) {
                        if (in_array($item['product_id'], $exclude_products)) {
                            continue;
                        }
                        if (isset($item['product_id']) && $item['product_id']) {
                            $p_data = wc_get_product($item['product_id']);
                            if (!$p_data->is_in_stock() && !$settings->enable_out_of_stock_product()) {
                                continue;
                            }
                            if ($p_data->get_status() != 'publish') {
                                continue;
                            }
                            if ($p_data->get_catalog_visibility() == 'hidden') {
                                continue;
                            }
                            // do stuff for everything else
                            $link = $p_data->get_permalink();


                            $product_tmp = array(
                                'title' => get_the_title($p_data->get_id()),
                                'url' => $link,
                                'thumb' => has_post_thumbnail($p_data->get_id()) ? get_the_post_thumbnail_url($p_data->get_id(), $product_thumb) : '',
                                'time' => live_sales_notifications_time_subsctract($order->get_date_created()->date_i18n("Y-m-d H:i:s")),
                                'time_org' => $order->get_date_created()->date_i18n("Y-m-d H:i:s"),
                                'first_name' => ucfirst(get_post_meta(get_the_ID(), '_billing_first_name', true)),
                                'last_name' => ucfirst(get_post_meta(get_the_ID(), '_billing_last_name', true)),
                                'city' => ucfirst(get_post_meta(get_the_ID(), '_billing_city', true)),
                                'state' => ucfirst(get_post_meta(get_the_ID(), '_billing_state', true)),
                                'country' => ucfirst(WC()->countries->countries[get_post_meta(get_the_ID(), '_billing_country', true)])
                            );
                            if (!$product_tmp['thumb'] && $p_data->is_type('variation')) {
                                $parent_id = $p_data->get_parent_id();
                                if ($parent_id) {
                                    $product_tmp['thumb'] = has_post_thumbnail($parent_id) ? get_the_post_thumbnail_url($parent_id, $product_thumb) : '';
                                }
                            }

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
        return is_product();
    }

    public function get_orders_by_product($product_id)
    {
        if (is_array($product_id)) {
            $product_id = implode(',', $product_id);
        }
        $order_threshold_num = $this->settings->get_order_threshold_num();
        $order_threshold_time = $this->settings->get_order_threshold_time();

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
            $timestamp = date('Y-m-d G:i:s', $current_time);
        }


        global $wpdb;

        $raw = "
        SELECT items.order_id,
          MAX(CASE 
              WHEN itemmeta.meta_key = '_product_id' THEN itemmeta.meta_value
           END) AS product_id
          
        FROM {$wpdb->prefix}woocommerce_order_items AS items
        INNER JOIN {$wpdb->prefix}woocommerce_order_itemmeta AS itemmeta ON items.order_item_id = itemmeta.order_item_id
        INNER JOIN {$wpdb->prefix}posts AS post ON post.ID = items.order_id
          
        WHERE items.order_item_type IN('line_item') AND itemmeta.meta_key IN('_product_id','_variation_id') AND post.post_date >= '%s'
        
        GROUP BY items.order_item_id
        
        HAVING product_id IN (%s)";

        $sql = $wpdb->prepare($raw, $timestamp, $product_id);

        return array_map(function ($data) {
            return wc_get_order($data->order_id);
        }, $wpdb->get_results($sql));

    }

    public function search_product()
    {
        $post_types = array('product');

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
                $prd = wc_get_product(get_the_ID());

                if ($prd->has_child() && $prd->is_type('variable')) {
                    $product_children = $prd->get_children();
                    if (count($product_children)) {
                        foreach ($product_children as $product_child) {

                            $product = array(
                                'id' => $product_child,
                                'text' => get_the_title($product_child)
                            );


                            $found_products[] = $product;
                        }

                    }
                } else {
                    $product_id = get_the_ID();
                    $product_title = get_the_title();
                    $the_product = new WC_Product($product_id);
                    if (!$the_product->is_in_stock()) {
                        $product_title .= ' (out-of-stock)';
                    }
                    $product = array('id' => $product_id, 'text' => $product_title);
                    $found_products[] = $product;
                }
            }
        }
        wp_send_json($found_products);
        die;
    }


    public function product_query($product_ids = array(), $post_type = array())
    {

        if (count($post_type) < 1) {
            $post_type = array('product');
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

                $data = wc_get_product($product);

                if ($data->get_type() == 'variation') {
                    continue;
                } else {
                    $name_prd = $data->get_title();
                }
                if (!$data->is_in_stock()) {
                    $name_prd .= ' (out-of-stock)';
                }

                $product_id = $data->get_id();
                $product_data[] = array(
                    'product_id' => $product_id,
                    'product_name' => $name_prd

                );
            }
        }
        return $product_data;
    }

    public function get_product_by_id($product_id)
    {
        $updated_product = new stdClass();

        $_product = new EDD_Download($product_id);

        $updated_product->type = '';

        return $updated_product;
    }
}