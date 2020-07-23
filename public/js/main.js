var itemEnc = 0;
$(document).ready(function() {
	// --------------------------------------
	// Modal
	$('#myModal').on('shown.bs.modal', function() {
		$('#myInput').trigger('focus')
	})

	// --------------------------------------
	// Item Calcs
	$("#item__enc").change(function() {
		updateTotal("enc");
	});
	$("#item__cost").change(function() {
		updateTotal("cost");
	});
	$("#item__qty").change(function() {
		let checked = $("#item__inc").is(':checked');
		if (checked) {
			updateTotal("enc", itemEnc);
		} else {
			updateTotal("enc");
		}
		updateTotal("cost");
	});

	$(".toggle-field").click(function() {
		let fieldName = $(this).parent().attr('for');
		toggleField("#" + fieldName);
	});

	$('#pack-wrap').on('click', $('#item__packed'), function() {
		let e = $('#item__packed');
		let encField = $('#item__enc');
		let checked = e.is(':checked');
		if (checked) {
			console.log(e.attr("id") + " Checked");
			itemEnc = 0.05;
			updateTotal('enc', itemEnc);
		} else {
			console.log(e.attr("id") + " Unchecked");
			itemEnc = 0.1;
			updateTotal('enc', itemEnc);
		}
	});

	$('#item__inc').click(function() {
		// Query for only the checked checkboxes and put the result in an array
		let checked = $(this).is(':checked');
		let packWrap = $('#pack-wrap');
		let encField = $('#item__enc');
		let encTotal = $('#item__enc_total');
		if (checked) {
			console.log('Checked');
			let packedBox = '<label for="item__packed" id="label_item__packed">Organised?</label><input type="checkbox" name="item__packed" id="item__packed" class="form-control" value="1">'
			packWrap.append(packedBox);
			packWrap.css('display', '');

			encField.prop("disabled", true);
			itemEnc = 0.1;
			updateTotal('enc', itemEnc);
		} else {
			console.log('Unchecked');
			packWrap.css('display', 'none');
			packWrap.empty();

			encField.prop("disabled", false);
			updateTotal('enc');
		}
	});

	$('#continueAction').click(function() {
		$.get('ajax/test.php', function(data) {
			$('.result').html(data);
		});
	});


	function loadItemAttrs(e) {
		var i = e.children("option:selected").val();
		// console.log(i);
		$('#item_row-attr2').load("/items/showAttr/" + i);
	}

	loadItemAttrs($('#item__type_id'));

	$('#item__type_id').change(function() {
		loadItemAttrs($(this));
	});

});




function updateTotal(n, v = 0) {
	if ($("#item__" + n + "_total_cust").val() == 0) {
		let f = $("#item__" + n);
		let totalField = $("#item__" + n + "_total");
		if (v === 0) {
			v = f.val();
		}
		let t = calcTotal(v);
		totalField.val(t);
	}
}

function calcTotal(v) {
	let q = $('#item__qty').val();
	let t = Math.floor(v * q);
	console.log(v + " x " + q + " = " + t);
	return t;
}

function toggleField(fieldName) {
	$(fieldName).prop("disabled", function(i, v) {
		return !v;
	});
	$(fieldName).toggleClass("cust-val");
	let custField = $(fieldName + "_cust");
	if ($(fieldName).hasClass("cust-val")) {
		custField.val(1);
	} else {
		custField.val(0);
		let calcField = fieldName.substring(0, fieldName.length - 11);
		updateTotal(calcField);
	}
}
