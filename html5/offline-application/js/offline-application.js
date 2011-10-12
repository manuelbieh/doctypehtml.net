
	window.addEventListener('online', function() {
		$('.offline').hide();
		$('.online').show();
	}, false);

	window.addEventListener('offline', function() {
		$('.online').hide();
		$('.offline').show();
	}, false);

	$(function() {

		if(navigator.onLine == true) {
			$('.offline').hide();
		} else {
			$('.online').hide();
		}

		$('#buy').bind('click', function() {
			$('#viewTickets').hide();
			$('#buyForm').fadeIn();
		});

		$('#save').bind('click', function() {

			if($('#name').val() == '') {
				alert('Please enter your name.');
				return;
			}

			if($('#amount').val() == '') {
				alert('Please select how many tickets you want to buy.');
				return;
			}

			var tickets = localStorage.getItem('tickets');

			if(!!tickets == false) {
				tickets = [];
			} else {
				tickets = JSON.parse(tickets);
			}

			var ticket = JSON.stringify({name: $('#name').val(), amount: $('#amount').val(), timestamp: new Date()});
			tickets.push(ticket);

			localStorage.setItem('tickets', JSON.stringify(tickets));

			alert('Your order has been saved. You can watch your Tickets everytime by clicking "View my Tickets". (Even when you\'re offline! :) )');
			$('.popup').fadeOut();

		});

		$('#cancel').bind('click', function() {

			var cancel = confirm('Do you really want to cancel your order?');
			if(cancel == true) {
				$('#name').val('');
				$('#amount').val('1');
				$('#buyForm').fadeOut();
			}

		});

		$('#view').bind('click', function() {

			$('#buyForm').hide();

			var tickets = localStorage.getItem('tickets');

			if(!!tickets == false) {

				$('#myTickets').text('You didnt purchase any tickets yet!');

			} else {

				tickets = JSON.parse(tickets);
				var content = '<ul>';
				$.each(tickets, function(key, value) {
					value = JSON.parse(value);
					content += '<li>';
					content += value['amount'] + ' ticket(s) bought by ';
					content += value['name'] + ' on ';
					content += value['timestamp'];
					content += '</li>';
				});
				content += '</ul>';
				$('#myTickets').html(content);

			}

			$('#viewTickets').fadeIn();

		});

		$('#delete').bind('click', function() {
			localStorage.clear();
		});

		$('.close').bind('click', function() {
			$('.popup').fadeOut();
		});

	});