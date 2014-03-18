var createForm = document.querySelector('.create-form');
	createForm.style.display = 'none';

var showCreateForm = document.querySelector('.show-create-form');
	showCreateForm.onclick = function() {
		createForm.style.display = 'block';
	}

var hideCreateForm = document.querySelector('.hide-create-form');
	hideCreateForm.onclick = function() {
		createForm.style.display = 'none';
	}