$(document).ready(function () {
	$(document).on("submit", "#remove-product-form", function (e) {
		e.preventDefault();
		const form = $(this);
		let id = $(this).siblings("input").val();
		let total_price = $(`.product_total_price_${id}`).text();

		$.post($(this).attr("action"), $(this).serialize(), function (res) {
			if (res.is_success === true) {
				$(".cart_count").text(parseInt($(".cart_count").text()) - 1);
				form.parent().remove();
				$(".total_price").text(
					parseInt($(".total_price").text()) - parseInt(total_price)
				);

				if ($(".products").children().length == 2) {
					$(".footer").remove();
					$(".total_price").text(0);
				}
			}
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

	/********************************** */
	$(".minus").click(function () {
		let id = $(this).attr("data-id");
		let quantity = $(`#${id}-input-quantity`).val();

		if (quantity > 1) {
			quantity--;
		}
		updateTotal(id, quantity);
		checkChanges(id, quantity);
		$(`#${id}-input-quantity`).val(quantity);
	});

	$(".add").click(function () {
		let id = $(this).attr("data-id");
		let quantity = $(`#${id}-input-quantity`).val();

		if (quantity < parseInt($(`.total_quantity_${id}`).text().split(" ")[2])) {
			quantity++;
		}
		updateTotal(id, quantity);
		checkChanges(id, quantity);
		$(`#${id}-input-quantity`).val(quantity);
	});

	$(".qty").change(function () {
		let id = $(this).attr("data-id");
		let quantity = $(this).val();
		let initital_quantity = $(this).attr("data-init-quantity");
		let remaining_quantity = parseInt(
			$(`.total_quantity_${id}`).text().split(" ")[2]
		);
		if (quantity > remaining_quantity) {
			$(this).val(initital_quantity);
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
		} else {
			checkChanges(id, quantity);
		}
	});

	$(".btn-update").click(function () {
		let products = $(".product");
		for (let i = 0; i < products.length; i++) {
			let id = $(products[i]).children("input").val();
			let quantity = $(`#${id}-input-quantity`).val();
			updateProductQuantity(id, quantity, function () {
				$(`#${id}-input-quantity`).attr("data-init-quantity", quantity);
				$(`#${id}-input-quantity`).removeAttr("style");
			});
		}

		$.toast({
			heading: "Success",
			text: "Cart successfully updated",
			icon: "success",
			showHideTransition: "slide",
			position: "top-right",
			hideAfter: 5000,
			bgColor: "#1a1a1a",
			textColor: "#ffffff",
			loaderBg: "#ec6a76",
		});
	});

	/*********************************** */

	function updateProductQuantity(
		cart_id = "",
		quantity = 0,
		callback = () => {}
	) {
		$.get(
			"carts/update_product_quantity?cart_id=" +
				cart_id +
				"&quantity=" +
				quantity,
			function (res) {
				if (res.is_success === true) {
					callback();
				}
			}
		);
	}

	function updateTotal(id, quantity) {
		const product_price = $(`.product_price_${id}`);
		const product_total_price = $(`.product_total_price_${id}`);

		product_total_price.text(parseInt(product_price.text()) * quantity);

		let full_total_price = 0;
		for (let i = 0; i < $(".total_product_price").length; i++) {
			full_total_price += parseInt($($(".total_product_price")[i]).text());
		}
		$(".total_price").text(full_total_price);
	}

	function checkChanges(id, quantity) {
		let initital_quantity = $(`#${id}-input-quantity`).attr(
			"data-init-quantity"
		);
		if (quantity != initital_quantity) {
			$(`#${id}-input-quantity`).css("border", "1px solid #ec6a76");
		} else {
			$(`#${id}-input-quantity`).removeAttr("style");
		}
	}
});
