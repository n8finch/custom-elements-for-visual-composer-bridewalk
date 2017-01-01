(function ($) {
	$(document).ready(function () {

		/*
		 * Adding functionality for Making Checklists as complete
		 *
		 */
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

		});// end checklist ajax function


		/*
		 * Adding functionality for marking vendors as booked
		 *
		 */

		 $('.marked_booked').on('click', function(e) {
			e.preventDefault();
 			var user_meta_key_booked = $(this).attr('data-mark-as-booked');
			var innerHTML = $(this).html();

 			//First, send the ajax
 			jQuery.ajax({
 				url : checklist_ajax_object.ajax_url,
 				type : 'post',
 				data : {
 					action : 'mark_as_booked_vendors',
 					booked_item: user_meta_key_booked,
 				},
 				success : function( response ) {
 					console.log(response);
 				}
			}); //end ajax

			//Toggle booking css
			$(this).toggleClass('marked_booked_booked');
			if( 'Booked' === innerHTML ) {
				$(this).html('Mark as Booked');
			} else {
				$(this).html('Booked');
			};

			//trigger wishlist item if not booked
			var getSibs = $(this).parent().siblings();
			var isWishlisted = $(getSibs[0]).hasClass('eltd-added-to-wishlist');

			if ( !isWishlisted && !('Booked' === innerHTML) ) {
				$(getSibs[0]).trigger('click');
			}
		}); // marked book event listener

		$('a.eltd-listing-whislist').on('click', function() {

			var isSinglePage = $(this).parent(); //correct
			isSinglePage = $(isSinglePage[0]).hasClass('eltd-single-listing-wishlist');

			if ( isSinglePage ) {
				return;
			}

			var isWishlisted = $(this).hasClass('eltd-added-to-wishlist');
			if ( isWishlisted ) {
				var sibling = $(this).siblings('.eltd-listing-item-booked').children();
				var siblingInnerHTML = (sibling[0]).innerHTML;
				console.log(siblingInnerHTML);
				if ( 'Booked' === siblingInnerHTML) {
					$(sibling).trigger('click');
				}
			}


		});//end wishlist click, remove booking.


	}); // end document.ready();

	// console.log('front end js loaded');
})(jQuery);
