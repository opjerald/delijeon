pageNum = 1;

$(document).ready(function () {
	getOrders(1);

	$(document).on("submit", "#filters_form", function (e) {
		e.preventDefault();
		getOrders(pageNum);
	});

	$(document).on("submit", ".update_status_form", function (e) {
		e.preventDefault();
		$.post($(this).attr("action"), $(this).serialize(), function (res) {
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

	/************************* */

	$(document).on("click", ".page", function () {
		pageNum = $(this).text();
		getOrders(pageNum);
		return false;
	});

	$(document).on("click", ".next-page", function () {
		if (pageNum + 1 >= document.querySelectorAll(".page").length + 1) {
			return false;
		}
		pageNum += 1;
		getOrders(pageNum);
		return false;
	});

	$(document).on("click", ".prev-page", function () {
		if (pageNum > 1) {
			pageNum -= 1;
		}
		getOrders(pageNum);
		return false;
	});

	/************************* */

	$(document).on("change", ".update_status_form", function () {
		$(this).submit();
		return false;
	});

	$("#filters_form .search__field").change(function () {
		$("#filters_form").submit();
	});

	$("#filters_form select").change(function () {
		$("#filters_form").submit();
	});

	/************************* */

	function getOrders(page = 1) {
		$.get(
			`http://delijeon.ph/orders/index_html?page=${page}&${$(
				"#filters_form"
			).serialize()}`,
			function (res) {
				$(".orders").html(res);
			}
		);
	}
});
