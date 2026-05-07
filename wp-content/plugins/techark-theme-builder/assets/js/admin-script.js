/**
 * Admin Scripts for TechArk Theme Builder
 */

(function ($) {
    'use strict';

    $(document).ready(function () {
        // Auto-generate fields from theme name
        $('#theme_name').on('blur', function () {
            var themeName = $(this).val();
            var $themeSlug = $('#theme_slug');
            var $textDomain = $('#text_domain');
            var $themePrefix = $('#theme_prefix');

            if (themeName) {
                // Generate slug (lowercase, hyphens)
                var slug = themeName.toLowerCase()
                    .replace(/[^a-z0-9]+/g, '-')
                    .replace(/^-+|-+$/g, '');

                // Generate prefix (lowercase, underscores)
                var prefix = slug.replace(/-/g, '_');

                // Auto-fill slug if empty
                if (!$themeSlug.val()) {
                    $themeSlug.val(slug);
                }

                // Auto-fill text domain if empty (same as slug)
                if (!$textDomain.val()) {
                    $textDomain.val(slug);
                }

                // Auto-fill prefix if empty
                if (!$themePrefix.val()) {
                    $themePrefix.val(prefix);
                }
            }
        });

        // Form submission loading state
        $('.tatb-form').on('submit', function () {
            var $form = $(this);
            var $submitBtn = $form.find('[type="submit"]');
            var originalBtnText = $submitBtn.val();

            // Use a small timeout so the button's name/value is still sent in the POST request
            setTimeout(function () {
                $submitBtn.prop('disabled', true);
                $submitBtn.val('Generating...');
            }, 50);

            // Monitor for download cookie to reset form
            var checkDownload = setInterval(function () {
                var cookieValue = document.cookie.split('; ').find(row => row.startsWith('tatb_download_started='));
                if (cookieValue) {
                    // Re-enable button
                    $submitBtn.prop('disabled', false);
                    $submitBtn.val(originalBtnText);

                    // Reset form
                    $form[0].reset();

                    // Trigger change on radio buttons to update instructions
                    $('input[name="theme_requirement"]:checked').trigger('change');

                    // Clear cookie
                    document.cookie = "tatb_download_started=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";

                    clearInterval(checkDownload);
                }
            }, 1000);
        });

        // Toggle instructions based on theme requirement selection
        $('input[name="theme_requirement"]').on('change', function () {
            var selected = $(this).val();
            $('.tatb-requirement-instructions').hide();
            if (selected === 'redux') {
                $('#tatb-redux-instructions').show();
            } else if (selected === 'acf') {
                $('#tatb-acf-instructions').show();
            }
        });
    });

})(jQuery);
