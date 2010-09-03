$(function() {
	$('a.ajaxme').live('click', function() {
		var url = this.href;
		$('<div>')
			.load(url)
			.dialog();
		return false;
	});
	
	$('a.ajax-delete').live('click', function() {
		var url = this.href + '.json';
		var self = this;
		$.ajax({
			url : url,
			success : function(response) {
				var message = $(response.message)
				$('#content').prepend(message);
				$(self).closest('tr').remove();
			},
			dataType: 'json'
		});
		return false;
	})
})