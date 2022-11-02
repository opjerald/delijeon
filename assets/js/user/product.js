$(document).ready(function () {
	$(document).on("submit", "#add-to-cart-form", function (e) {
		e.preventDefault();
		$.post($(this).attr("action"), $(this).serialize(), function (res) {
			if (res.add_count === true) {
				$(".cart_count").text(parseInt($(".cart_count").text()) + 1);
			}
			$("#input-quantity").val(1);
			$.toast({
				heading: res.is_success ? "Success" : "Error",
				text: res.message,
				icon: res.is_success ? "success" : "error",
				showHideTransition: "slide",
				position: "top-right",
				hideAfter: 5000,
				bgColor: "#1a1a1a",
				textColor: "#ffffff",
				loaderBg: "#ec6a76",
			});
		});
	});

	/***************************** */
	$(".minus").click(function () {
		let quantity = $(`#input-quantity`).val();

		if (quantity > 1) {
			quantity--;
		}
		$(`#input-quantity`).val(quantity);
	});

	$(".add").click(function () {
		let quantity = $(`#input-quantity`).val();

		if (quantity < parseInt($(`.total_quantity`).text())) {
			quantity++;
		}
		$(`#input-quantity`).val(quantity);
	});
	$("#input-quantity").change(function () {
		let quantity = $(this).val();
		let remaining_quantity = parseInt($(`.total_quantity`).text());

		if (quantity > remaining_quantity) {
			$(this).val(remaining_quantity);
			$.toast({
				heading: "Error",
				text: "The inputted quantity exceeded the remaining quantity.",
				icon: "error",
				showHideTransition: "slide",
				position: "top-right",
				hideAfter: 5000,
				bgColor: "#1a1a1a",
				textColor: "#ffffff",
				loaderBg: "#ec6a76",
			});
		}
	});

	$(".image").click(function () {
		$("#main").attr("src", $(this).attr("src"));
	});
});
