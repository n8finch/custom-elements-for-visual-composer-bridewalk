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










		/******************************************************************************************
		 * Budget Calculator section
		 *
		 ******************************************************************************************
		 */

		function budgetCalcAJAX(newBudget, currentLineItem) {
			//First, send the ajax
			jQuery.ajax({
				url : checklist_ajax_object.ajax_url,
				type : 'post',
				data : {
					action : 'update_budget_calculator_totals',
					budget_line_item: currentLineItem,
					budget_new_amout: newBudget,

				},
				success : function( response ) {
					console.log(response);
				}
			});
		}

		//Add up category totals and replace total spent
		function addTotalSpent() {
			var totalSpent = addSubCats();
			$('.spent_container').html('$' + totalSpent.toFixed(2));
		}//end addTotalSpent function


		//Add up subcategories
		function addSubCats(sumTotalCost) {
			var actualCost = $('.actual_cost');
			var totalCostArr = [];
			var sumTotalCost = 0;

			//Sum the values in an array, parameter in .reduce() function
			function sumArray(a, b) {
				return a + b;
			}

			$.each(actualCost, function(key, catTotalElem) {
				var subCostArr = [];
				var sumSubCats = 0;
				var subCatsObj = $(catTotalElem).parents('div.section.group.category').siblings();
				$.each(subCatsObj, function(key, value) {

					var subCost = $(value).find('.sub_cost').html().replace(/\$|,/g, '');
					subCost = parseFloat(subCost);
					subCostArr.push(subCost);

					sumSubCats = subCostArr.reduce(sumArray, 0);

				});

				//Replace the category total with the new sum
				$(catTotalElem).html('$' + sumSubCats.toFixed(2));

				totalCostArr.push(sumSubCats);

			});

			sumTotalCost = totalCostArr.reduce(sumArray, 0);

			return sumTotalCost;

		}; // end addSubCats function



		//Updateable container function
		function updatePrice(event) {
			var self = event.currentTarget;
			var currentBudget = $(self).html();
			var currentLineItem = $(self).data('lineItem');
			currentBudget = Number(currentBudget.replace(/(,[^\d]*)/, '').slice(1));
			//Create input form for new budget
			var html = '<input id="budget-input" type="text" name="" value="' + currentBudget + '"  /><i id="total_buget_pencil_icon" class="eltd-icon-linear-icon lnr lnr-pencil "></i>';
			$(self).html(html);

			//Get the input value
			$("#budget-input").focus().on('blur', function() {
				var newBudget = $(this).val();
				var length = newBudget.length;

				//TODO: ajax the newBudget here

				//TODO: regex or replace $ sign and commas for numbers


				$(self).html('$' + Number(newBudget).toFixed(2));

				budgetCalcAJAX(newBudget, currentLineItem);

				//Call functions for updating
				addSubCats();
				addTotalSpent();
			});



		}; //end updatePrice function


		//Change out Total Budget
		$('.budget_container').on('click', function(e) {
			updatePrice(e);
		});

		//Change out Sub Categories
		$('.sub_cost').on('click', function(e) {
			updatePrice(e);
		});

		//Initialize the budget calculator functions
		(function init() {
			addTotalSpent();
		})();


	}); // end document.ready();

})(jQuery);
