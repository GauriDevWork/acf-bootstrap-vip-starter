<?php
/**
 * Simple page template creator
 */

function {{PREFIX}}_add_template_creator_page()
{
    add_theme_page(
        __('Template Creator', '{{TEXT_DOMAIN}}'),
        __('Template Creator', '{{TEXT_DOMAIN}}'),
        'manage_options',
        '{{PREFIX}}_template-creator',
        '{{PREFIX}}_template_creator_page_html'
    );
}
add_action('admin_menu', '{{PREFIX}}_add_template_creator_page');

function {{PREFIX}}_template_creator_page_html()
{
    if (!current_user_can('manage_options')) {
        return;
    }

    $message = '';
    $error = '';

    if (isset($_POST['{{PREFIX}}_template_name']) && check_admin_referer('{{PREFIX}}_create_template', '{{PREFIX}}_template_nonce')) {
        $template_name = sanitize_text_field(wp_unslash($_POST['{{PREFIX}}_template_name']));

        if (!empty($template_name)) {
            $slug = sanitize_title($template_name);
            $filename = $slug . '-page-template.php';
            $filepath = trailingslashit(get_template_directory()) . $filename;

            if (file_exists($filepath)) {
                $error = sprintf(
                    __('The template file %s already exists.', '{{TEXT_DOMAIN}}'),
                    esc_html($filename)
                );
            } elseif (!wp_is_writable(get_template_directory())) {
                $error = __('The theme directory is not writable. Please adjust file permissions.', '{{TEXT_DOMAIN}}');
            } else {
                $template_header = "/**\n";
                $template_header .= " * Template Name: " . $template_name . "\n";
                $template_header .= " */\n\n";

                $template_body = "get_header(); ?>\n\n";
                $template_body .= "<main id=\"primary\" class=\"site-main\">\n";
                $template_body .= "    <div class=\"container\">\n";
                $template_body .= "        <?php\n";
                $template_body .= "        while ( have_posts() ) :\n";
                $template_body .= "            the_post();\n";
                $template_body .= "            the_content();\n";
                $template_body .= "        endwhile;\n";
                $template_body .= "        ?>\n";
                $template_body .= "    </div>\n";
                $template_body .= "</main>\n\n";
                $template_body .= "<?php\n";
                $template_body .= "get_footer();\n";

                $template_code = "<?php\n" . $template_header . $template_body;

                $result = file_put_contents($filepath, $template_code);

                if (false === $result) {
                    $error = __('Could not create template file. Please check file permissions.', '{{TEXT_DOMAIN}}');
                } else {
                    $message = sprintf(
                        __('Template "%1$s" created successfully as %2$s.', '{{TEXT_DOMAIN}}'),
                        esc_html($template_name),
                        esc_html($filename)
                    );
                }
            }
        } else {
            $error = __('Please enter a template name.', '{{TEXT_DOMAIN}}');
        }
    }
    ?>
    <div class="wrap">
        <h1><?php esc_html_e('Template Creator', '{{TEXT_DOMAIN}}'); ?></h1>

        <p><?php esc_html_e('Create simple page templates that use the standard header and footer.', '{{TEXT_DOMAIN}}'); ?></p>

        <?php if ($message): ?>
            <div class="notice notice-success is-dismissible">
                <p><?php echo esc_html($message); ?></p>
            </div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="notice notice-error">
                <p><?php echo esc_html($error); ?></p>
            </div>
        <?php endif; ?>

        <form method="post">
            <?php wp_nonce_field('{{PREFIX}}_create_template', '{{PREFIX}}_template_nonce'); ?>

            <table class="form-table" role="presentation">
                <tbody>
                    <tr>
                        <th scope="row">
                            <label for="{{PREFIX}}_template_name"><?php esc_html_e('Template name', '{{TEXT_DOMAIN}}'); ?></label>
                        </th>
                        <td>
                            <input type="text" name="{{PREFIX}}_template_name" id="{{PREFIX}}_template_name" class="regular-text" required />
                            <p class="description"><?php esc_html_e('Example: Landing Page, Services, Case Study.', '{{TEXT_DOMAIN}}'); ?></p>
                        </td>
                    </tr>
                </tbody>
            </table>

            <?php submit_button(__('Create Template', '{{TEXT_DOMAIN}}')); ?>
        </form>
    </div>
    <?php
}
