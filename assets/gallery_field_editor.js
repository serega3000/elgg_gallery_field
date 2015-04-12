(function ( $ ) {	
	
	var full_image_container = null;
	var links = null;
	var delete_enabled = false;
	var upload_button;
	var delete_button;
	var delete_images_span;
	var editor_main = null;
	
	var deletingImagesCLick = function(){
		$(this).toggleClass('deleting');		
		return false;
	}
	
	var cancelDeleting = function(){
		editor_main.show();		
		delete_images_span.hide();
		delete_enabled = false;
		links.removeClass('deleting');
		links.unbind('click',deletingImagesCLick);		
	}
	
	var init_gallery_editor = function(el){
		
		editor_main = el.find('.editor_main');
		var upload_form = el.find('form');
		var upload_field = el.find("form input.upload_input");
		upload_button = el.find('.upload-btn');
		delete_images_span = el.find('.delete_images');
		delete_button = el.find(".delete-btn");		
		var delete_cancel_button = el.find(".delete-cancel-btn");
		var delete_confirm_button = el.find(".delete-confirm-btn");
		//var images = images
		
		upload_field.on('change', function(){				
			upload_form.submit();			
			editor_main.hide();
			editor_main.parent().append("<h1>Loading...</h1>");
		});
		upload_button.click(function(){
			upload_field.trigger('click');
		});					
		
		delete_button.click(function(){
			editor_main.hide();
			delete_images_span.show();
			full_image_container.empty();
			links.blur();
			delete_enabled = true;
			links.on('click',deletingImagesCLick);
		});
		
		delete_cancel_button.click(function(){
			cancelDeleting();
		});
		
		delete_confirm_button.click(function(){
			var delete_ids = [];
			links.filter('.deleting').each(function(){
				delete_ids.push($(this).data('image-id'));
			});
			if(delete_ids.length === 0){
				alert($(this).data('empty-text'));
			} else {
				if(confirm("" + delete_ids.length + $(this).data('confirm-text')))
				{
					links.filter('.deleting').each(function(){
						$(this).parent().remove();
					});
					$.post("/gallery_field_image/delete",{
							entity_id: el.data('entity-id'),
							field: el.data('entity-field'),
							images: delete_ids.join(","),
							success: function(){
								cancelDeleting();
							}
						}
					);					
				}
			}
		});
		
	};
	
	$.fn.gallery_field = function() {
		if(this.length === 0) return;	
		
		links = this.find(".images a");
		full_image_container = this.find('.image_full');
		var el = this;
		
		links.focus(function(){
			if(delete_enabled){
				this.blur();
				return;
			}
				
			var image = $('<img/>');
			var thumb_href = $(this).find('img').attr('src');
			var full_href = this.href;
			image.attr('src', thumb_href);
			image.css({'opacity':0.5});
			full_image_container.html(image);	
			image.attr('src', full_href);
			image.load(function(){
				image.css({'opacity':1});
			});					
		});
		
		links.click(function(){
			if(delete_enabled) return true;
			if(false === $(this).is(":focus")){
				this.focus();
			}			
			return false;
		});
		
		links.keydown(function(e) {
			if(delete_enabled) return;
			var link = $(this);
			if(e.keyCode == 37) { // left
				var prev = link.parent().prev().find('a');
				if(prev.length){
					prev.focus();
				}
			}
			else if(e.keyCode == 39) { // right
				var next = link.parent().next().find('a');
				if(next){
					next.focus();
				}
			}					
		});
			
		if(this.hasClass('gallery-field-editor'))
		{
			init_gallery_editor(this);	
		}
		
		this.find('.editor_toggler').click(function(){
			el.find('.editor').show();
			$(this).hide();
			return false;
		});
		
		this.find('.edit-cancel-btn').click(function(){
			if(delete_enabled){
				cancelDeleting();
			}
			el.find('.editor').hide();
			el.find('.editor_toggler').show();
		});		
		
		
		
		
	};
}( jQuery ));

jQuery(function(){
	$('.gallery-field-images-list').each(function(){
		$(this).gallery_field();
	});
});
