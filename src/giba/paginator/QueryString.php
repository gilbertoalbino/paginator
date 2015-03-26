<?php

namespace Giba;

/**
 * This class can be used to rebuild a query string.
 *
 * @link        http://github.com/gilbertoalbino/paginator for the canonical source repository.
 * @category    HTTP
 * @package     Paginator
 * @author      Gilberto Albino <www@gilbertoalbino.com>
 * @copyright   2015 Gilberto Albino (http://gilbertoalbino.com)
 * @license     GLP3+
 * @version     Release: 1.0
 * @since       Class available since Release 1.0
 * 
 */

class QueryString
{

    /**
     * Rebuild the query string.
     * It's refactored from some code I found on the internet
     * 
     * @param String $current
     * @return Boolean|String 
     */
    public static function rebuild($current)
    {
        if(!is_string($current)) {
            throw new \InvalidArgumentException(
                sprintf(
                    '$current must be of type String. Given %s in %s.',
                     ucfirst(gettype($current)),
                     __METHOD__
                )
            );            
        }
        
        $queryString = $_SERVER['QUERY_STRING'];

        if (strlen($queryString) > 0) {

            $parts = explode("&", $queryString);
            $data = array();

            foreach ($parts as $val) {
                if (stristr($val, $current) == false) {
                    array_push($data, $val);
                }
            }

            if (count($data) != 0) {
                $queryString = "&" . implode("&", $data);
            } else {
                return false;
            }

            return $queryString;
        } else {
            return false;
        }
    }

}
