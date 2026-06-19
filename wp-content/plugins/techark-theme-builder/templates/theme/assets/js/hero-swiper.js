document.addEventListener(
	'DOMContentLoaded',
	function () {

		const swiperEl = document.querySelector( '.hero-swiper' );

		if ( ! swiperEl ) {
			return;
		}

		new Swiper(
			'.hero-swiper',
			{
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
			}
		);

	}
);