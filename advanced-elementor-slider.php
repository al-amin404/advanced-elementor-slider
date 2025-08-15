<?php
/**
 * Plugin Name: Advanced Elementor Slider
 * Description: Advanced pro Elementor elements for the Elementor Website Builder.
 * Plugin URI: https://github.com/al-amin404/advanced-elementor-slider
 * Version: 1.0.0
 * Author: Al Amin
 * Author URI: https://github.com/al-amin404
 * Requires PHP: V7.4
 * License: GPLv2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: aes_slider
 * Domain Path: /languages
 * 
 * Requires Plugins: elementor
 * Elementor tested up to: 3.25.0
 * Elementor Pro tested up to: 3.25.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


add_action('elementor/widgets/register', 'register_aes_slider');
add_action('wp_enqueue_scripts', 'register_slider_assets');
// add_action('elementor/frontend/after_register_styles', 'register_slider_styles');
add_action( 'elementor/frontend/after_enqueue_scripts', 'enqueue_slider_scripts' );
add_action( 'elementor/frontend/after_enqueue_styles', 'enqueue_slider_styles' );

function register_aes_slider($widget_manager){
    require_once (plugin_dir_path(__FILE__).'/includes/slider.php');

    $widget_manager->register(new Slider());
}

function register_slider_assets(){
    wp_register_style('aes-slider-style', plugin_dir_url(__FILE__).'assets/slider-styles.css', [], '1.0.0');

    wp_register_script('aes-slider-script', plugin_dir_url(__FILE__).'assets/slider.js', ['jquery', 'elementor-frontend'], time(), true);
}

function enqueue_slider_scripts(){
    wp_enqueue_script('aes-slider-script');
}

function enqueue_slider_styles(){
    wp_enqueue_style('aes-slider-style');
}
