document.addEventListener('DOMContentLoaded', function () {

	const heroSwiper = new Swiper('.hero-swiper', {
		loop: true,
		autoplay: {
			delay: 4000,
		},
		speed: 800,
		pagination: {
			el: '.swiper-pagination',
			clickable: true,
		},
		navigation: {
			nextEl: '.swiper-button-next',
			prevEl: '.swiper-button-prev',
		},
	});

});