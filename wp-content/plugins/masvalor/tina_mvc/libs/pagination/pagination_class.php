<?php
/**
 * A Pagination class from http://net.tutsplus.com/tutorials/php/how-to-paginate-data-with-php/
 *
 * @package    Tina-MVC
 * @subpackage Tina-Core-Libs
 * @author     http://www.catchmyfame.com/2007/07/28/finally-the-simple-pagination-class/ and francis@crossen.org
 * @see        http://www.SeeIT.org
 */

/**
 * Pagination class 
 *
 * This is based on code presented at
 * http://www.catchmyfame.com/2007/07/28/finally-the-simple-pagination-class/and
 * adapted to suit Tina.
 * 
 * @package    Tina-MVC
 * @subpackage Tina-Core-Libs
 */
class Paginator{
    var $items_per_page;
    var $items_total;
    var $current_page;
    var $num_pages;
    var $mid_range;
    var $low;
    var $high;
    var $limit;
    var $return;
    var $default_ipp = 25;
    
    /**
     * Tina MVC customisations
     */
    var $base_url;
    var $tina_items_per_page;
    var $tina_page_no;

    function Paginator()
    {
        $this->current_page = 1;
        $this->mid_range = 7;
    }

    function paginate()
    {
        
        // in case we are dsplaying all, we need to be able to revert...
        $this->saved_items_per_page = $this->items_per_page;
        
        //tmprd( $this->items_per_page );
        if( ! empty($this->tina_items_per_page) ) {
            $this->items_per_page = $this->tina_items_per_page;
        }
        else {
            $this->default_ipp;
        }
        
        if($this->items_per_page == 'all')
        {
            // $this->num_pages = $this->items_total;
            $this->num_pages = 1;
        }
        else
        {
            if( $this->items_per_page < 0) {
                $this->items_per_page = $this->default_ipp;
            }
            $this->num_pages = ceil($this->items_total/$this->items_per_page);
        }
        
        // tmprd( $this->items_per_page );
        //tmpr( $this->sort_ord );
        //tmprd( $this->sort_by );
        
        // the string for sort by and order by
        if( ! empty( $this->sort_ord ) ) {
            $sort_string = '/sort-'.urlencode( $this->sort_by ).'-'.$this->sort_ord;
        }
        else {
            $sort_string = '';
        }
        
        $this->current_page = (int) $this->tina_page_no; // must be numeric > 0
        if($this->current_page < 1 Or !is_numeric($this->current_page)) $this->current_page = 1;
        if($this->current_page > $this->num_pages) $this->current_page = $this->num_pages;
        $prev_page = $this->current_page-1;
        $next_page = $this->current_page+1;

        if($this->num_pages > 10)
        {
            $this->return = ($this->current_page != 1 And $this->items_total >= 10) ? "<a class=\"paginate\" href=\"{$this->base_url}$prev_page/{$this->items_per_page}{$sort_string}#{$this->pager_id}\">« Previous</a> ":"<span class=\"inactive\" href=\"#\">« Previous</span> ";

            $this->start_range = $this->current_page - floor($this->mid_range/2);
            $this->end_range = $this->current_page + floor($this->mid_range/2);

            if($this->start_range <= 0)
            {
                $this->end_range += abs($this->start_range)+1;
                $this->start_range = 1;
            }
            if($this->end_range > $this->num_pages)
            {
                $this->start_range -= $this->end_range-$this->num_pages;
                $this->end_range = $this->num_pages;
            }
            $this->range = range($this->start_range,$this->end_range);

            for($i=1;$i<=$this->num_pages;$i++)
            {
                if($this->range[0] > 2 And $i == $this->range[0]) $this->return .= " ... ";
                // loop through all pages. if first, last, or in range, display
                if($i==1 Or $i==$this->num_pages Or in_array($i,$this->range))
                {
                    // $this->return .= ($i == $this->current_page And $this->tina_page_no != 'all') ? "<a title=\"Go to page $i of $this->num_pages\" class=\"current\" href=\"#\">$i</a> ":"<a class=\"paginate\" title=\"Go to page $i of $this->num_pages\" href=\"{$this->base_url}$i/$this->items_per_page\">$i</a> ";
                    $this->return .= ($i == $this->current_page And $this->tina_page_no != 'all') ? "<span class=\"current\">$i</span> ":"<a class=\"paginate\" title=\"Go to page $i of $this->num_pages\" href=\"{$this->base_url}$i/{$this->items_per_page}{$sort_string}#{$this->pager_id}\">$i</a> ";
                }
                if($this->range[$this->mid_range-1] < $this->num_pages-1 And $i == $this->range[$this->mid_range-1]) $this->return .= " ... ";
            }
            $this->return .= (($this->current_page != $this->num_pages And $this->items_total >= 10) And ($this->tina_page_no != 'all')) ? "<a class=\"paginate\" href=\"{$this->base_url}$next_page/{$this->items_per_page}{$sort_string}#{$this->pager_id}\">Next »</a>\n":"<span class=\"inactive\" href=\"#\">» Next</span>\n";
            
            //tmprd( $this->items_per_page);
            
            $this->return .= ($this->items_per_page == 'all') ? "<a class=\"current\" style=\"margin-left:10px\" href=\"{$this->base_url}1/{$this->saved_items_per_page}{$sort_string}#{$this->pager_id}\">$this->saved_items_per_page</a> \n":"<a class=\"paginate\" style=\"margin-left:10px\" href=\"{$this->base_url}1/all{$sort_string}#{$this->pager_id}\">(show all {$this->items_total})</a> \n";
        }
        else
        {
            for($i=1;$i<=$this->num_pages;$i++)
            {
                $this->return .= ($i == $this->current_page) ? "<a class=\"current\" href=\"#\">$i</a> ":"<a class=\"paginate\" href=\"{$this->base_url}$i{$sort_string}#{$this->pager_id}\">$i</a> ";
            }
            if( $this->items_per_page == 'all' ) {
                $this->return .= "<a class=\"paginate\" href=\"{$this->base_url}1/0{$sort_string}#{$this->pager_id}\">({$this->saved_items_per_page} per page)</a> \n";
            }
            else {
                $this->return .= "<a class=\"paginate\" href=\"{$this->base_url}1/all{$sort_string}#{$this->pager_id}\">(show all {$this->items_total})</a> \n";
            }
        }
        $this->low = ($this->current_page-1) * $this->items_per_page;
        $this->high = ($this->items_per_page == 'all') ? $this->items_total:($this->current_page * $this->items_per_page)-1;
        $this->limit = ($this->items_per_page == 'all') ? "":" LIMIT $this->low,$this->items_per_page";
        
    }

    function display_items_per_page()
    {
        $items = '';
        $ipp_array = array(10,25,50,100,'All');
        foreach($ipp_array as $ipp_opt)    $items .= ($ipp_opt == $this->items_per_page) ? "<option selected value=\"$ipp_opt\">$ipp_opt</option>\n":"<option value=\"$ipp_opt\">$ipp_opt</option>\n";
        return "<span class=\"paginate\">Items per page:</span><select class=\"paginate\" onchange=\"window.location='{$this->base_url}1/'+this[this.selectedIndex].value;return false\">$items</select>\n";
    }

    function display_jump_menu()
    {
        for($i=1;$i<=$this->num_pages;$i++)
        {
            $option .= ($i==$this->current_page) ? "<option value=\"$i\" selected>$i</option>\n":"<option value=\"$i\">$i</option>\n";
        }
        return "<span class=\"paginate\">Page:</span><select class=\"paginate\" onchange=\"window.location='{$this->base_url}'+this[this.selectedIndex].value+'/$this->items_per_page';return false\">$option</select>\n";
    }

    function display_pages()
    {
        return $this->return;
    }
}
?>