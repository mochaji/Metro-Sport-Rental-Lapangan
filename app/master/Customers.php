<?php 
if (function_exists($_GET['f_name'])) {
    $_GET['f_name']();
}

function get_all_customers(){
    require_once "../../config/connection.php";
    $sql = "SELECT * from customers where deleted_at is null";
    $query = mysqli_query($connect,$sql);
    $html = "";
    $no = 1;
    while ($row = mysqli_fetch_array($query)) {
        $html .= "<tr>
                        <td>".$no++."</td>
                        <td>".$row['customer_code']."</td>
                        <td>".$row['customer_name']."</td>
                        <td>".$row['pic']."</td>
                        <td>".$row['email']."</td>
                        <td>".$row['phone']."</td>
                        <td>".$row['address']."</td>
                        <td>
                            <div class='btn-group' role='group'>
                                <button type='button' class='btn btn-sm btn-warning' onclick='getcustomerbyId(".$row['id_customer'].")'><i class='fa fa-pen'></i></button>
                                <button type='button' id='warning' onclick='deleteCustomer(".$row['id_customer'].")' class='btn btn-sm btn-danger warning'><i class='fa fa-trash'></i></button>
                            </div>
                        </td>
                    </tr>";
    }

    echo $html;
}

function get_customer_by_id(){
    require_once "../../config/connection.php";
    require_once "../../helpers/helpers.php";
    
    $token = $_GET['token'];
    $valid = validateToken($token);
    if ($valid) {
        $id = $_GET['data'];
        $sql = "SELECT * from customers where id_customer='$id' and deleted_at is null";
        $query = mysqli_query($connect,$sql);
        $data = mysqli_fetch_assoc($query);    
    }else{
        $data = [
            "code" => "500",
            "message" => "Invalid Token",
        ];
    }
    
    echo json_encode($data);
}

function store(){
    require_once "../../config/connection.php";
    
    $count_customer = mysqli_num_rows(mysqli_query($connect,"SELECT * from customers"));
    $new_num = $count_customer+1;
    $code = "CST-".sprintf('%04d',$new_num);

    $customer_name = $_POST['customer_name'];
    $pic = $_POST['pic'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    $stmt = $conn->prepare("INSERT INTO customers (customer_code, customer_name, pic, email, phone, address, id_user) VALUES (?, ?, ?, ?, ?, ?, 1)");
    $stmt->bind_param("ssssss", $code, $customer_name, $pic, $email, $phone, $address);
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
    

    $customer_name = $_POST['customer_name'];
    $pic = $_POST['pic'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $id_customer = $_POST['id_customer'];

    $stmt = $conn->prepare("UPDATE customers set customer_name = ?, pic = ?, email = ?, phone = ?, address = ?, id_user = 1, updated_at = sysdate() where id_customer = ?");
    $stmt->bind_param("sssssi", $customer_name, $pic, $email, $phone, $address, $id_customer);
    

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
    $id_customer = $_GET['id_customer'];
    $stmt = $conn->prepare("UPDATE customers set deleted_at = sysdate() where id_customer = ?");
    $stmt->bind_param("i", $id_customer);
    

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