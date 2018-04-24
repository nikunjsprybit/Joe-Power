var _custom_media = true,
_orig_send_attachment = wp.media.editor.send.attachment;
jQuery(document).ready(function($){
  $('.wcfm-wp-fields-uploader').each(function() {
  	addWCFMUploaderProperty($(this));	
  });
  $('.add_media').on('click', function(){
    _custom_media = false;
  });
});

function addWCFMUploaderProperty(wcfmuploader) {
	wcfmuploader.find('img').each(function() {
	  var src = jQuery(this).attr('src');
	  if(src.length == 0) jQuery(this).hide();
	});
	
	wcfmuploader.find('.upload_button').click(function(e) {
		var send_attachment_bkp = wp.media.editor.send.attachment;
		var button = jQuery(this);
		var mime = jQuery(this).data('mime');
		var id = button.attr('id').replace('_button', '');
		_custom_media = true;
		wp.media.editor.send.attachment = function(props, attachment) {
			if ( _custom_media ) {
				if(mime  == 'image') {
					// jQuery("#"+id+'_display').attr('src', attachment.url).removeClass('placeHolder').show();

					jQuery(attachment).each( function(a, b) {
						jQuery('<div class="uploaded_images imageid_'+b.id+'" data-imageid="'+b.id+'"><input type="hidden" value="'+b.id+'" name="product_image_gallery[]"><img src="'+b.url+'" height="100px" alt="thumb"><i class="fa deleter fa-trash-o" data-imageid="'+b.id+'"></i></div></div>').prependTo('#imagelist');
					});

					if(jQuery("#"+id+'_preview').length > 0)
						jQuery("#"+id+'_preview').attr('src', attachment.url);
				} else {
					jQuery("#"+id+'_display').attr('href', attachment.url);
					//if(attachment.icon) jQuery("#"+id+'_display span').css('background', 'url("'+attachment.icon+'")').css('width', '48px').css('height', '64px');
				}
				jQuery("#"+id+'_display span').show();
				jQuery("#"+id).val(attachment.url);
				jQuery("#"+id).hide();
				// button.hide();
				// jQuery("#"+id+'_remove_button').show();
			} else {
				return _orig_send_attachment.apply( this, [props, attachment] );
			};
		}

		wp.media.editor.open(button);
		return false;
	});
	
	wcfmuploader.find('.remove_button').each(function() {
		var button = jQuery(this);
		var mime = jQuery(this).data('mime');
		var id = button.attr('id').replace('_remove_button', '');
		if(mime == 'image')
			var attachment_url = jQuery("#"+id+'_display').attr('src');
		else
			var attachment_url = jQuery("#"+id+'_display').attr('href');
		if(!attachment_url || attachment_url.length == 0) {
			button.hide();
			jQuery("#"+id+'_display span').hide();
		} else {
			jQuery("#"+id+'_button').hide();
		}
		button.click(function(e) {
			id = jQuery(this).attr('id').replace('_remove_button', '');
			if(mime == 'image') {
				jQuery("#"+id+'_display').attr('src', '').addClass('placeHolder').hide();
				jQuery("#"+id+'_preview').attr('src', '');
			} else {
				jQuery("#"+id+'_display').attr('href', '#');
			}
			jQuery("#"+id+'_display span').hide();
			jQuery("#"+id).val('');
			jQuery(this).hide();
			jQuery("#"+id+'_button').show();
			return false;
		});
	});
}

jQuery(document).on('click', 'i.deleter', function() { 
	var _this = jQuery(this);
	var id = _this.data('imageid');
	jQuery('.imageid_'+id).remove();
});


jQuery(document).on('dblclick', '.uploaded_images', function(){
	jQuery('i.set_featured').remove();
	jQuery('#product_feimage').remove();
    var thisId =  jQuery(this).attr('data-imageid');
    var thisUrl = jQuery('.imageid_'+thisId+' img').attr('src');
    jQuery('<i class="fa thumber fa-star set_featured"></i>').appendTo(this);
    jQuery('#featured_img').val(thisUrl);
    jQuery('<input type="text" value="'+thisId+'" name="product_feimage" id="product_feimage" style="display:none;">').insertAfter('#featured_img');
});