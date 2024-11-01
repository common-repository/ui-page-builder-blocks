<?php

/* Manage features of Image Viewer */
class UIPBB_Viewer_Manager{

	/* Intialize actions and filters required for fields */
	public function __construct(){
		add_action( 'add_meta_boxes', array($this,'image_viewer_meta_box'));

		add_action('init',array($this,'register_image_viewers'));

        add_action( 'save_post', array($this,'save_image_viewers' ));				

        add_filter( 'wp_insert_post_data', array($this,'add_image_viewer'), '99', 2 );

        add_shortcode( 'uipbb_viewer' , array($this,'uipbb_image_viewer'));

        add_filter( 'manage_edit-uipbb_image_viewer_columns', array($this,'edit_uipbb_image_viewer_columns' ) );
        add_action( 'manage_uipbb_image_viewer_posts_custom_column', array($this,'manage_uipbb_image_viewer_columns'), 10, 2 );

        add_action( 'add_meta_boxes', array($this, 'remove_other_meta_boxes'), 999 );

        add_action('admin_menu', array(&$this, 'admin_settings_menu'), 9);
	}

    /* Add Getting started menu */
    public function admin_settings_menu(){
        add_submenu_page( 'edit.php?post_type='.UIPBB_IMAGE_VIEWER_POST_TYPE, __('Getting Started', 'uipbb' ), __('Getting Started', 'uipbb'),'manage_options','uipbb-help',array(&$this,'help'));
    
    }

    /* Add meta boxes for Image Viewer - images, settings and shortcode */
	public function image_viewer_meta_box(){
		add_meta_box(
                    'uipbb-image-viewer-images',
                    __( 'Image Viewer - Manage Images', 'uipbb' ),
                    array($this,'manage_viewer_images'),
                    UIPBB_IMAGE_VIEWER_POST_TYPE
                );

        add_meta_box(
                    'uipbb-image-viewer-settings',
                    __( 'Image Viewer - Manage Settings', 'uipbb' ),
                    array($this,'manage_viewer_settings'),
                    UIPBB_IMAGE_VIEWER_POST_TYPE
                );

        add_meta_box(
                    'uipbb-image-viewer-shortcode',
                    __( 'Image Viewer - Shortcode', 'uipbb' ),
                    array($this,'manage_viewer_shortcode'),
                    UIPBB_IMAGE_VIEWER_POST_TYPE,
                    'side'
                );
	}

    /* Display uploaded images in image viewer meta box */
    public function manage_viewer_images($post){
        global $uipbb,$uipbb_viewer_params;

        wp_enqueue_media();
        wp_enqueue_script('jquery-ui-sortable');

        $uipbb_viewer_params['post'] = $post;

        ob_start();
        $uipbb->template_loader->get_template_part('manage-viewer-images');    
        $display = ob_get_clean();  
        echo $display;
    }

    /* Display settings in image viewer meta box */
    public function manage_viewer_settings($post){
        global $uipbb,$uipbb_viewer_params;

        $uipbb_viewer_params['post'] = $post;

        ob_start();
        $uipbb->template_loader->get_template_part('manage-viewer-settings');    
        $display = ob_get_clean();  
        echo $display;
    }

    /* Display shortcode for image viewer in image viewer meta box */
    public function manage_viewer_shortcode($post){
        if(isset($post->ID)){
            echo "<div class='uipbb-shortcode'>[uipbb_viewer id='". $post->ID ."' ]</div>";
        }
    }

    /* Register new custom post type for image viewers */
	public function register_image_viewers(){

        register_post_type( UIPBB_IMAGE_VIEWER_POST_TYPE,
            array(
                'labels' => array(
                    'name'              => __('Image Viewers','uipbb'),
                    'singular_name'     => __('Image Viewer','uipbb'),
                    'add_new'           => __('Add New','uipbb'),
                    'add_new_item'      => __('Add New Image Viewer','uipbb'),
                    'edit'              => __('Edit','uipbb'),
                    'edit_item'         => __('Edit Image Viewer','uipbb'),
                    'new_item'          => __('New Image Viewer','uipbb'),
                    'view'              => __('View','uipbb'),
                    'view_item'         => __('Preview Image Viewer','uipbb'),
                    'search_items'      => __('Search Image Viewer','uipbb'),
                    'not_found'         => __('No Image Viewer found','uipbb'),
                    'not_found_in_trash' => __('No Image Viewer found in Trash','uipbb'),
                ),

                'public' => true,
                'menu_position' => 100,
                'supports' => array( 'title'),
                'has_archive' => true
            )
        );

	}

    /* Save image viewer images and settings */
    public function save_image_viewers($post_id){


        if ( ! isset( $_POST['uipbb_image_viewer_nonce'] ) ) {
            return;
        }

        if ( ! wp_verify_nonce( $_POST['uipbb_image_viewer_nonce'], 'uipbb_image_viewer_settings' ) ) {
            return;
        }

        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }

        if ( isset( $_POST['post_type'] ) && $_POST['post_type'] == UIPBB_IMAGE_VIEWER_POST_TYPE ) {
            if ( ! current_user_can( 'edit_page', $post_id ) ) {
                return;
            }
        } else {
            if ( ! current_user_can( 'edit_post', $post_id ) ) {
                return;
            }
        }

        $viewer_images = isset( $_POST['uipbb_viewer_uploaded_images'] ) ? $_POST['uipbb_viewer_uploaded_images'] : '';
        $viewer_settings = isset( $_POST['uipbb_viewer_settings'] ) ? $_POST['uipbb_viewer_settings'] : array(); 
        
        update_post_meta( $post_id, '_uipbb_viewer_images', $viewer_images );
        update_post_meta( $post_id, '_uipbb_viewer_settings', $viewer_settings );
    }

    /* Add image viewer shortcode when saving to enable preview */
    public function add_image_viewer($data , $postarr){
        if($data['post_type'] == UIPBB_IMAGE_VIEWER_POST_TYPE && isset($postarr['post_ID'])){
            $post_id = $postarr['post_ID'];
            $data['post_content'] = "[uipbb_viewer id='".$post_id."' ]";
        }
        return $data;
    }

    /* Display image viewer in frontend using the shortcode */
    public function uipbb_image_viewer($attr){
        $post_id =  $attr['id'];


        wp_enqueue_style('uipbb-image-viewer-style');
        wp_enqueue_script('uipbb-image-viewer-script');

        $viewer_images_str = get_post_meta( $post_id , '_uipbb_viewer_images', true );
        $viewer_images = explode(',', $viewer_images_str);

        $upload_dir = wp_upload_dir();
        $upload_dir_url = $upload_dir['baseurl']."/";
        $upload_sub_dir_url = $upload_dir['baseurl'].$upload_dir['subdir']."/";


        $display = "<div id='uipbb-front-viewer-".$post_id."' class='uipbb-front-viewer' >";

        foreach($viewer_images as $attach_id){
                if($attach_id != ''){
                    $image_icons = "<img class='uipbb-viewer-edit' src='" . UIPBB_PLUGIN_URL ."images/viewer-edit.png' />
                                    <img class='uipbb-viewer-delete' src='" . UIPBB_PLUGIN_URL . "images/viewer-delete.png' />";

                    $attachment = wp_get_attachment_metadata( $attach_id );

                    $thumbnail = isset($attachment['sizes']['medium']['file']) ? $upload_sub_dir_url.$attachment['sizes']['medium']['file'] : $upload_dir_url.$attachment['file'];

                    $display .= "<div class='uipbb-front-viewer-single'><img data-original='". $upload_dir_url.$attachment['file'] ."' src='" . $thumbnail . "' ></div>";
     

            }
        }

        $display .= "<div class='uipbb-clear'></div></div>";


        $viewer_settings = (array) get_post_meta( $post_id, '_uipbb_viewer_settings', true );

        $mode = ($viewer_settings['mode'] == 'modal' ) ? 'false' : 'true';
        $navbar = ($viewer_settings['navbar']  == 'enabled' ) ? 'true' : 'false';
        $title = ($viewer_settings['title'] == 'enabled' ) ? 'true' : 'false';
        $toolbar = ($viewer_settings['toolbar'] == 'enabled' ) ? 'true' : 'false';
        $tooltip = ($viewer_settings['tooltip'] == 'enabled' ) ? 'true' : 'false';
        $movable = ($viewer_settings['movable'] == 'enabled' ) ? 'true' : 'false';
        $zooming = ($viewer_settings['zooming'] == 'enabled' ) ? 'true' : 'false';
        $rotating = ($viewer_settings['rotating'] == 'enabled' ) ? 'true' : 'false';
        $scaling = ($viewer_settings['scaling'] == 'enabled' ) ? 'true' : 'false';
        $transition = ($viewer_settings['transition'] == 'enabled' ) ? 'true' : 'false';
        $fullscreen = ($viewer_settings['fullscreen'] == 'enabled' ) ? 'true' : 'false';
        // $custom_css = ($viewer_settings['custom_css'] != '') ? $viewer_settings['custom_css'] : '';

        $display .= "<script type='text/javascript'>
                        jQuery(document).ready( function( $ ) {
                            var options = {
                                url: 'data-original',
                                inline : ".$mode.",
                                navbar : ".$navbar.",
                                title : ".$title.",
                                toolbar : ".$toolbar.",
                                tooltip : ".$tooltip.",
                                movable : ".$movable.",
                                zoomable : ".$zooming.",
                                rotatable : ".$rotating.",
                                scalable : ".$scaling.",
                                transition:".$transition.",
                                fullscreen:".$fullscreen.",
                                
                              };

                            $('#uipbb-front-viewer-".$post_id."').viewer(options);
                        });
                    </script>";
        return $display;
    }
    
    /* Add image viewer shortcode to image viewer list */
    public function edit_uipbb_image_viewer_columns( $columns ) {

        $columns = array(
            'cb' => '<input type="checkbox" />',
            'title' => __( 'Image Viewer','uipbb' ),
            'shortcode' => __( 'Shortcode','uipbb'),
            'date' => __( 'Date','uipbb' )
        );

        return $columns;
    }

    /* Add image viewer shortcode to image viewer list */
    public function manage_uipbb_image_viewer_columns( $column, $post_id ) {
        global $post;

        switch( $column ) {
            case 'shortcode' :
                echo "[uipbb_viewer id='".$post_id."' ]";   
                break;
            default :
                break;
        }
    }

    /* Remove meta boxes generated by other plugins for Image Viewer post type */
    public function remove_other_meta_boxes(){
        global $wp_meta_boxes;

        $allowed_meta_boxes = array('submitdiv','uipbb_image_viewer','uipbb-image-viewer-shortcode','uipbb-image-viewer-images',
            'uipbb-image-viewer-settings','slugdiv');
        foreach ($wp_meta_boxes as $post_type => $meta_box) {
            if($post_type == UIPBB_IMAGE_VIEWER_POST_TYPE){
                foreach ($meta_box as $context => $context_value) {
                    foreach ($context_value as $priority => $priority_value) {
                        foreach ($priority_value as $meta_box_key => $meta_box_settings) {
                            if(!in_array($meta_box_key, $allowed_meta_boxes)){
                                unset($wp_meta_boxes[$post_type][$context][$priority][$meta_box_key]);
                            }
                        }
                    }
                }
            }
        }
    }


}
