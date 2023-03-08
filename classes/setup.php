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

## Checks if theme class path is defined
if( ! \defined('__CLASSES__') ):
    ## defines classes path
    \define( '__CLASSES__', __ROOT__ . 'classes/' );
endif;

# checks for Base class, the master class that the blocks class extends
if( ! class_exists('Alkamist\Base') ): 
    ## includes theme required script base class
    require_once( __CLASSES__ . 'base.php' );
endif;

# checks for blocks class
if( ! class_exists('Alkamist\Patterns') ): 
    ## includes theme required script base class
    require_once( __CLASSES__ . 'patterns.php' );
endif;

# checks for patterns class
if( ! class_exists('Alkamist\Blocks') ): 
    ## includes theme required script base class
    require_once( __CLASSES__ . 'blocks.php' );
endif;


## Defines WP_Error class as WP_Error
use WP_Error as WP_Error;

## Defines Base class as Base
use Alkamist\Base as Base;

## Defines Blocks class as Blocks
use Alkamist\Blocks as Blocks;

## Defines Patterns class as Patterns
use Alkamist\Patterns as Patterns;

/**
 * Undocumented class
 */
class Setup extends Base
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
     * ACTIVATION MESSAGE
     * 
     * The message that displays when the theme is activated.
     *
     * @var string
     * 
     * @since version 1.0.0
     */
    private static string $activation_mesage;

    /**
     * SET ACTIVATION MESSAGE
     *
     * Defines the message thats shown when the theme is activated.
     * 
     * @param string $message The user message to show on activation.
     * 
     * @since version 1.0.0
     * 
     * @return true all ways true once valid
     */
    final public static function set_activation_message( string $message = '' )
    {
        # Get theme name from data
        $themeName = ( \function_exists('\rtrim') )
        ? ## remove trailing slash from namespace
            \rtrim( self::get_namespace(), '/' )
        : ## could not remove traling slash
            self::get_namespace()
        ;

        # Determins the teme message to set
        self::$activation_mesage = ( isset($message) && \is_string($message) 
        && !empty($message) && $message !== '' )
        ? ## set user message
            $message
        : ## set default message
            "
                Thanks for using \"$themeName\", tha pleasure is ours. 
                To take full advantage of \"$themeName\" please visit our site for 
                a full <a href='#'>overview</a>.
            "
        ;
        # always true if the srcitp isn't broken
        return true;
    }

    /**
     * GET ACTIVATION MESSAGE
     * 
     * Returns the theme's activation message if valid.
     * 
     * @since version 1.0.0
     *
     * @return mixed String when valid otherwise null.
     */
    final public static function get_activation_message()
    {
        return ( isset( self::$activation_mesage ) && !empty( self::$activation_mesage ) )
        ? # the set namespace
            self::$activation_mesage
        : # not set
            null
        ;
    }

    /**
     * PRINT ACTIVATION MESSAGE
     * 
     * Prints the activation theme's activation.
     *
     * @since version 1.0.0
     * 
     * @return void
     */
    final public static function activation_message()
    {
        # Get theme name from data
        $themeName = ( \function_exists('\rtrim') )
        ? ## remove trailing slash from namespace
            \rtrim( self::get_namespace(), '/' )
        : ## could not remove traling slash
            self::get_namespace()
        ;

        # Get theme textdomain from data
        $textdomain = self::get_textdomain();

        $message = ( \function_exists("\sprintf") && $themeName && $textdomain
        && \is_string($themeName) && \is_string($textdomain) )
        ? # theme activation message
            \sprintf( __(self::$activation_mesage, $textdomain), $themeName  )
        : # no activation message
            false
        ;

        # Print activation message when available
        if( $message && \is_string($message) )
        {
            echo
            "
                <div class='notice notice-success is-dismissible'>
                    <p>$message</p>
                </div>
            ";
        }
        return;
    }

    final public static function theme_supports()
    {
        // ! rember to check against version as well 

        ## checks if theme can add editor styles
        if( \function_exists('\add_editor_style') )
        {
            \add_editor_style('style.css');
        }

        ## Checks if theme can add theme supports
        if( \function_exists('\add_theme_support') )
        {
            \add_theme_support( 'wp-block-styles' );
            \add_theme_support( 'starter-content' );
            \add_theme_support( 'dark-editor-style' );
        }
    }

    final public static function theme_styles()
    {
    }

    final public static function theme_scripts()
    {
    }

    /**
     * SET BASE SETTINGS
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
     *  - @var string $settings[activation_msg] The displayed message on activation, optional
     * 
     * }
     * 
     * @since version 1.0.0
     * 
     * @return bool true when settings are set otherwise false
     */
    final protected static function set_base_settings( array $settings )
    {
        ## get parent base settings
        $base_settings = parent::set_base_settings($settings);

        ## Change array key to lowercase when possible
        $settings = ( \is_array($settings) && !empty($settings)
        && \function_exists('\array_change_key_case') )
        ? # can change keys
            \array_change_key_case($settings, 0)
        : # cant change keys
            $settings
        ;

        # check for custom activation messase before sanitize
        $activation_msg = ( isset($settings['activation_msg']) && 
        \is_string($settings['activation_msg']) )
        ? # use user value
            $settings['activation_msg']
        : # default value
            ''
        ;

        ## set activation message
        self::set_activation_message($activation_msg);

        # ensure base settings and activation message are set
        return ( $base_settings && self::get_activation_message() )
        ? # both
            true
        : # error
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
     * @param array $settings An associated array of setup settings
     * {
     * 
     *  possible value:
     *  - @var string $settings[namespace] The theme's namespace, optional
     * 
     *  - @var string $settings[textdomain] The theme's textdomain, optional
     * 
     *  - @var string $settings[activation_msg] The displayed message on activation, optional
     * 
     * }
     * 
     * 
     * 
     * @since version 1.0.0
     * 
     * @return null
     */
    private function __construct( array $settings = array() )
    { ## private constructor to prevent direct instantiation

        # set required base properties in base class
        $bas_Settings = self::set_base_settings( $settings );

        # ensure base settings applied
        if( $bas_Settings && $bas_Settings === true):

            ## stop excicution when add action function not exists
            self::can_hook();

            # includes blocks and patterns features
            if( self::can_register_block_type() ):
                # include blocks class
                /*$theme_blocks = Blocks::init([
                    'namespace'  => self::get_namespace(),
                    'textdomain' => self::get_textdomain()
                ]);*/
            endif;

            # includes blocks and patterns features
            if( self::can_register_pattern() ):
                # include patterns class
                /*$theme_patterns = Patterns::init([
                    'namespace'  => self::get_namespace(),
                    'textdomain' => self::get_textdomain()
                ]);*/
            endif;

            # Functions to support the theme
            \add_action( 'after_setup_theme', array($this, 'theme_supports'), 2, 0 );

            # Theme required styles
            \add_action( 'wp_enqueue_scripts', array($this, 'theme_styles'), 3, 0 );

            # Theme required scripts
            \add_action( "wp_enqueue_scripts", array($this, 'theme_scripts'), 4, 0 );

            # Theme activation message
            \add_action( 'after_switch_theme', array($this, 'activation_message'), 5, 0 );
        endif;
    }

    /**
     * INIT
     * 
     * The method use to initialize all new instances of this class.
     *
     * @param array $settings An associated array of setup settings
     * 
     * {
     * 
     *  possible value:
     *  - @var string $settings[namespace] The theme's namespace, optional
     * 
     *  - @var string $settings[textdomain] The theme's textdomain, optional
     * 
     *  - @var string $settings[activation_msg] The displayed message on activation, optional
     * 
     * }
     * 
     * @since version 1.0.0
     * 
     * @return object The current setup instance 
     */
    final public static function init( array $settings = array() )
    {
        ## Checks if instance is already set
        if ( ! isset( self::$instance ) || empty( self::$instance ) )
        {
            if( isset( $settings ) && \is_array($settings) )
            {
                ## Creates a new setup instance
                self::$instance = new self($settings);
            }
        }
        ## return the instance
        return self::$instance;
    }
}