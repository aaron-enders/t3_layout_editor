if (typeof jQuery == 'undefined') {  
    t3jQuery = TYPO3.jQuery;
} else {
    t3jQuery = jQuery;
}

( function($) {
	

	$(document).on("click", ".layoutEditor .add",function() {
		var index_str = $(".layoutEditor fieldset:last-of-type .number").attr("name");

		var index_start_pos = index_str.indexOf('[contentLayouts][') + 17;
		var index_end_pos = index_str.indexOf(']',index_start_pos);
		var index = parseInt(index_str.substring(index_start_pos,index_end_pos)) + 1;
		
		var ele = $('.layoutEditor fieldset:last-of-type').clone(true);
		
		$('.layoutEditor fieldset:last-of-type').after(ele);

		$(".layoutEditor fieldset:last-of-type input[type='text']").each(function( e ) {
			var newName_str = $(this).attr("name");
			newName_str = newName_str.replace(/\[contentLayouts\]\[(.+?)\]/,"[contentLayouts]["+index+"]");
			//newName_str = newName_str.replace(/\[\d+\]/,"asd");
			$(this).attr("name", newName_str);
		});
		

	})
	$(document).on("click", ".layoutEditor .delete",function() {
		if (confirm("Are you sure?") == true) {
			var ele = $('.layoutEditor fieldset:last-of-type').clone(true);
			$(this).closest("fieldset").remove();
		    return true;
		  } else {
		    return false;
		  }
		
	})

	$(document).on("click", "ul.tabs li",function() {
		var tab_id = $(this).attr('data-tab');

		$('ul.tabs li').removeClass('current');
		$('.tab-content').removeClass('current');

		$(this).addClass('current');
		$("#"+tab_id).addClass('current');
	})
} ) ( t3jQuery );