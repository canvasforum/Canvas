$(function(){
	$('#head_buttons #preview').click(function(){
		$.post(Canvas.BASE + 'canvas/preview.php', {
			'contents': $('textarea[name=contents]').val()
		}, function(Q){
			$('#preview_post').show().html(Q);
		});
	});

	$('textarea').css('box-sizing', 'border-box').bind('input keyup', function(){
		var ele = $(this)[0];
		var sh = ele.scrollHeight;

		var tb = parseInt(window.getComputedStyle(ele, null).getPropertyValue('border-top-width'));
		var bb = parseInt(window.getComputedStyle(ele, null).getPropertyValue('border-bottom-width'));

		$(this).css('height', sh + tb + bb + 'px');
		$(window).scrollTop($(this).parents('.wrap').position().top + $(this).parents('.wrap').height());
	});

	$('*[title]').tipsy({gravity: 's'});
});