var changeStatus = function(item, event){
	var url = item.attr('href');
	var img = item.find('img');
	var imgSrc = img.attr('src');
	var current = item.attr('class');
	var title = img.attr('title');
	if(current == 'ajax-inactive-item') {
		item.attr('class','ajax-active-item');		
		item.attr('href',url.replace(/\/type\/1/gi, "/type/0"));		
		img.attr('title',title.replace(/Active/gi, "Inactive"));		
		$.get(url);		
		imgSrc = imgSrc.replace(/inactive.png/gi, "active.png");
		img.attr('src',imgSrc);		
	}else if(current == 'ajax-active-item'){
		item.attr('class','ajax-inactive-item');		
		item.attr('href',url.replace(/\/type\/0/gi, "/type/1"));		
		img.attr('title',title.replace(/Inactive/gi, "Active"));		
		$.get(url);
		imgSrc = imgSrc.replace(/active.png/gi, "inactive.png");
		img.attr('src',imgSrc);	
	}else if(current == 'ajax-access-item'){
		item.attr('class','ajax-noaccess-item');		
		item.attr('href',url.replace(/\/type\/0/gi, "/type/1"));		
		img.attr('title',title.replace(/No Access/gi, "Access"));		
		$.get(url);
		imgSrc = imgSrc.replace(/active.png/gi, "inactive.png");
		img.attr('src',imgSrc);	
	}else if(current == 'ajax-noaccess-item') {
		item.attr('class','ajax-access-item');		
		item.attr('href',url.replace(/\/type\/1/gi, "/type/0"));		
		img.attr('title',title.replace(/Access/gi, "No Access"));		
		$.get(url);		
		imgSrc = imgSrc.replace(/inactive.png/gi, "active.png");
		img.attr('src',imgSrc);		
	}else if(current == 'ajax-nospecial-item') {
		item.attr('class','ajax-special-item');		
		item.attr('href',url.replace(/\/type\/1/gi, "/type/0"));		
		img.attr('title',title.replace(/Yes/gi, "No"));		
		$.get(url);		
		imgSrc = imgSrc.replace(/inactive.png/gi, "active.png");
		img.attr('src',imgSrc);		
	}else if(current == 'ajax-special-item') {
		item.attr('class','ajax-nospecial-item');		
		item.attr('href',url.replace(/\/type\/0/gi, "/type/1"));		
		img.attr('title',title.replace(/No/gi, "Yes"));		
		$.get(url);		
		imgSrc = imgSrc.replace(/active.png/gi, "inactive.png");
		img.attr('src',imgSrc);			
	}else if(current == 'ajax-featured-item') {
		item.attr('class','ajax-nofeatured-item');		
		item.attr('href',url.replace(/\/type\/0/gi, "/type/1"));		
		img.attr('title',title.replace(/No/gi, "Yes"));		
		$.get(url);		
		imgSrc = imgSrc.replace(/featured.png/gi, "nofeatured.png");
		img.attr('src',imgSrc);			
	}else if(current == 'ajax-nofeatured-item') {
		item.attr('class','ajax-featured-item');		
		item.attr('href',url.replace(/\/type\/1/gi, "/type/0"));		
		img.attr('title',title.replace(/Yes/gi, "No"));		
		$.get(url);		
		imgSrc = imgSrc.replace(/nofeatured.png/gi, "featured.png");
		img.attr('src',imgSrc);	
	}else if(current == 'ajax-favorites-item') {
		item.attr('class','ajax-nofavorites-item');		
		item.attr('href',url.replace(/\/type\/0/gi, "/type/1"));		
		img.attr('title',title.replace(/No/gi, "Yes"));		
		$.get(url);		
		imgSrc = imgSrc.replace(/favorites.png/gi, "nofavorites.png");
		img.attr('src',imgSrc);			
	}else if(current == 'ajax-nofavorites-item') {
		item.attr('class','ajax-favorites-item');		
		item.attr('href',url.replace(/\/type\/1/gi, "/type/0"));		
		img.attr('title',title.replace(/Yes/gi, "No"));		
		$.get(url);		
		imgSrc = imgSrc.replace(/nofavorites.png/gi, "favorites.png");
		img.attr('src',imgSrc);	
	}
	event.preventDefault();
};

$(document).ready(function(){
	$('.ajax-active-item').click(function(event){
		changeStatus($(this), event);
	});
	
	$('.ajax-inactive-item').click(function(event){
		changeStatus($(this), event);
	});
	
	$('.ajax-access-item').click(function(event){
		changeStatus($(this), event);
	});
	
	$('.ajax-noaccess-item').click(function(event){
		changeStatus($(this), event);
	});
	$('.ajax-special-item').click(function(event){
		changeStatus($(this), event);
	});
	$('.ajax-nospecial-item').click(function(event){
		changeStatus($(this), event);
	});
	
	$('.ajax-nofeatured-item').click(function(event){
		changeStatus($(this), event);
	});
	$('.ajax-featured-item').click(function(event){
		changeStatus($(this), event);
	});
	$('.ajax-favorites-item').click(function(event){
		changeStatus($(this), event);
	});
	$('.ajax-nofavorites-item').click(function(event){
		changeStatus($(this), event);
	});
	
	$('.ajax-delete-item').click(function(event){
		var title = $(this).find('img').attr('title');
		var item = $(this);
		var url = item.attr('href');
		jConfirm('Do you want to delete this record?', 'Confirmation Dialog', function(r) {
			if(r==true){
				$.get(url);
				item.parent().parent().fadeOut('slow');
			}
		});
		event.preventDefault();
	});
	
	/*$('.even td input[type="checkbox"]').click(function(){
		$(this).parent().css('background','red');
	});*/
});