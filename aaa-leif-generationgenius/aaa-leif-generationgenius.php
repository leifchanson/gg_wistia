<?php
 
/**
 
 * @package AAA-Leif-GenerationGenius
 
 */
 
/*
 
Plugin Name: AAA-Leif-GenerationGenius
 
Plugin URI: https://www.generationgenius.com
 
Description: Generation Genius Programming Test; GeniusWistia.
 
Version: 1.0.67
 
Author: Leif Hanson for Generation Genius, Inc.
 
Author URI: http://leifhanson.info
 
License: GPLv2 or later
 
Text Domain: aaa-leif-generationgenius
 
*/



class GenerationGenius {

    // Constructor.
    public function __construct() {

        //add_action( 'admin_init', 'wpse_136058_debug_admin_menu' );
        //function wpse_136058_debug_admin_menu() {
        //  echo '<pre>' . print_r( $GLOBALS[ 'menu' ], TRUE) . '</pre>';
        //}

        // Set WordPress Plugin folder URL agnostic to wp prefix.
        $main_domain = $_SERVER['SERVER_NAME'];
        if($main_domain == 'generationgenius.com' || $main_domain == 'www.generationgenius.com') {
            define( 'GG_PLUGIN_PATH', '/wp-content/plugins/aaa-leif-generationgenius/' );
        }
        else if($main_domain == 'leifhanson.info' || $main_domain == 'www.leifhanson.info') {
            define( 'GG_PLUGIN_PATH', '/wp-content/plugins/aaa-leif-generationgenius/' );
        }
        else {
            define( 'GG_PLUGIN_PATH', str_replace('~/leifhanson/Sites/localhost/gg-wistia/wp-content/plugins/aaa-leif-generationgenius/', '', plugin_dir_path( __FILE__ ) ) );
        }

        // Add Admin Menu Item.
        add_action('admin_menu', [$this, 'gg_setup_admin_menu']);

        // Add styles.
        add_action('admin_head', [$this, 'gg_setup_styles']);

        // Add activate and deactivate hooks.
        register_activation_hook(__FILE__, array( $this, 'gg_activate'));
        register_deactivation_hook( __FILE__, array( $this, 'gg_deactivate' ) );

        // Enqueue Front End Scripts.
        function lh_enqueue_scripts()
        {   
            if(is_page('wistia-video-page')) {

                wp_enqueue_script( 'wistia_api', 'https://fast.wistia.com/assets/external/E-v1.js', array('jquery'), '3.3.5', false );
                wp_enqueue_script( 'my_custom_script', plugin_dir_url( __FILE__ ) . 'js/gg_scripts.js', array('jquery'), '3.3.5', true );

                wp_enqueue_style( 'wistia_styles', plugin_dir_url( __FILE__ ) . 'css/styles.css' );
            }
        }
        add_action('wp_enqueue_scripts', 'lh_enqueue_scripts');
        
        // Successful Activation message.
        register_activation_hook( __FILE__, 'gg_admin_notice_example_activation_hook' );

        function gg_admin_notice_example_activation_hook() {
            set_transient( 'gg-admin-notice-example', true, 5 );
        }

        add_action( 'admin_notices', 'gg_admin_notice_example_notice' );

        function gg_admin_notice_example_notice(){

            /* Check transient, if available display notice */
            if( get_transient( 'gg-admin-notice-example' ) ){
                ?>
                <div class="updated notice is-dismissible">
                    <p>Wistia Plugin Activated. <a href="/wistia-video-page" target="_blank">Click here to View the Video Page</a></p>
                </div>
                <?php
                /* Delete transient, only display this notice once. */
                delete_transient( 'fx-admin-notice-example' );
            }
        }

        // Check if user is logged in.
        function ajax_check_user_logged_in() {
            echo is_user_logged_in()?'yes':'no';
            die();
        }
        add_action('wp_ajax_is_user_logged_in', 'ajax_check_user_logged_in');
        add_action('wp_ajax_nopriv_is_user_logged_in', 'ajax_check_user_logged_in');

        // Post Content Include
        function add_specific_page_file() {
            if(is_page('wistia-video-page')) {
                include './lh-post-content.php';
            }
        } 
        add_action( 'init', 'add_specific_page_file' );

    }

    // Database Activation hook.
    public function gg_activate() {

        // Build the Video Page element here?

        // Create Wistia Video Page post object
        $my_post = array(
            'post_title'    => wp_strip_all_tags( 'Wistia Video Page' ),
            'post_content'  => 'Wistia Video Player Example Page. Auto-Generated upon Plugin Activation<br><br><div class="wistia_embed wistia_async_bcqogyv52u" style="width:640px;height:360px;" id="wistia_vid"></div>',
            'post_status'   => 'publish',
            'post_type'     => 'page',
            'wp_error'      => true
        );

        // Insert the post into the database
        wp_insert_post( $my_post, true );

        // Get the page object for use now.
        $page = get_page_by_title('Wistia Video Page' );

        // Redirect to the page upon activation.
        //exit( wp_redirect( $page->post_name ) );
        // To-do: Figure out how to redirect from the Activation without interrupting the activation?

    }

    // Database Deactivation hook.
    public function gg_deactivate() {

        $page = get_page_by_title('Wistia Video Page' );
        wp_delete_post( $page->ID, true );

    }

    function get_post_by_title($page_title, $output = OBJECT) {
        global $wpdb;
            $post = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_title = %s AND post_type='post'", $page_title ));
            if ( $post )
                return get_post($post, $output);
    
        return null;
    }

    // Admin Admin Menu Item.
    /* function cm_setup_admin_menu() {

        add_menu_page( 'GeniusHare', 'GeniusHare', 'manage_options', 'aaa-leif-generationgenius/admin/gg-admin.php', '', 'dashicons-carrot', 100 );
        
    } */

    // Styles
    function cm_setup_styles() {

        global $wpdb;

        echo '<style>
            @font-face {
                font-family: "GlossAndBloom";
                src: url(' . CM_PLUGIN_PATH . '/styles/Gloss_And_Bloom.ttf) format("truetype");
            }
            @font-face {
                font-family: "Papyrus";
                src: url(' . CM_PLUGIN_PATH . '/styles/papyrus.ttf) format("truetype");
            }
            

        </style>';

    }
    

  }
  
  new GenerationGenius();