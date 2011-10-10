var exampleNotification;
var exampleNotificationHTML;

function requestPermission(callback) {
	window.webkitNotifications.requestPermission(callback);
}

function callback() {

	// 0 if permission was granted
	if(window.webkitNotifications.checkPermission() > 0) {

		requestPermission(callback);

	} else {

		// Check for presence to prevent opening of multiple notification windows
		if(!!exampleNotification == false) {

			exampleNotification = window.webkitNotifications.createNotification(
				"http://a2.twimg.com/profile_images/906885509/twpic_reasonably_small.jpg", 
				"Desktop Notification!", 
				'This is a sample notification. (Popup will be closed automatically after 10 seconds.)'
			);
			exampleNotification.show();

			setTimeout(function() {
			
				exampleNotification.cancel();

				setTimeout(function() {
					exampleNotification = '';
				}, 30);

			}, 10000);

		} else {

			alert('Notification is already open!');

		}

	}

}

function callbackHTML() {

	// 0 if permission was granted
	if(window.webkitNotifications.checkPermission() > 0) {

		requestPermission(callbackHTML);

	} else {

		// Check for presence to prevent opening of multiple notification windows
		if(!!exampleNotificationHTML == false) {

			exampleNotificationHTML = window.webkitNotifications.createHTMLNotification('http://doctypehtml.net/sites/doctypehtml.net/assets/htmlnotification.html');
			exampleNotificationHTML.show();

			setTimeout(function() {

				exampleNotificationHTML.cancel();

				setTimeout(function() {
					exampleNotificationHTML = '';
				}, 30);

			}, 10000);

		} else {

			alert('HTML Notification is already open!');

		}

	}

}

$(function() {

	if(!window.webkitNotifications) {

		$('#supported').hide();
		$('#nosupport').show();

	} else {

		$('#showNotification').bind('click', function() {
			requestPermission(callback);
		});

		$('#showNotificationHTML').bind('click', function() {
			requestPermission(callbackHTML);
		});

	}

});
