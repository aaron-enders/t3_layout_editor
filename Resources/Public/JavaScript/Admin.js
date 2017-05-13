if (typeof jQuery == 'undefined') {  
    t3jQuery = TYPO3.jQuery;
} else {
    t3jQuery = jQuery;
}
( function($) {
	$(document).on("click", ".layoutEditor .add",function() {
		var index_str = $(this).closest(".tab-content").find("fieldset:last-of-type .number").attr("name");
		var index_start_pos = index_str.indexOf('Layouts][') + 9;
		var index_end_pos = index_str.indexOf(']',index_start_pos);
		var index = parseInt(index_str.substring(index_start_pos,index_end_pos)) + 1;
		var ele = $(this).closest(".tab-content").find('fieldset:last-of-type').clone(true);
		$(this).closest(".tab-content").find('fieldset:last-of-type').after(ele);
		$(this).closest(".tab-content").find("fieldset:last-of-type input[type='text']").each(function( e ) {
			var newName_str = $(this).attr("name");
			newName_str = newName_str.replace(/\Layouts\]\[(.+?)\]/,"Layouts]["+index+"]");
			$(this).attr("name", newName_str);
			$(this).attr("id", newName_str);
		});
		$(this).closest(".tab-content").find('fieldset:last-of-type .number').val(((index)+100));

	})
	$(document).on("click", ".layoutEditor .delete",function() {
		var count = $(this).closest(".tab-content").find("input[id*='tx_layouteditor_tools_layouteditoradmin[']").length;
		if(count > 2){
			if (confirm("Are you sure?") == true) {
				var ele = $('.layoutEditor fieldset:last-of-type').clone(true);
				$(this).closest("fieldset").remove();
			    return true;
			  } else {
			    return false;
			  }
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