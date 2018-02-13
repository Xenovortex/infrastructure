// JavaScript Document

(function($){ "use strict"; 


//$(".anchor-input").prop('disabled', true);


	//#setting_themo_meta_box_builder_meta_boxes
	
	$( "#setting_themo_meta_box_builder_meta_boxes" ).append( "<p>Need help? <a href='http://docs.themovation.com/pursuit/#metaboxbuilder' target='_blank'>Meta Box Documentation</a></p>" );
	
	/*var scriptEls = document.getElementsByTagName( 'script' );
	var thisScriptEl = scriptEls[scriptEls.length - 1];
	var scriptPath = thisScriptEl.src;
	var scriptFolder = scriptPath.substr(0, scriptPath.lastIndexOf( '/' )+1 );
   	var scriptImgFolder = scriptFolder.replace('js/', 'images/');
	//console.log(scriptImgFolder);

	$('#setting_themo_meta_box_builder_meta_boxes input:checkbox').each(function() { // Grab all elements with a title attribute,and set "this"
	
	var help_title = "Help";
	var help_msg = "<a href='http://docs.themovation.com/pursuit'>Learn More</a>";
		switch ($(this).val()) {
			case 'accordion':
				help_title = "Accordion";
				help_msg = "Use the accordion metabox to built a simple collapsible accordion text blocks. <a href='http://docs.themovation.com/pursuit'>See Example</a>";
				break;
			case '':
				break;
		}
		$(this).qtip({ // 
			//content:'<img src="'+scriptImgFolder+'meta_qtip_'+ $(this).val()+'.jpg" alt="'+$(this).val()+'" width="500" height="300" />',
			
			content: {
				title: help_title, // content: { title: { text: value } }
				text: help_msg // Use the "div" element next to this for the content
			},
			hide: {
				delay: 1500
			},
			style: {
				//def: false, // Remove the default styling
				classes: 'themo_meta_qtip'
			},
		});
	});*/
   
   
	/*var labelID;
	$('#setting_themo_meta_box_builder_meta_boxes label')
	  .mouseover(function() {
		 labelID = $(this).attr('for');
		   $('#'+labelID).trigger('mouseover');
	  })
	  .mouseout(function() {
		 labelID = $(this).attr('for');
		   $('#'+labelID).trigger('mouseout');
	  });*/

	//-----------------------------------------------------
	// Show Warning about updating page when custom template selected
	// in admin
	//-----------------------------------------------------
	$('#themo_template_selection').change(function(){
		$( "#setting_themo_template_select_help" ).slideDown( "slow", function() {
		// Animation complete.
		});
	});

	// When unchecking a meta box from a page, make sure the meta box is not currenly set to display, if it us don't allow uncheck.
	$("#setting_themo_meta_box_builder_meta_boxes input[type=checkbox]").click( function(){
		
	   if ($(this).prop('checked')==false){ 
			// Check matching display status and see if we need to warn user.
			var meta_box_name = $(this).val();
			if(meta_box_name > ""){
				var meta_box_name_ucase = meta_box_name
				meta_box_name_ucase = meta_box_name_ucase.toLowerCase().replace(/\b[a-z]/g, function(letter) {
					return letter.toUpperCase();
				});
	
				if($("input:radio[name='themo_"+meta_box_name+"_1_sortorder_show']:checked").val() == 'on'){
					alert('Display for '+meta_box_name_ucase+' is set to "ON", switch this to "OFF" before removing this Meta Box.');
					return false;
				};
			}
		}
	});

	if($("#themo_sortable").length){
		// Make list item sortable / drag and drop.
		$("#themo_sortable").sortable({
			update: function(event, ui) {
				//create the array that hold the positions...
				var order = []; 
				var meta_box_sort_order = 0;
				//loop trought each li...
				$('#themo_sortable li').each( function(e) {
				//add each li position to the array...     
				// the +1 is for make it start from 1 instead of 0
					order.push( $(this).context.childNodes[0].id  + '=' + ( $(this).index()) );
					var updateMe = '#'+$(this).context.childNodes[0].id;
					var data_meta_box_name = $(updateMe).data('meta-box-name');
					$(updateMe).val($(this).index());
					
					// Update sort order value of the actual meta box. themo_accordion_2_order
					var meta_box_order_input = '_order';
					if($('#'+data_meta_box_name+'_order').length){
						meta_box_sort_order=meta_box_sort_order+10;
						$('#'+data_meta_box_name+'_order').val(meta_box_sort_order)
					}
				});
				// join the array as single variable...
				var positions = order.join(';')
			}
		}).disableSelection();
	}

	// SORT Drag and Drop list on page load.
	$('#themo_sortable li').each(function (index) {
		var updateMe = '#'+$(this).context.childNodes[0].id;
		var data_meta_box_name = $(updateMe).data('meta-box-name');
		var meta_box_order_input = data_meta_box_name + '_order';
	
		if($('#'+meta_box_order_input).length){
			var meta_box_order_value = $('#'+meta_box_order_input).val();
			$(updateMe).val(meta_box_order_value);
		}
	});

	// Sort Meta Box List when page loads.
	function sortlist(a, b) {
	  return (parseInt($(a).find(".option-tree-ui-checkbox").val(), 10) - parseInt($(b).find(".option-tree-ui-checkbox").val(), 10));
	}

	$("#themo_sortable li").sort(sortlist).appendTo("#themo_sortable");
		
	// This does the ajax request
	$(".themo_wp_editor").on( "click", function(){
	
	// Set the data to pass to ajax post.
	// 
	var data = {
		'action':'wp_editor_box_editor_html',  // name of action in custom.php
		'id':this.id, // ID of element clicked
		'textarea_name':$(this).attr('name'), // name of element clicked
		'content':$(this).val(), // Content inside current element
	};
	
	var elmID = "#"+this.id; // ID of element clicked
	
	$.post(ajaxurl, data, function(response) { // Ajax call, with response var
		$(elmID).replaceWith(response); // Replace element with what's in the resposne.
		
		if ( $("#wp-content-wrap").hasClass('tmce-active' )) { // Check if we are in visual mode, if not, don't init mce editor
			try {
				tinyMCE.init(tinyMCEPreInit.mceInit[data.id]); // init mce editor
	
				if ( ! window.wpActiveEditor ) {
					window.wpActiveEditor = data.id;
				}
			} catch(e){}
		}
		
		
		if ( typeof quicktags !== 'undefined' ) { // if we are in html / text mode then try and activate quicktags
			console.log('quicktags!');
			for ( data.id in tinyMCEPreInit.qtInit ) {
				try {
					quicktags( tinyMCEPreInit.qtInit[data.id] ); // Try to add quicktags

					if ( ! window.wpActiveEditor ) {
						window.wpActiveEditor = data.id;
					}
				} catch(e){};
			}
		}
	});
	
});


})(jQuery);


