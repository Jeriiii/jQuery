/**
 * JQuery Plugin zajišťující rezervační systém. Rezervační systém se dá použít na libovolnou rezervaci
 * např. kina nebo tenisového kurtu. Pomocí změny defaultních proněných jdou navolit své vlastní funkce
 * při práci s myší a obrázky které plugin využívá (jako je třeba sedačka).
 * 
 * @author Petr Kukrál
 * @param $ slouží ke kompatibilitě mezi zásuvnými moduly a knihovnami
 */

;(function($) {

/* nastavění uživatele doplněné o defaultní nastavení */
var opts;

/**
 * Nejdříve načte nastavení uživatele a doplní je o defaultní nastavení. Poté zjistí v jakém je vstup formátu. Jestli
 * se jedná o formát xls, tak si ho převede na cvs. Z cvs se rozdělí skupiny (řádky) do pole array_series. Jednotlivé
 * skupiny se pak ještě rozdělí podle elementů a uloží do dvourozměrného pole array_series_elements. Z pole se
 * pak načítají jednotlivé skupiny a elementy. Při načtení každé skupiny se v cyklu vytvoří nový box na elementy
 * funkcí createSerie. Do tohoto boxu se pak elementy vkládají. Když element obsahuje první znak "[", je
 * vyhodnocen jako popisek řady. Ten se vytvoří pomocí funkce createMarkRowsOfElements Vše ostatní bude
 * vyhodnoceno jako normální element. Ten se vytvoří pomocí funkce createElement. Ta vrací počítadlo sedadel.
 * Je to z toho důvodu, že v této funkci se zjišťuje, jestli jde o platný element (např. sedačka) nebo neplatný (např.
 * ulička - ta se nepočítá). Nakonec se načtou všechny zarezervovaná místa a na všechny elementy kde to má smysl
 * (např. na sedačky které nejsou zarezervované) se navážou události.
 * 
 * @name booking_system
 * @param options Nastavení uživatele.
 * @example
 *  $(document).ready(function () {
 *	$("#cinema").booking_system({
 *		format: "xls",
 *		input: $(".xls").text()
 *	});
 * });
 */

$.fn.booking_system = function(options){
	/* doplneni nevyplnenych nastaveni o deafultni nastaveni */
	var opts = $.extend({}, $.fn.booking_system.defaults, options);
	
	setOpts(opts);
	
	var cvs;
	if(opts.format == "xls")
		cvs = cvsFromXls(opts.input);
	else
		cvs = opts.input;
	
	/* pole obsahující jednotlivé skupiny elementů, např. řady v kině */
	var array_series = arrayFromString(cvs);

	/* dvourozměrné pole obsahující jako první rozměr skupiny elementů a jako druhý elemnty ve skupinách */
	var array_series_elements = [];
	$.each(array_series, function(index){
		array_series_elements[index] = array_series[index].split(",");
	});

	var serie_counter = 1;
	$.each(array_series_elements, function(index2, value){
		var element_counter = 1;
		serie_counter = createSerie($, serie_counter);
		
		$.each(value, function(index1, value){
			
			if(value.charAt(0) == "[")
			{
				createMarkRowsOfElements($, value);
			}else{
				element_counter = createElement($, value, index1, index2, element_counter);
			
				//element_counter = createElement($, value, opts.name_class_element, opts. name_class_without_element, index1, index2, element_counter, opts.img_element, opts.img_double_element);
			}
		});
	});
	$('body').append("<div style='clear:both'></div>");
	
	loadReservedElement();

	$('.sedadlo[class!=reserved], .sedadlo_2[class!=reserved]')
	.click(
		opts.mouse_up_data,
		opts.mouse_up
	)
	.click(
		selected
	)
	.mouseover(
		opts.mouse_over_data,
		opts.mouse_over
	)
	.mouseout(
		opts.mouse_out_data,
		opts.mouse_out
	);
};

/**
 * Doplnění hodnot které zadal uživatel o defaultní hodnoty.
 */
$.fn.booking_system.defaults = {
	/* formát vstupu */
	format: "cvs",
	/* vstup */
	input: "1,1,1,2,;,1,1,1,1;,,2,, ;",
	/* název třídy elementu pro css */
	name_class_element: "sedadlo",
	/* název třídy elementu pro prázdné místo pro css */
	name_class_without_element: "vynechane_misto",
	/* funkce která se spustí po přejetí myši přes element */
	mouse_over: mouseOverDefault,
	/* data pro funkci která se spustí po přejetí myši přes element */
	mouse_over_data: {},
	/* funkce která se spustí po klepnutí myši na element */
	mouse_up: mouseUpDefault,
	/* data pro funkci která se spustí po klepnutí myši na element */
	mouse_up_data: {},
	/* funkce která se spustí po opuštění myší element */
	mouse_out: mouseOutDefault,
	/* data pro funkci která se spustí po opuštění myší element */
	mouse_out_data: {},
	/* obrázek elementu */
	img_element: "images/cervene_jednosedadlo.png",
	/* obrázek dvojelementu např. dvojsedačky */
	img_double_element: "images/cervene_dvojsedadlo.png",
	/* obrázek rezervovaného elementu */
	img_reserved: "images/sede_jednosedadlo.png",
	/* obrázek rezervovaného dvojelementu např. dvojsedačky */
	img_double_reserved: "images/sede_jednosedadlo.png",
	/* obrázek vybraného elementu */
	img_selected: "images/zelene_jednosedadlo.png",
	/* obrázek vybraného dvojelementu např. dvojsedačky */
	img_double_selected: "images/zelene_dvojsedadlo.png"
};

/**
 * Setter pro opts.
 * 
 * @name setOpts
 * @param opts Nastavení uživatele doplněné o defaultní nastavení.
 */

function setOpts(opts) {
	this.opts = opts;
}

/**
 * Getter pro opts.
 * 
 * @name getOpts
 * @return Nastavení uživatele doplněné o defaultní nastavení.
 */

function getOpts() {
	return this.opts;
}

/**
 * Načte elementy li z objektu reserved. Ten obsahuje zaregistrované elementy. Podle těch pak vyhledá elementy,
 * které jsou rezervované a označí je atributem reserved, který znemožní další rezervaci na tento element. Také
 * mu změní obrázek na rezervovaný element.
 * 
 * @name loadReservedElement
 */

function loadReservedElement() {
	$("#reserved li")
		.each(function(index, element) {
			var id = $(this).html();
			var reservedElement = $("#" + id);
			reservedElement	
				.attr("class", "reserved");
			reservedElement
				.children()
				.attr("src", "images/sede_jednosedadlo.png")
		});
}

/**
 * Rozhoduje, jestli element je nebo není vybraný. Jestli ano, tak zavolá funkci pro jeho odstranění z vybraných
 * elementů. Jestli vybraný není, zavolá funkci pro vybrání elementu.
 * 
 * @name selected
 * @param e Element na kterém funkce probíhá.
 */

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

/**
 * Vybere daný element. Nejdříve údaje o elemntu tedy řadu (skupinu) a pořadové číslo vygeneruje do formuláře
 * jako skrytý prvek (slouží pro odeslání vybraných prvků). Poté přidá prvku třídu selected a změní na vybraný
 * obrázek.
 * 
 * @name addToSelected
 * @param e Element na kterém funkce probíhá.
 */

function addToSelected(e) {
	var element_series = $(e.target)
					.parent()
					.attr("id")
					.split("_");
	$("#selected form")
		.append("<input \n\
			id=form" + element_series[0] + "_"  + element_series[1] +  "\n\
			type='hidden' name='" + element_series[0] + "_" + element_series[1] + "' \n\
			value='" + element_series[0] + "_" + element_series[1] + "' \n\
		\>");
	
	var element = $(e.target);
	var parent_element = element
						.parent();
	parent_element
		.addClass("selected");

	/* kontrola jedná li se o jedno či dvoj element - např. dvojsedačka */
	var opts = getOpts();
	var type_element = parent_element
					.attr("class")
					.split("_");
					
	/* ověřuje, jestli element obsahuje "_CISLO" tedy jde o dvojelement */
	if("1" in type_element) {
		element
			.attr("src", opts.img_double_selected);
	}else{
		element
			.attr("src", opts.img_selected);
	}
}

/**
 * Odstraní element z vybraných elementů. Ostraní u elementu třídu selected a odstraní element z formuláře
 * vybraných elementů. Poté vrátí elementu původní obrázek.
 * 
 * @name removeFromSelected
 * @param e Element na kterém funkce probíhá.
 */

function removeFromSelected(e) {
	var element = $(e.target);
	var parentElement = element.parent();
	parentElement
		.removeClass("selected");
	var id = parentElement
			.attr("id");
	$("#form" + id)
		.remove();
	var opts = getOpts();
	var type_element = parentElement
					.attr("class")
					.split("_");
	if("1" in type_element) {
		element
			.attr("src", opts.img_double_element);
	}else{
		element
			.attr("src", opts.img_element);
	}
	
}

/**
 * Defaultní funkce která se zavolá po najetí myši na element. Tato funkce jde jednoduše překrýt v opts.
 * 
 * @name mouseOverDefault
 * @param e Element na kterém funkce probíhá.
 */

function mouseOverDefault(e) {
	$(e.target)
		.stop(true)
		.animate({opacity: 0}, 500);
}

/**
 * Defaultní funkce která se zavolá po klepnutí myší na element. Tato funkce jde jednoduše překrýt v opts.
 * 
 * @name mouseUpDefault
 * @param e Element na kterém funkce probíhá.
 */

function mouseUpDefault(e) {

}

/**
 * Defaultní funkce která se zavolá po opuštění myší element. Tato funkce jde jednoduše překrýt v opts.
 * 
 * @name mouseOutDefault
 * @param e Element na kterém funkce probíhá.
 */

function mouseOutDefault(e) {
	$(e.target)
		.stop(true)
		.animate({opacity: 1}, 200);
}

/*
 * Vytváří element. Nejdřív rozhodne, jedná-li se o prázdné místo, element nebo
 * dvojelement, popř. prázdný prvek a poté udělá příslušnou akci. U prázdného
 * místa vytvoří toto prázdné místo přičemž ho nezahrne do číslování elementů.
 * Při vytvoření elementu či dvojelementu ho vytvoří a zahrne tento element do
 * číslování. Při prázdném prveku tento prvek přeskočí a nezahrne ho do číslování.
 * 
 * 
 * value - jednosedacka ci dvojsedacka nebo mezera
 **/
function createElement($, value, index1, index2, indexElement) {
	var opts = this.opts;
	
	if(value == "-"){
		$('.ctverec:last').append("<div id=" + index1 + "_" + index2 +  " class='" + opts.name_class_without_element + "'></div>");
		--indexElement;
	}else if(value == 1){
		$('.ctverec:last').append("<div class='box_element'><div id=" + index1 + "_" + index2 +  " class='" + opts.name_class_element + "'><img src=" + opts.img_element + "\></div>" + indexElement + "</div>");
	}else if(value == 2){
		$('.ctverec:last').append("<div class='box_duble_element'><div id=" + index1 + "_" + index2 +  " class='" + opts.name_class_element + "_" + value + "'><img src=" + opts.img_double_element + "\></div>" + indexElement + "</div>");
	}else if(value == 0 || value == ""){
		--indexElement;
	}
	return ++indexElement;
}

function createSerie($, counter) {
	$('#cinema').append("<div id='serie_" + counter  + "' class='ctverec'></div>");
	return ++counter;
}

function createMarkRowsOfElements($, value) {
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