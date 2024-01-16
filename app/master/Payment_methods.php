<?php 
if (function_exists($_GET['f_name'])) {
    $_GET['f_name']();
}

function get_all_payment_methods(){
    require_once "../../config/connection.php";
    $sql = "SELECT * from payment_methods where deleted_at is null";
    $query = mysqli_query($connect,$sql);
    $html = "";
    $no = 1;
    while ($row = mysqli_fetch_array($query)) {
        $html .= "<tr>
                        <td>".$no++."</td>
                        <td>".$row['payment_method']."</td>
                        <td>
                            <div class='btn-group' role='group'>
                                <button type='button' class='btn btn-sm btn-warning' onclick='getPaymentMethodbyId(".$row['id_payment_method'].")'><i class='fa fa-pen'></i></button>
                                <button type='button' id='warning' onclick='deletePaymentMethod(".$row['id_payment_method'].")' class='btn btn-sm btn-danger warning'><i class='fa fa-trash'></i></button>
                            </div>
                        </td>
                    </tr>";
    }

    echo $html;
}

function get_payment_method_by_id(){
    require_once "../../config/connection.php";
    $id = $_GET['data'];
    $sql = "SELECT * from payment_methods where id_payment_method='$id' and deleted_at is null";
    $query = mysqli_query($connect,$sql);
    $data = mysqli_fetch_assoc($query);
    echo json_encode($data);
}

function store(){
    require_once "../../config/connection.php";
    $payment_method = $_POST['payment_method'];

    $stmt = $conn->prepare("INSERT INTO payment_methods (payment_method, id_user) VALUES (?, 1)");
    $stmt->bind_param("s", $payment_method);
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
    

    $payment_method = $_POST['payment_method'];
    $id_payment_method = $_POST['id_payment_method'];

    $stmt = $conn->prepare("UPDATE payment_methods set payment_method = ?, id_user = 1, updated_at = sysdate() where id_payment_method = ?");
    $stmt->bind_param("si", $payment_method, $id_payment_method);
    

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
    $id_payment_method = $_GET['id_payment_method'];
    $stmt = $conn->prepare("UPDATE payment_methods set deleted_at = sysdate() where id_payment_method = ?");
    $stmt->bind_param("i", $id_payment_method);
    

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