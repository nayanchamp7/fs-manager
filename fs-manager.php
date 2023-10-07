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

