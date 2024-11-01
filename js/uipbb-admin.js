// Backend scripts

jQuery(document).ready( function( $ ) {

    /* Upload and insert images to Image Slider */
    $('#uipbb-slider-images-panel-upload').click(function() {
        renderMediaUploader( $);
    });

    /* Edit image details using Media Uploader */
    $('#uipbb-slider-images-panel').on('click','.uipbb-slider-edit',function() {
        var attachment_id = $(this).parent().parent().find('.uipbb-slider-preview-thumb').attr('data-attchement-id');
        renderMediaUploader( $ , attachment_id);
    });

    /* Delete images from image slider */
    $('#uipbb-slider-images-panel').on('click','.uipbb-slider-delete',function() {
        var attachment_id = $(this).parent().parent().find('.uipbb-slider-preview-thumb').attr('data-attchement-id');
        $(this).parent().parent().remove();

        var uploaded_images = '';
        $('.uipbb-slider-preview-thumb').each(function(){

            if(uploaded_images == ''){
                uploaded_images += $(this).attr('data-attchement-id');
            }else{
                uploaded_images +=  "," + $(this).attr('data-attchement-id') ;
            }
                        
        });
        $("#uipbb_slider_uploaded_images").val(uploaded_images);
    });

    /* Allow to change image order of slider by draging and dropping images */
    if(jQuery("#uipbb-slider-images-panel-gallery").length > 0){
        $( "#uipbb-slider-images-panel-gallery" ).sortable({
            update: function(e,ui){

                var uploaded_images = '';
                $('.uipbb-slider-preview-thumb').each(function(){

                    if(uploaded_images == ''){
                        uploaded_images += $(this).attr('data-attchement-id');
                    }else{
                        uploaded_images +=  "," + $(this).attr('data-attchement-id') ;
                    }
                                
                });
                $("#uipbb_slider_uploaded_images").val(uploaded_images);

                
            },
        });
    }


    $('#uipbb_slider_settings_slider_type').change(function() {

        switch($(this).val()){
            case 'thumbnail_slider':
                $('#uipbb-thumbnail-slider').show();
                $('#uipbb-image-gallery').hide();
                break;
            case 'image_gallery':
                $('#uipbb-image-gallery').show();
                $('#uipbb-thumbnail-slider').hide();
                break;
            case 'tab_slider':
                $('#uipbb-image-gallery').hide();
                $('#uipbb-thumbnail-slider').hide();
                break;
            default:
                $('#uipbb-image-gallery').hide();
                $('#uipbb-thumbnail-slider').hide();
                break;
        }
    });

});


/* Open WordPress media uploader with necessary selections */
function renderMediaUploader( $ , attachment_id) {
    'use strict';

    

    var file_frame, image_data, json , attachment_id;
    if (!attachment_id) { attachment_id = 0; }

    if ( undefined !== file_frame ) {
        file_frame.open();
        return;
    }

    file_frame = wp.media.frames.file_frame = wp.media({
        frame:    'post',
        title: UIPBBAdmin.insertToSlider,
          button: {
            text: UIPBBAdmin.addToSlider
          },
        multiple: true
    });

    file_frame.on( 'insert', function() {

        // Read the JSON data returned from the Media Uploader
        var selection = file_frame.state().get( 'selection' );
        json = file_frame.state().get( 'selection' ).toJSON();
        
        $.each(json, function(index,obj){
            console.log(obj);
            if ( 0 > $.trim( obj.id.length ) && 0 > $.trim( obj.url.length ) ) {
                return;
            }
            
            var thumbnail_url = obj.url;
            if(obj.sizes.thumbnail){
                thumbnail_url = obj.sizes.thumbnail.url;
            }


            var image_icons = "<img class='uipbb-slider-edit' src='" + UIPBBAdmin.images_path + "slider-edit.png' /><img class='uipbb-slider-delete' src='" + UIPBBAdmin.images_path + "slider-delete.png' />";

            var uploaded_images = $("#uipbb_slider_uploaded_images").val();
            if(attachment_id != obj.id){
                $("#uipbb-slider-images-panel-gallery").append("<div class='uipbb-slider-images-panel-gallery-single'><img src='"+ thumbnail_url +"' alt='"+ obj.alt +"' data-attchement-id='"+obj.id+ "' class='uipbb-slider-preview-thumb' /><div class='uipbb-slider-images-panel-gallery-icons'>"+image_icons+"</div></div>");
                
                if(uploaded_images == ''){
                    uploaded_images += obj.id ;
                }else{
                    uploaded_images +=  "," + obj.id ;
                }
            }

            $("#uipbb_slider_uploaded_images").val(uploaded_images);
        });

        

        console.log(json);

    });

    file_frame.on('open',function() {
        var selection = file_frame.state().get('selection');
        if(attachment_id != 0){
            var attachment = wp.media.attachment(attachment_id);
            attachment.fetch();
            selection.add( attachment ? [ attachment ] : [] );
        }
    });

    file_frame.open();

}
