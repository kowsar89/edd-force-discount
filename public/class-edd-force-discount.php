<?php

if ( !class_exists('FOA_EDD_Force_Discount' ) ):

class FOA_EDD_Force_Discount {

    private static $instance = null;
    public $plugin_slug = 'edd-force-discount';

    private function __construct() {
        add_action( 'plugins_loaded', array( $this, 'load_textdomain' ) );
        add_action( 'edd_checkout_error_checks', array( $this, 'discount_validation' ) );
    }

    public static function instance() {
        if ( null == self::$instance ) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    // textdomain
    public function load_textdomain(){
        load_plugin_textdomain( 'edd-force-discount', false, $this->plugin_slug. '/languages/' );
    }

    // validate coupon
    public function discount_validation( $data ){
        if ($data['discount'] == 'none' || empty( $data['discount'] ) ) {
            $options = get_option( 'foa_edd_force_discount', '' );
            $errornotice = empty($options['errornotice'])? __( 'Discount code is a required field. Please enter a discount code.', 'edd-force-discount' ): $options['errornotice'];
            edd_set_error( 'efdfoa_error_notice', $errornotice );
        }
    }
}

endif;
