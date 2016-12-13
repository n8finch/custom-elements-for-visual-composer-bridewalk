(function ($) {
	$(document).ready(function () {
		// console.log('document is ready');

		$('.checkbox-with-text-checklist').on('click', function() {
			var self = $(this);
			var child = $(this)
			var user_meta_key_checked = self.attr('data-user-checklist');
			//First, send the ajax
			jQuery.ajax({
				url : checklist_ajax_object.ajax_url,
				type : 'post',
				data : {
					action : 'checklist_item_check_uncheck',
					checklist_item: user_meta_key_checked,
				},
				success : function( response ) {
					console.log(response);
				}
			});

			//Then change the classes
			var isChecked = self.hasClass('checked');
			var checkedElems = $('span.checked');
			var uncheckedElems = $('span.unchecked');
			console.log(checkedElems);

				if(isChecked) {

		      var backgroundColor = "#fff";
		      var borderColor = "#46B1BB";

					self.removeClass('checked').addClass('unchecked');
					self.css({'background-color': backgroundColor, 'border-color': borderColor});
					self.children().css('color', '#46B1BB');

					self.mouseleave(function() {
						self.css({'background-color': backgroundColor, 'border-color': borderColor});
						self.children().css('color', '#46B1BB');
					});

				} else {

					var backgroundColor = "#e37171";
		      var borderColor = "#e37171";

					self.removeClass('unchecked').addClass('checked');
					self.css('background-color', backgroundColor).css('border-color', borderColor);
					self.children().css('color', '#fff');

					self.mouseleave(function() {
						self.css('background-color', backgroundColor).css('border-color', borderColor);
						self.children().css('color', '#fff');
					});

				}

		});

	});

	// console.log('front end js loaded');
})(jQuery);
