let pageNum = 1;

$(document).ready(function () {
	/********************** */

	$(".img_sets").sortable({
		revert: true,
	});

	const add_form = $("#add_form").validate({
		rules: {
			name: "required",
			description: "required",
			category: "required",
			"files[]": "required",
			price: {
				required: true,
				number: true,
			},
			quantity: {
				required: true,
				number: true,
			},
		},
	});

	/********************** */

	getProducts(1);

	$(document).on("submit", "#search_form", function () {
		getProducts(pageNum);
		return false;
	});

	$(document).on("click", "#add_form button", function (e) {
		e.preventDefault();
		if (add_form.form()) {
			$("#add_form").submit();
		}
	});

	$(document).on("click", ".delete", function () {
		if (!confirm("Are you sure?")) {
			return false;
		}
	});

	$(document).on("click", ".page", function () {
		pageNum = $(this).text();
		getProducts(pageNum);
		return false;
	});

	$(document).on("click", ".next-page", function () {
		if (pageNum + 1 >= document.querySelectorAll(".page").length + 1) {
			return false;
		}
		pageNum += 1;
		getProducts(pageNum);
		return false;
	});

	$(document).on("click", ".prev-page", function () {
		if (pageNum > 1) {
			pageNum -= 1;
		}
		getProducts(pageNum);
		return false;
	});

	$(document).on("change", "#search", function () {
		$("#search_form").submit();
	});

	$(document).on("change", "#chk_main", function () {
		let name = $(this).parent().parent().siblings(".img").children("p").text();
		if ($("input:checked").length > 0) {
			$("input[type='checkbox']:not(:checked)").attr("disabled", "disabled");
			$("input[name='main']").val(name);
		} else {
			$("input[type='checkbox']:not(:checked)").removeAttr("disabled");
			$("input[name='main']").val("");
		}
	});

	$(document).on("click", ".trigger, .close-button", function () {
		$(".modal").toggleClass("show-modal");
	});

	$(".dropdown .input").click(function () {
		$(this).siblings(".options").toggleClass("show");
	});

	$(".option").click(function () {
		let value = $(this).children(".value").text();
		let id = $(this).children(".value").attr("data-value");
		$('input[name="category_id"').val(id);
		$(".dropdown_input").val(value);
		$(".dropdown_input").click();
	});

	$(".actions .bi-trash3").click(function () {
		$(this).parent().parent().remove();
	});

	$(".option").hover(
		function () {
			$(this).children(".actions").addClass("show");
		},
		function () {
			$(this).children(".actions").removeClass("show");
		}
	);

	$(document).on("change", "#img_upload", function () {
		readURL(this);
	});

	function getProducts(page = 1) {
		$.get(
			`http://delijeon.ph/products/index_html?page=${page}&${$(
				"#search_form"
			).serialize()}`,
			function (res) {
				$(".products").html(res);
			}
		);
	}

	function readURL(input) {
		$(".img_sets").html("");
		if (!input.files || !input.files[0]) {
			return false;
		} else if ($(".img_card").length + input.files.length > 5) {
			alert("Only four (4) images in total are allowed to be upload.");
			return false;
		}

		const reader = new FileReader();
		let onLoadCounter = 0;

		reader.addEventListener("load", function (e) {
			const html_img_card = `<div class="img_card">
					<i class="bi bi-grip-horizontal"></i>
					<div class="img">
						<img src="${e.target.result}" alt="${input.files[onLoadCounter].name}" class="tbl-image">
						<p>${input.files[onLoadCounter].name}</p>
					</div>
					<div class="action">
						<i class="bi bi-trash-fill remove"></i>
						<label><input type="checkbox" id="chk_main"> Main</label>
					</div>
				</div>`;
			onLoadCounter++;
			$(".img_sets").prepend(html_img_card);
		});

		reader.readAsDataURL(input.files[0]);

		let counter = 1;
		reader.onloadend = function (e) {
			if (counter < input.files.length) {
				reader.readAsDataURL(input.files[counter]);
				counter++;
			}
		};
	}
});
