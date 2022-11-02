$(document).ready(function () {
	const nav = $("nav")[0];
	if (nav != undefined) {
		let navTop = nav.offsetTop;

		$(window).scroll(function () {
			if (window.scrollY > navTop) {
				nav.classList.add("fixed");
			} else {
				nav.classList.remove("fixed");
			}
		});
	}

	$("#form-signup").validate({
		rules: {
			first_name: "required",
			last_name: "required",
			email: {
				required: this,
				email: true,
			},
			password: {
				required: true,
				minlength: 8,
			},
			confirm_password: {
				required: true,
				equalTo: "#password",
			},
		},
	});

	$("#form-signin").validate({
		rules: {
			email: {
				required: true,
				email: true,
			},
			password: "required",
		},
	});
});
