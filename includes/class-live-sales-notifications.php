<?php
if (!defined('ABSPATH')) {
    exit;
}

final class Live_Sales_Notifications
{

    /**
     * Plugin version.
     *
     * @var string
     */
    public $version = LIVE_SALES_NOTIFICATIONS_VERSION;

    /**
     * Theme single instance of this class.
     *
     * @var object
     */
    protected static $_instance = null;

    /**
     * Return an instance of this class.
     *
     * @return object A single instance of this class.
     */
    public static function instance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }


    public $store_type = '';


    public $options = array();


    public $storewise_options = array();


    public $compatibility;

    /**
     * Cloning is forbidden.
     *
     * @since 1.0.0
     */
    public function __clone()
    {
        _doing_it_wrong(__FUNCTION__, esc_html__('Cheatin&#8217; huh?', 'live-sales-notifications'), '1.0.0');
    }

    /**
     * Unserializing instances of this class is forbidden.
     *
     * @since 1.0.0
     */
    public function __wakeup()
    {
        _doing_it_wrong(__FUNCTION__, esc_html__('Cheatin&#8217; huh?', 'live-sales-notifications'), '1.0.0');
    }

    /**
     * Initialize the plugin.
     */
    private function __construct()
    {
        $this->define_constants();
        $this->init_hooks();

        do_action('live_sales_notifications_loaded');
    }

    /**
     * Define Constants.
     */
    private function define_constants()
    {

        $this->define('LIVE_SALES_NOTIFICATIONS_ABSPATH', dirname(LIVE_SALES_NOTIFICATIONS_PLUGIN_FILE) . '/');
        $this->define('LIVE_SALES_NOTIFICATIONS_PLUGIN_BASENAME', plugin_basename(LIVE_SALES_NOTIFICATIONS_PLUGIN_FILE));
        $this->define('LIVE_SALES_NOTIFICATIONS_URI', trailingslashit(plugin_dir_url(LIVE_SALES_NOTIFICATIONS_PLUGIN_FILE)));
        $this->define('LIVE_SALES_NOTIFICATIONS_DIR', trailingslashit(plugin_dir_path(LIVE_SALES_NOTIFICATIONS_PLUGIN_FILE)));


    }

    /**
     * Define constant if not already set.
     *
     * @param string $name Constant name.
     * @param string|bool $value Constant value.
     */
    private function define($name, $value)
    {
        if (!defined($name)) {
            define($name, $value);
        }
    }

    /**
     * Hook into actions and filters.
     */
    private function init_hooks()
    {
        // Load plugin text domain.
        add_action('init', array($this, 'load_plugin_textdomain'));
        add_action('init', array($this, 'load_options'), 11);


        // Register activation hook.
        register_activation_hook(LIVE_SALES_NOTIFICATIONS_PLUGIN_FILE, array($this, 'install'));

        $this->includes();

    }

    public function load_options($is_force = false)
    {
        if (!$this->options instanceof Live_Sales_Notifications_Options || $is_force) {

            $this->options = new Live_Sales_Notifications_Options();
        }

        $this->store_type = $this->options->get_store_type();

        $this->storewise_options = $this->options->get_storewise_options();

    }

    /**
     * Include required core files.
     */
    private function includes()
    {
        include_once LIVE_SALES_NOTIFICATIONS_ABSPATH . 'includes/class-live-sales-notifications-autoloader.php';

        include_once LIVE_SALES_NOTIFICATIONS_ABSPATH . 'includes/abstracts/abstract-live-sales-notifications-compatibility.php';

        include_once LIVE_SALES_NOTIFICATIONS_ABSPATH . 'includes/functions.php';


        if ($this->is_request('admin')) {
            include_once LIVE_SALES_NOTIFICATIONS_ABSPATH . 'includes/admin/class-live-sales-notifications-admin.php';
        }

        if ($this->is_request('frontend')) {
            $this->frontend_includes();
        }
    }

    /**
     * What type of request is this?
     *
     * @param  string $type admin, ajax, cron or frontend.
     * @return bool
     */
    private function is_request($type)
    {
        switch ($type) {
            case 'admin':
                return is_admin();
            case 'ajax':
                return defined('DOING_AJAX');
            case 'cron':
                return defined('DOING_CRON');
            case 'frontend':
                return (!is_admin() || defined('DOING_AJAX')) && !defined('DOING_CRON') && !defined('REST_REQUEST');
        }
    }

    public function frontend_includes()
    {
        include_once LIVE_SALES_NOTIFICATIONS_ABSPATH . 'includes/frontend/class-live-sales-notifications-notify.php';

    }

    /**
     * Install
     */
    public function install()
    {

        // Bypass if filesystem is read-only and/or non-standard upload system is used.
        if (!is_blog_installed() || apply_filters('live_sales_notifications_install_skip_create_files', false)) {
            return;
        }

        flush_rewrite_rules();
    }

    /**
     * Load Localisation files.
     *
     * Note: the first-loaded translation file overrides any following ones if the same translation is present.
     *
     * Locales found in:
     *      - WP_LANG_DIR/live-sales-notifications/live-sales-notifications-LOCALE.mo
     *      - WP_LANG_DIR/plugins/live-sales-notifications-LOCALE.mo
     */
    public function load_plugin_textdomain()
    {
        $locale = is_admin() && function_exists('get_user_locale') ? get_user_locale() : get_locale();
        $locale = apply_filters('plugin_locale', $locale, 'live-sales-notifications');
        unload_textdomain('live-sales-notifications');
        load_textdomain('live-sales-notifications', WP_LANG_DIR . '/live-sales-notifications/live-sales-notifications-' . $locale . '.mo');
        load_plugin_textdomain('live-sales-notifications', false, plugin_basename(dirname(LIVE_SALES_NOTIFICATIONS_PLUGIN_FILE)) . '/languages');
    }

    /**
     * Get the plugin url.
     *
     * @return string
     */
    public function plugin_url()
    {
        return untrailingslashit(plugins_url('/', LIVE_SALES_NOTIFICATIONS_PLUGIN_FILE));
    }

    /**
     * Get the plugin path.
     *
     * @return string
     */
    public function plugin_path()
    {
        return untrailingslashit(plugin_dir_path(LIVE_SALES_NOTIFICATIONS_PLUGIN_FILE));
    }

    /**
     * Display row meta in the Plugins list table.
     *
     * @param  array $plugin_meta Plugin Row Meta.
     * @param  string $plugin_file Plugin Row Meta.
     * @return array
     */
    public function plugin_row_meta($plugin_meta, $plugin_file)
    {
        if (LIVE_SALES_NOTIFICATIONS_PLUGIN_BASENAME === $plugin_file) {
            $new_plugin_meta = array(
                'docs' => '<a href="' . esc_url(apply_filters('live_sales_notifications_docs_url', 'https://mantrabrain.com/docs/live-sales-notifications/')) . '" title="' . esc_attr(__('View Live Sales Notification Documentation', 'live-sales-notifications')) . '">' . __('Docs', 'live-sales-notifications') . '</a>',
                'support' => '<a href="' . esc_url(apply_filters('live_sales_notifications_support_url', 'https://mantrabrain.com/support-forum/')) . '" title="' . esc_attr(__('Visit Free Customer Support Forum', 'live-sales-notifications')) . '">' . __('Free Support', 'live-sales-notifications') . '</a>',
            );

            return array_merge($plugin_meta, $new_plugin_meta);
        }

        return (array)$plugin_meta;
    }

    public function compatibility($key = '')
    {
        if (empty($key)) {
            $key = $this->store_type;
        }

        if (empty($key)) {
            new Exception("Something wrong, please try again");
        }
        $class = '';

        switch ($key) {
            case "edd":
                $class = "Live_Sales_Notifications_Compatibility_EDD";
                break;
            case "woocommerce":
                $class = "Live_Sales_Notifications_Compatibility_WooCommerce";
                break;
            default:
                new Exception("Wrong compatibility");
                break;
        }
        if (empty($class)) {
            throw new Exception("Wrong compatibility, please check your code");
        }
        if (empty($this->compatibility)) {
            $this->compatibility = new $class;
            return $this->compatibility;
        } else if (!$this->compatibility instanceof $class) {
            $this->compatibility = new $class;
            return $this->compatibility;
        }
        return $this->compatibility;
    }

}
