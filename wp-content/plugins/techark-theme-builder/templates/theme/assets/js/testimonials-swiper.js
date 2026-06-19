document.addEventListener(
	'DOMContentLoaded',
	function () {

		// Normal slider
		const slider = document.querySelector( '.testimonials-swiper' );
		if ( slider ) {
			new Swiper(
				slider,
				{
					slidesPerView: 1,
					spaceBetween: 20,
					loop: true,
					autoplay: { delay: 3000 },
					pagination: {
						el: '.swiper-pagination',
						clickable: true
					},
					breakpoints: {
						768: { slidesPerView: 2 },
						1024: { slidesPerView: 3 }
					}
				}
			);
		}

		// Centered slider
		const centered = document.querySelector( '.testimonials-centered-swiper' );
		if ( centered ) {
			new Swiper(
				centered,
				{
					slidesPerView: 1,
					centeredSlides: true,
					loop: true,
					autoplay: { delay: 3000 },
					pagination: {
						el: '.swiper-pagination',
						clickable: true
					}
				}
			);
		}

	}
);