<?php

## This script uses strict types
declare(strict_types=1);

## This script has a namespace
namespace Alkamist;

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

## Checks if theme class path is defined
if( ! \defined('__CLASSES__') ):
    ## defines classes path
    \define( '__CLASSES__', __ROOT__ . 'classes/' );
endif;

## Checks if theme blocks path is defined
if( ! \defined('__BLOCKS__') ):
    ## defines blocks path
    \define( '__BLOCKS__', __ASSETS__ . 'blocks/' );
endif;


# checks for Base class, the master class that the blocks class extends
if( ! class_exists('Alkamist\Base') ): 
    ## includes theme required script base class
    require_once( __CLASSES__ . 'base.php' );
endif;


## Defines WP_Error class as WP_Error
use WP_Error as WP_Error;

## Defines Base class as Base
use Alkamist\Base as Base;


class Blocks extends Base
{
    /**
     * INSTANCE
     * 
     * All instances created by this class.
     *
     * @var object
     * 
     * @since version 1.0.0
     */
    private static object $instance;

    /**
     * BLOCK DIRECTORY
     * 
     * The location of all defined theme blocks.
     *
     * @var string
     * 
     * @since version 1.0.0
     */
    private static string $block_directory;

    /**
     * BLOCKS
     * 
     * The list of blocks to register.
     *
     * @var array
     * 
     * @since version 1.0.0
     */
    private static array $blocks = array(
        // usues init php that is 'init.php'
        /*'copyright' => array(
            'path'          => '',
            'namespace'     => '',
            'register'      => array(),
            'options'       => array()
        )*/
    );

    /**
     * BLOCK OPTIONS
     * 
     * The default list of posible values of a 
     * block type to be registered.
     *
     * @var array The default options used for registering blocks
     * {
     * 
     *  Possible values:
     *  @see https://developer.wordpress.org/reference/functions/register_block_type_from_metadata/
     * }
     */
    private static array $block_options = array(
        'api_version'           => '',
        'title'                 => '',
        'category'              => '',
        'parent'                => [],
        'ancestor'              => [],
        'icon'                  => '',
        'description'           => '',
        'keywords'              => [],
        'textdomain'            => '',
        'styles'                => '',
        'variations'            => [],
        'supports'              => array(),
        'example'               => array(),
        'render_callback'       => null,
        'attributes'            => array(),
        'uses_context'          => [],
        'provides_context'      => '',
        'editor_script_handles' => [],
        'script_handles'        => [],
        'view_script_handles'   => [],
        'editor_style_handles ' => [],
        'style_handles'         => []
    );

    /**
     * SET BLOCK DIRECTORY
     * 
     * Defines the location to look for theme block.
     * 
     * Defaults to "alkamist/assets/blocks/" 
     * if this location exists.
     *
     * @param string $path The directory path
     * 
     * @since version 1.0.0
     * 
     * @return true once valid
     */
    final public static function set_block_directory( string $path = '' )
    {
        // Ensure the directory path ends with a trailing slash.
        if (substr($path, -1) !== '/')
        {
            $path .= "/";
        }

        ## set instance  diretory
        self::$block_directory = ( self::is_valid_directory($path) )
        ? # user dir
            $path
        : # invalid dir
            ''
        ;

        return true;
    }

    /**
     * GET BLOCK DIRECTORY
     * 
     * Returns the current instance block directory.
     *
     * @since version 1.0.0
     * 
     * @return mixed When valid the instance block directory string otherwise null
     */
    final public static function get_block_directory()
    {
        return ( isset( self::$block_directory ) && !empty( self::$block_directory ) )
        ? # the set textdomain
            self::$block_directory
        : # not set
            null
        ;
    }

    /**
     * LOAD DIRECTORY BLOCKS
     *
     * @return void
     */
    private static function load_directory_blocks()
    {
        ## the given block directory path
        $directory = self::get_block_directory();

        ## checks for invalid directory
        if( ! self::is_valid_directory($directory) 
        || ! \function_exists('\array_filter') )
        {
            # diretory invalid
            return false;
        }

        ## block files as array values
        $blocks = array();

        ## Get a list of block subdirectories.
        $subdirectories = \array_filter(glob($directory . '/*'), 'is_dir');
        
        # for each [blocks as block] 
        # that is each [subdirectories as subdirectory]
        foreach ($subdirectories as $subdirectory)
        { 
            ## directory name as key
            $block_name = \basename($subdirectory);

            ## directory files as value
            $block_values = array();

            // Get the list of files in the directory.
            if ( \is_readable($subdirectory) )
            {
                # iterate scandir to remove current dir deeper dir
                $block_values = \array_filter( \scandir($subdirectory),
                function($block_value)
                {
                    return !\in_array($block_value, array('.', '..'));
                });
            }

            ## adds new block array
            $blocks[$block_name] = $block_values;
        }

        # for each defined blocks from sub directory
        foreach( $blocks as $block_name => $block_files )
        {
            ## Checks for valid blocks
            if( self::is_valid_string($block_name) 
            && self::is_valid_array($block_files) 
            && \in_array('init.php', $block_files, false) )
            {
                ## the block init file
                $block_settings = include(
                    "$directory" . "$block_name" . "/init.php"
                );

                if( self::is_valid_array($block_settings) )
                {
                    ## Set block path
                    $block_path = ( isset($block_settings['path']) 
                    && \file_exists($block_settings['path']) )
                    ?
                        self::$blocks[$block_name]['path'] 
                        = $block_settings['path']
                    :
                        null
                    ;

                    ## Block scripts to register
                    $block_register = ( isset($block_settings['register']) 
                    && self::is_valid_array($block_settings['register']) )
                    ?
                        self::$blocks[$block_name]['register'] 
                        = $block_settings['register']
                    :
                        array()
                    ;

                    ## Set block php options
                    $block_options = ( isset($block_settings['options']) 
                    && self::is_valid_array( $block_settings['options'] ) )
                    ?
                        self::$blocks[$block_name]['options'] 
                        = $block_settings['options']
                    :
                        array()
                    ;

                    ## Set block json file
                    $block_json = ( isset($block_settings['block.json']) 
                    && \file_exists($block_settings['block.json']) )
                    ?
                        self::$blocks[$block_name]['block.json'] 
                        = $block_settings['block.json']
                    :
                        ''
                    ;

                    # updates block property
                    self::$blocks[] = array(
                        $block_name => array(
                            'path'          => $block_path,
                            'register'      => $block_register,
                            'options'       => $block_options,
                            'block.json'    => $block_json,
                        )
                    );
                }
            }
        }
    }


    final public static function register_blocks()
    {
        if( ! isset(self::$blocks) || ! self::is_valid_array(self::$blocks) ):
            return false;
        endif;

        foreach( self::$blocks as $block_name => $args ):
            if( self::is_valid_string($block_name) 
            && self::is_valid_array($args) ):

                if( isset( $args['options'] ) 
                && self::is_valid_array($args['options']) ):
                    \register_block_type($block_name, $args['options']);
                endif;

                if( isset($args['block.json'])
                && self::is_valid_array($args['block.json']) ):
                    \register_block_type( $args['block.json'] );
                endif;

            endif;
        endforeach;

        return true;
    }



    


    // ! the aim is to remove this function
    /*final public static function register_blocks()
    {
        ## prevents register block if in valid blocks
        if( ! isset(self::$blocks)  || empty (self::$blocks) 
        || \count(self::$blocks) < 1 ):
            return false;
        endif;

        foreach( self::$blocks  as $block_name => $block_script )
        {
            # the current block in loop
            $current_block      = self::$blocks[$block_name];
            $block_init_file    = self::$block_directory . $block_name . '/init.php';

            if( \in_array('init.php', self::$blocks[$block_name], false) 
            && \is_file($block_init_file) ):

                # get block settings
                $block_setting = include_once($block_init_file);

                if( \is_array($block_setting) && !empty($block_setting) ):

                     # get block metadata option path [block path location]
                    $block_path = ( \array_key_exists('path', $block_setting)
                    && file_exists($block_setting['path']) )
                    ?
                        $block_setting['path']
                    :
                        ''
                    ;
                    
                    if($block_path && $block_path !== '' ):
                        if( isset($block_setting['scripts']) 
                        && \is_array($block_setting['scripts']) ):
                            foreach($block_setting['scripts'] as $handle => $options )
                            {
                                if( isset(self::$block_scripts) 
                                && isset(self::$block_scripts['scripts']) 
                                && \is_array(self::$block_scripts['scripts']) ):
                                    self::$block_scripts['scripts'][$handle] = $options;
                                endif;
                            }
                            unset($handle, $options);
                        endif;

                        $valid_options = array();
                        if( isset($block_setting['options']) 
                        && \is_array($block_setting['options']) ):
                            foreach($block_setting['options'] as $key => $value)
                            {
                                if( \array_key_exists($key, self::$block_options) )
                                {
                                    $valid_options[$key] = $value;
                                }
                            }
                            unset($options, $value);
                        endif;

                        if( $valid_options && \is_array($valid_options) 
                        && \count($valid_options) >= 1 ):
                            //var_dump($block_path);

                            ## register block scripts
                            //self::register_scripts();

                            ## register blocks from block json
                            \register_block_type(
                                "$block_path/block.json",
                                //$valid_options
                            );
                        endif;
                    endif;
                endif;
            endif;
        }
    }*/

    

    /**
     * SET BLOCKS BASE SETTINGS
     *
     * Set required theme settings on initialize.
     * 
     * @param array $settings An associated array of setup settings
     * {
     * 
     *  possible value:
     *  - @var string $settings[namespace] The theme's namespace, optional
     * 
     *  - @var string $settings[textdomain] The theme's textdomain, optional
     * 
     *  - @var string $settings[directory] The theme's blocks location, optional
     * 
     * }
     * 
     * @since version 1.0.0
     * 
     * @return bool true when settings are set otherwise false
     */
    final protected static function set_base_settings( array $settings )
    {
        ## get base class settings
        $base_settings      = parent::set_base_settings($settings);

        ## block class settings
        $blocks_setteings   = false;

        ## Change array key to lowercase when possible
        $settings = ( \is_array($settings) && !empty($settings)
        && \function_exists('\array_change_key_case') )
        ? # can change keys
            \array_change_key_case($settings, 0)
        : # cant change keys
            $settings
        ;

        # check for custom block directory before sanitize
        $directory = ( isset($settings['directory']) 
        && self::is_valid_string($settings['directory']) )
        ? # use user value
            $settings['directory']
        : # default value
            __BLOCKS__
        ;

        if( self::is_valid_directory( $directory ) ):
            ## set block directory
            self::set_block_directory($directory);

            ## load blocks from directory
            self::load_directory_blocks();

            $blocks_setteings = true;
        endif;

        # ensure base settings and block directory are set
        return ($base_settings === true && $blocks_setteings === true)
        ?
            true
        :
            false
        ;
    }

    /**
     * CONSTRUCTOR
     * 
     * {
     * 
     *  Private constructor is a special type of constructor that is declared as private.
     *  
     *  Private constructors are used to prevent direct instantiation of a class.
     * 
     *  This means that you cannot create a new instance of the class using 
     * 
     *  the new keyword from outside the class.
     * 
     * }
     * 
     * @since version 1.0.0
     * 
     * @return null
     */
    private function __construct( array $settings = array(), array $options = array() )
    { ## private constructor to prevent direct instantiation

        # set required base properties in base class
        $bas_Settings = self::set_base_settings( $settings );

        # ensure base settings applied
        if( $bas_Settings && $bas_Settings === true):

            # Determins if theme can register blocks
            if( self::can_register_block_type() && self::can_hook() ):

                ## register blocks && block scripts
                \add_action( 'init', array(new self(), 'register_blocks'), 9, 0 );

            endif;

        endif;
    }

    /**
     * INIT
     * 
     * The method use to initialize all new instances of this class.
     *
     * @since version 1.0.0
     * 
     * @return object The current setup instance 
     */
    final public static function init( array $settings = array(), array $options = array() )
    {
        ## Checks if instance is already set
        if ( ! isset( self::$instance ) || empty( self::$instance ) )
        {
            if( isset( $settings ) && \is_array($settings) )
            {
                ## Creates a new setup instance
                self::$instance = new self($settings, $options);
            }
        }
        ## return the instance
        return self::$instance;
    }
}