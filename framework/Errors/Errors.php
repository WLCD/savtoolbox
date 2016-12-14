<?php
/**
 * Description of Errors
 *
 * @author wlcd
 */
class Errors
{
    private static $_console;
    
    private static $_instance = Null;

    public static function get($console)
    {
        if (Null == self::$_instance)
        {
            self::$_instance = new Errors($console);
        }

        return self::$_instance;
    }
    
    private function __construct( $console ) {
        self::$_console = $console;
    }

    // CATCHABLE ERRORS
    public static function captureNormal( $number, $message, $file, $line )
    {
        // Insert all in one table
        $error = array( 'type' => $number, 'message' => $message, 'file' => $file, 'line' => $line );
        // Display content $error variable
        //self::$_console->message(implode("<br />",$error));
        
        switch($number){
            // Erreur fatale
            case E_USER_ERROR:
                self::$_console->message("<strong>Erreur fatale</strong> : $message");
                exit; // On arrête le script
                break;

            // Avertissement
            case E_USER_WARNING:
                self::$_console->message("<strong>Avertissement</strong> : $message");
                break;

            // Note
            case E_USER_NOTICE:
                self::$_console->message("<strong>Note</strong> : $message");
                break;

            // Erreur générée par PHP
            default:
                self::$_console->message("<strong>Erreur Inconnue</strong> : [$number] : $message <br /> dans le fichier $file à la ligne $line");
                break;
        }
    }
    
    // EXTENSIONS
    public static function captureException( $exception )
    {
        // Display content $exception variable
        self::$_console->message($exception->getMessage());
    }
    
    // UNCATCHABLE ERRORS
    public static function captureShutdown( )
    {
        $error = error_get_last( );
        if( $error ) {
            ## IF YOU WANT TO CLEAR ALL BUFFER, UNCOMMENT NEXT LINE:
            # ob_end_clean( );
            
            // Display content $error variable
            self::$_console->message($error);
        } else { return true; }
    }
}

set_error_handler( array( 'Errors', 'captureNormal' ) );
set_exception_handler( array( 'Errors', 'captureException' ) );
register_shutdown_function( array( 'Errors', 'captureShutdown' ) );
?>
