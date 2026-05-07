jQuery(function ($) {
    var field = $('#{{THEME_PREFIX}}options-dark_section_colors'); // wrapper ID for that field
    field.find('.linkColor strong').each(function () {
        let t = $(this).text().trim();
        if (t === 'Regular') $(this).text('Background');
        if (t === 'Hover') $(this).text('Text Color');
    });
    var field_2 = $('#{{THEME_PREFIX}}options-on_button_hover');
    field_2.find('.linkColor strong').each(function () {
        let t = $(this).text().trim();
        if (t === 'Regular') $(this).text('Background');
        if (t === 'Hover') $(this).text('Text Color');
        if (t === 'Active') $(this).text('Border Color');
    });
});