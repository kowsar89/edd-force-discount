<?php
/**
 * Plugin Name: Force Discount for EDD
 * Plugin URI: http://kowsarhossain.com/
 * Description: A lightweight plugin to force the customer to enter a discount code during checkout
 * Version: 1.0.1
 * Author: Md. Kowsar Hossain
 * Author URI: http://kowsarhossain.com
 * Text Domain: edd-force-discount
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 *
 */

if ( ! defined( 'WPINC' ) ) die;

// exit if Easy Digital Downloads not activated
if ( !in_array( 'easy-digital-downloads/easy-digital-downloads.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ){
	return;
}

define('EFDFOA_BASENAME', plugin_basename(__FILE__));

if ( is_admin() ):
	require_once dirname( __FILE__ ) . '/admin/class-settings-api.php';
	require_once dirname( __FILE__ ) . '/admin/class-edd-force-discount-admin.php';
	FOA_EDD_Force_Discount_Admin::instance();
endif;

require_once dirname( __FILE__ ) . '/public/class-edd-force-discount.php';
FOA_EDD_Force_Discount::instance();