$(document).ready(function() {
	$("#item__enc").change(function () {
    calcTotal($("#item__qty"), $(this), $("#item__enc-total"));
	});
	$("#item__cost").change(function () {
    calcTotal($("#item__qty"), $(this), $("#item__cost-total"));
	});
	$("#item__qty").change(function () {
		calcTotal($("#item__enc"), $(this), $("#item__enc-total"));
    calcTotal($("#item__cost"), $(this), $("#item__cost-total"));
	});

	$('#myModal').on('shown.bs.modal', function() {
	  $('#myInput').trigger('focus')
	})
});

function calcTotal(firstField, secondField, totalField) {
	let qty = firstField.val();
	let enc = secondField.val();
	let total = Math.floor(enc * qty);
	$(totalField).html(total);
}
