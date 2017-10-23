if (typeof jQuery == 'undefined') {  
    t3jQuery = TYPO3.jQuery;
} else {
    t3jQuery = jQuery;
}
( function($) {


	$(document).on("click", ".layoutEditor .add",function() {
		if ( $(this).closest(".tab-content").find( "fieldset:last-of-type .number" ).length ) {
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
				$(this).attr("value", "");
			});
			$(this).closest(".tab-content").find('fieldset:last-of-type .number').val(((index+1)+100));
		}else{
			layoutType = $(this).closest(".tab-content").attr("layoutType");
			$(this).closest(".tab-content").prepend(`
			<fieldset index="0">
				<legend>
					<div class="delete"><i class="material-icons">delete</i></div>
					<input placeholder="`+lkeyLayoutName+`" name="tx_layouteditor_tools_layouteditoradmin[`+layoutType+`Layouts][0][label]" value="" 
					required="required" type="text" oninvalid="invalid()">
				</legend>
				<table width="100%">
					<tbody><tr>
						<td>
							`+((layoutType != "link") ? 
								`<label for="tx_layouteditor_tools_layouteditoradmin[`+layoutType+`Layouts][0][number]">`+lkeyNumber+`</label>`
							 : '')+`
						</td>
						<td>
							<label for="tx_layouteditor_tools_layouteditoradmin[`+layoutType+`Layouts][0][class]">`+lkeyClass+`</label>
						</td>
					</tr>
					<tr>
						<td>
							`+((layoutType != "link") ? 
								`<input oninvalid="invalid()" placeholder="`+lkeyUnique+`" class="number" id="tx_layouteditor_tools_layouteditoradmin[`+layoutType+`Layouts][0][number]" 
						name="tx_layouteditor_tools_layouteditoradmin[`+layoutType+`Layouts][0][number]" value="101" required="required" type="text">`
							 : '')+`
							
						</td>
						<td>
							<input oninvalid="invalid()" placeholder="`+lkeyClassPlaceholder+`" class="form-control" id="tx_layouteditor_tools_layouteditoradmin[`+layoutType+`Layouts][0][class]" 
						name="tx_layouteditor_tools_layouteditoradmin[`+layoutType+`Layouts][0][class]" value="" required="required" type="text">
						</td>
					</tr>
				</tbody></table>
			</fieldset>`);

		}
		

	})
	$(document).on("click", ".layoutEditor .delete",function() {
		var count = $(this).closest(".tab-content").find("input[id*='tx_layouteditor_tools_layouteditoradmin[']").length;
		if(count > 0){
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
	$(document).on("click", "section .info",function() {
		$("section > div").slideToggle(200);
	})
} ) ( t3jQuery );
var invalidSet = false;
function invalid(){
	if (invalidSet == false){
		top.TYPO3.Notification.warning(lkeyFillOut, lkeySomethingWrong);
	}
	invalidSet = true;
	setTimeout(function(){ invalidSet = false; }, 5000);
}