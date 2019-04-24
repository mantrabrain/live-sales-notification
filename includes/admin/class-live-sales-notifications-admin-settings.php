<?php

if (!defined('ABSPATH')) {
    exit;
}

class Live_Sales_Notifications_Admin_Settings
{


    /**
     * Get files in directory
     *
     * @param $dir
     *
     * @return array|bool
     */
    static private function get_audios($path = '')
    {

        $audio_path = live_sales_notifications_instance()->plugin_path() . '/assets/audios/';

        $audio_array = array(
            'cool.mp3' => 'cool.mp3',
            'iphone.mp3' => 'iphone.mp3',
            'unique.mp3' => 'unique.mp3',
        );
        if ($path != '') {
            $audio_array = is_array($path) ? $path : array($path);
        }

        return ($audio_array) ? $audio_array : false;
    }

    private function stripslashes_deep($value)
    {
        $value = is_array($value) ? array_map('stripslashes_deep', $value) : stripslashes($value);

        return $value;
    }


    /**
     * Set Nonce
     * @return string
     */
    protected static function set_nonce()
    {
        return wp_nonce_field('live_sales_notifications_save_email_settings', '_live_sales_notifications_nonce');
    }


    /**
     * Get list shortcode
     * @return array
     */
    public static function setting_page()
    {
        do_action('live_sales_notifications_before_admin_setting');
        wp_enqueue_media();

        $main_instance = live_sales_notifications_instance();
        $tabs = self::setting_tabs();

        ?>
        <div class="wrap live-sales-notifications">
            <h2><?php esc_attr_e('Sales Notification Settings', 'live-sales-notifications') ?></h2>
            <form method="post" action="" class="mbui form">
                <?php echo ent2ncr(self::set_nonce()) ?>

                <div class="mbui attached tabular menu">
                    <?php
                    $index = 0;
                    foreach ($tabs as $tab_key => $tab_label) {
                        ?>
                        <div class="item <?php echo $index == 0 ? 'active' : '' ?>" data-tab="<?php echo $tab_key; ?>">
                            <a href="#<?php echo $tab_key; ?>"><?php echo $tab_label ?></a>
                        </div>
                        <?php

                        $index++;
                    }
                    ?>
                </div>
                <div class="live-sales-notifications-admin-tab-content">
                    <?php
                    $index_content = 0;
                    foreach ($tabs as $tab_index => $label) {
                        ?>
                        <div class="mbui bottom attached tab segment <?php echo $index_content == 0 ? 'active' : '' ?>"
                             data-tab="<?php echo $tab_index; ?>">
                            <?php
                            $file = 'views/html-settings-tab-' . $tab_index . '.php';
                            if (file_exists(LIVE_SALES_NOTIFICATIONS_ABSPATH . 'includes/admin/' . $file)) {

                                include_once $file;

                            } else {
                                echo '<h1>File not exists</h1>';
                            }
                            ?>
                        </div>

                        <?php

                        $index_content++;
                    }
                    ?>
                </div>
                <p style="position: relative; z-index: 99999; margin-bottom: 70px; display: inline-block;">
                    <button class="mbui button labeled icon primary live-sales-notifications-submit ">
                        <i class="icon dashicons dashicons-yes"></i> <?php esc_html_e('Save', 'live-sales-notifications') ?>
                    </button>
                </p>
            </form>
        </div>
    <?php }

    private static function setting_tabs()
    {
        return apply_filters('live_sales_notifications_setting_tabs', array(
            'general' => __('General', 'live-sales-notifications'),
            'design' => __('Design', 'live-sales-notifications'),
            'notifications' => __('Notifications', 'live-sales-notifications'),
            'products' => __('Products', 'live-sales-notifications'),
            'product-detail' => __('Product Details', 'live-sales-notifications'),
            'time' => __('Time', 'live-sales-notifications'),
            //'audio' => __('Audio', 'live-sales-notifications'),
            'assign' => __('Assign', 'live-sales-notifications'),
        ));
    }
}

new Live_Sales_Notifications_Admin_Settings();