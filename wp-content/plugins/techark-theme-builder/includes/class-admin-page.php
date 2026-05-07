<?php
/**
 * Admin Page Handler
 *
 * @package TechArk_Theme_Builder
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

class TATB_Admin_Page
{
    /**
     * Constructor
     */
    public function __construct()
    {
        add_action('admin_menu', array($this, 'add_menu_page'));
        add_action('admin_init', array($this, 'handle_form_submission'));
    }

    /**
     * Add menu page
     */
    public function add_menu_page()
    {
        add_menu_page(
            __('TechArk Theme Builder', 'techark-theme-builder'),
            __('Theme Builder', 'techark-theme-builder'),
            'manage_options',
            'techark-theme-builder',
            array($this, 'render_page'),
            'dashicons-hammer',
            99
        );

        add_submenu_page(
            'techark-theme-builder',
            __('Template Creator', 'techark-theme-builder'),
            __('Template Creator', 'techark-theme-builder'),
            'manage_options',
            'tatb-template-creator',
            array($this, 'render_template_creator_page')
        );
    }

    /**
     * Handle form submission
     */
    public function handle_form_submission()
    {
        // Handle Theme Generator Form
        if (isset($_POST['tatb_nonce']) && wp_verify_nonce($_POST['tatb_nonce'], 'tatb_generate_theme')) {
            $this->handle_theme_generation();
        }

        // Handle Template Creator Form
        if (isset($_POST['tatb_template_nonce']) && wp_verify_nonce($_POST['tatb_template_nonce'], 'tatb_create_template')) {
            $this->handle_template_creation();
        }
    }

    /**
     * Handle theme generation
     */
    private function handle_theme_generation()
    {

        // Check capabilities
        if (!current_user_can('manage_options')) {
            wp_die(__('You do not have sufficient permissions.', 'techark-theme-builder'));
        }

        // Get and sanitize form data
        $theme_data = array(
            'theme_name' => sanitize_text_field($_POST['theme_name']),
            'theme_slug' => !empty($_POST['theme_slug']) ? sanitize_title($_POST['theme_slug']) : '',
            'theme_prefix' => !empty($_POST['theme_prefix']) ? sanitize_key($_POST['theme_prefix']) : '',
            'text_domain' => !empty($_POST['text_domain']) ? sanitize_title($_POST['text_domain']) : '',
            'author' => sanitize_text_field($_POST['author']),
            'author_uri' => esc_url_raw($_POST['author_uri']),
            'description' => sanitize_textarea_field($_POST['description']),
            'theme_requirement' => isset($_POST['theme_requirement']) ? sanitize_text_field($_POST['theme_requirement']) : 'redux',
        );

        // Validate theme name
        if (empty($theme_data['theme_name'])) {
            add_settings_error(
                'tatb_messages',
                'tatb_message',
                __('Theme name is required.', 'techark-theme-builder'),
                'error'
            );
            return;
        }

        // Auto-generate slug if empty
        if (empty($theme_data['theme_slug'])) {
            $theme_data['theme_slug'] = sanitize_title($theme_data['theme_name']);
        }

        // Auto-generate prefix if empty
        if (empty($theme_data['theme_prefix'])) {
            $theme_data['theme_prefix'] = sanitize_key(str_replace('-', '_', $theme_data['theme_slug']));
        }

        // Auto-generate text domain if empty
        if (empty($theme_data['text_domain'])) {
            $theme_data['text_domain'] = $theme_data['theme_slug'];
        }

        // Generate theme
        require_once TATB_PLUGIN_DIR . 'includes/class-theme-generator.php';
        $generator = new TATB_Theme_Generator($theme_data);
        $result = $generator->generate();

        if (is_wp_error($result)) {
            add_settings_error(
                'tatb_messages',
                'tatb_message',
                $result->get_error_message(),
                'error'
            );
        } else {
            // Trigger download and exit
            $generator->download_theme();
            exit;
        }
    }

    /**
     * Handle template creation
     */
    private function handle_template_creation()
    {
        // Check capabilities
        if (!current_user_can('manage_options')) {
            wp_die(__('You do not have sufficient permissions.', 'techark-theme-builder'));
        }

        $template_name = sanitize_text_field(wp_unslash($_POST['tatb_template_name']));

        if (empty($template_name)) {
            add_settings_error(
                'tatb_messages',
                'tatb_message',
                __('Please enter a template name.', 'techark-theme-builder'),
                'error'
            );
            return;
        }

        $slug = sanitize_title($template_name);
        $filename = $slug . '-template-page.php';

        $theme_dir = trailingslashit(get_template_directory());
        $template_dir = $theme_dir . 'custom-templates/';

        // Create folder if it doesn't exist
        if (!file_exists($template_dir)) {
            wp_mkdir_p($template_dir);
        }

        $filepath = $template_dir . $filename;

        if (file_exists($filepath)) {
            add_settings_error(
                'tatb_messages',
                'tatb_message',
                sprintf(__('The template file %s already exists.', 'techark-theme-builder'), esc_html($filename)),
                'error'
            );
            return;
        }

        if (!wp_is_writable(get_template_directory())) {
            add_settings_error(
                'tatb_messages',
                'tatb_message',
                __('The theme directory is not writable. Please adjust file permissions.', 'techark-theme-builder'),
                'error'
            );
            return;
        }

        $template_header = "/**\n";
        $template_header .= " * Template Name: " . $template_name . "\n";
        $template_header .= " * Generated by TechArk Theme Builder.\n";
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
            add_settings_error(
                'tatb_messages',
                'tatb_message',
                __('Could not create template file. Please check file permissions.', 'techark-theme-builder'),
                'error'
            );
        } else {
            add_settings_error(
                'tatb_messages',
                'tatb_message',
                sprintf(
                    __('Template "%1$s" created successfully as %2$s.', 'techark-theme-builder'),
                    esc_html($template_name),
                    esc_html($filename)
                ),
                'updated'
            );
        }
    }

    /**
     * Render admin page
     */
    public function render_page()
    {
        settings_errors('tatb_messages');
        ?>
        <div class="wrap tatb-admin-wrap">
            <h1><?php echo esc_html(get_admin_page_title()); ?></h1>

            <div class="tatb-intro">
                <p><?php esc_html_e('Fill in the details below and click Generate Theme to download a ready-to-use WordPress theme ZIP with Redux options and your custom prefix.', 'techark-theme-builder'); ?>
                </p>
            </div>

            <form method="post" class="tatb-form">
                <?php wp_nonce_field('tatb_generate_theme', 'tatb_nonce'); ?>

                <table class="form-table" role="presentation">
                    <tbody>
                        <tr>
                            <th scope="row">
                                <label for="theme_name"><?php esc_html_e('Theme Name', 'techark-theme-builder'); ?> <span class="required">*</span></label>
                            </th>
                            <td>
                                <input type="text" name="theme_name" id="theme_name" class="regular-text" required placeholder="<?php esc_attr_e('My Awesome Theme', 'techark-theme-builder'); ?>" />
                            </td>
                        </tr>

                        <tr>
                            <th scope="row">
                                <label for="theme_slug"><?php esc_html_e('Theme Slug (folder & text domain)', 'techark-theme-builder'); ?></label>
                            </th>
                            <td>
                                <input type="text" name="theme_slug" id="theme_slug" class="regular-text" placeholder="<?php esc_attr_e('my-awesome-theme', 'techark-theme-builder'); ?>" />
                                <p class="description">
                                    <?php esc_html_e('Leave blank to auto-generate from Theme Name.', 'techark-theme-builder'); ?>
                                </p>
                            </td>
                        </tr>

                        <tr>
                            <th scope="row">
                                <label for="theme_prefix"><?php esc_html_e('Theme Prefix (functions, Redux, etc.)', 'techark-theme-builder'); ?></label>
                            </th>
                            <td>
                                <input type="text" name="theme_prefix" id="theme_prefix" class="regular-text" placeholder="<?php esc_attr_e('mytheme_prefix', 'techark-theme-builder'); ?>" />
                                <p class="description">
                                    <?php
                                    printf(
                                        /* translators: 1: example function prefix, 2: example Redux option name */
                                        esc_html__('Used as function prefix (e.g. %1$s) and Redux option name (%2$s). If blank, it uses the slug.', 'techark-theme-builder'),
                                        '<code>mytheme_prefix_setup()</code>',
                                        '<code>mytheme_prefix_options</code>'
                                    );
                                    ?>
                                </p>
                            </td>
                        </tr>

                        <tr>
                            <th scope="row">
                                <label for="text_domain"><?php esc_html_e('Text Domain', 'techark-theme-builder'); ?></label>
                            </th>
                            <td>
                                <input type="text" name="text_domain" id="text_domain" class="regular-text" placeholder="<?php esc_attr_e('my-awesome-theme', 'techark-theme-builder'); ?>" />
                                <p class="description">
                                    <?php esc_html_e('Leave blank to use the slug.', 'techark-theme-builder'); ?>
                                </p>
                            </td>
                        </tr>

                        <tr>
                            <th scope="row">
                                <label for="author"><?php esc_html_e('Author', 'techark-theme-builder'); ?></label>
                            </th>
                            <td>
                                <input type="text" name="author" id="author" class="regular-text" placeholder="<?php esc_attr_e('Your Name or Company', 'techark-theme-builder'); ?>" />
                            </td>
                        </tr>

                        <tr>
                            <th scope="row">
                                <label for="author_uri"><?php esc_html_e('Author URI', 'techark-theme-builder'); ?></label>
                            </th>
                            <td>
                                <input type="url" name="author_uri" id="author_uri" class="regular-text" placeholder="<?php esc_attr_e('https://your-site.com', 'techark-theme-builder'); ?>" />
                            </td>
                        </tr>

                        <tr>
                            <th scope="row">
                                <label for="description"><?php esc_html_e('Description', 'techark-theme-builder'); ?></label>
                            </th>
                            <td>
                                <textarea name="description" id="description" rows="3" class="large-text" placeholder="<?php esc_attr_e('Starter theme with Redux theme options, global design settings, and template creator.', 'techark-theme-builder'); ?>"></textarea>
                            </td>
                        </tr>

                        <tr>
                            <th scope="row">
                                <label><?php esc_html_e('Theme Requirements', 'techark-theme-builder'); ?></label>
                            </th>
                            <td>
                                <fieldset>
                                    <label>
                                        <input type="radio" name="theme_requirement" value="redux" checked />
                                        <?php
                                        printf(
                                            /* translators: %s: Redux plugin link */
                                            esc_html__('Redux Framework (Recommended) - %s', 'techark-theme-builder'),
                                            '<a href="https://wordpress.org/plugins/redux-framework/" target="_blank">' . esc_html__('Redux Framework', 'techark-theme-builder') . '</a>'
                                        );
                                        ?>
                                    </label><br>
                                    <label>
                                        <input type="radio" name="theme_requirement" value="acf" />
                                        <?php
                                        printf(
                                            /* translators: 1: ACF PRO link, 2: Flexible Layout Preview link */
                                            esc_html__('Advanced Custom Fields PRO + Flexible Layout Preview Image for ACF - %1$s | %2$s', 'techark-theme-builder'),
                                            '<a href="https://www.advancedcustomfields.com/pro/" target="_blank">' . esc_html__('Advanced Custom Fields PRO', 'techark-theme-builder') . '</a>',
                                            '<a href="https://wordpress.org/plugins/flexible-layout-preview-image-for-acf/" target="_blank">' . esc_html__('Flexible Layout Preview Image for ACF', 'techark-theme-builder') . '</a>'
                                        );
                                        ?>
                                    </label>
                                </fieldset>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <?php submit_button(__('Generate Theme', 'techark-theme-builder'), 'primary large', 'tatb_generate_theme'); ?>
            </form>

            <div class="tatb-how-to-use">
                <h2><?php esc_html_e('How to Use the Generated Theme', 'techark-theme-builder'); ?></h2>
                <hr>

                <div class="tatb-step-section">
                    <h3><?php esc_html_e('1. Install the Theme', 'techark-theme-builder'); ?></h3>
                    <ol>
                        <li><?php esc_html_e('Download the generated ZIP file.', 'techark-theme-builder'); ?></li>
                        <li><?php esc_html_e('Go to Appearance > Themes > Add New > Upload Theme.', 'techark-theme-builder'); ?>
                        </li>
                        <li><?php esc_html_e('Upload and activate your new theme.', 'techark-theme-builder'); ?></li>
                    </ol>
                    <div id="tatb-redux-instructions" class="tatb-requirement-instructions" style="display: block;">
                        <div class="tatb-step-section">
                            <h3><?php esc_html_e('2. Install Required Plugins', 'techark-theme-builder'); ?></h3>
                            <p><?php printf(esc_html__('The following plugin is included in your theme in the %s folder for easy access:', 'techark-theme-builder'), '<code>/redux-setup/</code>'); ?>
                            </p>
                            <ul>
                                <li><strong>redux-framework.4.5.10.zip</strong> -
                                    <?php esc_html_e('Required for theme options.', 'techark-theme-builder'); ?>
                                </li>
                            </ul>
                            <p><?php esc_html_e('Install this by going to Plugins > Add New > Upload Plugin.', 'techark-theme-builder'); ?>
                            </p>
                        </div>
                    </div>

                    <div id="tatb-acf-instructions" class="tatb-requirement-instructions" style="display: none;">
                        <div class="tatb-step-section">
                            <h3><?php esc_html_e('2. Install Required Plugins', 'techark-theme-builder'); ?></h3>
                            <p><?php printf(esc_html__('The following plugins are included in your theme in the %s folder for easy access:', 'techark-theme-builder'), '<code>/acf-setup/</code>'); ?>
                            </p>
                            <ul>
                                <li><strong>advanced-custom-fields-pro.zip</strong> -
                                    <?php esc_html_e('Required for theme functionality.', 'techark-theme-builder'); ?>
                                </li>
                                <li><strong>flexible-layout-preview-image-for-acf.zip</strong> -
                                    <?php esc_html_e('Required for flexible layout previews.', 'techark-theme-builder'); ?>
                                </li>
                            </ul>
                            <p><?php esc_html_e('Install these by going to Plugins > Add New > Upload Plugin.', 'techark-theme-builder'); ?>
                            </p>
                        </div>

                        <div class="tatb-step-section">
                            <h3><?php esc_html_e('3. Import ACF Structure', 'techark-theme-builder'); ?></h3>
                            <p><?php printf(esc_html__('To import the pre-defined fields, use the following file found in your theme in the %s folder:', 'techark-theme-builder'), '<code>/acf-setup/</code>'); ?>
                            </p>
                            <code>acf-export-2026-02-12.json</code>
                            <ol>
                                <li><?php esc_html_e('Go to Custom Fields > Tools.', 'techark-theme-builder'); ?></li>
                                <li><?php esc_html_e('Under "Import Field Groups", select the JSON file from your theme folder.', 'techark-theme-builder'); ?>
                                </li>
                                <li><?php esc_html_e('Click "Import JSON".', 'techark-theme-builder'); ?></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <?php
    }

    /**
     * Render template creator page
     */
    public function render_template_creator_page()
    {
        settings_errors('tatb_messages');
        ?>
            <div class="wrap tatb-admin-wrap">
                <h1><?php esc_html_e('Template Creator', 'techark-theme-builder'); ?></h1>

                <p><?php esc_html_e('Create simple page templates that use the standard header and footer.', 'techark-theme-builder'); ?></p>

                <form method="post" class="tatb-form">
                    <?php wp_nonce_field('tatb_create_template', 'tatb_template_nonce'); ?>

                    <table class="form-table" role="presentation">
                        <tbody>
                            <tr>
                                <th scope="row">
                                    <label for="tatb_template_name"><?php esc_html_e('Template Name', 'techark-theme-builder'); ?></label>
                                </th>
                                <td>
                                    <input type="text" name="tatb_template_name" id="tatb_template_name" class="regular-text" required />
                                    <p class="description"><?php esc_html_e('Example: Landing Page, Services, Case Study.', 'techark-theme-builder'); ?></p>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <?php submit_button(__('Create Template', 'techark-theme-builder'), 'primary', 'tatb_create_template_submit'); ?>
                </form>
            </div>
            <?php
    }
}
