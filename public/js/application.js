$(function() {
	$(document).ready(function() {
		$('#newfolder').on('click', function() {
			$('#newfolder').attr('disabled', 'disabled');
			$('#upload').attr('disabled', 'disabled');
			
			$('#newfolderform').css('display', 'inline-block');
		});

		$('#upload').on('click', function() {
			$('#uploadstatus').css('display', 'inline-block');
			$('#fileuploader').trigger('click');
		});

		$('#fileuploader').on('change', function() {
			$('#uploadbtn').css('display', 'inline-block');
		});
	});
});
