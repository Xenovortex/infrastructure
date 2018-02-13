$(function(){
	$('#sidebar a').click(function(){
		
		jQuery.scrollTo.window().queue([]).stop();
		if( $(this).attr('href') == '#intro' ){
			$.scrollTo(0 , 800, { easing: 'easeInOutCubic' });
		}
		else {
			$.scrollTo($(this).attr('href') , 800, { easing: 'easeInOutCubic' });
		}
	
		
		
	});
	
	$('body').scrollspy({
		target: '#sidebar',
		offset: 100
	});
	
	$("#accordion > li").click(function(){
		console.log('hello');
		if(false == $(this).next().is(':visible')) {
			$('#accordion > ul').slideUp(300);
		}
		$(this).next().slideToggle(300);
	});

	$('#accordion > ul:eq(0)').show();

});
