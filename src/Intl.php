<?php
namespace Giba;
use Giba\Paginator;
/**
 * This class can be used to translate text from a JSON file.
 * Check the folder /src/giba/paginator/locales for translations.
 *
 * @link        http://github.com/gilbertoalbino/paginator for the canonical source repository.
 * @category    Internatinalization
 * @package     Paginator
 * @author      Gilberto Albino <www@gilbertoalbino.com>
 * @copyright   2015 Gilberto Albino (http://gilbertoalbino.com)
 * @license     GLP3+
 * @version     Release: 1.0
 * @since       Class available since Release 1.0
 * 
 */
class Intl
{
    /**
     * This is the loaded filed containing a JSON 
     * with text to translate into form a key
     * @var Array
     */
    public static $data = null;
    /**
     * Define the JSON file to be encoded
     */
    public static function setData()
    {
        self::$data = json_decode(
            file_get_contents(
                dirname(__FILE__) 
                . '/locales/' 
                . Paginator::getLocale() . '.json'
            )
        );
    }
    /**
     * Get the encoded JSON 
     * 
     * @return JSON
     */
    public static function getData()
    {
        self::setData();
        return self::$data;
    }
    /**
     * Get the string to be translated from a key
     * 
     * @param String $key
     * @return String
     */
    public static function get($key)
    {
        self::getData();
        return self::$data->$key;
    }
}
