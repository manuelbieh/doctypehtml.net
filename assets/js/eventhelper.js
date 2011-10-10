function addEvent(el, ev, fn) {
	if(document.addEventListener) {
		if(el && el.nodeName || el === window) {
			el.addEventListener(ev, fn, false);
		} else if(el.length > 0) {
			for(var i = 0; i < el.length; i++) {
				addNewEvent(el[i], ev, fn);
			}
		}
	} else {
		if(el && el.nodeName || el === window) {
			el.attachEvent('on' + ev, function() { return fn.call(el, window.event);});
		} else if(el.length > 0) {
			for(var i = 0; i < el.length; i++) {
				addNewEvent(el[i], ev, fn);
			}
		}
	}
}