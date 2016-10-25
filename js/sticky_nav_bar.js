$(document).ready(function(){
	var altura = $('.menu-static').offset().top;
	
	$(window).on('scroll', function(){
		if ( $(window).scrollTop() > altura ){
			$('.menu-static').addClass('menu-fixed').fadeIn();
		} else {
			$('.menu-static').removeClass('menu-fixed').fadeIn();
		}
	});

});
