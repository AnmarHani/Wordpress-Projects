<?php

function fitTheme_theme_support()
{

    add_theme_support('title-tag'); // Dynamic Title Tag from WP.
    add_theme_support('custom-logo'); // Dynamic Logo from WP.
}

add_action('after_setup_theme', 'fitTheme_theme_support');

function fitTheme_register_styles()
{
    wp_enqueue_style('global-fittheme-styles', get_template_directory_uri() . '/style.css', [], wp_get_theme()->get("Version"), 'all');
}

add_action('wp_enqueue_scripts', 'fitTheme_register_styles'); // When WP runs scripts 'from the hook' run my function too.

function fitTheme_register_scripts()
{
    wp_enqueue_script('global-fittheme-scripts', get_template_directory_uri() . '/script.js', [], wp_get_theme()->get("Version"), true);
}

add_action('wp_enqueue_scripts', 'fitTheme_register_scripts'); // When WP runs scripts 'from the hook' run my function too.


function fitTheme_menus()
{
    $location_of_menus = [
        "top" => "Primary Location (Top)"
    ];

    register_nav_menus($location_of_menus);
}

add_action("init", "fitTheme_menus");
