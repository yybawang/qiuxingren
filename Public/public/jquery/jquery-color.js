
 /**
 *  jQuery Color Animations
 * @author ������ͷ
 * Դ�ԣ�jQuery UI    jquery.effects.core.js
 * ����http://www.css88.com/archives/4090
 */

;(function(jQuery){

	// ������ɫ��ʽ
	jQuery.each(['backgroundColor', 'borderBottomColor', 'borderLeftColor', 'borderRightColor', 'borderTopColor', 'color', 'outlineColor'], function(i,attr){
		jQuery.fx.step[attr] = function(fx){
			if ( fx.state == 0 ) {
				fx.start = getColor( fx.elem, attr );
				fx.end = getRGB( fx.end );
			}

			fx.elem.style[attr] = "rgb(" + [
				Math.max(Math.min( parseInt((fx.pos * (fx.end[0] - fx.start[0])) + fx.start[0]), 255), 0),
				Math.max(Math.min( parseInt((fx.pos * (fx.end[1] - fx.start[1])) + fx.start[1]), 255), 0),
				Math.max(Math.min( parseInt((fx.pos * (fx.end[2] - fx.start[2])) + fx.start[2]), 255), 0)
			].join(",") + ")";
		}
	});

	// Color Conversion functions from highlightFade
	// By Blair Mitchelmore
	// http://jquery.offput.ca/highlightFade/
    //һ��JavaScript ���飬���а��� 0��255֮����������֣� (ie [255,255,255]).
    //An RGB 'function call syntax' string. either interger or percentage float form. (ie rgb(255,255,255) or rgb(100%,100%,100%))
    //An RGB hex value. Either short or long form. (ie #FFF or #FFFFFF)
    //A W3C standard colour name string as defined at W3Schools. (ie 'white', 'blue', 'red', 'black', et. al)

	// Parse strings looking for color tuples [255,255,255]
	function getRGB(color) {
		var result;

		// һ��JavaScript ���飬���а��� 0��255֮����������֣����磺 [255,255,255]
		if ( color && color.constructor == Array && color.length == 3 )
			return color;

		// Look for rgb(num,num,num)
		if (result = /rgb\(\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*\)/.exec(color))
			return [parseInt(result[1]), parseInt(result[2]), parseInt(result[3])];

		// Look for rgb(num%,num%,num%)
		if (result = /rgb\(\s*([0-9]+(?:\.[0-9]+)?)\%\s*,\s*([0-9]+(?:\.[0-9]+)?)\%\s*,\s*([0-9]+(?:\.[0-9]+)?)\%\s*\)/.exec(color))
			return [parseFloat(result[1])