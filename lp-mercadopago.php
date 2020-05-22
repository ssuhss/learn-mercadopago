<?php
/**
 * Plugin Name:          lp mercadopago
 * Plugin URI:           https://github.com/mercadopago/learn
 * Description:          Habilita o payment
 * Version:              1.0.0
 * Author:               Michel
 * Text Domain:          lp-mercadopago
 * Domain Path:          /languages
 * License:              GPL 2.0
 * Requires at least:    4.4
 * Tested up to:         5.5.2
 * Requires PHP:         5.6
 */

namespace LPMP;

/** Composer Autoloader */
require_once plugin_dir_path(__FILE__) . 'vendor/autoload.php';

/** Constants we will use later on */
define('LPMP_BASE_PATH', __DIR__);
define('LPMP_BASE_URL', plugin_dir_url(__FILE__));

// Exit if accessed directly.
defined('ABSPATH') || die();

/**
 *
 */
function notify_learnpress_miss()
{
    $type = 'error';
    $message = sprintf(
        __('The Mercado Pago module needs an active version of %s in order to work!', 'lp-mercadopago'),
        ' <a href="https://wordpress.org/extend/plugins/woocommerce/">LearnPress</a>'
    );
    echo $message;
}

function woocommerce_learnpress_load_plugin_textdomain()
{
    $text_domain = 'lp-mercadopago';
    $locale = apply_filters('plugin_locale', get_locale(), $text_domain);

    $original_language_file = dirname(__FILE__) . '/languages/learnpress-pt_BR.mo';

    // Unload the translation for the text domain of the plugin
    unload_textdomain($text_domain);
    // Load first the override file
    load_textdomain($text_domain, $original_language_file);
}

add_action('plugins_loaded', 'woocommerce_learnpress_load_plugin_textdomain');

function mercadopago_learnpress_init()
{
    if (!class_exists('LearnPress')) {
        add_action('admin_notices', 'notify_learnpress_miss');
    }
    require_once dirname(__FILE__) . '/inc/class-lp-gateway-mercadopago.php';

    //require_once dirname(__FILE__) . '/lp-gateway.php';
    //new LP_MP_Gateway();
}

add_action('plugins_loaded', 'mercadopago_learnpress_init');


