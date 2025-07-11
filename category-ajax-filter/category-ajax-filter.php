<?php
/*
Plugin Name: Category Ajax Filter
Description: Filter posts/custom post types by category without page reload.Easy to sort/filter and display posts on page with Ajax. It Supports Divi, Elementor and other page builders.
Version: 2.8.4
Author: Trusty Plugins
Author URI: https://trustyplugins.com
License: GPL3
License URI: https://www.gnu.org/licenses/gpl-3.0.html
Text Domain: category-ajax-filter
Domain Path: /languages
 */
// Block direct access to the main plugin file.
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
/*---- CONFIGURATION >>>> DEFINE CURRENT VERSION ----*/
if (!defined('CAF_CURRENT_VERSION')) {
    define('CAF_CURRENT_VERSION', '2.8.4');
}
if (!defined('CAF_OPTIONS')) {
    define('CAF_OPTIONS', 'Category Ajax Filter');
}
if (!defined('TC_CAF_PATH')) {
    define('TC_CAF_PATH', plugin_dir_path(__FILE__));
}
class TC_CAF_Plugin
{
    public function __construct()
    {
        add_action('plugins_loaded', array($this, 'tc_caf_load_plugin_textdomain'));
        $this->tc_caf_plugin_constants();
        //require_once TC_CAF_PATH . 'admin/admin.php';
        if (CAF_CURRENT_VERSION >= 2.6) {
            require_once(ABSPATH . 'wp-admin/includes/plugin.php');

            if (!defined('TC_CAF_PRO_PLUGIN_VERSION')) {
                if (is_plugin_active('category-ajax-filter-pro/caf-pro.php')) {
                    $caf_pr = new TC_CAF_PRO();
                    $caf_pr->tc_caf_plugin_constants();
                    if (TC_CAF_PRO_PLUGIN_VERSION < 8.6) {
                        add_action('admin_notices', array($this, 'tc_caf_pro_version_admin_error_notice'));
                        deactivate_plugins('category-ajax-filter-pro/caf-pro.php');
                    } else if (TC_CAF_PRO_PLUGIN_VERSION >= 8.8) {
                        //echo "3";
                        //do nothing
                        return;
                    } else {
                        // echo "1";
                        require_once TC_CAF_PATH . 'admin/admin.php';
                    }
                } else {
                    // echo "2";
                    require_once TC_CAF_PATH . 'admin/admin.php';
                }
            } else {
                $caf_pr = new TC_CAF_PRO();
                $caf_pr->tc_caf_plugin_constants();
                if (TC_CAF_PRO_PLUGIN_VERSION >= 8.8) {
                    //echo "4";
                    // do nothing
                } else {
                    require_once TC_CAF_PATH . 'admin/admin.php';
                }
            }
        } else {
            // echo "5";
            require_once TC_CAF_PATH . 'admin/admin.php';
        }
        /*---- UPDATE THE CURRENT ACTIVE VERSION OF THE PLUGIN ----*/
        if (!get_option('tc_caf_plugin_version')) {
            update_option('tc_caf_plugin_version', TC_CAF_PLUGIN_VERSION);
        }
    }
    public function tc_caf_pro_version_admin_error_notice()
    {
        /* translators: %1$s is replaced with "string" */
        $message = sprintf(esc_html__('The %1$sCategory Ajax Filter PRO %2$s should be updated atleast to %1$s8.6%2$s to run properly. Please update %1$s PRO Version%2$s now or download latest version from official website.', 'category-ajax-filter'), '<strong>', '</strong>');
        printf('<div class="notice notice-error"><p>%1$s</p></div>', wp_kses_post($message));
    }
    /*---- LOAD PLUGIN TEXTDOMAIN ----*/
    public function tc_caf_load_plugin_textdomain()
    {
        load_plugin_textdomain('category-ajax-filter', false, dirname(plugin_basename(__FILE__)) . '/languages/');
    }
    /*---- set plugin constants ----*/
    public function tc_caf_plugin_constants()
    {
        if (!defined('TC_CAF_URL')) {
            define('TC_CAF_URL', plugin_dir_url(__FILE__));
        }
        if (!defined('TC_CAF_PATH')) {
            define('TC_CAF_PATH', plugin_dir_path(__FILE__));
        }
        if (!defined('TC_CAF_PLUGIN_VERSION')) {
            define('TC_CAF_PLUGIN_VERSION', '2.8.4');
        }
    }
}
// Instantiate the plugin class.
$tc_caf_plugin = new TC_CAF_Plugin();
register_activation_hook(__FILE__, 'tc_caf_activate');
register_deactivation_hook(__FILE__, 'tc_caf_deactivate');
function tc_caf_activate()
{
}
function tc_caf_deactivate()
{
}
