$(function() {

	$('.dnd li a').bind('click', function() {
		return false;
	});

	$.each($('.dnd li a'), function(key, el) {

		el.setAttribute('draggable', 'true');

		addEvent(el, 'dragstart', function(e) {
			e.dataTransfer.effectAllowed = 'copy';
			e.dataTransfer.setData('Text', $(this).parent().attr('id'));
		});

	});

	$.each($('.dnd'), function(key, el) {

		addEvent(el, 'dragenter', function (e) {
			$(this).addClass('dragover');
			return false;
		});

		addEvent(el, 'dragover', function(e) {
			e.preventDefault();
			$(this).addClass('dragover');
			e.dataTransfer.dropEffect = 'copy';
			return false;
		});

		addEvent(el, 'dragleave', function(e) {
			$(this).removeClass('dragover');
		});

		addEvent(el, 'drop', function(e) {
			e.preventDefault();
			$('#' + e.dataTransfer.getData('Text')).appendTo($(this));
			$(this).removeClass('dragover');
		});

	});

});