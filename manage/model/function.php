<?php
/**
 * 获取后台控制菜单
 * @param array $menu
 */
function get_menu(&$menu)
{
    $tpl = '<a href="%s"><li class="list-group-item %s"><span class="badge">%s</span><span class="glyphicon %s"></span> %s</li></a>';
    $html = '';
    $controller_name = \Core\Application::get_controller(true);
    foreach ($menu as &$val)
    {
        if(stripos($val['link'], $controller_name))
        {
            $val['is_active'] = true;
        }
        $active = $val['is_active'] ? 'select' : '';
        $html .= sprintf($tpl, $val['link'], $active, $val['badge'], $val['ico'], $val['name']);
    }
    return $html;
}

/**
 * 获取当前激活的菜单
 * @param array $menu
 */
function get_active_item($menu)
{
    $tpl = '<span class="glyphicon %s"></span> %s';
    foreach ($menu as $val)
    {
        if($val['is_active'])
        {
            return sprintf($tpl, $val['ico'], $val['name']);
        }
    }
}