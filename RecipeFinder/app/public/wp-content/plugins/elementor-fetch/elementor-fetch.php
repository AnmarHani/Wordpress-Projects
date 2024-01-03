<?php

/**
 * Plugin Name: Elementor Fetch
 * Description: A custom Elementor widget plugin to fetch (GET, POST)to external APIs.
 * Version: 1.0
 * Author: Anmar Hani
 */

namespace ElementorFetchWidgets;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Hook for registering widgets
add_action('elementor/widgets/widgets_registered', 'ElementorFetchWidgets\register_elementor_fetch_widgets');

function register_elementor_fetch_widgets()
{
    if (class_exists('Elementor\Widget_Base')) {
        require_once(realpath(plugin_dir_path(__FILE__)) . DIRECTORY_SEPARATOR . 'widgets' . DIRECTORY_SEPARATOR . 'fetch-button.php');
        require_once(realpath(plugin_dir_path(__FILE__)) . DIRECTORY_SEPARATOR . 'widgets' . DIRECTORY_SEPARATOR . 'fetch-text.php');
        require_once(realpath(plugin_dir_path(__FILE__)) . DIRECTORY_SEPARATOR . 'widgets' . DIRECTORY_SEPARATOR . 'fetch-form.php');
        \Elementor\Plugin::instance()->widgets_manager->register(new FetchButton());
        \Elementor\Plugin::instance()->widgets_manager->register(new FetchText());
        \Elementor\Plugin::instance()->widgets_manager->register(new FetchForm());
    }
}

// Hook to add  custom category
add_action('elementor/elements/categories_registered', 'ElementorFetchWidgets\add_elementor_fetch_categories');

// Function to add a new category for custom widgets
function add_elementor_fetch_categories($elements_manager)
{
    $elements_manager->add_category(
        'elementor-fetch-widgets',
        [
            'title' => "Elementor Fetch Widgets",
            'icon' => 'fa fa-plug',
        ]
    );
}
