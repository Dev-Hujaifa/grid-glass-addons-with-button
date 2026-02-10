<?php
/*
Plugin Name: Grid Glass Addons With Button
Description: Elegant Glassmorphism Elementor Addons including Card Grid and Advanced Button widgets.
Version: 1.0.0
Author: MD.ABU HOJAIFA
Author URI: https://github.com/Dev-Hujaifa
License: GPLv2 or later
Text Domain: grid-glass-addons-with-button
*/

if ( ! defined( 'ABSPATH' ) ) exit;

/* 🔌 Plugin Init */
add_action( 'plugins_loaded', function() {

    /* Load text domain */
    load_plugin_textdomain(
        'egup-glass-addon',
        false,
        dirname( plugin_basename( __FILE__ ) ) . '/languages'
    );

    /* Elementor dependency check */
    if ( ! did_action( 'elementor/loaded' ) ) {
        add_action( 'admin_notices', function(){
            echo '<div class="notice notice-error"><p>';
            echo esc_html__( 'Grid Glass Addons requires Elementor to be installed and activated.', 'egup-glass-addon' );
            echo '</p></div>';
        });
        return;
    }

    /* Register Elementor widgets */
    add_action( 'elementor/widgets/register', function( $widgets_manager ){

        require_once __DIR__ . '/widgets/glass-card-grid.php';
        require_once __DIR__ . '/widgets/glass-button-pro.php';

        $widgets_manager->register( new \EGUP_Glass_Card_Grid() );
        $widgets_manager->register( new \EGUP_Glass_Button_Pro() );
    });
});

/* 🎨 CSS enqueue */
add_action( 'wp_enqueue_scripts', function(){
    wp_enqueue_style(
        'egup-glass-style',
        plugin_dir_url( __FILE__ ) . 'assets/css/glass.css',
        [],
        '1.0.0'
    );
});
