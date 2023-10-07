<?php
/**
 * FS Manager
 *
 * Plugin Name:  FS Manager
 * Description:  The plugin to manager extra other features of the website.
 * Version:      1.0.0
 * Plugin URI:   https://api.whatsapp.com/send?phone=8801676029828
 * Author:       Nazrul Islam Nayan
 * Author URI:   https://api.whatsapp.com/send?phone=8801676029828
 * Text Domain:  fs-manager
 * Domain Path:  /languages/
 * Requires PHP: 7.4
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( !defined( 'ABSPATH' ) ) exit;

function fs_custom_login_css() 
{
    ?>
    <style type="text/css">
        .login label {
            display: inline-block !important;
        }
    </style>
    <?php
}
add_action('login_head', 'fs_custom_login_css');

function fs_filter_backtoblog_link($html_link) 
{
    $html_link = sprintf(
        '<a href="%s">%s</a>',
        esc_url( 'https://carmount.com/shop/become-vip/' ),
        sprintf(
            /* translators: %s: Site title. */
            _x( 'BECOME A VIP →', 'site' ),
        )
    );

    return $html_link;
}
add_filter('login_site_html_link', 'fs_filter_backtoblog_link');

