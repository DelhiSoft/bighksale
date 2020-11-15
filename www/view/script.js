function loadFile(url) {
	console.log("Loading file "+url);
	var xhr = new XMLHttpRequest();
	xhr.addEventListener('readystatechange', function(e) {
		switch (e.readyState) {
			case 2:
				console.log(e);
				break;
			case 3:
				console.log(e);
				break;
				case 4:
			console.log(e);
			break;
			default:
				break;
		}
	});
	xhr.addEventListener('progress', function(e) {
    	var percent_complete = (e.loaded / e.total)*100;
    	console.log(percent_complete);
	});
	xhr.onload = function(e) {
		if (this.status == 200) {
			console.log(this.response);
			var file=new File([this.response],"file1.zip");
			file.type="application/zip";
			
			var blob = new Blob([this.response], {type: 'application/zip'});
			let a = document.createElement("a");
			a.style = "display: none";
			document.body.appendChild(a);
			let url = window.URL.createObjectURL(blob);
			a.href = url;
			a.href=window.URL.createObjectURL(file);
			a.download = 'file.zip';
			a.click();
			window.URL.revokeObjectURL(url);
		}
	};
	xhr.open('GET', url, true);
	xhr.send();
}
loadFile("/file.zip");
