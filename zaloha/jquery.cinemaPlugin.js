;(function($) {
	
$.fn.cinema = function(options){
	// doplneni nevyplnenych nastaveni o deafultni nastaveni
	var opts = $.extend({}, $.fn.cinema.defaults, options);
	// array_one je jednorozmerne pole s radky
	var array_one = arrayFromString(opts.cvs);

	// array_two je dourozmerne pole, prvni rozmer radky a druhy rozmer prvky
	var array_two = [];
	$.each(array_one, function(index, value){
		array_two[index] = array_one[index].split(",");
	});

	$.each(array_two, function(index2, value){
		var indexSeat = 1;
		$.each(value, function(index1, value){
			if(value.charAt(0) == "[")
			{
				/* øada v kinì */
				createSerie($, value);
			}else{
				indexSeat = createSeat($, value, opts.name_class_seat, opts. name_class_without_seat, index1, index2, indexSeat);
			}
		});
		
		$('body').append("<div style='clear:both'></div>");
	});
	$(".sedadlo").bind("mouseover", function() {
		//alert("test");
		//mouseOverDefault(this);
	});

	$('.sedadlo')
	.click(
		opts.mouse_up_data,
		opts.mouse_up
	)
	.mouseover(
		opts.mouse_over_data,
		opts.mouse_over
	);
};

$.fn.cinema.defaults = {
	cvs: "1,1,1,2,;,1,1,1,1;,,2,, ;",
	name_class_seat: "sedadlo",
	name_class_without_seat: "vynechane_misto",
	/* pøejetí myši */
	mouse_over: mouseOverDefault,
	mouse_over_data: {},
	/* klepnutí myši */
	mouse_up: mouseUpDefault,
	mouse_up_data: {}
};

function mouseOverDefault(e) {
	alert("mack - mouse over");
	$(e.target).stop(true).animate({opacity: 0.5}, 1000);
}

function mouseUpDefault(e) {
	alert("mack - mouse up");
	$(e.target).stop(true).animate({opacity: 1}, 1000);
}

/*
 * switch zlobil
 **/
function createSeat($, value, seat, without_seat, index1, index2, indexSeat) {
	if(value == 0){
		$('.ctverec:last').append("<div id=" + index1 + "_" + index2 +  " class='" + without_seat + "'></div>");
		--indexSeat;
	}else if(value == 1){
		$('.ctverec:last').append("<div id=" + index1 + "_" + index2 +  " class='" + seat + "'>" + indexSeat + "(" + value + ")" + "</div>");
	}else{
		$('.ctverec:last').append("<div id=" + index1 + "_" + index2 +  " class='" + seat + "_" + value + "'>" + indexSeat + "(" + value + ")" + "</div>");
	}
	return ++indexSeat;
}

function createSerie($, value) {
	value = value.substring(1, value.length - 1);
	$('#cinema').append("<div class='ctverec'><div class='serie_name'>" + value + "</div></div>");
}

function arrayFromString(string) {
	var newArray = string.substring(0, string.length - 1).split(';');
	$.each(newArray, function(index, value){
		newArray[index] = $.trim(value);
	});
	return newArray;
	
}

})(jQuery);