<?php
/**
 * Plugin Name: Template Debugger
 * Plugin URI: http://www.chubbyninja.co.uk
 * Description: A template debugger that helps you identify what template files are being used on the page you're viewing
 * Version: 2.2.2
 * Author: Danny Hearnah - ChubbyNinjaa
 * Author URI: http://danny.hearnah.com
 * License: GPL2
 *
 * Copyright 2015  DANNY HEARNAH  (email : dan.hearnah@gmail.com)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2, as
 * published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

defined('ABSPATH') or die("No direct access");

$qetl_current_template = $qetl_main_template = '';

/**
 *
 */
function chubby_ninja_admin_bar_style()
{
    wp_register_style('template-debugger', plugin_dir_url(__FILE__) . 'css/quick_edit_template_link.min.css');
    wp_enqueue_style('template-debugger');
}

/**
 *
 */
function chubby_ninja_admin_bar_init()
{
    if ( ! is_super_admin() || ! is_admin_bar_showing() || is_admin()) {
        return;
    }

    load_plugin_textdomain('quick-edit-template-link', false, 'quick-edit-template-link/languages');

    add_action('wp_enqueue_scripts', 'chubby_ninja_admin_bar_style');
    add_action('admin_bar_menu', 'chubby_ninja_admin_bar_link', 500);
}

/**
 *
 */
function chubby_ninja_admin_bar_link()
{
    global $wp_admin_bar, $template, $qetl_main_template;

    $href = $url = '#';

    $explode_on = 'themes';
    if (strstr($template, '/wp-content/plugins/')) {
        $explode_on = 'plugins';
    }
    $explode_content    = explode('/wp-content/' . $explode_on . '/', $template);
    $qetl_main_template = $cur_name = end($explode_content);
    $name               = str_replace('/', ' &rarr; ', $qetl_main_template);

    $explode_content    = explode('/', $qetl_main_template);
    $qetl_main_template = end($explode_content);


    if (current_user_can('edit_themes')) {
        $parts = explode('/', $cur_name, 2);
        $url   = get_bloginfo('wpurl') . '/wp-admin/theme-editor.php?file=%s&theme=%s';

        if (count($parts) > 1) {
            $href = sprintf($url, $parts[1], $parts[0]);
        }
    }

    // Add as a parent menu
    $wp_admin_bar->add_node(array(
        'title' => '<span class="ab-icon"></span>' . $name,
        'href'  => $href,
        'id'    => 'edit-tpl'
    ));


    $options = get_option('qetl_settings');

    if (empty($options['qetl_max_recursive'])) {
        $options['qetl_max_recursive'] = 99;
    }

    if ($options['qetl_checkbox_exectime'] == 1) {


        $load_time = timer_stop(1);
        $wp_admin_bar->add_node(array(
            'parent' => 'edit-tpl',
            'title'  => sprintf(__('Load time: %ss', 'quick-edit-template-link'), $load_time),
            'href'   => '#',
            'id'     => 'edit-tpl-exectime'
        ));

    }

    addPart(parse_includes(), 'edit-tpl', $url, 0, $options['qetl_max_recursive']);
}


/**
 * @param $parts
 * @param $class
 * @param $url
 * @param int $depth
 * @param int $max_depth
 * @param string $prepend_path
 * @param string $type
 */
function addPart($parts, $class, $url, $depth = 0, $max_depth = 99, $prepend_path = '', $type = '')
{

    global $wp_admin_bar, $qetl_current_template, $qetl_main_template;

    $current_prepend_path = $prepend_path;


    if ( ! is_array($parts)) {
        return;
    }
    if ($depth > $max_depth) {
        return;
    }

    foreach ($parts as $key => $part) {

        if ($depth == 0) {
            $type = $key;
        }
        if ($depth == 1) {
            $qetl_current_template = $key;
        }

        $id = $class . '-' . $key;

        if (is_array($part)) {

            if ($depth >= 2) {
                $current_prepend_path = $prepend_path . $key . '/';
            }

            $wp_admin_bar->add_node(array(
                'parent' => $class,
                'title'  => $key,
                'href'   => '#',
                'id'     => $id
            ));

            addPart($part, $id, $url, ($depth + 1), $max_depth, $current_prepend_path, $type);

        } else {

            $href = '#';

            if (current_user_can('edit_themes') && $type == 'themes') {
                $_part = $prepend_path . $part;
                $href  = sprintf($url, $_part, $qetl_current_template);
            }


            if ($part == $qetl_main_template) {
                $part = '* ' . $part;
            }

            $wp_admin_bar->add_node(array(
                'parent' => $class,
                'title'  => $part,
                'href'   => $href,
                'id'     => $id
            ));
        }

    }

}

/**
 * @param $path
 * @param string $separator
 *
 * @return array
 */
function pathToArray($path, $separator = '/')
{
    if (($pos = strpos($path, $separator)) === false) {
        return array($path);
    }

    return array(substr($path, 0, $pos) => pathToArray(substr($path, $pos + 1)));
}

/**
 * @return array
 */
function parse_includes()
{

    $options = get_option('qetl_settings');

    $files = get_included_files();

    $incs = array();

    foreach ($files as $f => $file) {
        if ( ! strstr($file, '/wp-content/themes/') && ! strstr($file, '/wp-content/plugins/')) {
            continue;
        }

        if (empty($options['qetl_checkbox_plugins']) && strstr($file, '/wp-content/plugins/')) {
            continue;
        }

        $explode_file = explode('/wp-content/', $file);
        $file         = end($explode_file);

        if (strstr($file, 'plugins')) {

            $str_replaced     = str_replace('plugins/', '', $file);
            $replaced_explode = explode('/', $str_replaced);
            $replaced_current = current($replaced_explode);
            $hash             = md5($replaced_current);
            if ($options['qetl_exclude_plugin_' . $hash]) {
                continue;
            }
        }

        $incs = array_merge_recursive($incs, pathToArray($file));
    }

    return $incs;
}

/**
 *
 */
function qetl_add_admin_menu()
{

    add_menu_page('Template Debugger', 'Template Debugger', 'manage_options', 'quick_edit_template_link',
        'quick_edit_template_link_options_page');
}

/**
 *
 */
function qetl_settings_init()
{

    register_setting('pluginPage', 'qetl_settings');

    add_settings_section('qetl_pluginPage_section', __('General', 'quick-edit-template-link'),
        'qetl_settings_section_callback', 'pluginPage');
    add_settings_section('qetl_pluginPage_section2', __('Plugins', 'quick-edit-template-link'),
        'qetl_settings_section2_callback', 'pluginPage');

    add_settings_field('qetl_checkbox_exectime', __('Show load time', 'quick-edit-template-link'),
        'qetl_checkbox_field_2_render', 'pluginPage', 'qetl_pluginPage_section');

    add_settings_field('qetl_checkbox_plugins', __('Show Plugins in Dropdown', 'quick-edit-template-link'),
        'qetl_checkbox_field_0_render', 'pluginPage', 'qetl_pluginPage_section2');

    add_settings_field('qetl_exclude_plugins', __('Exclude From Dropdown', 'quick-edit-template-link'),
        'qetl_checkbox_field_1_render', 'pluginPage', 'qetl_pluginPage_section2');
    add_settings_field('qetl_exclude_plugins', __('Maximum recursive depth', 'quick-edit-template-link'),
        'qetl_textarea_field_0_render', 'pluginPage', 'qetl_pluginPage_section');

    add_settings_section('qetl_pluginPage_child', '', 'qetl_pluginPage_child_callback', 'childTheme');
    add_settings_field('qetl_select_theme', __('Select Parent Theme', 'quick-edit-template-link'), 'qetl_select_render',
        'childTheme', 'qetl_pluginPage_child');
    add_settings_field('qetl_theme_name1', __('Child Theme Name', 'quick-edit-template-link'),
        'qetl_text_child_name_render', 'childTheme', 'qetl_pluginPage_child');
    add_settings_field('qetl_theme_name2', __('Author Name', 'quick-edit-template-link'),
        'qetl_text_child_author_render', 'childTheme', 'qetl_pluginPage_child');
    add_settings_field('qetl_theme_name3', __('Author URI', 'quick-edit-template-link'),
        'qetl_text_child_author_uri_render', 'childTheme', 'qetl_pluginPage_child');
    add_settings_field('qetl_theme_name4', __('Child Theme Version', 'quick-edit-template-link'),
        'qetl_text_child_version_render', 'childTheme', 'qetl_pluginPage_child');

    qetl_check_form_action();
}

$qetl_error = $qetl_success = false;
function qetl_check_form_action()
{
    global $qetl_error, $qetl_success;
    if ( ! isset($_POST['action'])) {
        return;
    }
    if ($_POST['action'] != 'qetl_generate_child') {
        return;
    }

    // lets create the child theme
    $parent     = $_POST['qetl_parent_theme'];
    $name       = $_POST['qetl_child_name'];
    $slug       = sanitize_title($name);
    $author     = $_POST['qetl_child_author'];
    $author_uri = $_POST['qetl_child_author_uri'];
    $version    = $_POST['qetl_child_version'];

    if (empty($parent) || empty($name) || empty($author) || empty($version)) {
        $qetl_error = new WP_Error('broke',
            __("The parent theme, name, author and version must not be blank", "quick-edit-template-link"));

        return;
    }

    $ph   = array(
        '$name',
        '$uri',
        '$author_uri',
        '$author',
        '$parent',
        '$version'
    );
    $live = array(
        $name,
        '',
        $author_uri,
        $author,
        $parent,
        $version
    );

    $root = get_theme_root();
    $path = $root . '/' . $slug;


    if (is_dir($path)) {
        $path .= '_' . wp_generate_password(5, false);
    }

    $ok = wp_mkdir_p($path);
    if ( ! $ok) {
        $qetl_error = new WP_Error('broke',
            __("I could not create your theme directory, please make sure " . $root . " is writable",
                "quick-edit-template-link"));

        return;
    }


    // create default files
    $default_functions = file_get_contents(__DIR__ . '/admin/functions.php');
    $functions         = str_replace($ph, $live, $default_functions);
    $fp                = fopen($path . '/functions.php', 'w');
    fwrite($fp, $functions);
    fclose($fp);

    $default_css = file_get_contents(__DIR__ . '/admin/style.css');
    $css         = str_replace($ph, $live, $default_css);
    $fp          = fopen($path . '/style.css', 'w');
    fwrite($fp, $css);
    fclose($fp);

    $qetl_success = true;

}

function qetl_pluginPage_child_callback()
{
}

/**
 *
 */
function qetl_select_render()
{
    $theme_list = wp_get_themes();
    ?>
    <select name="qetl_parent_theme" id="">
        <option value=""><?php echo __('Select Theme', 'quick-edit-template-link'); ?></option>
        <?php
        foreach ($theme_list as $theme_slug => $theme__) {
            $theme = wp_get_theme($theme_slug);
            if ($theme->get('Template')) {
                continue;
            }

            $name = $theme->get('Name');

            if ( ! $name) {
                $name = $theme_slug;
            }

            ?>
            <option value="<?php echo $theme_slug; ?>" <?php echo((isset($_POST['qetl_parent_theme'])) ? ' selected=selected ' : null); ?> ><?php echo $name; ?></option>
            <?php
        }
        ?>
    </select>
    <?php
}

function qetl_text_child_name_render()
{
    ?>
    <input type='text' name='qetl_child_name' value="<?php echo((isset($_POST['qetl_child_name'])) ? $_POST['qetl_child_name'] : null); ?>">
    <?php
}

function qetl_text_child_author_render()
{

    $current_user = wp_get_current_user();
    ?>
    <input type='text' name='qetl_child_author' value="<?php echo((isset($_POST['qetl_child_name'])) ? $_POST['qetl_child_author'] : $current_user->display_name); ?>">
    <?php
}

function qetl_text_child_author_uri_render()
{
    ?>
    <input type='text' name='qetl_child_author_uri' value="<?php echo((isset($_POST['qetl_child_name'])) ? $_POST['qetl_child_author_uri'] : null); ?>">
    <?php
}

function qetl_text_child_version_render()
{
    ?>
    <input type='text' name='qetl_child_version' value="<?php echo((isset($_POST['qetl_child_name'])) ? $_POST['qetl_child_version'] : '1.0.0'); ?>">
    <?php
}


/**
 *
 */
function qetl_checkbox_field_0_render()
{

    $options = get_option('qetl_settings');
    ?>
    <input type='checkbox' name='qetl_settings[qetl_checkbox_plugins]' <?php checked($options['qetl_checkbox_plugins'],
        1); ?> value='1'>
    <?php
}


/**
 *
 */
function qetl_checkbox_field_2_render()
{

    $options = get_option('qetl_settings');
    ?>
    <input type='checkbox' name='qetl_settings[qetl_checkbox_exectime]' <?php checked($options['qetl_checkbox_exectime'],
        1); ?> value='1'>
    <?php
}

/**
 *
 */
function qetl_textarea_field_0_render()
{

    $options = get_option('qetl_settings');
    ?>
    <input type='text' name='qetl_settings[qetl_max_recursive]' value='<?php echo $options['qetl_max_recursive']; ?>'> (0 = <?php echo __('unlimited',
    'quick-edit-template-link'); ?>)
    <?php
}

/**
 *
 */
function qetl_checkbox_field_1_render()
{

    $options = get_option('qetl_settings');
    $plugins = get_plugins();

    foreach ($plugins as $key => $val) {
        $hash = md5(current(explode('/', $key)));
        ?>
        <input type='checkbox' name='qetl_settings[qetl_exclude_plugin_<?php echo $hash; ?>]' <?php checked($options['qetl_exclude_plugin_' . $hash],
            1); ?> value='1'>
        <?php echo $val['Name']; ?><br>
        <?php
    }

}

/**
 *
 */
function qetl_settings_section_callback()
{

    echo __('This plugin appends the admin bar with a dropdown showing you what files are being included on that specific page',
        'quick-edit-template-link');

}

/**
 *
 */
function qetl_settings_section2_callback()
{

    echo __('If you want to exclude specific plugins from the dropdown, select them here', 'quick-edit-template-link');

}

/**
 *
 */
function quick_edit_template_link_options_page()
{

    $active_tab = 'general';

    if (isset($_GET['tab'])) {
        $active_tab = $_GET['tab'];
    }
    ?>
    <div class="wrap">
        <h1>Template Debugger</h1>

        <?php
        $donate_link = 'https://wordpress.org/support/view/plugin-reviews/quick-edit-template-link';
        ?>
        <p><?php echo sprintf(__('If you find this plugin useful or would like to see something added, please take a minute to <a href="%s" target="_blank">Rate &amp; Review</a> the plugin.',
                'quest-edit-template-link'), $donate_link); ?></p>

        <div style="width:60%;float:left;">

            <h2 class="nav-tab-wrapper">
                <a class="nav-tab <?php echo(($active_tab == 'general') ? 'nav-tab-active' : null); ?>" href="admin.php?page=quick_edit_template_link"><?php echo __('General',
                        'quick-edit-template-link'); ?></a>
                <a class="nav-tab <?php echo(($active_tab == 'child_theme') ? 'nav-tab-active' : null); ?>" href="admin.php?page=quick_edit_template_link&tab=child_theme"><?php echo __('Create a Child Theme',
                        'quick-edit-template-link'); ?></a>
            </h2>

            <?php
            switch ($active_tab) {
                case 'general':
                    ?>
                    <form action='options.php' method='post'>
                        <?php
                        settings_fields('pluginPage');
                        do_settings_sections('pluginPage');
                        submit_button();
                        ?>
                    </form>
                    <?php
                    break;

                case 'child_theme':
                    doThemeCreateForm();
                    break;

                default:
                    settings_fields('pluginPage');
                    do_settings_sections('pluginPage');
                    submit_button();
            }

            ?>
        </div>
        <div style="width:35%;float:right;">
            <h3><?php echo __('Advert', 'quick-edit-template-link'); ?></h3>

            <p><?php echo __('This advert is to help contribute to development costs.',
                    'quick-edit-template-link'); ?></p>
            <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
            <!-- Quick Edit Template Link -->
            <ins class="adsbygoogle"
                 style="display:inline-block;width:300px;height:600px"
                 data-ad-client="ca-pub-4524739862142506"
                 data-ad-slot="7190258734"></ins>
            <script>
                (adsbygoogle = window.adsbygoogle || []).push({});
            </script>
        </div>
        <div class="clear:both;"></div>
    </div>
    <?php

}


function doThemeCreateForm()
{
    ?>
    <p><?php echo __('When you download a theme and want to modify it, you should always do so in a child theme, this ensures your changes are not lost when the theme is updated by the author.',
            'quick-edit-template-link'); ?></p>

    <p><?php echo __('Using the form below, you can easily create the child theme', 'quick-edit-template-link'); ?></p>

    <?php
    global $qetl_error, $qetl_success;
    if (is_wp_error($qetl_error)) {
        ?>
        <div id="" class="error">
            <p><?php echo $qetl_error->get_error_message(); ?></p>
        </div>
        <div style="border-left:solid 4px #f90000; background-color:#fff; box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);">
            <p style="margin: 0;padding: 13px 17px;"><?php echo $qetl_error->get_error_message(); ?></p>
        </div>
        <?php
    }

    if ($qetl_success) {

        $message = sprintf(__('Your Child theme has been created, head over to <a href="%s" target="_blank">Themes</a> to activate it.',
            'quest-edit-template-link'), admin_url('themes.php'));
        ?>
        <div id="" class="updated">
            <p><?php echo $message; ?></p>
        </div>
        <div id="" style="border-left:solid 4px #7ad03a; background-color:#fff; box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);">
            <p style="margin: 0;padding: 13px 17px;"><?php echo $message; ?></p>
        </div>

        <?php
        $donate_link = 'https://wordpress.org/support/view/plugin-reviews/quick-edit-template-link';
        ?>
        <p style="font-weight: bold;"><?php echo sprintf(__('If you find this plugin useful or would like to see something added, please take a minute to <a href="%s" target="_blank">Rate &amp; Review</a> the plugin.',
                'quest-edit-template-link'), $donate_link); ?></p>
        <?php
    } else {
        ?>
        <form action="" method="post">
            <input type="hidden" name="action" value="qetl_generate_child">
            <?php
            do_settings_sections('childTheme');
            submit_button(__('Create Child Theme', 'quick-edit-template-link'));
            ?>
        </form>
        <?php
    }
}


function qetl_add_meta_box()
{
    add_meta_box('qetl_meta_box', __('Template Debugger'), 'qetl_metabox_callback', null, 'side', 'high');
}

/**
 * Get post meta in a callback
 *
 * @param WP_Post $post The current post.
 * @param array $metabox With metabox id, title, callback, and args elements.
 */

function qetl_metabox_callback($post, $metabox)
{
    ?>
    <strong><?php echo __('Template(s)', 'quick-edit-template-link'); ?></strong>
    <?php
    if ( ! $post->ID || ! $post->post_name) {
        ?>
        <p><?php echo __('You must save this item before options are available', 'quick-edit-template-link'); ?></p>
        <?php
    } else {

        $is_post_type    = false;
        $template_prefix = 'page';
        $version_used    = $more_options = $version_used = $version_id = null;

        switch ($post->post_type) {
            case 'page':
                break;

            case 'post':
                $template_prefix = 'single';
                $is_post_type    = true;
                break;

            default:
                $is_post_type    = true;
                $template_prefix = 'single-' . $post->post_type;
                $more_options    = '<option value="custom_post_type">' . $template_prefix . '.php</option>';
        }


        if ($is_post_type) {

            if (file_exists(get_template_directory() . '/' . $template_prefix . '.php')) {
                $version_used = 'custom_post_type';
            }

        } else {

            $slug_version = $template_prefix . '-' . $post->post_name . '.php';
            $id_version   = $template_prefix . '-' . $post->ID . '.php';


            if (file_exists(get_template_directory() . '/' . $slug_version)) {
                $version_used = 'slug';
            }
            if (file_exists(get_template_directory() . '/' . $id_version)) {
                $version_used = 'id';
            }


            $frontpage_id = get_option('page_on_front');
            if ($frontpage_id == $post->ID) {
                if (file_exists(get_template_directory() . '/front-page.php')) {
                    $version_used = 'slug';
                    $slug_version = 'front-page.php';
                }
                $more_options = '<option value="front-page">front-page.php</option>';
            }
        }

        if ($version_used) {
            if ($is_post_type) {
                $v = $template_prefix . '.php';
            } else {
                $v = (($version_used == 'id') ? $id_version : $slug_version);
            }
            ?>
            <p><?php echo sprintf(__('This uses <strong>%s</strong>', 'quick-edit-template-link'), $v); ?></p>
            <?php
            return;
        }
        if ( ! is_writable(get_template_directory() . '/')) {
            ?>
            <p><?php echo __('Your themes directory is not writable', 'quick-edit-template-link'); ?></p>
            <?php
            return;
        }
        ?>
        <p><?php echo __('Create a page specific template', 'quick-edit-template-link'); ?></p>
        <select name="qetl_create_template" id="">
            <option value=""><?php echo __('Select Template', 'quick-edit-template-link'); ?></option>
            <?php echo $more_options; ?>
            <?php
            if ( ! $is_post_type) {
                ?>
                <option value="slug"><?php echo $template_prefix; ?>-<?php echo $post->post_name; ?>.php</option>
                <option value="id"><?php echo $template_prefix; ?>-<?php echo $post->ID; ?>.php</option>
                <?php
            }
            ?>
        </select>
        <?php
    }
}

function qetl_save_meta_box($post_id)
{

    if ( ! isset($_POST['qetl_create_template'])) {
        return;
    }
    if (empty($_POST['qetl_create_template'])) {
        return;
    }

    $version = $_POST['qetl_create_template'];
    $post    = get_post($post_id);

    $file      = null;
    $copy_from = 'page';

    if ($version == 'slug') {
        $file = 'page-' . $post->post_name;
    } elseif ($version == 'id') {
        $file = 'page-' . $post->ID;
    } elseif ($version == 'front-page') {
        $file = 'front-page';
    } elseif ($version == 'custom_post_type') {
        $file      = 'single-' . $post->post_type;
        $copy_from = 'single';
    }

    if ($file) {
        if ( ! file_exists(get_template_directory() . '/' . $file . '.php')) {

            if ( ! file_exists(get_template_directory() . '/' . $copy_from . '.php')) {
                $copy_from = 'index';
            }
            copy(get_template_directory() . '/' . $copy_from . '.php', get_template_directory() . '/' . $file . '.php');
        }
    }

}

add_action('save_post', 'qetl_save_meta_box');
add_action('add_meta_boxes', 'qetl_add_meta_box');
add_action('admin_bar_init', 'chubby_ninja_admin_bar_init');
add_action('admin_menu', 'qetl_add_admin_menu');
add_action('admin_init', 'qetl_settings_init');
