<?php

if ( !class_exists('FOA_EDD_Force_Discount_Admin' ) ):

class FOA_EDD_Force_Discount_Admin {
    
    private static $instance = null;
    public $plugin_slug = 'edd-force-discount';
    private $settings_api;

    private function __construct() {

        $this->settings_api = new FOA_EDD_Force_Discount_Settings_API;

        add_action( 'admin_init', array($this, 'admin_init') );
        add_action( 'admin_menu', array($this, 'admin_menu') );

        add_filter('plugin_action_links_'.EFDFOA_BASENAME, array( $this, 'plugin_settings_link' ) ); 
    }

    public static function instance() {
        if ( null == self::$instance ) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    // Settings link for plugin page
    public function plugin_settings_link($links) {
        $settings_link = '<a href="'. esc_url( get_admin_url(null, "edit.php?post_type=download&page=$this->plugin_slug") ) .'">'.__('Settings', 'edd-force-discount').'</a>';
        array_unshift($links, $settings_link);
        return $links;
    }

    public function admin_init() {

        //set the settings
        $this->settings_api->set_sections( $this->get_settings_sections() );
        $this->settings_api->set_fields( $this->get_settings_fields() );

        //initialize settings
        $this->settings_api->admin_init();
    }

    public function admin_menu() {
        add_submenu_page( 'edit.php?post_type=download', 'Force Discount for EDD', 'Force Discount', 'manage_options', $this->plugin_slug, array($this, 'plugin_page') );
    }

    public function get_settings_sections() {
        $sections = array(
            array(
                'id' => 'foa_edd_force_discount',
                'title' => __( 'Force Discount for EDD', 'edd-force-discount' )
            )
        );

        return $sections;
    }

    /**
     * Returns all the settings fields
     *  
     * @return array settings fields
     */
    public function get_settings_fields() {
        $settings_fields = array(
            'foa_edd_force_discount' => array(
                array(
                    'name'    => 'errornotice',
                    'label'   => __( 'Error Notice', 'edd-force-discount' ),
                    'desc'    => __( 'Error notice when no discount code is applied', 'edd-force-discount' ),
                    'type'    => 'textarea',
                    'placeholder'    => __( 'eg. Discount code is a required field. Please enter a discount code.', 'edd-force-discount' ),
                ),
            )
        );

        return $settings_fields;
    }

    public function plugin_page() {
        echo '<div class="wrap">';
        $this->settings_api->show_forms();
        echo '</div>';
    }

    /**
     * Get all the pages
     *
     * @return array page names with key value pairs
     */
    public function get_pages() {
        $pages = get_pages();
        $pages_options = array();
        if ( $pages ) {
            foreach ($pages as $page) {
                $pages_options[$page->ID] = $page->post_title;
            }
        }

        return $pages_options;
    }

}

endif;
