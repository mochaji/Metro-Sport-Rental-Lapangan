<?php
require_once('config/connection.php');

$pageload = '';
$pagemenu = '';
if (!empty($_GET['pageload'])) {
    $pageload = $_GET['pageload'];
}

if (!empty($_GET['menu'])) {
    $pagemenu = $_GET['menu'];
}

$level = 1;
$sql = "SELECT DISTINCT a.id_menu, a.menu_name, a.link, a.icon, a.path from menus a  join access_menu b on b.id_menu = a.id_menu where b.level = $level";
$query = mysqli_query($connect,$sql);
$html = "";
while ($menu = mysqli_fetch_array($query)) {
    $id_menu = $menu['id_menu'];
    $submenu = '';
    $active = '';
    $sql_submenu = mysqli_query($connect,"SELECT a.id_submenu, a.submenu_name, a.link, a.pageload from submenus a where a.id_menu = $id_menu and a.deleted_at is null");
    $has_submenu = (mysqli_num_rows($sql_submenu) > 0) ? 'has-sub' : '';


    //get active menu
    $check = mysqli_num_rows(mysqli_query($connect,"SELECT a.pageload from submenus a where a.id_menu = $id_menu and a.pageload = '$pageload'"));
    $active = ($check>0) ? 'active' : '';

    if (!empty($pagemenu)) {
        $check = mysqli_num_rows(mysqli_query($connect,"SELECT * from menus a where a.id_menu = $id_menu and a.path = '$pagemenu'"));
        $active = ($check>0) ? 'active' : '';
    }


    if (empty($pageload) && empty($pagemenu) && $id_menu == 1) {
        $active = 'active';
    }

    //submenu
    if ($has_submenu == 'has-sub') {
        $submenu = '<ul class="submenu '.$active.'">';
        while ($sub = mysqli_fetch_array($sql_submenu)) {
            $submenu .= '<li class="submenu-item '.$active.'">
                            <a href="'.$sub['link'].'">'.$sub['submenu_name'].'</a>
                        </li>';
        }
        $submenu .= '</ul>';
    }

    //menu
    $html .= '<li class="sidebar-item '.$has_submenu.' '.$active.'">
                    <a href="'.$menu['link'].'" class="sidebar-link">
                        <i class="'.$menu['icon'].'"></i>
                        <span>'.$menu['menu_name'].'</span>
                    </a>
                    '.$submenu.'
                </li>';
}

echo $html;

?>