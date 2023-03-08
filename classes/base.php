<?php
## This script uses strict types
declare(strict_types=1);

## This script has a namespace
namespace Alkamist;

## includes wp required scripts wp_error class
use WP_Error as WP_Error;

class Base
{
    /**
     * NAMESPACE
     * 
     * The namespace to append 
     * to all patterns actions.
     *
     * @var string
     * 
     * @since version 1.0.0
     */
    protected static string $namespace;

    /**
     * NAME
     * 
     * The name of the current theme.
     * 
     * @var string
     * 
     * @since version 1.0.0
     */
    protected static string $name;

    /**
     * TEXTDOMAIN
     * 
     * The textdomain to used for translating 
     * theme context.
     *
     * @var string
     * 
     * @since version 1.0.0
     */
    protected static string $textdomain;

    /**
     * WP VERSIONS
     * 
     * The current wordpress version.
     *
     * @var string
     * 
     * @since version 1.0.0
     */
    protected static string $wp_version;

    /**
     * THEME VERSION
     * 
     * The current theme version
     *
     * @var string
     */
    protected static string $theme_version;

    /**
     * STRIP WHITESPACE
     * 
     * {
     * 
     *  removes all whitespace from the given 
     * 
     *  string when possible.
     * 
     * }
     * 
     * @param string $string The given string.
     * 
     * @since version 1.0.0
     * 
     * @return bool When valid true otherwise false.
     */
    final protected static function strip_whitespace( string $string )
    {
        ## checks the given string
        return ( \is_string($string) && \function_exists('\str_replace') )
        ? # valid string
            \str_replace(array("\n", "\r", "\t", ' '), '', $string)
        :   # invalid string
            false
        ;
    }

    /**
     * IS VALID STRING
     * 
     * Determins if the given string is valid none empty string.
     * 
     * @param string $string The given string.
     * 
     * @since version 1.0.0
     * 
     * @return bool When valid true otherwise false.
     */
    final protected static function is_valid_string( string $string )
    {
        # checks for empty string
        $string = self::strip_whitespace($string);

        ## determins string to return
        return ( $string && \is_string($string) 
        && !empty($string) && $string !== '' )
        ? # valid string
            true
        : # invalid string
            false
        ;
    }

    /**
     * IS VALID ARRAY
     * 
     * Determins if the given array is valid none empty array.
     * 
     * @param string $string The given array.
     * 
     * @since version 1.0.0
     * 
     * @return bool When valid true otherwise false.
     */
    final protected static function is_valid_array( array $array )
    {
        ## determins the state of the array to return
        return ( isset($array) && \is_array($array) 
        && !empty($array) && \count($array) >= 1)
        ? # valid string
            true
        : # invalid string
            false
        ;
    }

    /**
     * IS VALID BOOL
     * 
     * Determins if the given boolean is a valid boolean or not.
     * 
     * @param mixed[bool|string] $string The given bool.
     * 
     * @since version 1.0.0
     * 
     * @return bool When valid true otherwise false.
     */
    final protected static function is_valid_bool( mixed $bool )
    {
        $bool = ( isset($bool) && \gettype($bool) === 'string' )
        ? # conver string to lowercase and no whitespace
            self::strip_whitespace( \strtolower($bool) )
        : # not string bool
            $bool
        ;

        ## determins the state of the bool to return
        return ( \is_bool((bool)$bool) )
        ? # valid string
            true
        : # invalid string
            false
        ;
    }

    /**
     * IS VALID DIRECTORY
     *
     * Checks if the given string is a valid directory or not.
     * 
     * Defaults to false when invalid or undefined
     * 
     * @param string $path The directory path to check.
     * 
     * @since version 1.0.0
     * 
     * @return boolean true when valid otherwise false.
     */
    final protected static function is_valid_directory( string $path )
    {
        #checks for valid directory
        return ( \is_dir($path) && \is_readable($path) )
        ?
            true
        :
            false
        ;
    }

    /**
     * LOWERCASE STRING
     * 
     *  Converts the given string to a lowercase characters.
     * 
     * @param string $string The given string to convert.
     * 
     * @since version 1.0.0
     *
     * @return mixed String when valid otherwise false
     */
    final protected static function lowercase_string( string $string )
    {
        # Determins the value to return
        return ( self::is_valid_string( $string )
        && \function_exists('\strtolower')  )
        ? # capitalized string
            \strtolower($string)
        : #failed
            false
        ;
    }

    /**
     * ONLY ALPHANUMERIC
     * 
     * {
     * 
     *  Converts the given string to a string containing both 
     * 
     *  numeric and alpha characters with no whitespace.
     * 
     * }
     * 
     * @param string $string The given string to convert.
     * 
     * @since version 1.0.0
     *
     * @return mixed String when valid otherwise false
     */
    final protected static function only_alphanumeric( string $string )
    {
        # determins whats returned
        return ( self::is_valid_string( $string ) 
        && \function_exists('\preg_replace') )
        ? # replace special character
            \preg_replace( '/[^a-zA-Z0-9]/', '', $string )
        : # failed
            false
        ;
    }
    
    /**
     * CAPITALIZED STRING
     * 
     * {
     * 
     *  Converts the given string to a capitalized first character 
     * 
     *  and all trailling alpha characters lowered.
     * 
     * }
     * 
     * @param string $string The given string to convert.
     * 
     * @since version 1.0.0
     *
     * @return mixed String when valid otherwise false
     */
    final protected static function capitalized_alphanumeric( string $string )
    {
        # Determins the value to return
        return ( self::is_valid_string( $string )
        && \function_exists('\strtolower')
        && \function_exists("ucfirst") )
        ? # capitalized string
            \ucfirst( \strtolower($string) )
        : #failed
            false
        ;
    }

    /**
     * SET NAME & NAMESPACE
     * 
     * Defines the instances name and namespace in the pattern 
     * name "Alkamist" && namespace "Alkamist/".
     * 
     * {
     * 
     * Defaults to 'Alkamist' && 'Alkamist/' which are the default name 
     * 
     * and namespace for the theme this class was created for respectivly.
     * 
     * }
     *
     * @param string $namespace The instance namespace to set
     * 
     * @since version 1.0.0
     * 
     * @return true The method rand sucessfully
     */
    final public static function set_namespace( string $namespace = '' )
    {
        if( self::is_valid_string($namespace) ):
            # removes all whitespace from string
            $namespace = self::strip_whitespace($namespace);
        endif;

        if( self::is_valid_string($namespace) ):
            # converts namespace to alpha numeric
            $namespace = self::only_alphanumeric($namespace);
        endif;

        if( self::is_valid_string($namespace) ):
            # converts namespace to capitalized
            $namespace = self::capitalized_alphanumeric($namespace);
        endif;

        # Determins theme/plugin name/namespace
        if ( self::is_valid_string($namespace) )
        {
            # Sets user given namespace
            self::$name         = $namespace;
            self::$namespace    = $namespace;
        }
        else
        {
            # Sets default name & namespace
            $name               = 'Alkamist';
            self::$name         = $name;
            self::$namespace    = $name;

        }

        # add trailling slash to namespace
        self::$namespace = self::$namespace . '/';

        # always true on success
        return true;
    }

    /**
     * GET NAMESPACE
     * 
     * Returns the current instance namespace.
     *
     * @since version 1.0.0
     * 
     * @return mixed When valid the namespace string otherwise null
     */
    final public static function get_namespace()
    {
        return ( isset( self::$namespace ) 
        && self::is_valid_string(self::$namespace) )
        ? # the set namespace
            self::$namespace
        : # not set
            null
        ;
    }

    /**
     * GET NAME
     * 
     * Returns the current theme or plugin name.
     * 
     * @since version 1.0.0
     *
     * @return mixed The theme/plugin name otherwise null.
     */
    final public static function get_name()
    {
        # determins name to return
        return ( isset( self::$name ) 
        && self::is_valid_string(self::$name) )
        ? # the set namespace
            self::$name
        : # not set
            null
        ;
    }
    
    /**
     * SET TEXTDOMAIN
     *
     * Defines the instanc's text domain in the format "alkamit".
     * 
     * Defaults to 'alkamist' which is the textdomain of the theme this 
     * class was created for.
     * 
     * @param string $textdomain The instance textdomain to set
     * 
     * @since version 1.0.0
     * 
     * @return true The method rand sucessfully
     */
    final public static function set_textdomain( string $textdomain = '' )
    {
        if( self::is_valid_string($textdomain) ):
            # removes all whitespace from string
            $textdomain = self::strip_whitespace($textdomain);
        endif;

        if( self::is_valid_string($textdomain) ):
            # converts string to alpha numeric
            $textdomain = self::only_alphanumeric($textdomain);
        endif;

        if( self::is_valid_string($textdomain) ):
            # converts string to lowercase
            $textdomain = self::lowercase_string( $textdomain );
        endif;

        # set capitalized user defined textdomain
        self::$textdomain = ( self::is_valid_string($textdomain) )
        ?
            # Sets user given textdomain
            $textdomain
        :
            # Sets default textdomain
            'alkamist';
        ;
        return true;
    }
    
    /**
     * GET TEXTDOMAIN
     * 
     * Returns the current instance textdomain.
     *
     * @since version 1.0.0
     * 
     * @return mixed When valid the textdomain string otherwise null
     */
    final public static function get_textdomain()
    {
        return ( isset( self::$textdomain ) 
        && self::is_valid_string(self::$textdomain) )
        ? # the set textdomain
            self::$textdomain
        : # not set
            null
        ;
    }

    /**
     * CAN HOOK
     * 
     * Checksk if the script can do 
     * wordPress add action function.
     * 
     * @since version 1.0.0
     *
     * @return true always true otherwise WP_Error
     */
    final protected static function can_hook()
    {
        ## validates add action
        return( \function_exists('\add_action') )
        ? # add action exists
            true
        : # add action doesn't exists
            new WP_Error(
                "ALK: (BASE-001)",
                "
                    Theme setup failed to create wp action, 
                    try down grading your wp_version or reinstalling 
                    WordPress. 
                ",
                "
                    Possible cause: 
                    modified wordpress files,
                    depreciated function
                "
            )
        ;
    }

    /**
     * CAN DO SCRIPTS
     * 
     * Checks for wp function that 
     * registers new scripts;
     * 
     * @since version 1.0.0
     * 
     * @return bool always true otherwise WP_Error
     */
    final protected static function can_do_scripts()
    {
        # Checks for wp register script functions
        return ( \function_exists('\wp_register_script') 
        && \function_exists('\wp_enqueue_script') 
        && \function_exists('\wp_register_style') 
        && \function_exists('\wp_enqueue_style') )
        ?
            true
        :
            new WP_Error(
                "ALK: (BASE-002)",
                "
                    Theme setup failed to create wp register script, 
                    try down grading your wp_version or reinstalling 
                    WordPress. 
                ",
                "
                    Possible cause: 
                    modified wordpress files,
                    depreciated function
                "
            )
        ;
    }

    /**
     * CAN REGISTER TYPE
     *
     * Checks if the current version of wordpress
     * can register block types.
     * 
     * @since version 1.0.0
     * 
     * @return boolean true when valid otherwise false.
     */
    final protected static function can_register_block_type()
    {
        return ( \function_exists('\register_block_type') 
        && \function_exists('\register_block_type_from_metadata')
        && \class_exists('\WP_Block_Type_Registry') )
        ?
            true
        :
            false
        ;
    }

    /**
     * CAN REGISTER PATTERNS
     *
     * Checks if the current version of wordpress
     * can register block patterns.
     * 
     * @since version 1.0.0
     * 
     * @return boolean true when valid otherwise false.
     */
    final protected static function can_register_pattern()
    {
        # Determins if theme can register block pattern
        return ( \function_exists('\register_block_pattern') 
        && \class_exists('\WP_Block_Patterns_Registry') )
        ?
            true
        :
            false
        ;
    }


    /**
     * TO ENQUEUE
     * 
     * An array of scripts/styles to register and or eneques.
     * 
     * @param string $type The type of script to register or enqueue
     * {
     * 
     *  possible values:
     *      - "localized"
     *      - "scripts"
     *      - "styles"
     * 
     * }
     * 
     * @param array $options A key value pair array of options for the script being added
     * 
     * {
     * 
     *      Make refference to:
     *          - wp_register_script
     *          - wp_register_style
     *      for assistance.
     * 
     *      $type = "scripts" possible values:
     *          - @var string $options[source]          The location of the script, required
     *          - @var string $options[dependencies]    Other scripts required by the script being registered, optional
     *          - @var string $options[version]         The version of the script being registered, optional
     *          - @var string $options[infooter]
     *          - @var string $options[action]          What to do with the script {
     *              possible values:
     *                  * "both"        - Enqueue & registers the script
     *                  * "register"    - Only registers the script
     *                  * "enqueue"     - Only enqueues the script
     *          }
     * 
     *      $type = "styles" possible values:
     *          - @var string $options[source]          The location of the script, required
     *          - @var string $options[dependencies]    Other scripts required by the script being registered, optional
     *          - @var string $options[version]         The version of the script being registered, optional
     *          - @var string $options[media]
     *          - @var string $options[action]          What to do with the script {
     *              possible values:
     *                  * "both"        - Enqueue & registers the script
     *                  * "register"    - Only registers the script
     *                  * "enqueue"     - Only enqueues the script
     *          }
     * 
     *      $type = "localized" possible values:
     *          - @var string $options[object_name] The name of the javascript object, required
     *          - @var array $options[object_name] The argument to pass to javascript, optional
     * 
     * }
     * 
     * @return bool true when scripts are enqueued other wise false;
     */
    final protected static function __to_enqueue( string $type, array $options )
    {
        # checks if we can register wp scripts
        if( ! self::can_do_scripts() )
        {
            return false;
        }

        # Convers $type to lowercase
        $type = ( function_exists('\strtolower') && \is_string($type) )
        ?
            \strtolower($type)
        :
            $type
        ;

        # Converts $options keys to lowercase when possible
        $options = ( function_exists('\array_change_key_case') && \is_string($options) )
        ?
            \array_change_key_case($options, 0)
        :
            $options
        ;

        # prevents excicution if $type or $options in valid
        if( ( ! isset($type) || ! self::is_valid_string($type) )
        && ( $type !== 'scripts' || $type !== 'styles' || $type !==  'localized' )
        && ( ! isset($options) || empty($options) || ! is_array($options) ) ):
            return false;
        endif;

        foreach( $options as $handle => $args )
        {
            if( self::is_valid_string($handle) && \is_array($args) && !empty($args) )
            {
                switch($type)
                {
                    case 'styles':
                    case 'scripts':
                        # determins script/style source
                        $_src = ( isset($args['source']) 
                        && self::is_valid_string($args['source']) 
                        && \file_exists($args['source']) )
                        ? # valid source
                            $args['source']
                        : # invalid
                            ''
                        ;

                        # determins script/style dependencies
                        $_deps = ( isset($args['dependencies']) 
                        && self::is_valid_array($args['dependencies']) )
                        ? #valid dependencies
                            $args['dependencies']
                        : # invalid
                            array()
                        ;

                        # determins script/style version
                        $_ver = ( isset($args['version'])
                        && ( self::is_valid_string($args['version']) 
                        || $args['version'] === false ) )
                        ?
                            $args['version']
                        :
                            false
                        ;

                        $_action = ( isset($args['action']) 
                        && self::is_valid_string($args['action'])
                        && ( $args['action'] === 'both' 
                        || $args['action'] === 'enqueue' 
                        || $args['action'] === 'register' ) )
                        ?
                            $args['action']
                        :
                            'both'
                        ;

                        if( $type === 'scripts' ):
                            # determins if the script should be in footer
                            $_in_footer = ( isset($args['infooter']) 
                            && \is_bool($args['infooter']) )
                            ?
                                $args['infooter']
                            :
                                true
                            ;

                            if( $_action === 'register' )
                            {# exciutes register
                                #register script
                                \wp_register_script(
                                    $handle,
                                    \filemtime($_src), $_deps, $_ver, $_in_footer
                                );
                            }
                            else if( $_action === 'enqueue' )
                            { # exciutes enqueue
                                #enqueue script
                                \wp_enqueue_script(
                                    $handle,
                                    \filemtime($_src), $_deps, $_ver, $_in_footer
                                );
                            }
                            else
                            { # exciutes both register and enqueue
                                #register script
                                \wp_register_script(
                                    $handle,
                                    \filemtime($_src), $_deps, $_ver, $_in_footer
                                );
                                #enqueue script
                                \wp_enqueue_script(
                                    $handle,
                                    \filemtime($_src), $_deps, $_ver, $_in_footer
                                );
                            }
                        endif;

                        if( $type === 'styles' ):
                            # determins the style media type
                            $_media = ( isset($args['media']) 
                            && self::is_valid_string($args['media']) )
                            ?
                                $args['media']
                            :
                                'all'
                            ;

                            if( $_action === 'register' )
                            {# exciutes register
                                #register style
                                \wp_register_style(
                                    $handle,
                                    \filemtime($_src), $_deps, $_ver, $_media
                                );
                            }
                            else if( $_action === 'enqueue' )
                            { # exciutes enqueue
                                #enqueue style
                                \wp_enqueue_style(
                                    $handle,
                                    \filemtime($_src), $_deps, $_ver, $_media
                                );
                            }
                            else
                            { # exciutes both register and enqueue
                                #register style
                                \wp_register_style(
                                    $handle,
                                    \filemtime($_src), $_deps, $_ver, $_media
                                );
                                #enqueue style
                                \wp_enqueue_style(
                                    $handle, 
                                    \filemtime($_src), $_deps, $_ver, $_media
                                );
                            }
                        endif;
                    break;
                    case 'localized':
                        // detrmins localized object name handle
                        $object = ( isset($args['object_name']) 
                        && self::is_valid_string($args['object_name']) )
                        ?
                            $args['object_name']
                        :
                            ''
                        ;

                        $settings = ( isset($args['settings']) 
                        && self::is_valid_array($args['settings']) )
                        ?
                            $args['settings']
                        :
                            array()
                        ;

                        // sets the localized script
                        if($object && self::is_valid_string($object) )
                        {
                            \wp_localize_script($handle, $object, $settings);
                        }
                    break;
                    default:
                    break;
                }
            }
        }
        # returns true when valid
        return true;
    }


    /**
     * SET BASE SETTINGS
     *
     * @param array $settings an array of settings to apply on initialize.
     * 
     * @return true
     */
    protected static function set_base_settings( array $settings )
    {
       $base_settings = false;

        ## Change array key to lowercase when possible
        $settings = ( \is_array($settings) && !empty($settings)
        && \function_exists('\array_change_key_case') )
        ? # can change keys
            \array_change_key_case($settings, 0)
        : # cant change keys
            $settings
        ;

        # validate namespace before sanitize
        $namespace = ( isset($settings['namespace']) && 
        self::is_valid_string($settings['namespace']) )
        ? # use user value
            $settings['namespace']
        : # default value
            ''
        ;

        # validate textdomain before sanitize
        $textdomain = ( isset($settings['textdomain']) && 
        self::is_valid_string($settings['textdomain']) )
        ? # use user value
            $settings['textdomain']
        : # default value
            ''
        ;

        if( self::is_valid_string($namespace )
        && self::is_valid_string($namespace ) ):
            # set class namespace and name
            self::set_namespace($namespace);

            # sets class textdomain 
            self::set_textdomain($textdomain);

            $base_settings = true;
        endif;

        return $base_settings;
    }
}