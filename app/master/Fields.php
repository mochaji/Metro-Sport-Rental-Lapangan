<?php 
if (function_exists($_GET['f_name'])) {
    $_GET['f_name']();
}

function get_all_fields(){
    require_once "../../config/connection.php";
    $sql = "SELECT * from fields where deleted_at is null";
    $query = mysqli_query($connect,$sql);
    $html = "";
    $no = 1;
    while ($row = mysqli_fetch_array($query)) {
        $html .= "<tr>
                        <td>".$no++."</td>
                        <td>".$row['field_name']."</td>
                        <td>".$row['note']."</td>
                        <td>".$row['price']."</td>
                        <td>
                            <div class='btn-group' role='group'>
                                <button type='button' class='btn btn-sm btn-warning' onclick='getFieldbyId(".$row['id_field'].")'><i class='fa fa-pen'></i></button>
                                <button type='button' id='warning' onclick='deleteField(".$row['id_field'].")' class='btn btn-sm btn-danger warning'><i class='fa fa-trash'></i></button>
                            </div>
                        </td>
                    </tr>";
    }

    echo $html;
}

function get_field_by_id(){
    require_once "../../config/connection.php";
    $id = $_GET['data'];
    $sql = "SELECT * from fields where id_field='$id' and deleted_at is null";
    $query = mysqli_query($connect,$sql);
    $data = mysqli_fetch_assoc($query);
    echo json_encode($data);
}

function store(){
    require_once "../../config/connection.php";
    $field_name = $_POST['field_name'];
    $price = $_POST['price'];
    $note = $_POST['note'];

    $stmt = $conn->prepare("INSERT INTO fields (field_name, price, note, id_user) VALUES (?, ?, ?, 1)");
    $stmt->bind_param("sis", $field_name, $price, $note);
    $stmt->execute();

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

function update(){
    require_once "../../config/connection.php";
    

    $field_name = $_POST['field_name'];
    $price = $_POST['price'];
    $note = $_POST['note'];
    $id_field = $_POST['id_field'];

    $stmt = $conn->prepare("UPDATE fields set field_name = ?, price = ?, note = ?, id_user = 1, updated_at = sysdate() where id_field = ?");
    $stmt->bind_param("sisi", $field_name, $price, $note, $id_field);
    

    if ($stmt->execute()) {
        $data = [
            "status" => 'success',
            "message" => 'hore',
        ];
        
    }else{
        $error_log = $stmt->error;
        $data = [
            "status" => 'failed',
            "message" => $error_log,
        ];
    }

    echo json_encode($data);
}

function delete(){
    require_once "../../config/connection.php";
    $id_field = $_GET['id_field'];
    $stmt = $conn->prepare("UPDATE fields set deleted_at = sysdate() where id_field = ?");
    $stmt->bind_param("i", $id_field);
    

    if ($stmt->execute()) {
        $data = [
            "status" => 'success',
            "message" => 'hore',
        ];
        
    }else{
        $error_log = $stmt->error;
        $data = [
            "status" => 'failed',
            "message" => $error_log,
        ];
    }

    echo json_encode($data);
}

?>