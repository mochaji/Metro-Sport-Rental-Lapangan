<?php 
if (isset($_GET['pageload'])) {
    $pageload=$_GET['pageload'];
    $getcontent = mysqli_query($connect,"SELECT a.submenu_name, a.link,a.path, a.pageload, b.menu_name, b.link menu_link, a.submenu_description from submenus a, menus b where a.id_menu = b.id_menu and a.pageload='$pageload'");
    $content = mysqli_fetch_array($getcontent);
    $submenu = $content['submenu_name'];
    $submenu_link = $content['link'];
    $menu = $content['menu_name'];
    $menu_link = $content['menu_link'];
    $description = $content['submenu_description'];

    if(file_exists($content['path'])){
        require_once($content['path']);
    }else{
        include "pages/error/404.php";
    }
 
   
}elseif (isset($_GET['menu'])){
    $menu = $_GET['menu'];
    $getcontent = mysqli_query($connect,"SELECT a.menu_name, a.menu_description, a.link as menu_link, a.path from menus a where path='$menu'");
    $content = mysqli_fetch_array($getcontent);
    $submenu = '';
    $submenu_link = '';
    $menu = $content['menu_name'];
    $menu_link = $content['menu_link'];
    $description = $content['menu_description'];
    $path = 'pages/'.$content['path'].'/index.php';
    if(file_exists($path)){
        require_once($path);
    }else{
        include "pages/error/404.php";
    }
}else{
    include "pages/dashboard/dashboard.php";
}





?>