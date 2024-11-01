<?php
    global $uipbb_slider_params;
    extract($uipbb_slider_params);

    $slider_settings = get_post_meta( $post->ID , '_uipbb_slider_settings', true );


    $upload_dir = wp_upload_dir();
    $upload_dir_url = $upload_dir['baseurl']."/";

    // Get the image slider specific settings from database 
    $slider_settings = (array) get_post_meta( $post->ID, '_uipbb_slider_settings', true );

    $slider_width = isset($slider_settings['slider_width']) ? $slider_settings['slider_width'] : '600';
    $slider_height = isset($slider_settings['slider_height']) ? $slider_settings['slider_height'] : '300';
    
    $transition = isset($slider_settings['transition']) ? $slider_settings['transition'] : 'fade';
    $auto_play = isset($slider_settings['auto_play']) ? $slider_settings['auto_play'] : 'enabled';

    $show_arrows = isset($slider_settings['show_arrows']) ? $slider_settings['show_arrows'] : 'enabled';
    $arrow_type  = isset($slider_settings['arrow_type']) ? $slider_settings['arrow_type'] : 'a01';
    //$custom_css = isset($slider_settings['custom_css']) ? $slider_settings['custom_css'] : '';

    $slider_type  = isset($slider_settings['slider_type']) ? $slider_settings['slider_type'] : 'image_slider';

    $transitions = uipbb_transitions();

    $number_of_slides  = isset($slider_settings['number_of_slides']) ? $slider_settings['number_of_slides'] : '3';
    $slide_width  = isset($slider_settings['slide_width']) ? $slider_settings['slide_width'] : '200';
    $autoplay_interval  = isset($slider_settings['autoplay_interval']) ? $slider_settings['autoplay_interval'] : '1';
    $autoplay_steps  = isset($slider_settings['autoplay_steps']) ? $slider_settings['autoplay_steps'] : '4';

    $thumbnail_visibility  = isset($slider_settings['thumbnail_visibility']) ? $slider_settings['thumbnail_visibility'] : '2';
    $thumbnail_gallery_design  = isset($slider_settings['thumbnail_gallery_design']) ? $slider_settings['thumbnail_gallery_design'] : 'inside';
    $thumbnail_back_color  = isset($slider_settings['thumbnail_back_color']) ? $slider_settings['thumbnail_back_color'] : '';
    
?>

<div id="uipbb-slider-settings-panel" >
    
    <div class="uipbb-slider-settings-row" >
        <div class="uipbb-slider-settings-column" >
            <div class="uipbb-slider-settings-label" ><?php _e('Slider Type','uipbb'); ?></div>
            <div class="uipbb-slider-settings-field" >
                <select name="uipbb_slider_settings[slider_type]" id="uipbb_slider_settings_slider_type" >
                    <option <?php selected('image_slider', $slider_type); ?> value="image_slider"><?php _e('Image Slider','uipbb'); ?></option>
                    <option <?php selected('thumbnail_slider', $slider_type); ?> value="thumbnail_slider"><?php _e('Logo/Thumbnail Slider','uipbb'); ?></option>
                    <option <?php selected('vertical_image_slider', $slider_type); ?> value="vertical_image_slider"><?php _e('Vertical Image Slider','uipbb'); ?></option>
                    <option <?php selected('image_gallery', $slider_type); ?> value="image_gallery"><?php _e('Image Gallery','uipbb'); ?></option>
                    <option <?php selected('tab_slider', $slider_type); ?> value="tab_slider"><?php _e('Tab Slider','uipbb'); ?></option>
                
                </select>

            </div>
        </div>
        
        <div class='uipbb-clear'></div>        
    </div>

    <div class="uipbb-slider-settings-row" >
        <div class="uipbb-slider-settings-column" >
            <div class="uipbb-slider-settings-label" ><?php _e('Slider Width','uipbb'); ?></div>
            <div class="uipbb-slider-settings-field" >
                <input type="text" name="uipbb_slider_settings[slider_width]" id="uipbb_slider_settings_slider_width" value="<?php echo $slider_width; ?>" />
                
            </div>
        </div>
        <div class="uipbb-slider-settings-column" >
            <div class="uipbb-slider-settings-label" ><?php _e('Slider Height','uipbb'); ?></div>
            <div class="uipbb-slider-settings-field" >
                <input type="text" name="uipbb_slider_settings[slider_height]" id="uipbb_slider_settings_slider_height" value="<?php echo $slider_height; ?>" />
                
            </div>
        </div>
        <div class='uipbb-clear'></div>        
    </div>

    <div class="uipbb-slider-settings-row" >
        <div class="uipbb-slider-settings-column" >
            <div class="uipbb-slider-settings-label" ><?php _e('Autoplay Transition','uipbb'); ?></div>
            <div class="uipbb-slider-settings-field" >
                <select name="uipbb_slider_settings[transition]" id="uipbb_slider_settings_transition" >
                    <?php foreach ($transitions as $transition_key => $transition_value) { ?>
                        <option <?php selected($transition_key, $transition); ?> value="<?php echo $transition_key; ?>"><?php echo $transition_value; ?></option>
                        
                    <?php } ?>
                    
                </select>
            </div>
        </div>
        <div class="uipbb-slider-settings-column" >
            <div class="uipbb-slider-settings-label" ><?php _e('Auto Play','uipbb'); ?></div>
            <div class="uipbb-slider-settings-field" >
                <select name="uipbb_slider_settings[auto_play]" id="uipbb_slider_settings_auto_play" >
                    <option <?php selected('enabled', $auto_play); ?> value="enabled"><?php _e('Enabled','uipbb'); ?></option>
                    <option <?php selected('disabled', $auto_play); ?> value="disabled"><?php _e('Disabled','uipbb'); ?></option>
                </select>
            </div>
        </div>
        <div class='uipbb-clear'></div>        
    </div>

    <div class="uipbb-slider-settings-row" >
        
        <div class="uipbb-slider-settings-column" >
            <div class="uipbb-slider-settings-label" ><?php _e('Navigarion Arrows','uipbb'); ?></div>
            <div class="uipbb-slider-settings-field" >
                <select name="uipbb_slider_settings[show_arrows]" id="uipbb_slider_settings_show_arrows" >
                    <option <?php selected('enabled', $show_arrows); ?> value="enabled"><?php _e('Enabled','uipbb'); ?></option>
                    <option <?php selected('disabled', $show_arrows); ?> value="disabled"><?php _e('Disabled','uipbb'); ?></option>
                </select>
            </div>
        </div>
        <div class="uipbb-slider-settings-column" >
            <div class="uipbb-slider-settings-label" ><?php _e('Arrow Type','uipbb'); ?></div>
            <div class="uipbb-slider-settings-field" >
                <select name="uipbb_slider_settings[arrow_type]" id="uipbb_slider_settings_arrow_type" >
                    <option <?php selected('a01', $arrow_type); ?> value="a01"><?php _e('Design 1','uipbb'); ?></option>
                    <option <?php selected('a02', $arrow_type); ?> value="a02"><?php _e('Design 2','uipbb'); ?></option>
                    <option <?php selected('a03', $arrow_type); ?> value="a03"><?php _e('Design 3','uipbb'); ?></option>
                    <option <?php selected('a08', $arrow_type); ?> value="a08"><?php _e('Design 4','uipbb'); ?></option>
                    <option <?php selected('a09', $arrow_type); ?> value="a09"><?php _e('Design 5','uipbb'); ?></option>
                </select>
            </div>
        </div>
        <div class='uipbb-clear'></div>        
    </div>

    

    <!-- Settings for Logo/Thumbnail Slider -->
    <?php
        $thumbnail_slider_visibility =  "display:none;";
        if($slider_type == 'thumbnail_slider'){
            $thumbnail_slider_visibility =  "display:block;";
        }
    ?>
    <div id="uipbb-thumbnail-slider" style="<?php echo $thumbnail_slider_visibility; ?> " >
        <div class="uipbb-settings-title"><h3><?php echo __('Logo/Thumbnail Slider Settings','uipbb'); ?></h3></div>
        <div class="uipbb-slider-settings-row" >
            <div class="uipbb-slider-settings-column" >
                <div class="uipbb-slider-settings-label" ><?php _e('Autoplay Steps','uipbb'); ?></div>
                <div class="uipbb-slider-settings-field" >
                    <input type="text" name="uipbb_slider_settings[autoplay_steps]" id="uipbb_slider_settings_autoplay_steps" value="<?php echo $autoplay_steps; ?>" />
                    
                </div>
            </div>
            <div class="uipbb-slider-settings-column" >
                <div class="uipbb-slider-settings-label" ><?php _e('Autoplay Interval','uipbb'); ?></div>
                <div class="uipbb-slider-settings-field" >
                    <input type="text" name="uipbb_slider_settings[autoplay_interval]" id="uipbb_slider_settings_autoplay_interval" value="<?php echo $autoplay_interval; ?>" />
                    
                </div>
            </div>
            <div class='uipbb-clear'></div>        
        </div>

        <div class="uipbb-slider-settings-row" >
            <div class="uipbb-slider-settings-column" >
                <div class="uipbb-slider-settings-label" ><?php _e('Slide Width','uipbb'); ?></div>
                <div class="uipbb-slider-settings-field" >
                    <input type="text" name="uipbb_slider_settings[slide_width]" id="uipbb_slider_settings_slide_width" value="<?php echo $slide_width; ?>" />
                    
                </div>
            </div>
            <div class="uipbb-slider-settings-column" >
                <div class="uipbb-slider-settings-label" ><?php _e('Number of Slides','uipbb'); ?></div>
                <div class="uipbb-slider-settings-field" >
                    <input type="text" name="uipbb_slider_settings[number_of_slides]" id="uipbb_slider_settings_number_of_slides" value="<?php echo $number_of_slides; ?>" />
                    
                </div>
            </div>
            <div class='uipbb-clear'></div>        
        </div>
    </div>

    <!-- Settings for Image Gallery -->
    <?php
        $image_gallery_visibility =  "display:none;";
        if($slider_type == 'image_gallery'){
            $image_gallery_visibility =  "display:block;";
        }
    ?>
    <div id="uipbb-image-gallery" style="<?php echo $image_gallery_visibility; ?> " >
        <div class="uipbb-settings-title"><h3><?php echo __('Image Gallery Settings','uipbb'); ?></h3></div>
        <div class="uipbb-slider-settings-row" >
            <div class="uipbb-slider-settings-column" >
                <div class="uipbb-slider-settings-label" ><?php _e('Thumbnail Visibility','uipbb'); ?></div>
                <div class="uipbb-slider-settings-field" >
                    <select name="uipbb_slider_settings[thumbnail_visibility]" id="uipbb_slider_settings_thumbnail_visibility" >
                        <option <?php selected('0', $thumbnail_visibility); ?> value="0"><?php _e('Never','uipbb'); ?></option>
                        <option <?php selected('1', $thumbnail_visibility); ?> value="1"><?php _e('Mouse Over','uipbb'); ?></option>
                        <option <?php selected('2', $thumbnail_visibility); ?> value="2"><?php _e('Always Visible','uipbb'); ?></option>
                    </select>                    
                </div>
            </div>
            <div class="uipbb-slider-settings-column" >
                <div class="uipbb-slider-settings-label" ><?php _e('Thumbnail Design','uipbb'); ?></div>
                <div class="uipbb-slider-settings-field" >
                    <select name="uipbb_slider_settings[thumbnail_gallery_design]" id="uipbb_slider_settings_thumbnail_visibility" >
                        <option <?php selected('inside', $thumbnail_gallery_design); ?> value="inside"><?php _e('Inside','uipbb'); ?></option>
                        <option <?php selected('outside', $thumbnail_gallery_design); ?> value="outside"><?php _e('Outside','uipbb'); ?></option>
                    </select>
                </div>
            </div>
            <div class='uipbb-clear'></div>        
        </div>
        <div class="uipbb-slider-settings-row" >
            <div class="uipbb-slider-settings-column" >
                <div class="uipbb-slider-settings-label" ><?php _e('Thumbnail Panel Color','uipbb'); ?></div>
                <div class="uipbb-slider-settings-field" >
                    <input type="text" name="uipbb_slider_settings[thumbnail_back_color]" id="uipbb_slider_settings_thumbnail_back_color" value="<?php echo $thumbnail_back_color; ?>" />
                    
                </div>
            </div>
            
            <div class='uipbb-clear'></div>        
        </div>

        
    </div>
</div>
