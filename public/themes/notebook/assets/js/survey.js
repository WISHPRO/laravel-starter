$(function(){
	
	$(".datepicker-input").each(function(){ $(this).datepicker();});

	$('#delay').click(function() {
		// $('#delay-date').val();
		// $('#delay-reason').val();
		$('#delay-box').toggle();
		var chk = $(this).prop('checked');
		// console.log(chk);
		if(chk == true) {
			var tf = confirm('Are you sure want to mark this project as delay?\nAll existing survey feedback for this project will be discarded.');
			if(tf) {
				$('#remark').val('');
				$('input[name *= questions]').each(function() {
					$(this).prop('checked', false);
				});
			}
		}

	});

});