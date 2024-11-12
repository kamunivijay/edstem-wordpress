jQuery(document).ready(function ($) {
	$("#product-category-filter").on("change", function () {
		const category = $(this).val();
		const price = $("#price-range").val();

		filterProducts(category, price);
	});

	$("#price-range").on("input", function () {
		const price = $(this).val();
		$("#price-range-value").text("$" + price);

		const category = $("#product-category-filter").val();
		filterProducts(category, price);
	});

	function filterProducts(category, price) {
		$("#product-grid-container").html(`
            <div class="skeleton-loader">
                <div class="skeleton-card">
                    <div class="skeleton-image"></div>
                    <div class="skeleton-title"></div>
                    <div class="skeleton-category"></div>
                    <div class="skeleton-price"></div>
                </div>
                <div class="skeleton-card">
                    <div class="skeleton-image"></div>
                    <div class="skeleton-title"></div>
                    <div class="skeleton-category"></div>
                    <div class="skeleton-price"></div>
                </div>
                <div class="skeleton-card">
                    <div class="skeleton-image"></div>
                    <div class="skeleton-title"></div>
                    <div class="skeleton-category"></div>
                    <div class="skeleton-price"></div>
                </div>
            </div>
        `);

		$.ajax({
			url: productFilter.ajax_url,
			type: "POST",
			data: {
				action: "filter_products",
				category: category,
				price: price,
			},
			success: function (response) {
				$("#product-grid-container").html(response);
			},
		});
	}
	
	
	
});


jQuery(document).ready(function ($) {
	$(".quickview").on("click", function (e) {
		e.preventDefault();

		var productId = $(this).data("product-id");

		$.ajax({
			url: productFilter.ajax_url,
			type: "POST",
			data: {
				action: "fetch_product_details",
				product_id: productId,
			},
			success: function (response) {
				$("#quick-view-content").html(response);
				$("#quick-view-modal").fadeIn();
			},
		});
	});

	// Close the modal
	$("#close-quick-view, .quick-view-backdrop").on("click", function () {
		$("#quick-view-modal").fadeOut();
	});
});

 