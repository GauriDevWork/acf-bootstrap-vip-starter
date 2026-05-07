<?php
/**
 * Theme Generator Class
 *
 * @package TechArk_Theme_Builder
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

class TATB_Theme_Generator
{
    /**
     * Theme data
     */
    private $theme_data = array();

    /**
     * Theme directory path
     */
    private $theme_path = '';

    /**
     * ZIP file path
     */
    private $zip_path = '';

    /**
     * Constructor
     */
    public function __construct($theme_data)
    {
        $this->theme_data = $theme_data;
    }

    /**
     * Generate theme
     */
    public function generate()
    {
        // Create temp directory
        $temp_dir = get_temp_dir() . 'tatb_' . uniqid();
        $this->theme_path = $temp_dir . '/' . $this->theme_data['theme_slug'];

        if (!wp_mkdir_p($this->theme_path)) {
            return new WP_Error('mkdir_failed', __('Failed to create theme directory.', 'techark-theme-builder'));
        }

        // Generate theme files from master template
        $gen_result = $this->generate_theme_files();
        if (is_wp_error($gen_result)) {
            $this->cleanup();
            return $gen_result;
        }

        // Copy support files (plugins, etc)
        $this->copy_support_files();

        // Create ZIP file
        $zip_result = $this->create_zip();

        if (is_wp_error($zip_result)) {
            error_log('TechArk Theme Builder Error: ' . $zip_result->get_error_message());
            $this->cleanup();
            return $zip_result;
        }

        if (!file_exists($this->zip_path)) {
            error_log('TechArk Theme Builder Error: ZIP file not found at ' . $this->zip_path);
            return new WP_Error('zip_missing', __('Generated ZIP file not found.', 'techark-theme-builder'));
        }

        return true;
    }

    /**
     * Generate all theme files by copying from master template
     */
    private function generate_theme_files()
    {
        $requirement = !empty($this->theme_data['theme_requirement']) ? $this->theme_data['theme_requirement'] : 'redux';
        $template_name = ($requirement === 'acf') ? 'acf-theme' : 'redux-theme';
        $template_path = TATB_PLUGIN_DIR . 'templates/' . $template_name;

        if (!is_dir($template_path)) {
            return new WP_Error('template_missing', sprintf(__('Template directory missing: %s', 'techark-theme-builder'), $template_name));
        }

        return $this->copy_recursive_with_replace($template_path, $this->theme_path);
    }

    /**
     * Recursively copy files and replace placeholders
     */
    private function copy_recursive_with_replace($source, $dest)
    {
        if (is_dir($source)) {
            if (!wp_mkdir_p($dest)) {
                return new WP_Error('mkdir_failed', sprintf(__('Failed to create directory: %s', 'techark-theme-builder'), $dest));
            }
            $files = scandir($source);
            foreach ($files as $file) {
                if ($file != "." && $file != "..") {
                    $result = $this->copy_recursive_with_replace("$source/$file", "$dest/$file");
                    if (is_wp_error($result)) {
                        return $result;
                    }
                }
            }
        } elseif (file_exists($source)) {
            $ext = strtolower(pathinfo($source, PATHINFO_EXTENSION));
            $replaceable_exts = array('php', 'css', 'txt', 'md', 'json', 'js', 'dist');

            if (in_array($ext, $replaceable_exts)) {
                $content = file_get_contents($source);
                if ($content !== false) {
                    $content = $this->replace_placeholders($content);
                    file_put_contents($dest, $content);
                }
            } else {
                copy($source, $dest);
            }
        }
        return true;
    }

    /**
     * Replace placeholders in file content
     */
    private function replace_placeholders($content)
    {
        $prefix = rtrim($this->theme_data['theme_prefix'], '_') . '_';
        $prefix_long = str_replace('-', '_', $this->theme_data['theme_slug']) . '_';
        $package = str_replace(' ', '_', $this->theme_data['theme_name']);

        $placeholders = array(
            '{{THEME_NAME}}' => $this->theme_data['theme_name'],
            '{{THEME_SLUG}}' => $this->theme_data['theme_slug'],
            '{{THEME_PREFIX}}' => $prefix,
            '{{TEXT_DOMAIN}}' => $this->theme_data['text_domain'],
            '{{THEME_PREFIX_LONG}}' => $prefix_long,
            '{{THEME_PACKAGE}}' => $package,
            '{{THEME_UPPER_PREFIX}}' => strtoupper(rtrim($this->theme_data['theme_prefix'], '_')),
            '{{THEME_UPPER_PREFIX}}_VERSION' => strtoupper(rtrim($this->theme_data['theme_prefix'], '_')) . '_VERSION',
            '{{AUTHOR}}' => !empty($this->theme_data['author']) ? $this->theme_data['author'] : 'Theme Author',
            '{{AUTHOR_URI}}' => !empty($this->theme_data['author_uri']) ? $this->theme_data['author_uri'] : '',
            '{{DESCRIPTION}}' => !empty($this->theme_data['description']) ? $this->theme_data['description'] : '',
        );

        return str_replace(array_keys($placeholders), array_values($placeholders), $content);
    }

    /**
     * Copy requirement-specific support files (plugins, exports) to the theme root
     */
    private function copy_support_files()
    {
        $requirement = !empty($this->theme_data['theme_requirement']) ? $this->theme_data['theme_requirement'] : 'redux';

        if ($requirement === 'acf') {
            $setup_dir = $this->theme_path . '/acf-setup';

            if (!wp_mkdir_p($setup_dir)) {
                return;
            }

            $acf_files = array(
                'acf-export-2026-02-12.json',
                'advanced-custom-fields-pro.zip',
                'flexible-layout-preview-image-for-acf.zip'
            );

            foreach ($acf_files as $file) {
                $source = TATB_PLUGIN_DIR . 'requirement-plugins/' . $file;
                $dest = $setup_dir . '/' . $file;

                if (file_exists($source)) {
                    copy($source, $dest);
                }
            }
        } elseif ($requirement === 'redux') {
            $setup_dir = $this->theme_path . '/redux-setup';

            if (!wp_mkdir_p($setup_dir)) {
                return;
            }

            $redux_files = array(
                'redux-framework.4.5.10.zip'
            );

            foreach ($redux_files as $file) {
                $source = TATB_PLUGIN_DIR . 'requirement-plugins/' . $file;
                $dest = $setup_dir . '/' . $file;

                if (file_exists($source)) {
                    copy($source, $dest);
                }
            }
        }
    }

    /**
     * Create ZIP file
     */
    private function create_zip()
    {
        if (!class_exists('ZipArchive')) {
            return new WP_Error('no_zip', __('ZipArchive class not available. Please contact your hosting provider.', 'techark-theme-builder'));
        }

        $temp_root = dirname($this->theme_path);
        $this->zip_path = $temp_root . '/' . $this->theme_data['theme_slug'] . '.zip';

        $zip = new ZipArchive();
        if ($zip->open($this->zip_path, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            return new WP_Error('zip_failed', __('Failed to create ZIP file.', 'techark-theme-builder'));
        }

        $this->add_files_to_zip($zip, $this->theme_path, $this->theme_data['theme_slug']);

        if ($zip->close() === false) {
            return new WP_Error('zip_close_failed', __('Failed to finalize ZIP file.', 'techark-theme-builder'));
        }

        return true;
    }

    /**
     * Recursively add files to ZIP
     */
    private function add_files_to_zip($zip, $path, $base_path)
    {
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($path),
            RecursiveIteratorIterator::LEAVES_ONLY
        );

        foreach ($files as $file) {
            if (!$file->isDir()) {
                $file_path = $file->getRealPath();
                $relative_path = $base_path . '/' . substr($file_path, strlen($path) + 1);

                $zip->addFile($file_path, $relative_path);
            }
        }
    }

    /**
     * Download theme ZIP
     */
    public function download_theme()
    {
        if (file_exists($this->zip_path)) {
            // Set cookie for JS to detect download start
            setcookie('tatb_download_started', '1', time() + 30, '/');

            // Clean ALL output buffers to prevent corrupt downloads
            while (ob_get_level()) {
                ob_end_clean();
            }

            header('Content-Type: application/zip');
            header('Content-Disposition: attachment; filename="' . basename($this->zip_path) . '"');
            header('Content-Transfer-Encoding: binary');
            header('Content-Length: ' . filesize($this->zip_path));
            header('Pragma: no-cache');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');

            readfile($this->zip_path);

            $this->cleanup();
            exit;
        }
    }

    /**
     * Cleanup temporary files
     */
    private function cleanup()
    {
        // Delete temp root directory
        if (!empty($this->theme_path)) {
            $temp_root = dirname($this->theme_path);
            if (file_exists($temp_root) && strpos($temp_root, 'tatb_') !== false) {
                $this->delete_directory($temp_root);
            }
        }

        // Delete ZIP file
        if (!empty($this->zip_path) && file_exists($this->zip_path)) {
            unlink($this->zip_path);
        }
    }

    /**
     * Recursively delete directory
     */
    private function delete_directory($dir)
    {
        if (!file_exists($dir)) {
            return;
        }

        if (!is_dir($dir)) {
            unlink($dir);
            return;
        }

        $files = array_diff(scandir($dir), array('.', '..'));

        foreach ($files as $file) {
            $path = $dir . '/' . $file;
            is_dir($path) ? $this->delete_directory($path) : unlink($path);
        }

        rmdir($dir);
    }
}
