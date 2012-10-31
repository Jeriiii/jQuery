;(function($) {

$.fn.cinema = function(options){
	// doplneni nevyplnenych nastaveni o deafultni nastaveni
	var opts = $.extend({}, $.fn.cinema.defaults, options);
	// array_one je jednorozmerne pole s radky
	
	if(opts.format == "xls")
		var cvs = cvsFromXls(opts.input);
	else
		var cvs = opts.input;
	
	var array_one = arrayFromString(cvs);

	// array_two je dourozmerne pole, prvni rozmer radky a druhy rozmer prvky
	var array_two = [];
	$.each(array_one, function(index, value){
		array_two[index] = array_one[index].split(",");
	});

	var serie_counter = 1;
	$.each(array_two, function(index2, value){
		var indexSeat = 1;
		serie_counter = createSerie($, serie_counter);
		
		$.each(value, function(index1, value){
			
			if(value.charAt(0) == "[")
			{
				/* znacka rady */
				createMarkRowsOfSeats($, value);
			}else{
				indexSeat = createSeat($, value, opts.name_class_seat, opts. name_class_without_seat, index1, index2, indexSeat, opts.img_seat, opts.img_duble_seat);
			}
		});
		
		$('body').append("<div style='clear:both'></div>");
	});
	
	loadReservedSeat($);

	//$("cinema").find("#id");

	$('.sedadlo[rel!=reserved], .sedadlo_2[rel!=reserved]')
	.click(
		opts.mouse_up_data,
		opts.mouse_up
	)
	.mouseover(
		opts.mouse_over_data,
		opts.mouse_over
	)
	.mouseout(
		opts.mouse_out_data,
		opts.mouse_out
	);
	/* oznaceni */
	//var sedadlo = $('.sedadlo[rel!=reserved], .sedadlo_2[rel!=reserved]').children();
	$('.sedadlo[rel!=reserved], .sedadlo_2[rel!=reserved]').click(
		selected
	);
};

$.fn.cinema.defaults = {
	format: "cvs",
	input: "1,1,1,2,;,1,1,1,1;,,2,, ;",
	name_class_seat: "sedadlo",
	name_class_without_seat: "vynechane_misto",
	/* prejeti mysi */
	mouse_over: mouseOverDefault,
	mouse_over_data: {},
	/* klepnuti mysi */
	mouse_up: mouseUpDefault,
	mouse_up_data: {},
	/* opusteni myss element */
	mouse_out: mouseOutDefault,
	mouse_out_data: {},
	/* obrazek sedadla */
	img_seat: "images/cervene_jednosedadlo.png",
	img_duble_seat: "images/cervene_dvojsedadlo.png",
	img_reserved: "images/sede_jednosedadlo.png",
	img_selected: "images/zelene_jednosedadlo.png"
};

function loadReservedSeat($) {
	$("#reserved li")
		.each(function(index, element) {
			var id = $(this).html();
			var reservedElement = $("#" + id);
			reservedElement	
				.attr("rel", "reserved");
			reservedElement
				.children()
				.attr("src", "images/sede_jednosedadlo.png")
		});
}

function selected(e){
	
	var hClass = $(e.target)
			.parent()
			.hasClass("selected");
	if(hClass){
		removeFromSelected(e);
	}else{
		addToSelected(e);
	}
}

function addToSelected(e) {
	var seat_series = $(e.target)
					.parent()
					.attr("id")
					.split("_");
	$("#selected form")
		.append("<input \n\
			id=form" + seat_series[0] + "_"  + seat_series[1] +  "\n\
			type='hidden' name='" + seat_series[0] + "_" + seat_series[1] + "' \n\
			value='" + seat_series[0] + "_" + seat_series[1] + "' \n\
		\>");
	
	var element = $(e.target);
	element
		.parent()
		.addClass("selected");
	element
		.attr("src", "images/zelene_jednosedadlo.png");
}

//function addToSelected(e) {
//	var seat_series = $(e.target)
//					.attr("id")
//					.split("_");
//	$("#selected form")
//		.append("<input \n\
//			id=form//" + seat_series[0] + "_"  + seat_series[1] +  "\n\
//			type='hidden' name='//" + seat_series[0] + "' \n\
//			value='//" + seat_series[1] + "' \n\
//		\>//");
//	
//	$(e.target)
//		.addClass("selected");
//}

function removeFromSelected(e) {
	var element = $(e.target);
	var parentElement = element.parent();
	parentElement
		.removeClass("selected");
	var id = parentElement
			.attr("id");
	$("#form" + id)
		.remove();
	element
		.attr("src", "images/cervene_jednosedadlo.png");
	
}

function mouseOverDefault(e) {
	$(e.target)
		.stop(true)
		.animate({opacity: 0}, 500);
}

function mouseUpDefault(e) {

}

function mouseOutDefault(e) {
	$(e.target)
		.stop(true)
		.animate({opacity: 1}, 200);
}

/*
 * switch zlobil
 * img zlobil
 * 
 * value - jednosedacka ci dvojsedacka nebo mezera
 **/
function createSeat($, value, seat, without_seat, index1, index2, indexSeat, img_seat, img_duble_seat) {
	if(value == "-"){
		$('.ctverec:last').append("<div id=" + index1 + "_" + index2 +  " class='" + without_seat + "'></div>");
		--indexSeat;
	}else if(value == 1){
		$('.ctverec:last').append("<div class='box_seat'><div id=" + index1 + "_" + index2 +  " class='" + seat + "'><img src=" + img_seat + "\></div>" + indexSeat + "</div>");
	}else if(value == 2){
		$('.ctverec:last').append("<div class='box_duble_seat'><div id=" + index1 + "_" + index2 +  " class='" + seat + "_" + value + "'><img src=" + img_duble_seat + "\></div>" + indexSeat + "</div>");
	}else if(value == 0 || value == ""){
		--indexSeat;
	}
	return ++indexSeat;
}

function createSerie($, counter) {
	$('#cinema').append("<div id='serie_" + counter  + "' class='ctverec'></div>");
	return ++counter;
}

function createMarkRowsOfSeats($, value) {
	value = value.substring(1, value.length - 1);
	$('.ctverec:last').append("<div class='serie_name'>" + value + "</div>");
}

function arrayFromString(string) {
	var newArray = $.trim(string).split(';');
	$.each(newArray, function(index, value){
		newArray[index] = $.trim(value);
	});
	return newArray;
	
}

function cvsFromXls(string) {
	return $.trim(string)
			.replace(/\t/g, ",")
			.replace(/\n/g, ";");
	
}

})(jQuery);