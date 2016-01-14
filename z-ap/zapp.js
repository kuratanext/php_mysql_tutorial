$(function() {

	$(".update").click(function() {
		$(".code").val($(this).parents("tr").children().first().text());
		$(".hidform").prop("action", "bupdate.php").submit();
	});

	$(".delete").click(function() {
		$(".code").val($(this).parents("tr").children().first().text());
		$(".hidform").prop("action", "bdelete.php").submit();
	});

});