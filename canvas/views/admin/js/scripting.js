$(function(){
	function updateForumOrder(e, u){
		var list = {};

		$('.category').each(function(){
			var category = $(this).attr('id');
			list[category] = [$(this).index() + 1, []];

			$(this).find('.forum').each(function(){
				list[category][1].push($(this).attr('id').split('-')[1]);
			});
		});

		var json = JSON.stringify(list);

		$.post(Canvas.BASE + 'forums', {
			list: json
		}, function(Q){
			console.log('reordered');
		});
	}

	$('#notepad').submit(function(e){
		e.preventDefault();

		var form = $(this);

		form.find('.progress').css('opacity', '1.0').addClass('icon-spinner').addClass('icon-spin');

		$.post(form.attr('action'), form.serialize(), function(Q){
			form.find('.progress').removeClass('icon-spinner').removeClass('icon-spin').text('Successfully updated.');
		});
	})

	$('textarea').expand({
		parent: '#main'
	});

	$('.category').sortable({
		axis: 'y',
		items: ' > .forum',
		connectWith: '.category',
		stop: updateForumOrder,
		handle: '.reorder'
	}).disableSelection();

	$('#categories').sortable({
		axis: 'y',
		stop: updateForumOrder,
		handle: '.reorder'
	}).disableSelection();
});