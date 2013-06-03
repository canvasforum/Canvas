$(function(){
	$('#notepad').submit(function(e){
		e.preventDefault();

		var form = $(this);

		form.find('.progress').css('opacity', '1.0').addClass('icon-spinner').addClass('icon-spin');

		$.post(form.attr('action'), form.serialize(), function(Q){
			form.find('.progress').removeClass('icon-spinner').removeClass('icon-spin').text('Successfully updated.');
		});
	})
});