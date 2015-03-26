<?php
namespace Giba;
use Giba\Intl;
/**
 * This class can be used to format the navigation output semantics and styles.
 *
 * @link        http://github.com/gilbertoalbino/paginator for the canonical source repository.
 * @category    Navigation
 * @package     Paginator
 * @author      Gilberto Albino <www@gilbertoalbino.com>
 * @copyright   2015 Gilberto Albino (http://gilbertoalbino.com)
 * @license     GLP3+
 * @version     Release: 1.0
 * @since       Class available since Release 1.0
 * 
 */
class Navigator
{
    /**
     * Get the results info to be shown on pagination.
     * 
     * @param \Giba\Paginator $paginator
     * @return String
     */
    public static function showResults(Paginator $paginator)
    {
        
        $contents = null;
        
        if ($paginator->getTotalOfResults() > 0) {
            $contents .= sprintf('<div class="results-info-bar">' . Intl::get('SHOW_RESULTS_MESSAGE') . '</div>', 
                $paginator->getCurrentPage(), 
                $paginator->getTotalOfPages(), 
                $paginator->getTotalOfResults()
            );
        } else {
            $contents .= sprintf('<div class="no-results-info-bar">' . Intl::get('SHOW_NO_RESULTS_MESSAGE') . '</div>');
        }
        
        return $contents;
    }
    /**
     * Get the navigation menu to be shown on pagination.
     * 
     * @param \Giba\Paginator $paginator
     * @return String
     */
    public static function showMenu(Paginator $paginator)
    {
        
        $currentPage = $paginator->getCurrentPage();
        $totalOfPages = $paginator->getTotalOfPages();
        $pager = $paginator->getPaginator();
        $queryString = QueryString::rebuild($pager);
        $range = $paginator->getRange();
        $contents = null;
        
        if ($paginator->getTotalOfResults() > 0) {
            $contents .= sprintf('<ul class="%s">', $paginator->getClass());
            
            if ($currentPage > 1) {
                
                $previous = $currentPage - 1;
                
                $contents .= sprintf(
                    '<li><a href="?%s=1%s" class="first"><span> %s</span></a></li>', 
                    $pager, 
                    $queryString, 
                    Intl::get('FIRST')
                );
                
                $contents .= sprintf(
                    '<li><a href="?%s=%s%s" class="previous"><span>%s</span></a></li>', 
                    $pager, 
                    $previous, 
                    $queryString, 
                    Intl::get('PREVIOUS')
                );
                
            }
            for ($x = ( $currentPage - $range ); $x < ( ( $currentPage + $range ) + 1 ); $x++) {
                
                if (( $x > 0 ) && ( $x <= $totalOfPages )) {
                    if ($x == $currentPage) {
                        $contents .= sprintf(
                            '<li class="disabled"><span class=\"current\">%s</span><li>', 
                             $x
                        );
                        
                    } else {
                        $contents .= sprintf(
                            '<li><a href="?%s=%s%s">%s</a><li>', 
                            $pager, 
                            $x, 
                            $queryString, 
                            $x
                        );
                        
                    }
                }
                
            }
            if ($currentPage != $totalOfPages) {
                
                $next = $currentPage + 1;
                
                $contents .= sprintf(
                    '<li><a href="?%s=%s%s" class="next">%s</a></li>', 
                    $pager, 
                    $next, 
                    $queryString, 
                    Intl::get('NEXT')
                );
                
                $contents .= sprintf(
                    '<li><a href="?%s=%s%s" class="last">%s</a></li>', 
                    $pager, 
                    $totalOfPages, 
                    $queryString, 
                    Intl::get('LAST')
                );
            }
            $contents .= '</ul>';
        }
        
        return $contents;
        
    }
}
