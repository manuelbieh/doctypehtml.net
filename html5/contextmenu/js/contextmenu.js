(function() {

if ('contextMenu' in document.body && 'HTMLMenuItemElement' in window) {
	document.documentElement.classList.add('contextmenu');
} else {
	return;
}

var counter = document.createElement('span');
counter.id = 'counter';
counter.className = 'hide';
document.body.appendChild(counter);

counter.addEventListener('click', function(ev) {
	this.className = 'hide';
}, false);

var	wordcountmenus = document.querySelectorAll('.wordcount'),
	i = wordcountmenus.length;

while (i--) {
	wordcountmenus[i].addEventListener('click', function(ev) {
		var text = document.getSelection(),
		count = text.toString().split(/\s/).length;
		counter.innerHTML = count + ' words';
		counter.className = '';
	}, false);
}

document.body.addEventListener('contextmenu', function(ev) {
	counter.style.left = ev.pageX + 'px';
	counter.style.top = ev.pageY + 'px';
	counter.className = 'hide';
}, false);

document.querySelector('#interactive').addEventListener('contextmenu', function(ev) {
	this.querySelector('.wordcount').disabled =
	document.getSelection().isCollapsed;  
}, false);

}());

function rotate() {
	document.querySelector('#menudemo').classList.toggle('rotate'); 
}

function resize() {   
	document.querySelector('#menudemo').classList.toggle('resize'); 
}