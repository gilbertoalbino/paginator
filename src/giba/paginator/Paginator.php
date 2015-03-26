<?php

namespace Giba;

use Giba\Navigator;
use Giba\QueryString;

/**
 * This class can be used to paginate a data set.
 *
 * @link        http://github.com/gilbertoalbino/paginator for the canonical source repository.
 * @category    Pagination
 * @package     Paginator
 * @author      Gilberto Albino <www@gilbertoalbino.com>
 * @copyright   2015 Gilberto Albino (http://gilbertoalbino.com)
 * @license     GLP3+
 * @version     Release: 1.0
 * @since       Class available since Release 1.0
 */

class Paginator
{

    /**
     * This is the dataset to paginate.
     * 
     * @var type ArrayIterator|NULL
     */
    public $resultSet = null;

    /**
     * This is the language used in navigation.
     * 
     * @var type String
     */
    public static $locale = 'en';

    /**
     * The string for identifying the paginator value.
     * 
     * @var String 
     */
    private $paginator = 'page';

    /**
     * The total of results per age.
     * 
     * @var type 
     */
    private $limitPerPage = 10;

    /**
     * The total of pages in the menu aside current.
     * 
     * @var type 
     */
    private $range = 5;

    /**
     * This is the UL css class default to 
     * Twitter Bootstrap 3 pagination componente as is
     * http://getbootstrap.com/components/#pagination
     * 
     * @var String
     */
    private $class = 'pagination';

    /**
     * The constructor may set a dataset and a locale.
     * 
     * @param mixed $resultSet
     */
    public function __construct($resultSet = null, $locale = null)
    {
        if ($resultSet !== null) {
            $this->setResultSet($resultSet);
        }

        if ($locale !== NULL) {
            $this->setLocale($locale);
        }

        $this->getPager();
    }

    /**
     * Define a set of data to handle pagination.
     * 
     * @param ArrayIterator $resultSet
     */
    public function setResultSet($resultSet)
    {
        $this->resultSet = new \ArrayIterator($resultSet);
    }

    /**
     * Get the resultSet.
     * @see Paginator->setResultSet().
     * 
     * @return ArrayIterator
     */
    public function getResultSet()
    {
        return $this->resultSet;
    }

    /**
     * Get the portion of the Array from offset and limit.
     * 
     * @return ArrayIterator
     */
    public function getResults()
    {
        $offSet = $this->getOffset();
        $limit = $offSet + $this->getLimitPerPage() - 1;
        $resultSet = Array();
        foreach ($this->getResultSet() as $key => $data) {
            if ($key < $offSet || $key > $limit) {
                continue;
            }
            $resultSet[$key] = $data;
        }
        return $resultSet;
    }

    /**
     * Get the total of results.
     * 
     * @return Integer
     */
    public function getTotalOfResults()
    {
        return $this->getResultSet()->count();
    }

    /**
     * Get the total number of pages.
     * 
     * @return Integer 
     */
    public function getTotalOfPages()
    {

        return ceil($this->getTotalOfResults() / $this->getLimitPerPage());
    }

    /**
     * Get the number of the current page.
     * 
     * @return Integer
     */
    public function getCurrentPage()
    {
        $totalOfPages = $this->getTotalOfPages();
        $pager = $this->getPager();

        if (isset($pager) && is_numeric($pager)) {
            $currentPage = $pager;
        } else {
            $currentPage = 1;
        }

        if ($currentPage > $totalOfPages) {
            $currentPage = $totalOfPages;
        }

        if ($currentPage < 1) {
            $currentPage = 1;
        }

        return (int) $currentPage;
    }

    /**
     * Get the offset.
     * 
     * @return int
     */
    public function getOffset()
    {

        return ( $this->getCurrentPage() - 1 ) * $this->getLimitPerPage();
    }

    /**
     * Set the paginator.
     */
    public function setPaginator($paginator)
    {

        if (!is_string($paginator)) {
            throw new \InvalidArgumentException(
                sprintf(
                    '$paginator must be of type String. Given %s in %s.',
                     ucfirst(gettype($paginator)),
                     __METHOD__
                )
            );
        }

        $this->paginator = $paginator;
    }

    /**
     * Get the paginator used to get the pager.
     * 
     * @return string 
     */
    public function getPaginator()
    {
        return $this->paginator;
    }

    /**
     * Get the value to paginate.
     * 
     * @return Integer
     */
    public function getPager()
    {
        return ( isset($_GET[$this->paginator]) ) ? (int) $_GET[$this->paginator] : 0;
    }

    /**
     * Set the limit of pagination available on the page.
     * 
     * @param Integer $limit
     */
    public function setLimitPerPage($limit)
    {

        if (!is_int($limit)) {
            throw new \InvalidArgumentException(
                sprintf(
                    '$limit must be of type Integer. Given %s in %s.',
                     ucfirst(gettype($limit)),
                     __METHOD__
                )
            );
        }

        $this->limitPerPage = $limit;
    }

    /**
     * Get the pagination limit per page.
     * 
     * @return Integer
     */
    public function getLimitPerPage()
    {

        return $this->limitPerPage;
    }

    /**
     * Set the range of pages to be selected aside current.
     * 
     * @param Integer $range
     */
    public function setRange($range)
    {

        if (!is_int($range)) {
            throw new \InvalidArgumentException(
                sprintf(
                    '$range must be of type Integer. Given %s in %s.',
                     ucfirst(gettype($range)),
                     __METHOD__
                )
            );
        }

        $this->range = $range;
    }

    /**
     * GEt the range of pages to be selected aside current.
     * 
     * @return Integer
     */
    public function getRange()
    {
        return $this->range;
    }

    /**
     * Helper for getting the Navigator display 
     * for results found or pagination menu itself.
     * 
     * @param String $option
     * @return String
     */
    public function navigate($option = 'menu')
    {
        $content = null;
        switch ($option) {
            case 'results' :
                $content = Navigator::showResults($this);
                break;
            case 'menu' :
                $content = Navigator::showMenu($this);
                break;
            default :
                $content = sprintf('Invalid $option in %s', __METHOD__);
                break;
        }
        
        return $content;
    }

    /**
     * Set the locale to translate Navigator into.
     * 
     * @param String $locale
     */
    public function setLocale($locale)
    {
        if(!is_string($locale)) {
            throw new \InvalidArgumentException(
                sprintf(
                    '$locale must be of type String. Given %s in %s.',
                     ucfirst(gettype($locale)),
                     __METHOD__
                )
            );            
        }
        
        self::$locale = $locale;
    }

    /**
     * Get the locale to translate Navigator into.
     * 
     * @return String
     */
    public static function getLocale()
    {
        return self::$locale;
    }

    /**
     * Set the CSS class for the UL.
     *
     * @param String $class
     */
    public function setClass($class)
    {
        if(!is_string($class)) {
            throw new \InvalidArgumentException(
                sprintf(
                    '$class must be of type String. Given %s in %s.',
                     ucfirst(gettype($class)),
                     __METHOD__
                )
            );            
        }
        $this->class = $class;
    }

    /**
     * Get the CSS class for the UL.
     * 
     * @return String
     */
    public function getClass()
    {
        return $this->class;
    }

}
