<?php
namespace Model;

class Page extends \Ext\Pagination
{   
    public function __toString()
    {
        if ($this->maximum_page < 1)
        {
            return '';
        }
        $html = '<ul class="pagination" style="margin:0px;"><li><a href="#">总数:'.$this->total.'</a></li>';
        $previous = $this->range($this->current_page - 1, 1, $this->maximum_page);
        $html.= '<li><a href="'.\Core\URI::a2p_before(array('page'=>$previous)).'">&laquo;</a></li>';
        for ($i = $this->first_page; $i <= $this->last_page; $i++)
        {
            if ($i == $this->current_page)
            {
                $html .= "<li class='active'><a href='".\Core\URI::a2p_before(array('page'=>$i))."'>{$i}</a></li>";
            }
            else 
            {
                $html .= "<li><a href='".\Core\URI::a2p_before(array('page'=>$i))."'>{$i}</a></li>";
            }
        }
        $next = $this->range($this->current_page + 1, 1, $this->maximum_page);
        $html .= '<li><a href="'.\Core\URI::a2p_before(array('page'=>$i)).'">&raquo;</a></li>';
        $html .= '</ul>';
        return $html;
    }
}