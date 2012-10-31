$(document).ready(function () {
	$("#cinema").cinema({
		format: "xls",
		input: $(".xls").text()
		//mouse_up: mouseUp,
		//mouse_over: mouseOver
	});
});

//function mouseUp(e) {
//	
//}

//function mouseOver(e) {
//	
//}

////$(document).ready(function () {
//	// array_one je jednorozmerne pole s radky
//	var array_one = $(".xls").text().split(';')
////	$.each(array_one, function(index, value){
////		alert(value);
////	});
//	// array_two je dourozmerne pole, prvni rozmer radky a druhy rozmer prvky
//	var array_two = [];
//	$.each(array_one, function(index, value){
//		array_two[index] = array_one[index].split(",");
//	});
//	alert(array_one.length);
////	$.each(array_two, function(index, value){
////		$.each(value, function(index, value){
////			alert(value);
////		});
////	});
//	$.each(array_two, function(index, value){
//		$('body').append("<div class='ctverec'>ctverec</div>");
//		alert(value.length);
//		$.each(value, function(index, value){
//			if(value == 0) // vynechane misto - bez sedadla
//			{
//				$('.ctverec:last').append("<div class='vynechane_misto'></div>");;
//			}
//			else // sedadlo
//			{
//				$('.ctverec:last').append("<div class='sedadlo'>" + value + "</div>");
//			}
//		});
//		$('body').append("<div style='clear:both'></div>");
//	});
//});
//$(document).ready(function (){
//	$('#animate').click(function () {
//		$('.box').slideToggle();
//	});
//});
//$(document).ready(function (){
//	$('#animate').click(function () {
//		var $box = $('.box');
//		if($box.is(':visible')) {
//			$box.fadeOut('slow');
//		}else{
//			$box.fadeIn('fast');
//		}
//	});
//});
//$(document).ready(function (){
//	$('#animate').click(function () {
//		$('.box').animate({
//			opacity:  'toggle',
//			height: 'toggle'
//		}, 'slow');
//	});
//});
//$(document).ready(function (){
//	$('#animate').click(function () {
//		var $box = $('#revealUp');
//		if ($box.height() > 0) {
//			$box.animate({height: 0});
//		} else {
//			$box.animate({height: '100%'});
//		}
//	});
//});
//$(document).ready(function () {
//  $('#animate').click(function () {
//    $('.box').animate({scrollTop: '+=100'},
//      { duration: 400, easing: 'easeOutElastic' });
//  });
//});
