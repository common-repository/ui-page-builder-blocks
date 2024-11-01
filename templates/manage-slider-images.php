<?php
    global $uipbb_slider_params;
    extract($uipbb_slider_params);

    // Get uploaded images for specific image slider
    $slider_images_str = get_post_meta( $post->ID , '_uipbb_slider_images', true );
    $slider_images = explode(',', $slider_images_str);

    $upload_dir = wp_upload_dir();
    $upload_dir_url = $upload_dir['baseurl']."/";
?>


<div id="uipbb-slider-images-panel" >
    <div id="uipbb-slider-images-panel-upload" ><?php _e('Add Images','uipbb'); ?></div>
    <div id="uipbb-slider-images-panel-gallery" >
        <?php 

            foreach($slider_images as $attach_id){
                if($attach_id != ''){
                    $image_icons = "<img class='uipbb-slider-edit' src='" . UIPBB_PLUGIN_URL ."images/slider-edit.png' />
                                    <img class='uipbb-slider-delete' src='" . UIPBB_PLUGIN_URL . "images/slider-delete.png' />";

                    $attachment = wp_get_attachment_metadata( $attach_id );
        ?>
                    <div class='uipbb-slider-images-panel-gallery-single'>
                        <img src="<?php echo $upload_dir_url.$attachment['file']; ?>" data-attchement-id='<?php echo $attach_id; ?>' class='uipbb-slider-preview-thumb' />
                        <div class='uipbb-slider-images-panel-gallery-icons'><?php echo $image_icons; ?></div>
                    </div>
                
        <?php
                }
            }
        ?>
    </div>
    <input type="hidden" name="uipbb_slider_uploaded_images" id="uipbb_slider_uploaded_images" value="<?php echo $slider_images_str; ?>" />
    <div class='uipbb-clear'></div>
</div>

<?php wp_nonce_field( 'uipbb_image_slider_settings', 'uipbb_image_slider_nonce' ); ?>