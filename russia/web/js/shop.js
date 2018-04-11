;
(function($) {
	"use strict";
	// Price Filter
	var priceinterval = setInterval(function woopricefilter() {
		var price_filter = jQuery('.price-filter');
		var price_filter_wrap = jQuery('.price_filter_wrap');
		var price_from = price_filter.find('span.from').text();
		var price_to = price_filter.find('span.to').text();

		price_filter_wrap.find('.ui-slider-handle').first().attr('data-width', price_from);
		price_filter_wrap.find('.ui-slider-handle').last().attr('data-width-r', price_to);
	}, 100);


	jQuery(document).ready(function() {
		// Price Filter
		jQuery('#filter_price').selectbox();
		var slider_range = jQuery("#slider-range");
		slider_range.slider({
			range: true,
			min: 0,
			max: 350,
			values: [ 50, 190 ],
			slide: function( event, ui ) {
				jQuery( ".price-filter" ).html( '<span class="from">$&nbsp;' + ui.values[ 0 ] + '</span> - <span class="to">$&nbsp;' + ui.values[ 1 ] + '</span>' );
			}
		});
		jQuery( ".price-filter" ).html( '<span class="from">$&nbsp;' + slider_range.slider( "values", 0 ) + '</span> - <span class="to">$&nbsp;' + slider_range.slider( "values", 1 ) + '</span>' );

		// Product Item Preview
		jQuery('.product_thumbs li a').on("click", function(){
			jQuery('.product_thumbs li a').removeClass("current");
			jQuery(this).addClass("current");
			jQuery('#largeImage').attr('src',jQuery(this).find('img').attr('src').replace('product_thumb','product_large'));
			jQuery('#zoom_product').attr('href',jQuery(this).find('img').attr('src').replace('product_thumb','product_large'));
			return false;
		});
	});
})(jQuery);