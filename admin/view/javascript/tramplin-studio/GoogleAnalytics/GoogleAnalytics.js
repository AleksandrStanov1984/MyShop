/*
	Tramplin Studio - development of modules for OpenCart
	Google Analytics v1.0
*/
$(function() {
	
	if (token) {
		var token_var = token;
		var token_var_name = 'token';
	} else {
		var token_var = user_token;
		var token_var_name = 'user_token';
	}
	
	var goals_page = 1;
	
	getGoalsList(goals_page);
	
	
	// Goal Add Modal
	$(document).on('click', '.goal_add', function () {
		
		$('#modal-goal .modal-title').html( modal_goal_text.title_add );
		$('#modal-goal .modal-footer button').html( modal_goal_text.button_add );
		$('#modal-goal #goal_submit').data( 'goal-action', 'Add' );
		$('#modal-goal #goal_submit').data( 'goal-id', '' );
		$('#modal-goal #goal_action').val( '' );
		$('#modal-goal #goal_label').val( '' );
		$('#modal-goal #goal_category').val( '' );
		$('#modal-goal #goal_element').val( '' );
		$('#modal-goal #goal_event').val( 'click' );
		$('#modal-goal #goal_value').val( '' );
		
		$('#modal-goal').modal('show');
		return false;
	});
	
	
	// Goal Edit Modal
	$(document).on('click', '.goal_edit', function () {
		
		var goal = $(this).closest('.goal_data');
		
		$('#modal-goal .modal-title').html( modal_goal_text.title_edit );
		$('#modal-goal .modal-footer button').html( modal_goal_text.button_edit );
		$('#modal-goal #goal_submit').data( 'goal-action', 'Edit' );
		$('#modal-goal #goal_submit').data( 'goal-id', goal.data('goal-id') );
		$('#modal-goal #goal_action').val( goal.data('action') );
		$('#modal-goal #goal_label').val( goal.data('label') );
		$('#modal-goal #goal_category').val( goal.data('category') );
		$('#modal-goal #goal_element').val( goal.data('element') );
		$('#modal-goal #goal_event').val( goal.data('event') );
		$('#modal-goal #goal_value').val( goal.data('value') );
		
		$('#modal-goal').modal('show');
		return false;
	});
	
	
	// Goal Add or Edit
	$(document).on('click', '#goal_submit', function () {
		
		var goal_action = $(this).data('goal-action');
		var goal_id = $(this).data('goal-id');
		var goal_data = '';
		
		goal_data += ' "goal_action": "' + goal_action + '",';
		$('#modal-goal').find('input[type="text"], select').each(function() {
			goal_data += ' "' + $(this).attr('name') + '": "' + $(this).val().replace(new RegExp('\"','g'), '\'') + '",';
		});
		
		goal_data = goal_data.substr(0, goal_data.length - 1);
		goal_data = '{' + goal_data + '}';
		goal_data = JSON.parse(goal_data);
		goal_data = JSON.stringify(goal_data);
		//console.log( goal_data );
		
		$('#goalsList').css('opacity', '0.7');
		
		$.ajax({
			url: 'index.php?route=extension/analytics/ts_google_analytics/goal' + goal_action + '&' + token_var_name + '=' + token_var + '&goal_id=' + goal_id,
			method: 'post',
			dataType: 'json',
			data: {data: goal_data},
			cache: false,
			success: function(json) {
				//console.log(json);
				if (json.error) {
					getError('#modal-goal', json.error, true);
				} else {
					getSuccess('#goalsList', json.success);
					$('#modal-goal').modal('hide');
				}
				
				getGoalsList(goals_page);
			}
		});
		
		return false;
	});
	
	
	// Goal Delete
	$(document).on('click', '.goal_delete', function () {
		
		var goal_id = $(this).closest('.goal_data').data('goal-id');
		
		$('#goalsList').css('opacity', '0.7');
		
		$.ajax({
			url: 'index.php?route=extension/analytics/ts_google_analytics/goalDelete&' + token_var_name + '=' + token_var + '&goal_id=' + goal_id,
			method: 'post',
			dataType: 'json',
			data: {data: ''},
			cache: false,
			success: function(json) {
				//console.log(json);
				if (json.error) {
					getError('#goalsList', json.error);
					$('#modal-goal').modal('hide');
				} else {
					getSuccess('#goalsList', json.success);
					$('#modal-goal').modal('hide');
					
					goals_page = json.pages;
				}
				
				getGoalsList(goals_page);
			}
		});
		
		return false;
	});
	
	
	// Goals Pagination
	$(document).on('click', '#goalsList .pagination a', function () {
		
		goals_page = $(this).data('page');
		
		$('#goalsList').css('opacity', '0.7');
		
		getGoalsList(goals_page);
		
		return false;
	});
	
	
	
	$('#modal-goal').on('hidden.bs.modal', function (e) {
		$(this).find('.modal-body').find('.alert-danger').remove();
	});
	
	$(document).on('click', '#tab-goals .copy-to-clipboard', function () {
		var action = $(this).closest('.goal_data').data('action');
		copyTextToClipboard(action);
		return false;
	});
	
	$(document).on('click', '#tab-userParams .copy-to-clipboard', function () {
		var copy = $(this).data('copy');
		copyTextToClipboard(copy);
		return false;
	});
	
	
	
	
	
	
	
	function getGoalsList(page) {
		$.ajax({
			url: 'index.php?route=extension/analytics/ts_google_analytics/goals&' + token_var_name + '=' + token_var + '&page=' + page,
			method: 'post',
			dataType: 'html',
			data: {data: ''},
			cache: false,
			success: function(html) {
				//fix tooltip
				$('.goal_add').tooltip('destroy');
				$('.goal_edit').tooltip('destroy');
				$('.goal_delete').tooltip('destroy');
				
				$('#goalsList').html(html);
				$('#goalsList').css('opacity', '1');
			}
		});
	}

	function getError(el, error, modal = false) {
		var html = '';
		html += '<div class="alert alert-danger" role="alert">';
		  html += '<span class="fa fa-exclamation-circle"></span>';
		  html += '&nbsp;' + error;
		  html += '<button type="button" class="close" data-dismiss="alert">&times;</button>';
		html += '</div>';
		
		if (modal) {
			$(el).find('.modal-body').find('.alert-danger').remove();
			$(el).find('.modal-body').prepend(html);
		} else {
			$(el).prev('.alert-danger').remove();
			$(el).before(html);
		}
	}

	function getSuccess(el, success) {
		var html = '';
		html += '<div class="alert alert-success" role="alert">';
		  html += '<span class="fa fa-check-circle"></span>';
		  html += '&nbsp;' + success;
		  html += '<button type="button" class="close" data-dismiss="alert">&times;</button>';
		html += '</div>';
		
		$(el).prev('.alert-success').remove();
		$(el).before(html);
	}

	function copyTextToClipboard(text) {
		if (navigator.clipboard) {
			navigator.clipboard.writeText(text);
		} else {
			var textArea = document.createElement("textarea");
			textArea.value = text;
			document.body.appendChild(textArea);
			textArea.select();
			document.execCommand('copy');
			document.body.removeChild(textArea);
		}
	}
});