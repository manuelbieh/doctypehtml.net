$(document).ready(function() {

	$('#dropbox')[0].addEventListener('drop', function(e) {

		e.stopPropagation();
		e.preventDefault();

		file = new Filehandling();
		file.upload(e.dataTransfer.files[0]);

	}, false);

	$('#dropbox').bind('dragexit', function(e) {
		e.preventDefault();
		e.stopPropagation();
		$('#dropbox').removeClass('droppable');
	});
	$('#dropbox').bind('dragover', function(e) {
		e.preventDefault();
		e.stopPropagation();
	});
	$('#dropbox').bind('dragenter', function(e) {
		e.preventDefault();
		e.stopPropagation();
		$('#dropbox').addClass('droppable');
	});

});


function Filehandling() {

	this.upload = function(file) {

		var fileName = file.name; //Grab the file name
		var fileSize = file.size; //Grab the file size
		var fileType = file.type; //Grab the file type

		var	reader = new FileReader();
			reader.readAsBinaryString(file);

			reader.onload = function() {

			var boundary = "bndry";
			var savepath = "storage/sites/html5.manuelbieh.com/scripts/fileapi-save.php";

			var xhr = new XMLHttpRequest();

			xhr.upload.addEventListener('progress', function(e) {
				if(e.lengthComputable) {
					$('#progress span').css({width: (e.loaded / e.total)*100 + '%'});
				}
			}, false);

			xhr.upload.addEventListener('load', function(e) {
				$('#progress span').css({width: '100%'});
				alert('Upload successful!');
			}, false);

			xhr.open("POST", savepath, true);

			xhr.setRequestHeader("Content-Type", "multipart/form-data, boundary="+boundary);
			xhr.setRequestHeader("Content-Length", fileSize);
	 
			var body = "--" + boundary + "\r\n";
			body += "Content-Disposition: form-data; name='dropfile'; filename='" + fileName + "'\r\n";
			body += "Content-Type: " + fileType + "\r\n\r\n";
			body += reader.result + "\r\n";
			body += "--" + boundary + "--";

			if(!!xhr.sendAsBinary == false) {

				XMLHttpRequest.prototype.sendAsBinary = function(datastr) {
					var bb = new BlobBuilder();
					var data = new ArrayBuffer(datastr.length);
					var ui8a = new Uint8Array(data, 0);
					for (var i=0; i<datastr.length; i++) {
						ui8a[i] = (datastr.charCodeAt(i) & 0xff);
					}
					bb.append(data);
					var blob = bb.getBlob();
					this.send(blob);
				}

			}

			xhr.sendAsBinary(body);

		}

		return true;

	}

}
