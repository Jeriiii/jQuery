$.fn.horizontalAccordion = function (speed) {
	return this.each(function () {
		var $accordionHeaders = $(this).find('h3'),
			$open = $accordionHeaders.next().filter(':first'),
			width = $open.outerWidth();
			
			// nastavi vlastnost display
			
			$accordionHeaders.next().filter(':not(:first)').css({display: 'none', width: 0});
			
			$accordionHeaders.click(function () {
				if ($open.prev().get(0) == this) {
					return;
				}
				$open.animate({width: 0}, {duration: speed});
				$open = $(this).next().animate({width: width}, {duration: speed});
			});
		});
};

$(document).ready(function () {
	$('#accordionWrapper').horizontalAccordion(200)
});