jQuery(document).ready(function ($) {

    if (jQuery('#gallery-container').length > 0) {

        lightGallery(document.getElementById('gallery-container'), {
            speed: 500,
            plugins: [lgVideo],
            autoplayVideoOnSlide: true,
            videoAutoplay: true,
            trapFocus: true,
            escKey: true,
            closable: true,
            controls: true,
            thumbnail: true,
            download: false,
            counter: false,
            youtubePlayerParams: {
                autoplay: 1,
                mute: 1,
                controls: 1,
                modestbranding: 1,
                rel: 0
            },
            vimeoPlayerParams: {
                autoplay: 1,
                muted: 1,
                playsinline: 1,
                controls: 1
            },
            mobileSettings: {
                controls: true,
                showCloseIcon: true
            }
        });

        (function () {

            const galleryEl = document.querySelector('#gallery-container');
            if (!galleryEl) return;

            let lastTriggerId = null;

            /* Before and After slide */

            galleryEl.addEventListener('lgAfterSlide', function (event) {

                const index = event.detail.index; // current slide index

                const trigger = document.querySelector(
                    `.video-btn[data-lg-index="${index}"]`
                );

                if (trigger) {
                    lastTriggerId = trigger.dataset.videoTrigger;
                }
                console.log(lastTriggerId + "after");
            });

            galleryEl.addEventListener('lgBeforeSlide', function (event) {

                // LightGallery v2
                const index = event.detail.index;

                const trigger = document.querySelector(
                    `.video-btn[data-lg-index="${index}"]`
                );

                if (trigger) {
                    lastTriggerId = trigger.dataset.videoTrigger;
                }
                console.log(lastTriggerId + "before");
            });

            /* ----------------------------------------
               1. Capture trigger BEFORE open
            -----------------------------------------*/

            galleryEl.addEventListener('click', function (e) {
                const btn = e.target.closest('.video-btn[data-video-trigger]');
                if (btn) {
                    lastTriggerId = btn.dataset.videoTrigger;
                }
                console.log(lastTriggerId + "capture click");
            });

            document.addEventListener('keydown', function (e) {
                if ((e.key === 'Enter' || e.key === ' ') &&
                    e.target.closest('.video-btn[data-video-trigger]')) {

                    lastTriggerId = e.target
                        .closest('.video-btn')
                        .dataset.videoTrigger;
                    console.log(lastTriggerId + "capture enter ecpat");
                }
            });

            /* ----------------------------------------
               2. Trap focus inside LightGallery
            -----------------------------------------*/

            function trapFocus(container) {
                const focusable = container.querySelectorAll(
                    'a[href], button:not([disabled]), textarea, input, select, iframe, [tabindex]:not([tabindex="-1"])'
                );

                if (!focusable.length) return;

                const firstEl = focusable[0];
                const lastEl = focusable[focusable.length - 1];

                container.addEventListener('keydown', function (e) {
                    if (e.key !== 'Tab') return;

                    if (e.shiftKey && document.activeElement === firstEl) {
                        e.preventDefault();
                        lastEl.focus();
                    } else if (!e.shiftKey && document.activeElement === lastEl) {
                        e.preventDefault();
                        firstEl.focus();
                    }
                });

                firstEl.focus();
                console.log(lastTriggerId + "focus");
            }

            /* ----------------------------------------
               3. After OPEN
            -----------------------------------------*/

            document.addEventListener('lgAfterOpen', function () {
                const lgContainer = document.querySelector('.lg-container');
                if (!lgContainer) return;

                // Disable background
                document.querySelectorAll('body > *:not(.lg-container)').forEach(el => {
                    el.setAttribute('inert', '');
                    el.setAttribute('aria-hidden', 'true');
                });

                trapFocus(lgContainer);
                console.log(lastTriggerId + "open");
            });

            /* ----------------------------------------
               4. CLOSE HANDLING (ESC + Close Button)
            -----------------------------------------*/

            function restoreFocus() {

                document.querySelectorAll('[inert]').forEach(el => {
                    el.removeAttribute('inert');
                    el.removeAttribute('aria-hidden');
                });

                if (!lastTriggerId) return;

                const trigger = document.querySelector(
                    `.video-btn[data-video-trigger="${lastTriggerId}"]`
                );

                if (trigger) {
                    setTimeout(() => trigger.focus(), 150);
                }
                console.log(lastTriggerId + "restore");
            }

            /* ESC key close */
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape' && document.querySelector('.lg-container')) {
                    restoreFocus();
                }
            });

            /* Close button click */
            document.addEventListener('click', function (e) {
                if (e.target.closest('.lg-close')) {
                    restoreFocus();
                }
            });

        })();
    }

    /* gtranslate js */

    setTimeout(function () {
        jQuery('#menu-gtranslate-menu-responsive a').attr("tabindex", "-1");
    }, 2000);

    if (jQuery('#menu-gtranslate-menu').length > 0) {

        jQuery("#menu-gtranslate-menu .menu-item-has-children a.gt-current-wrapper").after("<span class='arrow-toggle-lan'></span>");

        if (window.matchMedia("(min-width: 1366px)").matches) {
            jQuery("#menu-gtranslate-menu .menu-item-has-children .gt-current-wrapper").hover(
                function () {
                    jQuery("#menu-gtranslate-menu .menu-item-has-children ul.sub-menu")
                        .css("display", "block");
                }
            );
        }

        if (window.matchMedia("(max-width: 1365px)").matches) {
            jQuery("#menu-gtranslate-menu .menu-item-has-children .arrow-toggle-lan")
                .on("click", function (e) {
                    e.stopPropagation();

                    const submenu = jQuery(this)
                        .siblings("ul.sub-menu");

                    submenu.toggleClass("open-submenu");
                    submenu.toggle();
                });
        }

        jQuery('#menu-gtranslate-menu').on('click', '.menu-item-gtranslate .menu-item-gtranslate-child', function (e) {
            e.stopPropagation();
            jQuery("#menu-gtranslate-menu .menu-item-has-children ul.sub-menu").css('display', 'none');
            jQuery("#menu-gtranslate-menu .menu-item-has-children").removeClass('open-submenu');
        });

        let selectedLang = jQuery('.gt-current-lang').data('gt-lang');
        if (selectedLang && selectedLang !== 'en') {
            jQuery('body').addClass('oth-lan');
        } else {
            jQuery('body').removeClass('oth-lan');
        }

        jQuery('.gtranslate-menu a.glink').on('click', function () {
            let selectedLang = jQuery(this).data('gt-lang');
            if (selectedLang && selectedLang !== 'en') {
                jQuery('body').addClass('oth-lan');
            } else {
                jQuery('body').removeClass('oth-lan');
            }
        });
    }
    /* end gtranslate */


    var viewportWidth = jQuery(window).width();

    jQuery(".ta-arrow-down1").click(function () {
        if (jQuery(this).parent().hasClass("ta-change-icon")) {
            jQuery(this).siblings(".sub-menu").slideUp();
            jQuery(this).parent().removeClass("ta-change-icon");
        } else {
            jQuery(".sub-menu").slideUp();
            jQuery(this).siblings(".sub-menu").slideDown();
            jQuery(".ta-open-menu li ul li").removeClass("ta-change-icon-submenu");
            jQuery(".ta-open-menu li").removeClass("ta-change-icon");
            jQuery(this).parent().addClass("ta-change-icon");
        }
    });

    jQuery(".ta-arrow-down2").click(function () {
        if (jQuery(this).parent().hasClass("ta-change-icon-submenu")) {
            jQuery(this).siblings(".sub-menu").slideUp();
            jQuery(this).parent().removeClass("ta-change-icon-submenu");
        } else {
            jQuery(".ta-change-icon-submenu .sub-menu").slideUp();
            jQuery(this).siblings(".sub-menu").slideDown();
            jQuery(".ta-open-menu .ta-change-icon ul li").removeClass("ta-change-icon-submenu");
            jQuery(this).parent().addClass("ta-change-icon-submenu");
        }
    });

    jQuery(".ta-navigation-menu .ta-close-icon").click(function () {
        jQuery("html").removeClass("ta-open-menu");
        jQuery(".sub-menu").slideUp();
        jQuery(".ta-navigation-menu ul li").removeClass("ta-arrow-down1");
        jQuery(".ta-navigation-menu ul li").removeClass("ta-arrow-down2");
        jQuery(".ta-open-menu .ta-change-icon ul li").removeClass("ta-change-icon-submenu");
        jQuery(".ta-open-menu li").removeClass("ta-change-icon");
    });

    jQuery(".ta-navigation-menu button").click(function () {
        jQuery("html").addClass("ta-open-menu");
    });

    jQuery(window).scroll(function () {
        var scroll = $(window).scrollTop();

        if (!jQuery('body').hasClass('no-sticky-header')) {

            if (scroll >= 100) {
                jQuery("body").addClass("sticky-header");
                var headerHeight = jQuery('header').outerHeight() || 0;
                jQuery('body').css('padding-top', headerHeight + 'px');
            } else {
                jQuery("body").removeClass("sticky-header");
                jQuery('body').css('padding-top', '0px');
            }

        }
    });

    jQuery(".navigation-menu button").click(function () {
        jQuery("html").addClass("open-menu");
    });

    jQuery(".navigation-menu .close-icon").click(function () {
        jQuery("html").removeClass("open-menu");
    });

    var counted = 0;
    jQuery(window).scroll(function () {

        if (jQuery('.my-theme-counter-sec').length > 0) {
            var oTop = jQuery('.my-theme-counter-sec').offset().top - window.innerHeight;

            if (counted == 0 && jQuery(window).scrollTop() > oTop) {

                jQuery('.count').each(function () {
                    var $this = jQuery(this),
                        countTo = $this.attr('data-count');

                    jQuery({ countNum: $this.text() }).animate(
                        { countNum: countTo },
                        {
                            duration: 2000,
                            easing: 'swing',
                            step: function () {
                                $this.text(Math.floor(this.countNum));
                            },
                            complete: function () {
                                $this.text(this.countNum);
                            }
                        }
                    );
                });

                counted = 1;
            }
        }

    });

    var menuMap = {
        'single-physicians': '#menu-item-50',
        'single-post': '#menu-item-46, #menu-item-61',
        'category': '#menu-item-46, #menu-item-61',
        'tag': '#menu-item-46, #menu-item-61',
        'archive': '#menu-item-46, #menu-item-61',
        'search-results': '#menu-item-46, #menu-item-61'
    };

    jQuery.each(menuMap, function (bodyClass, menuSelector) {
        if (jQuery('body').hasClass(bodyClass)) {
            jQuery(menuSelector).addClass('current-menu-item');
        }
    });

    jQuery('.locations-list li a').on('click', function (e) {
        e.preventDefault();

        jQuery('.map-block .loader').removeClass('d-none');
        jQuery('.map-block iframe').hide();

        let mapSrc = jQuery(this).attr('href');
        jQuery('.map-block iframe').attr('src', mapSrc);

        jQuery('.map-block iframe').fadeIn(500);

        jQuery('.locations-list li').removeClass('active');
        jQuery(this).closest('li').addClass('active');

        setTimeout(function () {
            jQuery('.map-block .loader').addClass('d-none');
        }, 2000);

    });

    if (jQuery('.back-top').length > 0) {
        var btn = jQuery('.back-top');
        jQuery(window).scroll(function () {
            if (jQuery(window).scrollTop() > 300) btn.addClass('show'); else btn.removeClass('show');
        });
        btn.on('click', function (e) {
            e.preventDefault(); jQuery('html, body').animate({
                scrollTop: 0
            }, '300')
        });
    }

    if (jQuery('.wpcf7-form').length > 0) {

        var timer;

        jQuery('.wpcf7-form').submit(function () {
            clearTimeout(timer);

            jQuery(this).find(".wpcf7-submit").attr('disabled', true);
            jQuery(this).find(".wpcf7-response-output").attr('style', "border: 0px solid #ffb900 !important");

            timer = setTimeout(function () {
                jQuery('.wpcf7-response-output').hide(0);
                jQuery('.wpcf7-response-output').text("");
            }, 8000);
        });

        document.addEventListener('wpcf7mailfailed', function (event) {
            jQuery('.wpcf7-submit').attr('disabled', false);
            jQuery(".wpcf7-response-output").css('border', "1px solid #E8272D ", "!important");

        }, false);

        document.addEventListener('wpcf7invalid', function () {
            jQuery('.wpcf7-submit').attr('disabled', false);
            jQuery(".wpcf7-response-output").css("border", "1px solid #ffb900 ", "important");
        }, false);

        document.addEventListener('wpcf7mailsent', function (event) {
            jQuery('.wpcf7-submit').attr('disabled', false);
            jQuery(".wpcf7-response-output").css('border', "1px solid #46b450 ", "!important");
        }, false);

        document.addEventListener('wpcf7spam', function (event) {
            jQuery('.wpcf7-submit').attr('disabled', false);
            jQuery(".wpcf7-response-output").css('border', "1px solid #E8272D ", "!important");
        }, false);

        if (jQuery('.appointment_date').length > 0) {
            jQuery(".appointment_date").datepicker({
                format: "mm/dd/yyyy",
                startDate: "currentDate",
                todayHighlight: true,
                autoclose: true
            }).attr("readonly", true);
        }

        if (jQuery('#phone_number').length > 0) {
            jQuery("#phone_number").inputmask("(999)-999-9999");
        }

        if (jQuery('#zip_code').length > 0) {

            var $zip = jQuery('#zip_code');

            // Block non-numeric typing
            $zip.on('keypress', function (event) {
                var key = event.keyCode || event.which;
                var keyChar = String.fromCharCode(key);

                if (!/[0-9]/.test(keyChar)) {
                    event.preventDefault();
                }
            });
            // Block pasting non-numeric values
            $zip.on('paste', function (event) {
                var pastedData = (event.originalEvent || event).clipboardData.getData('text');

                if (!/^\d+$/.test(pastedData)) {
                    event.preventDefault();
                }
            });

            // Extra: block dragging text into field
            $zip.on('drop', function (event) {
                event.preventDefault();
            });
        }

        jQuery('body').on('keydown input', '.wpcf7-form textarea', function () {
            this.style.removeProperty('height');
            this.style.height = (this.scrollHeight + 2) + 'px';
        });
    }


    var windowWidth = jQuery(window).width();

    var findUsSlider = jQuery('.my-theme-find-us-slider');

    if (findUsSlider.length > 0) {
        var findSlideCount = findUsSlider.children().length;

        if (findSlideCount >= 4 || (findSlideCount === 3 && windowWidth < 1400) || (findSlideCount === 2 && windowWidth < 992)) {
            findUsSlider.owlCarousel({
                nav: false,
                loop: true,
                dots: false,
                touchDrag: true,
                mouseDrag: true,
                autoHeight: false,
                margin: 30,
                autoplay: true,
                autoplaySpeed: 3000,
                responsive: {
                    0: {
                        items: 1,
                        autoWidth: true,
                        margin: 20,
                    },
                    768: {
                        margin: 30,
                        items: 1,
                        autoWidth: true,
                    },
                },
            });
        } else {
            findUsSlider.addClass("off");
        }
    }

    var clientSlider = jQuery('.my-theme-client-slider');
    var clientSlideCount = clientSlider.children().length;

    if (clientSlider.length > 0) {

        if (clientSlideCount >= 4 || (clientSlideCount === 3 && windowWidth < 1200) || (clientSlideCount === 2 && windowWidth < 992)) {
            clientSlider.owlCarousel({
                loop: true,
                touchDrag: true,
                mouseDrag: true,
                margin: 30,
                centerSlide: true,
                autoplay: true,
                autoplaySpeed: 3000,
                responsive: {
                    0: {
                        items: 1
                    },
                    992: {
                        items: 2
                    },
                    1200: {
                        items: 3
                    },
                }
            });
        } else {
            clientSlider.addClass("off");
        }
    }

    var physiciansSlider = jQuery('.my-theme-physicians-slider');
    var physiciansSlideCount = physiciansSlider.children().length;

    if (physiciansSlider.length > 0) {

        if (physiciansSlideCount >= 3 || (physiciansSlideCount === 2 && windowWidth < 1200)) {
            physiciansSlider.owlCarousel({
                loop: true,
                margin: 30,
                center: true,
                nav: false,
                dots: false,
                touchDrag: true,
                mouseDrag: true,
                autoplay: true,
                autoplaySpeed: 3000,
                responsive: {
                    0: {
                        items: 1.2,
                        autoWidth: false,
                        margin: 20,
                    },
                    768: {
                        autoWidth: true,
                        margin: 30,
                    },
                }
            });
        } else {
            physiciansSlider.addClass("off");
        }
    }

    var physiciansSlider = jQuery('.my-theme-related-slider');
    var physiciansSlideCount = physiciansSlider.children().length;

    if (physiciansSlider.length > 0) {

        if (physiciansSlideCount >= 3 || (physiciansSlideCount === 2 && windowWidth < 1200)) {
            physiciansSlider.owlCarousel({
                loop: true,
                margin: 30,
                // center: true,
                nav: false,
                dots: false,
                touchDrag: true,
                mouseDrag: true,
                autoplay: true,
                autoplaySpeed: 3000,
                responsive: {
                    0: {
                        items: 1,
                        margin: 20,
                    },
                    767: {
                        items: 2,
                        margin: 30,
                    },
                    1199: {
                        items: 3,
                        margin: 30,
                    },
                }
            });
        } else {
            physiciansSlider.addClass("off");
        }
    }

    var rpSlider = jQuery('.my-theme-rp-slider');
    var rpSlideCount = rpSlider.children().length;

    if (rpSlider.length > 0) {

        if (rpSlideCount >= 4 || (rpSlideCount === 3 && windowWidth < 1200) || (rpSlideCount === 2 && windowWidth < 992)) {
            rpSlider.owlCarousel({

                loop: true,
                touchDrag: true,
                mouseDrag: true,
                margin: 30,
                centerSlide: true,
                autoplay: true,
                autoplaySpeed: 3000,
                responsive: {
                    0: {
                        items: 1
                    },
                    992: {
                        items: 2
                    },
                    1200: {
                        items: 3
                    },
                }
            });
        }
        else {
            rpSlider.addClass("off");
        }
    }

    var currentUrl = window.location.href;

    jQuery('.my-theme-footer .copyright-text a').each(function () {
        var linkUrl = jQuery(this).attr('href');
        if (currentUrl.indexOf(linkUrl) !== -1 && linkUrl !== '#') {
            jQuery(this).addClass('current-menu-item');
        }
    });


    var flag = 0;

    function lazy_load_js() {

        if (flag == 0) {

            jQuery('body .custom-lazystyle').each(function () {
                var data_bg = jQuery(this).attr('data-style');
                if (data_bg) {
                    jQuery(this).css("background-image", "url(" + data_bg + ")");
                    jQuery(this).fadeIn('2000');
                }
            });

            jQuery('body img').each(function () {
                if (jQuery(this).hasClass('custom-lazyload')) {
                    var data_src = jQuery(this).attr('data-src');
                    jQuery(this).attr('src', data_src);
                    jQuery(this).fadeIn(1000);
                }
            });

            jQuery('body iframe').each(function () {
                if (jQuery(this).hasClass('custom-lazyload-iframe')) {
                    var data_src = jQuery(this).attr('data-src');
                    jQuery(this).attr('src', data_src);
                    jQuery(this).fadeIn(1000);
                }
            });

            flag = 1;
        }

    }

    jQuery(document).on('mousemove click keypress touchstart touchmove', lazy_load_js);

    setTimeout(function () {
        lazy_load_js();
    }, 3500);

});

jQuery(window).on('load', function () {
    setTimeout(function () {
        var textarea = jQuery(document).find(".g-recaptcha-response");
        textarea.attr("aria-hidden", "true");
        textarea.attr("aria-label", "do not use");
        textarea.attr("aria-readonly", "true");
    }, 1000);
});

document.addEventListener("DOMContentLoaded", function () {
    const links = document.querySelectorAll('.gtranslate-menu a[data-gt-lang]');

    links.forEach(function (link) {
        link.setAttribute('tabindex', '0');

        link.addEventListener('keydown', function (e) {
            if (e.key === "Enter") {
                const lang = link.getAttribute('data-gt-lang');

                // Set the googtrans cookie manually
                document.cookie = `googtrans=/auto/${lang}; path=/; expires=Fri, 31 Dec 9999 23:59:59 GMT`;

                // Force reload (Guest Mode compatible)
                window.location.href = window.location.href;
            }
        });
    });
});


document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.wpcf7 fieldset').forEach(function (fieldset, index) {
        if (!fieldset.querySelector('legend')) {
            const legend = document.createElement('legend');
            legend.className = 'visually-hidden';
            legend.textContent = 'Form hidden fields';
            fieldset.prepend(legend);
        }
    });
});

document.addEventListener('DOMContentLoaded', function () {

    const main = document.querySelector('main#main-content');
    const skipLink = document.querySelector('.skip-to-content');

    if (!main || !skipLink) return;

    const sections = main.querySelectorAll(':scope > section');

    // If second section exists
    if (sections.length >= 2) {

        const targetSection = sections[1];
        targetSection.setAttribute('id', 'skip-main-content');

        // Enable skip link
        skipLink.removeAttribute('aria-disabled');
        skipLink.removeAttribute('tabindex');
        skipLink.classList.remove('is-disabled');

        skipLink.addEventListener('click', function (e) {
            e.preventDefault();

            const header = document.querySelector('.header');
            const headerHeight = header ? header.offsetHeight : 0;

            const targetPosition =
                targetSection.getBoundingClientRect().top +
                window.pageYOffset -
                headerHeight - 50;

            window.scrollTo({
                top: targetPosition,
                behavior: 'smooth'
            });

            // Accessibility: move focus
            targetSection.setAttribute('tabindex', '-1');
            targetSection.focus({ preventScroll: true });
        });

    } else {

        // Disable skip link
        skipLink.setAttribute('aria-disabled', 'true');
        skipLink.setAttribute('tabindex', '-1');
        skipLink.classList.add('is-disabled');

        skipLink.addEventListener('click', function (e) {
            e.preventDefault();
        });
    }
});

document.addEventListener('DOMContentLoaded', function () {
    const container = document.querySelector('.responsive-contact');
    if (!container) return;

    const focusables = container.querySelectorAll(
        'a, button, input, textarea, select, [tabindex]'
    );

    focusables.forEach(el => {
        el.setAttribute('tabindex', '-1');
    });
});


