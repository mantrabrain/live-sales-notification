<?php
if (!defined('ABSPATH')) {
    exit;
}
/**
 * Function include all files in folder
 *
 * @param $path   Directory address
 * @param $ext    array file extension what will include
 * @param $prefix string Class prefix
 */
if (!function_exists('live_sales_notifications_prefix')) {
    function live_sales_notifications_prefix()
    {
        $prefix = get_option('_live_sales_notifications_prefix', date("Ymd"));

        return $prefix . '_products_' . date("Ymd");
    }
}

if (!function_exists('live_sales_notifications_wpversion')) {
    function live_sales_notifications_wpversion()
    {
        global $wp_version;
        if (version_compare($wp_version, '4.5.0', '<=')) {
            return true;
        } else {
            false;
        }
    }
}


/**
 *
 * @param string $version
 *
 * @return bool
 */
if (!function_exists('live_sales_notifications_store_type')) {
    function live_sales_notifications_store_type()
    {
        $store_type = array(
            'woocommerce' => __('WooCommerce', 'live-sales-notifications'),
            'edd' => __('Easy Digital Download', 'live-sales-notifications')
        );

        return apply_filters('live_sales_notifications_store_type', $store_type);
    }
}

if (!function_exists('live_sales_notifications_get_field')) {

    function live_sales_notifications_get_field($field, $default = '')
    {
        $instance = live_sales_notifications_instance();

        $options = $instance->options;

        $store_type = $instance->store_type;

        $storewise_params = $instance->storewise_options;

        $return_value = $default;

        if (isset($storewise_params[$field])) {
            $return_value = $storewise_params[$field];
        }
        if (isset($storewise_params[$store_type . '_' . $field])) {
            $return_value = $storewise_params[$store_type . '_' . $field];
        }

        return $return_value;

    }
}

if (!function_exists('live_sales_notifications_set_field')) {

    function live_sales_notifications_set_field($field, $multi = false)
    {
        if ($field) {
            if ($multi) {
                return 'live_sales_notifications_params[' . $field . '][]';
            } else {
                return 'live_sales_notifications_params[' . $field . ']';
            }
        } else {
            return '';
        }

    }
}

if (!function_exists('live_sales_notifications_get_language')) {

    function live_sales_notifications_get_language()
    {
        $language = '';
        // Plugin : sitepress-multilingual-cms/sitepress.php
        if (function_exists('wpml_get_current_language')) {

            $language = wpml_get_current_language();

            return $language;
            // Plugin : polylang/polylang.php
        } elseif (class_exists('Polylang')) {

            $language = pll_current_language('slug');

            return $language;
        }


    }
}

if (!function_exists('live_sales_notifications_time_subsctract')) {
    function live_sales_notifications_time_subsctract($time, $number = false, $calculate = false)
    {
        if (!$number) {
            if ($time) {
                $time = strtotime($time);
            } else {
                return false;
            }
        }

        if (!$calculate) {
            $current_time = current_time('timestamp');
            //			echo "$current_time - $time";
            $time_substract = $current_time - $time;
        } else {
            $time_substract = $time;
        }
        if ($time_substract > 0) {

            /*Check day*/
            $day = $time_substract / (24 * 3600);
            $day = intval($day);
            if ($day > 1) {
                return $day . ' ' . esc_html__('days', 'live-sales-notifications');
            } elseif ($day > 0) {
                return $day . ' ' . esc_html__('day', 'live-sales-notifications');
            }

            /*Check hour*/
            $hour = $time_substract / (3600);
            $hour = intval($hour);
            if ($hour > 1) {
                return $hour . ' ' . esc_html__('hours', 'live-sales-notifications');
            } elseif ($hour > 0) {
                return $hour . ' ' . esc_html__('hour', 'live-sales-notifications');
            }

            /*Check min*/
            $min = $time_substract / (60);
            $min = intval($min);
            if ($min > 1) {
                return $min . ' ' . esc_html__('minutes', 'live-sales-notifications');
            } elseif ($min > 0) {
                return $min . ' ' . esc_html__('minute', 'live-sales-notifications');
            }

            return intval($time_substract) . ' ' . esc_html__('seconds', 'live-sales-notifications');

        } else {
            return esc_html__('a few seconds', 'live-sales-notifications');
        }


    }
}