let category_id = "";
let pageNum = 1;

$(document).ready(function () {
	getProducts(1);

	$(document).on("click", ".categories > li > a", function () {
		category_id = $(this).attr("data-id");
		let categorName = $(this).text().split("(")[0];
		$(".category-name").text(categorName);

		$("#search-form > input").val("");

		getProducts(1, category_id);
		return false;
	});

	$(document).on("click", ".pagination .page", function () {
		pageNum = $(this).text();
		getProducts(pageNum, category_id);
		return false;
	});

	$(document).on("click", ".next-page", function () {
		if (pageNum + 1 >= document.querySelectorAll(".page").length + 1) {
			return false;
		}
		pageNum += 1;
		getProducts(pageNum, category_id);
		return false;
	});

	$(document).on("click", ".prev-page", function () {
		if (pageNum > 1) {
			pageNum -= 1;
		}
		getProducts(pageNum, category_id);
		return false;
	});

	$(document).on("submit", "#search-form", function (e) {
		e.preventDefault();
		pageNum = 1;
		getProducts(pageNum, category_id);
		return false;
	});

	$(document).on("submit", "#add-to-cart-form", function (e) {
		e.preventDefault();
		$.post($(this).attr("action"), $(this).serialize(), function (res) {
			if (res.add_count === true) {
				$(".cart_count").text(parseInt($(".cart_count").text()) + 1);
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

	/************************** */
	$("#search-form > input").change(function (e) {
		$("#search-form").submit();
	});

	$("#item-per-page").change(function () {
		$("#search-form").submit();
	});

	$("#select-order").change(function () {
		$("#search-form").submit();
	});

	function getProducts(page = 1, category = "") {
		$.get(
			`products/index_html?page=${page}&category=${category}&${$(
				"#search-form"
			).serialize()}&${$("#paginate-number-form").serialize()}&${$(
				"#order-form"
			).serialize()}`,
			function (res) {
				$(".items").html(res);
			}
		);
	}
});
