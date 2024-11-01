<?php
    global $uipbb_viewer_params;
    extract($uipbb_viewer_params);

    // Get uploaded images for specific image viewer
    $viewer_images_str = get_post_meta( $post->ID , '_uipbb_viewer_images', true );
    $viewer_images = explode(',', $viewer_images_str);

    $upload_dir = wp_upload_dir();
    $upload_dir_url = $upload_dir['baseurl']."/";
?>


<div id="uipbb-viewer-images-panel" >
    <div id="uipbb-viewer-images-panel-upload" ><?php _e('Add Images','uipbb'); ?></div>
    <div id="uipbb-viewer-images-panel-gallery" >
        <?php 

            foreach($viewer_images as $attach_id){
                if($attach_id != ''){
                    $image_icons = "<img class='uipbb-viewer-edit' src='" . UIPBB_PLUGIN_URL ."images/viewer-edit.png' />
                                    <img class='uipbb-viewer-delete' src='" . UIPBB_PLUGIN_URL . "images/viewer-delete.png' />";

                    $attachment = wp_get_attachment_metadata( $attach_id );
        ?>
                    <div class='uipbb-viewer-images-panel-gallery-single'>
                        <img src="<?php echo $upload_dir_url.$attachment['file']; ?>" data-attchement-id='<?php echo $attach_id; ?>' class='uipbb-viewer-preview-thumb' />
                        <div class='uipbb-viewer-images-panel-gallery-icons'><?php echo $image_icons; ?></div>
                    </div>
                
        <?php
                }
            }
        ?>
    </div>
    <input type="hidden" name="uipbb_viewer_uploaded_images" id="uipbb_viewer_uploaded_images" value="<?php echo $viewer_images_str; ?>" />
    <div class='uipbb-clear'></div>
</div>

<?php wp_nonce_field( 'uipbb_image_viewer_settings', 'uipbb_image_viewer_nonce' ); ?>