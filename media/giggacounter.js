$(document).ready(function()
{
	// Hide initially
	$('#form-group-date').hide();

	// COUNT FOR radio selection
	$('input[type=radio][name=counter]').change(
		function() 
		{ 
			if ($('#count_date').prop('checked'))
			{
				$('#form-group-date').show('fast');
			}
			else
			{
				$('#form-group-date').hide('fast');
			}
		}
	);
});