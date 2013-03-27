$(function(){
	$('#head_buttons #preview').click(function(){
		$.post(Canvas.BASE + 'canvas/preview.php', {
			'contents': $('textarea[name=contents]').val()
		}, function(Q){
			$('#preview_post').show().html(Q);
		});
	});

	$('textarea').expand({
		parent: '.wrap'
	});

	$('*[title]').tipsy({gravity: 's'});


	$('#reveal').click(function(){
		var that = $(this);

		$('input[name$="password"]').attr('type', (function(){
			if($(that).is(':checked')){
				return 'text';
			}
			else{
				return 'password';
			}
		})());
	});
});