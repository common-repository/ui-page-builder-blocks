<?php
	global $uipbb,$uipbb_slider_params;
	extract($uipbb_slider_params);

    $slider_inner_height = $slider_height;
    if($thumbnail_gallery_design == 'outside'){
        $slider_inner_height = $slider_height - 100;
    }

?>

<div id='uipbb-slider-container-<?php echo $post_id; ?>' class='uipbb-slider-active jssor_slider_outer_container' style='position: relative; top: 0px; left: 0px; width:<?php echo $slider_width; ?>px;height:<?php echo $slider_height; ?>px;' >
        
    <div u='slides' class='jssor_slider_slides' style='width:<?php echo $slider_width; ?>px;height:<?php echo $slider_inner_height; ?>px;cursor:default;overflow:hidden;' >
        <?php foreach($slider_images as $attach_id){
                if($attach_id != ''){
                    $attachment = wp_get_attachment_metadata( $attach_id );
                    $upload_dir = wp_upload_dir();
                    
                    $thumbnail = wp_get_attachment_thumb_url( $attach_id );
                    //echo "<pre>";print_r($url);exit;
        ?>
                    <div class='uipbb-front-slider-single'>
                        <img data-u='image' src='<?php echo $upload_dir_url.$attachment['file']; ?>' alt='<?php echo $attachment['image_meta']['title']; ?>' >
                        <div data-u="thumb">
                            <img  src="<?php echo $thumbnail; ?>" />
                        </div>
                    </div>
     
        <?php
            }
        }
        ?>
    </div>


	<?php if($show_arrows == 'enabled'){ ?>
        <span u='arrowleft' class='jssor<?php echo $arrow_type; ?>l' style='top: <?php echo  (int) ($slider_height/2); ?>px; left: 8px;'></span>        
        <span u='arrowright' class='jssor<?php echo $arrow_type; ?>r' style='top: <?php echo  (int) ($slider_height/2); ?>px; right: 8px;'></span>
	<?php } ?>


    <!-- Thumbnail Navigator -->
    <div data-u="thumbnavigator" class="jssort16" style="position:absolute;left:0px;bottom:0px;width:<?php echo $slider_width; ?>px;height:100px;<?php echo 'background-color:'.$thumbnail_back_color; ?>" data-autocenter="1">
        <!-- Thumbnail Item Skin Begin -->
        <div data-u="slides" style="cursor: default;">
                <div data-u="prototype" class="p">
                    <div data-u="thumbnailtemplate" class="t"></div>
                </div>
            </div>
        <!-- Thumbnail Item Skin End -->
    </div>


</div>