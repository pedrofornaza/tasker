function makeHiddenForm(formName) {
	var form = document.querySelector('.'+formName+'-form');
		form.style.display = 'none';


	var showButton = document.querySelector('.show-'+formName+'-form');
		showButton.onclick = function() {
			form.style.display = 'block';
		}

	var hideButton = document.querySelector('.hide-'+formName+'-form');
		hideButton.onclick = function() {
			form.style.display = 'none';
		}
}