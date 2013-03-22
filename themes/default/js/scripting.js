$(function(){
	$('#head_buttons #preview').click(function(){
		$.post(Canvas.BASE + 'canvas/preview.php', {
			'contents': $('textarea[name=contents]').val()
		}, function(Q){
			$('#preview_post').show().html(Q);
		});
	});

	$('textarea').autosize();
});