<?php
    global $uipbb_viewer_params;
    extract($uipbb_viewer_params);

    $viewer_settings = get_post_meta( $post->ID , '_uipbb_viewer_settings', true );


    $upload_dir = wp_upload_dir();
    $upload_dir_url = $upload_dir['baseurl']."/";

    // Get the image viewer specific settings from database 
    $viewer_settings = (array) get_post_meta( $post->ID, '_uipbb_viewer_settings', true );

    $mode = isset($viewer_settings['mode']) ? $viewer_settings['mode'] : 'modal';
    $navbar = isset($viewer_settings['navbar']) ? $viewer_settings['navbar'] : 'enabled';
    $title = isset($viewer_settings['title']) ? $viewer_settings['title'] : 'enabled';
    $toolbar = isset($viewer_settings['toolbar']) ? $viewer_settings['toolbar'] : 'enabled';
    $tooltip = isset($viewer_settings['tooltip']) ? $viewer_settings['tooltip'] : 'enabled';
    $movable = isset($viewer_settings['movable']) ? $viewer_settings['movable'] : 'enabled';
    $zooming = isset($viewer_settings['zooming']) ? $viewer_settings['zooming'] : 'enabled';
    $rotating = isset($viewer_settings['rotating']) ? $viewer_settings['rotating'] : 'enabled';
    $scaling = isset($viewer_settings['scaling']) ? $viewer_settings['scaling'] : 'enabled';
    $transition = isset($viewer_settings['transition']) ? $viewer_settings['transition'] : 'enabled';
    $fullscreen = isset($viewer_settings['fullscreen']) ? $viewer_settings['fullscreen'] : 'enabled';
    //$custom_css = isset($viewer_settings['custom_css']) ? $viewer_settings['custom_css'] : '';
?>


<div id="uipbb-viewer-settings-panel" >
    <div class="uipbb-viewer-settings-row" >
        <div class="uipbb-viewer-settings-column" >
            <div class="uipbb-viewer-settings-label" ><?php _e('Viewer Mode','uipbb'); ?></div>
            <div class="uipbb-viewer-settings-field" >
                <select  name="uipbb_viewer_settings[mode]" class="uipbb_viewer_settings_mode" >
                    <option <?php selected('modal', $mode); ?> value="modal"><?php _e('Modal','uipbb'); ?></option>
                    <option <?php selected('inline', $mode); ?> value="inline"><?php _e('Inline','uipbb'); ?></option>
                </select>
            </div>
        </div>
        <div class="uipbb-viewer-settings-column" >
            <div class="uipbb-viewer-settings-label" ><?php _e('Navigation Bar','uipbb'); ?></div>
            <div class="uipbb-viewer-settings-field" >
                <select name="uipbb_viewer_settings[navbar]" class="uipbb_viewer_settings_navbar" >
                    <option <?php selected('enabled', $navbar); ?> value="enabled"><?php _e('Enabled','uipbb'); ?></option>
                    <option <?php selected('disabled', $navbar); ?> value="disabled"><?php _e('Disabled','uipbb'); ?></option>
                </select>
            </div>
        </div>
        <div class='uipbb-clear'></div>        
    </div>

    <div class="uipbb-viewer-settings-row" >
        <div class="uipbb-viewer-settings-column" >
            <div class="uipbb-viewer-settings-label" ><?php _e('Title','uipbb'); ?></div>
            <div class="uipbb-viewer-settings-field" >
                <select name="uipbb_viewer_settings[title]" class="uipbb_viewer_settings_title" >
                    <option <?php selected('enabled', $title); ?> value="enabled"><?php _e('Enabled','uipbb'); ?></option>
                    <option <?php selected('disabled', $title); ?> value="disabled"><?php _e('Disabled','uipbb'); ?></option>
                </select>
            </div>
        </div>
        <div class="uipbb-viewer-settings-column" >
            <div class="uipbb-viewer-settings-label" ><?php _e('Toolbar','uipbb'); ?></div>
            <div class="uipbb-viewer-settings-field" >
                <select name="uipbb_viewer_settings[toolbar]" class="uipbb_viewer_settings_toolbar" >
                    <option <?php selected('enabled', $toolbar); ?> value="enabled"><?php _e('Enabled','uipbb'); ?></option>
                    <option <?php selected('disabled', $toolbar); ?> value="disabled"><?php _e('Disabled','uipbb'); ?></option>
                </select>
            </div>
        </div>
        <div class='uipbb-clear'></div>        
    </div>

    <div class="uipbb-viewer-settings-row" >
        <div class="uipbb-viewer-settings-column" >
            <div class="uipbb-viewer-settings-label" ><?php _e('Tooltip','uipbb'); ?></div>
            <div class="uipbb-viewer-settings-field" >
                <select name="uipbb_viewer_settings[tooltip]" class="uipbb_viewer_settings_tooltip" >
                    <option <?php selected('enabled', $tooltip); ?> value="enabled"><?php _e('Enabled','uipbb'); ?></option>
                    <option <?php selected('disabled', $tooltip); ?> value="disabled"><?php _e('Disabled','uipbb'); ?></option>
                </select>
            </div>
        </div>
        <div class="uipbb-viewer-settings-column" >
            <div class="uipbb-viewer-settings-label" ><?php _e('Moving','uipbb'); ?></div>
            <div class="uipbb-viewer-settings-field" >
                <select name="uipbb_viewer_settings[movable]" class="uipbb_viewer_settings_moovable" >
                    <option <?php selected('enabled', $movable); ?> value="enabled"><?php _e('Enabled','uipbb'); ?></option>
                    <option <?php selected('disabled', $movable); ?> value="disabled"><?php _e('Disabled','uipbb'); ?></option>
                </select>
            </div>
        </div>
        <div class='uipbb-clear'></div>        
    </div>

    <div class="uipbb-viewer-settings-row" >
        <div class="uipbb-viewer-settings-column" >
            <div class="uipbb-viewer-settings-label" ><?php _e('Zooming','uipbb'); ?></div>
            <div class="uipbb-viewer-settings-field" >
                <select name="uipbb_viewer_settings[zooming]" class="uipbb_viewer_settings_zooming" >
                    <option <?php selected('enabled', $zooming); ?> value="enabled"><?php _e('Enabled','uipbb'); ?></option>
                    <option <?php selected('disabled', $zooming); ?> value="disabled"><?php _e('Disabled','uipbb'); ?></option>
                </select>
            </div>
        </div>
        <div class="uipbb-viewer-settings-column" >
            <div class="uipbb-viewer-settings-label" ><?php _e('Rotating','uipbb'); ?></div>
            <div class="uipbb-viewer-settings-field" >
                <select name="uipbb_viewer_settings[rotating]" class="uipbb_viewer_settings_rotating" >
                    <option <?php selected('enabled', $rotating); ?> value="enabled"><?php _e('Enabled','uipbb'); ?></option>
                    <option <?php selected('disabled', $rotating); ?> value="disabled"><?php _e('Disabled','uipbb'); ?></option>
                </select>
            </div>
        </div>
        <div class='uipbb-clear'></div>        
    </div>

    <div class="uipbb-viewer-settings-row" >
        <div class="uipbb-viewer-settings-column" >
            <div class="uipbb-viewer-settings-label" ><?php _e('Scaling','uipbb'); ?></div>
            <div class="uipbb-viewer-settings-field" >
                <select name="uipbb_viewer_settings[scaling]" class="uipbb_viewer_settings_scaling" >
                    <option <?php selected('enabled', $scaling); ?> value="enabled"><?php _e('Enabled','uipbb'); ?></option>
                    <option <?php selected('disabled', $scaling); ?> value="disabled"><?php _e('Disabled','uipbb'); ?></option>
                </select>
            </div>
        </div>
        <div class="uipbb-viewer-settings-column" >
            <div class="uipbb-viewer-settings-label" ><?php _e('Transition','uipbb'); ?></div>
            <div class="uipbb-viewer-settings-field" >
                <select name="uipbb_viewer_settings[transition]" class="uipbb_viewer_settings_transition" >
                    <option <?php selected('enabled', $transition); ?> value="enabled"><?php _e('Enabled','uipbb'); ?></option>
                    <option <?php selected('disabled', $transition); ?> value="disabled"><?php _e('Disabled','uipbb'); ?></option>
                </select>
            </div>
        </div>
        <div class='uipbb-clear'></div>        
    </div>

    <div class="uipbb-viewer-settings-row" >
        <div class="uipbb-viewer-settings-column" >
            <div class="uipbb-viewer-settings-label" ><?php _e('Full Screen','uipbb'); ?></div>
            <div class="uipbb-viewer-settings-field" >
                <select name="uipbb_viewer_settings[fullscreen]" class="uipbb_viewer_settings_fullscreen" >
                    <option <?php selected('enabled', $fullscreen); ?> value="enabled"><?php _e('Enabled','uipbb'); ?></option>
                    <option <?php selected('disabled', $fullscreen); ?> value="disabled"><?php _e('Disabled','uipbb'); ?></option>
                </select>
            </div>
        </div>
        
        <div class='uipbb-clear'></div>        
    </div>

    
    
</div>
