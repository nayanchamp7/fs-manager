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

if ( ! defined( 'FSM_FILE' ) ) {
    define( 'FSM_FILE', __FILE__ );
}

if ( ! defined( 'FSM_PLUGIN_URL' ) ) {
    define( 'FSM_PLUGIN_URL', plugins_url( '', FSM_FILE ) );
}

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

function fs_custom_css() 
{
    ?>
    <style type="text/css">
        @media screen and (max-width: 480px) {
            .single_add_to_cart_button {
                width: calc(100% - 110px) !important;
            } 
        }
    </style>
    <?php
}
add_action('wp_head', 'fs_custom_css');

function fs_add_custom_checkbox_for_bundle_product() 
{
    global $post;
    $product_id = $post->ID;

    //$product = wc_get_product( $product_id );

    $terms = get_the_terms($product_id, 'product_cat');
    $term_slugs = [];
    foreach ($terms as $term) {
        $product_cat = $term->slug;

        array_push($term_slugs, $product_cat);
    } 

    // do this for only bundles category products
    if( !in_array("bundles", $term_slugs)  ) {
        return;
    }

    ?>
    <script>
        (function($) {
            $(document).ready(function() {
                $('.fs-gift-box-checkbox input').on('change', function() {
                    $('#gift_box_message').toggle();
                });
            })
        })(jQuery)
    </script>
    <div class="fs-gift-box-input-wrapper">
        <div class="fs-gift-box-checkbox">
            <input type="checkbox" name="gift_box"> <label for="gift_box">Send this bundle as a gift</label>
        </div>

        <div id="gift_box_message" style="display:none;">
            <textarea name="gift_box_message" maxlength="50" cols="30" rows="5"></textarea>
            <p>To send the product as a gift, please write your message here.</p>
        </div>
    </div>
    <?php
}
add_action('woocommerce_before_add_to_cart_quantity', 'fs_add_custom_checkbox_for_bundle_product');

// Add data to cart item
add_filter( 'woocommerce_add_cart_item_data', 'fs_add_cart_item_data', 25, 2 );
function fs_add_cart_item_data( $cart_item_data, $product_id ) {

    if( isset( $_POST['gift_box_message'] ) ) {
        $cart_item_data['custom_data']['gift_box_message'] = $_POST['gift_box_message'];
    }

    return $cart_item_data;
}

// Add order item meta.
add_action( 'woocommerce_add_order_item_meta', 'fs_add_order_item_meta' , 10, 3 );
function fs_add_order_item_meta ( $item_id, $cart_item, $cart_item_key ) {
    if ( isset( $cart_item[ 'custom_data' ]['gift_box_message'] ) && !empty($cart_item[ 'custom_data' ]['gift_box_message']) ) {
        $message = $cart_item[ 'custom_data' ]['gift_box_message'];
        wc_add_order_item_meta( $item_id, __( "Message"), $message );
    }
}

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

/**
 * Add Suffix to price
 */
add_filter( 'woocommerce_get_price_suffix', 'fs_add_price_suffix', 99, 4 );
function fs_add_price_suffix( $html, $product, $price, $qty ){
    if( !is_product() ) {
        return;
    } 

    $html .= ' <img src="'. FSM_PLUGIN_URL . "/assets/images/vip-user.png" .'" alt="VIP User" />';
    return $html;
}



