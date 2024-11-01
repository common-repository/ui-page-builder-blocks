<?php
/*
  Plugin Name: UI Page Builder Blocks
  Plugin URI: http://www.wpexpertdeveloper.com/ui-page-builder-blocks/
  Description: Interactive UI blocks for building the pages of your site. Includes image sliders and image viewers
  Version: 1.0
  Author: Rakhitha Nimesh
  Author URI: http://www.wpexpertdeveloper.com
 */


// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

/* Main Class for Image Slider Made Easy */
if( !class_exists( 'UIPBB_Manager' ) ) {
    
    class UIPBB_Manager{
    
        private static $instance;

        /* Create instances of plugin classes and initializing the features  */
        public static function instance() {
            
            if ( ! isset( self::$instance ) && ! ( self::$instance instanceof UIPBB_Manager ) ) {
                self::$instance = new UIPBB_Manager();
                self::$instance->setup_constants();

                //add_action( 'plugins_loaded', array( self::$instance, 'load_textdomain' ) );
                self::$instance->includes();

                add_action('wp_enqueue_scripts',array(self::$instance,'load_scripts'),9);
                add_action('admin_enqueue_scripts', array(self::$instance,'load_admin_scripts'));
                 
                self::$instance->template_loader    = new UIPBB_Template_Loader();
                self::$instance->image_slider       = new UIPBB_Slider_Manager();
                self::$instance->image_viewer       = new UIPBB_Viewer_Manager();
            }
            return self::$instance;
        }

        /* Setup constants for the plugin */
        private function setup_constants() {
            
            // Plugin version
            if ( ! defined( 'UIPBB_VERSION' ) ) {
                define( 'UIPBB_VERSION', '1.2' );
            }

            // Plugin Folder Path
            if ( ! defined( 'UIPBB_PLUGIN_DIR' ) ) {
                define( 'UIPBB_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
            }

            // Plugin Folder URL
            if ( ! defined( 'UIPBB_PLUGIN_URL' ) ) {
                define( 'UIPBB_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
            }

            if ( ! defined( 'UIPBB_JSSOR_IMAGE_SLIDER_POST_TYPE' ) ) {
                define( 'UIPBB_JSSOR_IMAGE_SLIDER_POST_TYPE', 'uipbb_impr_slider');
            }

            if ( ! defined( 'UIPBB_IMAGE_VIEWER_POST_TYPE' ) ) {
                define( 'UIPBB_IMAGE_VIEWER_POST_TYPE', 'uipbb_image_viewer');
            }
        }

        /* Load scripts and styles for frontend */
        public function load_scripts(){
          
            wp_register_style('uipbb-front-style', UIPBB_PLUGIN_URL . 'css/uipbb-front.css');
            wp_enqueue_style('uipbb-front-style');

            wp_register_script('uipbb-front', UIPBB_PLUGIN_URL.'js/uipbb-front.js', array('jquery'));
           
            wp_register_script('uipbb-jssor-slides-script', UIPBB_PLUGIN_URL.'lib/jssor/jssor.slider.mini.js', array('jquery'));
            
            wp_register_script('uipbb-slider-init', UIPBB_PLUGIN_URL.'js/uipbb-slider-init.js', array('jquery'));
           
        

            wp_register_style('uipbb-viewer-front-style', UIPBB_PLUGIN_URL . 'css/uipbb-viewer-front.css');
            wp_enqueue_style('uipbb-viewer-front-style');

            wp_register_script('uipbb-viewer-front', UIPBB_PLUGIN_URL.'js/uipbb-viewer-front.js', array('jquery'));
            wp_enqueue_script('uipbb-viewer-front');

            wp_register_style('uipbb-image-viewer-style', UIPBB_PLUGIN_URL . 'lib/viewer-master/viewer.css');
            wp_register_script('uipbb-image-viewer-script', UIPBB_PLUGIN_URL.'lib/viewer-master/viewer.js', array('jquery'));


        }

        public function load_admin_scripts(){
            wp_register_script('uipbb-admin', UIPBB_PLUGIN_URL.'js/uipbb-admin.js', array('jquery','media-upload','thickbox'));
            wp_enqueue_script('uipbb-admin');

            $uipbb_admin = array(
                'AdminAjax' => admin_url('admin-ajax.php'),
                'images_path' =>  UIPBB_PLUGIN_URL . 'images/',
                'addToSlider' => __('Add to Slider','uipbb'), 
                'insertToSlider' => __('Insert Images to Slider','uipbb'),      
            );
            wp_localize_script('uipbb-admin', 'UIPBBAdmin', $uipbb_admin);


            wp_register_style('uipbb-admin-style', UIPBB_PLUGIN_URL . 'css/uipbb-admin.css');
            wp_enqueue_style('uipbb-admin-style');



            wp_register_script('uipbb-viewer-admin', UIPBB_PLUGIN_URL.'js/uipbb-viewer-admin.js', array('jquery','media-upload','thickbox'));
            wp_enqueue_script('uipbb-viewer-admin');

            $uipbb_admin = array(
                'AdminAjax' => admin_url('admin-ajax.php'),
                'images_path' =>  UIPBB_PLUGIN_URL . 'images/',
                'addToViewer' => __('Add to Viewer','uipbb'), 
                'insertToViewer' => __('Insert Images to Viewer','uipbb'),      
            );
            wp_localize_script('uipbb-viewer-admin', 'UIPBBAdmin', $uipbb_admin);


            wp_register_style('uipbb-viewer-admin-style', UIPBB_PLUGIN_URL . 'css/uipbb-viewer-admin.css');
            wp_enqueue_style('uipbb-viewer-admin-style');
        }
        
        /* Include class files */
        private function includes() {

            require_once UIPBB_PLUGIN_DIR . 'classes/class-uipbb-template-loader.php';
            require_once UIPBB_PLUGIN_DIR . 'classes/class-uipbb-slider-manager.php';
            require_once UIPBB_PLUGIN_DIR . 'classes/class-uipbb-viewer-manager.php';
            require_once UIPBB_PLUGIN_DIR . 'functions.php';

            if ( is_admin() ) {}
        }
    
    }
}

function UIPBB_Manager() {
    global $uipbb;    
	$uipbb = UIPBB_Manager::instance();
}

UIPBB_Manager();


















