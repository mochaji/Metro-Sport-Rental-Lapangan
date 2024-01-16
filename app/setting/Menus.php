<?php 
if (function_exists($_GET['f_name'])) {
    $_GET['f_name']();
}

function get_all_menus(){
    require_once "../../config/connection.php";
    $sql = "SELECT * from menus where deleted_at is null";
    $query = mysqli_query($connect,$sql);
    $html = "";
    $no = 1;
    while ($row = mysqli_fetch_array($query)) {
        $html .= "<tr>
                        <td>".$no++."</td>
                        <td>".$row['menu_name']."</td>
                        <td>".$row['menu_description']."</td>
                        <td>".$row['link']."</td>
                        <td>".$row['path']."</td>
                        <td>".$row['icon']."</td>
                        <td>
                            <div class='btn-group' role='group'>
                                <button type='button' class='btn btn-sm btn-warning' onclick='getMenubyId(".$row['id_menu'].")'><i class='fa fa-pen'></i></button>
                                <button type='button' id='warning' class='btn btn-sm btn-danger warning'><i class='fa fa-trash'></i></button>
                            </div>
                        </td>
                    </tr>";
    }

    echo $html;
}

function get_menu_by_id(){
    require_once "../../config/connection.php";
    $id = $_GET['data'];
    $sql = "SELECT * from menus where id_menu='$id' and deleted_at is null";
    $query = mysqli_query($connect,$sql);
    $data = mysqli_fetch_assoc($query);
    echo json_encode($data);
}


function store(){
    require_once "../../config/connection.php";
    $menu_name = $_POST['menu_name'];
    $menu_description = $_POST['menu_description'];
    $link = $_POST['link'];
    $path = $_POST['path'];
    $icon = $_POST['icon'];

    $stmt = $conn->prepare("INSERT INTO menus (menu_name, menu_description, link, path, icon, id_user) VALUES (?, ?, ?, ?, ?, 1)");
    $stmt->bind_param("sssss", $menu_name, $menu_description, $link, $path, $icon);
    $stmt->execute();

    $menu_id = $conn->insert_id;


    $stmt = $conn->prepare("INSERT INTO access_menu (id_menu, level, id_user) VALUES (?, 1, 1)");
    $stmt->bind_param("i", $menu_id);
    $stmt->execute();

    if (!file_exists($path)) {
        $directory = '../../pages/'.$path;
        $newfile = $directory."/index.php";
        $make_dir = mkdir($directory, 0777, true);
        $fh = fopen($newfile, 'w') or die("Can't create file");
        chmod($newfile,0777);

        $text = mysqli_fetch_array(mysqli_query($connect,"SELECT data from global_variable where variable = 'default_content_menu'"));
        $txt = $text['data'];
        file_put_contents($newfile, $txt, FILE_APPEND);


    }



    // $store = mysqli_query($connect,"INSERT into menus(menu_name,menu_description,link,path,icon) values('$menu_name','$menu_description','$link','$path','$icon')");
    if (false === $stmt) {
        $error_log = $stmt->error;
        $data = [
            "status" => 'failed',
            "message" => $error_log,
        ];
    }else{
        $data = [
            "status" => 'success',
            "message" => 'hore',
        ];
    }


        echo json_encode($data);
    
}


?>