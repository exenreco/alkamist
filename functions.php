<?php

## This script uses strict types
declare(strict_types=1);

## This script has a namespace
namespace Alkamist;

# If an absolute path to was not uses to acces this script prevents 
# this script from excicuting
defined('ABSPATH') or die('Unathorized access are not allowed!');



## checks if wp error class exists
if( ! class_exists('\WP_Error') ) { return; }

## checks if theme can get template directory
if ( ! function_exists('\get_template_directory') ) { return; }



## includes wp required scripts wp_error class
use WP_Error as WP_Error;



## Checks if theme root directory path
if( ! \defined('__ROOT__') ):
    ## defines theme root directory path
    \define( '__ROOT__', get_template_directory() . '/' );
endif;

## Checks if theme assets path is defined
if( ! \defined('__ASSETS__') ):
    ## defines assets path
    \define( '__ASSETS__', __ROOT__ . 'assets/' );
endif;

## Checks if theme blocks path is defined
if( ! \defined('__BLOCKS__') ):
    ## defines blocks path
    \define( '__BLOCKS__', __ASSETS__ . 'blocks/' );
endif;

## Checks if theme class path is defined
if( ! \defined('__CLASSES__') ):
    ## defines classes path
    \define( '__CLASSES__', __ROOT__ . 'classes/' );
endif;


# Theme function "theme_data"
if( ! \function_exists('theme_data') ):
    /**
     * GET THEME DATA
     * 
     * Returns the theme data when available.
     * 
     * Defaults to false when in valid
     *
     * @param [type] $option The theme option to get
     * 
     * @see wp/function wp_get_theme()
     * 
     * @since 1.0.0
     * 
     * @return mixed the requested value when valid otherwise false. 
     */
    function theme_data()
    {
        ## check for wordpress wp_get_theme function
        return ( \function_exists('\wp_get_theme') )
        ? # function found
            \wp_get_theme()
        : # function not found
            false
        ;
    }
endif;


## includes theme required script base class
require_once( __CLASSES__ . 'base.php' );

## Checks for valid theme class base
if( ! \class_exists('Alkamist\Base', true) ):
    # Whenever theme main class fails
    return new WP_Error(
        "ALK: (BASE-001)",
        "
            Theme main class not found, try reinstalling the 
            theme or remove any changes made to all theme files.
        ",
        "
            Triggered From: functions.php,
            Missing class: /classes/base.php
        "
    );
endif;

## includes theme required script setup class
require_once( __CLASSES__ . 'setup.php' );

## Initialize theme if not initialize
if( ! isset($THEME) || ! $THEME || empty($THEME) ):

    # Get theme data
    $data = theme_data();

    # Theme namespace
    $namespace = '';

    # Theme textdomain
    $textdomain = '';

    # Set thme data from style.css
    if( \is_object($data) )
    {
        # Get theme namespace
        $namespace = $data->get("Name");

        # Get theme text domain
        $textdomain = $data->get("TextDomain");
    }

    # Global theme instance
    $THEME = Setup::init([
        'namespace'     => $namespace,
        'textdomain'    => $textdomain
    ]);
endif;


// ! block class is disabled !!!! fix errors here!!!

function copy_block_xxx()
{
    wp_register_script(
        'copyright-block-editor-script',
        get_template_directory_uri() . "/assets/blocks/copyright-block/assets/js/editor_handles.js",
        array(
            'wp-dom',
            'wp-data',
            'wp-i18n',
            'wp-blocks',
            'wp-element',
            'wp-components',
            'wp-block-editor'
        ),
        false,
        false,
    );
    wp_register_style(
        'copyright-block-editor-styles',
        get_template_directory_uri() . "/assets/blocks/copyright-block/assets/css/editor_handles.css",
        array(),
        false,
        'all',
    );

    

    \register_block_type( 
        'alkamist/copyright',
        array(
            //'block.json'            =>  file_get_contents(get_template_directory() . "/assets/blocks/copyright-block/block.json"),
            'script_handles'        => ['copyright-block-editor-script'],
            'view_script_handles'   => ['copyright-block-editor-script'],
            'editor_script_handles' => ['copyright-block-editor-script'],
            'editor_style_handles'  => ['copyright-block-editor-styles'],
        )
    );

    \wp_enqueue_script( 'copyright-block-editor-script' );
    \wp_enqueue_style( 'copyright-block-editor-styles' );
}
\add_action('admin_enqueue_scripts', "Alkamist\copy_block_xxx", 5, 0 );
\add_action('wp_enqueue_scripts', "Alkamist\copy_block_xxx", 5, 0 );
