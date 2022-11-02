let inputs = [
	"first_name",
	"last_name",
	"address",
	"postal_code",
	"city",
	"region",
	"country",
];

$(document).ready(function () {
	// This function is for input validation
	const formPlaceOrder = $("#payment-form").validate({
		rules: {
			first_name_ship: "required",
			last_name_ship: "required",
			address_ship: "required",
			city_ship: "required",
			region_ship: "required",
			country: "required",
			postal_code_ship: {
				required: true,
				number: true,
			},
			first_name_bill: "required",
			last_name_bill: "required",
			address_bill: "required",
			city_bill: "required",
			region_bill: "required",
			country: "required",
			postal_code_bill: {
				required: true,
				number: true,
			},
			card: "required",
			code: {
				required: true,
				number: true,
			},
			month: {
				required: true,
				min: 1,
				max: 12,
			},
			year: {
				required: true,
				min: new Date().getFullYear() + 1,
			},
		},
	});

	/********************* */

	$(".rd-other-billing").click(function () {
		$($(".inputs")[1]).removeClass("hide");

		for (let i = 0; i < inputs.length; i++) {
			$(`#${inputs[i]}_bill`).val("");
		}
	});
	$(".rd-same-billing").click(function () {
		$($(".inputs")[1]).addClass("hide");

		for (let i = 0; i < inputs.length; i++) {
			$(`#${inputs[i]}_bill`).val($(`#${inputs[i]}_ship`).val());
		}
	});

	$("#btn-pay").click(function () {
		if (formPlaceOrder.form()) {
			generateToken();
		}
	});

	function generateToken() {
		const $stripeForm = $(".form-validation");
		$("form.form-validation").bind("submit", function (e) {
			if (!$stripeForm.data("cc-on-file")) {
				e.preventDefault();
				Stripe.setPublishableKey($stripeForm.data("stripe-publishable-key"));
				Stripe.createToken(
					{
						number: $(".card-number").val(),
						cvc: $(".card-cvc").val(),
						exp_month: $(".card-expiry-month").val(),
						exp_year: $(".card-expiry-year").val(),
					},
					stripeResponseHandler
				);
			}
		});
		function stripeResponseHandler(_, res) {
			if (res.error) {
				console.log(res.error.message);
			} else {
				var token = res["id"];
				$stripeForm.find("input[type=text]").empty();
				$stripeForm.append(
					"<input type='hidden' name='stripeToken' value='" + token + "'/>"
				);
				$stripeForm.get(0).submit();
			}
		}
	}
});
