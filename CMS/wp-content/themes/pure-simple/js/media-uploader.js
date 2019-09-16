/**
* @description This is media uploader js which helps on adding media on widgets area
* @version 3.0.0
* @package pure simple
*/
jQuery(document).ready(function($){    
    $('#favicon_upload_btn').click(function(e) {
		e.preventDefault();
        var fav = $(this);
		var image = wp.media({ 
			title: 'Upload Image',
			// mutiple: true if you want to upload multiple files at once
			multiple: false
		}).open()
		.on('select', function(e){
			// This will return the selected image from the Media Uploader, the result is an object
			var uploaded_image = image.state().get('selection').first();
			// We convert uploaded_image to a JSON object to make accessing it easier
			// Output to the console uploaded_image
			console.log(uploaded_image);
			var image_url = uploaded_image.toJSON().url;
			// Let's assign the url value to the input field
			$('#favicon').val(image_url);
            $(fav).next('.favicon_preview').children('img').attr("src",image_url);
            $(fav).next('.favicon_preview').fadeIn();
		});
	});
    
    $('.slide-upload-button').click(function(e) {
		e.preventDefault();
        var self = $(this);
		var image = wp.media({ 
			title: 'Upload Image',
			// mutiple: true if you want to upload multiple files at once
			multiple: false
		}).open()
		.on('select', function(e){
			// This will return the selected image from the Media Uploader, the result is an object
			var uploaded_image = image.state().get('selection').first();
			// We convert uploaded_image to a JSON object to make accessing it easier
			// Output to the console uploaded_image
			console.log(uploaded_image);
			var image_url = uploaded_image.toJSON().url;
			// Let's assign the url value to the input field
			//$('#slide1').val(image_url);
            $(self).prev('.slide-image-url').val(image_url);
            $(self).next('.slide_preview').children('img').attr("src",image_url);
            $(self).next('.slide_preview').fadeIn();
		});
	});
    
    $(document).on('click' , '.upload-button', function(e) {
		e.preventDefault();
        var $this = $(this);
		var image = wp.media({ 
			title: 'Upload Image',
			// mutiple: true if you want to upload multiple files at once
			multiple: false
		}).open()
		.on('select', function(e){
			// This will return the selected image from the Media Uploader, the result is an object
			var uploaded_image = image.state().get('selection').first();
			// We convert uploaded_image to a JSON object to make accessing it easier
			// Output to the console uploaded_image
			var image_url = uploaded_image.toJSON().url;
			// Let's assign the url value to the input field
			$this.prev('.upload').val(image_url);
            
            var img = "<img src='"+image_url+"' width='125px' height='125px' /><a class='remove-image remove-screenshot'>Remove</a>";
            $this.next('.screenshot').html(img);
		});
	});
    
    $(document).on('click' , '.remove-screenshot', function(e) {
        $(this).parent().prev().prev('.upload').val('');
        $(this).parent().html('');
	});
});

// show/hide option toggle for portfolio tab
jQuery(document).ready(function($){
    $("button.moreOption").click(function(){
        $(".cat_options").toggle();
        // alert('yes');
    });

    $("button.moreOption1").click(function(){
        $(".cat_options1").toggle();
        // alert('yes');
    });

    $("button.moreOption2").click(function(){
        $(".cat_options2").toggle();
        // alert('yes');
    });

    $("button.moreOption4").click(function(){
        $(".cat_options4").toggle();
        // alert('yes');
    });

    $("button.moreOption3").click(function(){
        $(".cat_options3").toggle();
        // alert('yes');
    });
});