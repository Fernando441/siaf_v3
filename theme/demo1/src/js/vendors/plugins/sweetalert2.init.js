"use strict";

const sx = swal.mixin({
	width: 400,
	heightAuto: false,
	padding: '2.5rem',
	buttonsStyling: false,
	confirmButtonClass: 'btn btn-success',
	cancelButtonClass: 'btn btn-secondary',
	confirmButtonColor: "#73ab17",
	cancelButtonColor: "#cc0c73",
});

window.Swal = sx;