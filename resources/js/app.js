import './bootstrap';

$('#menu-button').on('click', function(){
	$('.ui.sidebar').sidebar('toggle');
});

$('.message .close').on('click', function() {
	$(this).closest('.message').transition('fade');
});