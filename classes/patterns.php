<?php
## This script uses strict types
declare(strict_types=1);

## This script has a namespace
namespace Alkamist;


## includes wp required scripts wp_error class
use WP_Error as WP_Error;


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

## Defines base class as Base
use Alkamist\Base as Base;

class Patterns extends Base
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


    final public function sticky_header()
    {
        \add_filter( 'block_patterns', function( $pattern )
        {
            if( $pattern['title'] === 'Sticky Header' )
            {
                // Add the "hidden" class to the pattern
                $pattern['content'][10]['attrs']['className'] .= 'sticky';
            }

            return $pattern;
        });
    }

    final public function sticky_nav()
    {
        echo('Sticky nav');
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
    final protected function __construct( array $settings = array(), array $options = array() )
    { ## private constructor to prevent direct instantiation

        # set required base functions
        self::set_base_settings( $settings );
        
        echo '<b>Patterns Class</b><br/>';
        echo "name:" . self::get_name() . "<br/>";
        echo "namespace:" . self::get_namespace() . "<br/>";
        echo "textdomain:" . self::get_textdomain() . "<br/>";

        $namespace = self::get_namespace();

        ## Add sticky header hook
        \add_action( $namespace . "sticky_header", array( $this, "sticky_header" ), 3, 0 );

        ## Add stick header nav hook
        \add_action( $namespace . "sticky_nav", array( $this, "sticky_nav"), 4, 0 );
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