// Backend scripts

jQuery(document).ready( function( $ ) {

    /* Upload and insert images to Image Viewer */
    $('#uipbb-viewer-images-panel-upload').click(function() {
        renderViewerMediaUploader( $);
    });

    /* Edit image details using Media Uploader */
    $('#uipbb-viewer-images-panel').on('click','.uipbb-viewer-edit',function() {
        var attachment_id = $(this).parent().parent().find('.uipbb-viewer-preview-thumb').attr('data-attchement-id');
        renderViewerMediaUploader( $ , attachment_id);
    });

    /* Delete images from image viewer */
    $('#uipbb-viewer-images-panel').on('click','.uipbb-viewer-delete',function() {
        var attachment_id = $(this).parent().parent().find('.uipbb-viewer-preview-thumb').attr('data-attchement-id');
        $(this).parent().parent().remove();

        var uploaded_images = '';
        $('.uipbb-viewer-preview-thumb').each(function(){

            if(uploaded_images == ''){
                uploaded_images += $(this).attr('data-attchement-id');
            }else{
                uploaded_images +=  "," + $(this).attr('data-attchement-id') ;
            }
                        
        });
        $("#uipbb_viewer_uploaded_images").val(uploaded_images);
    });

    /* Allow to change image order of viewer by draging and dropping images */
    if(jQuery("#uipbb-viewer-images-panel-gallery").length > 0){
        $( "#uipbb-viewer-images-panel-gallery" ).sortable({
            update: function(e,ui){

                var uploaded_images = '';
                $('.uipbb-viewer-preview-thumb').each(function(){

                    if(uploaded_images == ''){
                        uploaded_images += $(this).attr('data-attchement-id');
                    }else{
                        uploaded_images +=  "," + $(this).attr('data-attchement-id') ;
                    }
                                
                });
                $("#uipbb_viewer_uploaded_images").val(uploaded_images);

                
            },
        });
    }




});


/* Open WordPress media uploader with necessary selections */
function renderViewerMediaUploader( $ , attachment_id) {
    'use strict';

    

    var file_frame, image_data, json , attachment_id;
    if (!attachment_id) { attachment_id = 0; }

    if ( undefined !== file_frame ) {
        file_frame.open();
        return;
    }

    file_frame = wp.media.frames.file_frame = wp.media({
        frame:    'post',
        title: UIPBBAdmin.insertToViewer,
          button: {
            text: UIPBBAdmin.addToViewer
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


            var image_icons = "<img class='uipbb-viewer-edit' src='" + UIPBBAdmin.images_path + "viewer-edit.png' /><img class='uipbb-viewer-delete' src='" + UIPBBAdmin.images_path + "viewer-delete.png' />";

            var uploaded_images = $("#uipbb_viewer_uploaded_images").val();
            if(attachment_id != obj.id){
                $("#uipbb-viewer-images-panel-gallery").append("<div class='uipbb-viewer-images-panel-gallery-single'><img src='"+ thumbnail_url +"' alt='"+ obj.alt +"' data-attchement-id='"+obj.id+ "' class='uipbb-viewer-preview-thumb' /><div class='uipbb-viewer-images-panel-gallery-icons'>"+image_icons+"</div></div>");
                
                if(uploaded_images == ''){
                    uploaded_images += obj.id ;
                }else{
                    uploaded_images +=  "," + obj.id ;
                }
            }

            $("#uipbb_viewer_uploaded_images").val(uploaded_images);
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
