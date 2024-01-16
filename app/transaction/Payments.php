<?php 
if (function_exists($_GET['f_name'])) {
    $_GET['f_name']();
}

function get_all_payments(){
    require_once "../../config/connection.php";
    $first_date = $_GET['first_date'];
    $last_date = $_GET['last_date'];
    $payment_method = $_GET['payment_method'];
    $search = $_GET['search'];
    $filter_payment_method = "";
    if (!empty($payment_method)) {
        $filter_payment_method = " and a.payment_method = ".$payment_method;
    }

    $filter_search = "";
    if (!empty($search)) {
        $filter_search = " and (a.customer_code = (SELECT customer_code from customers where customer_name like '%".$search."%') or a.no_booking like '%".$search."%' or no_payment like '%".$search."%')";
    }
    $sql = "SELECT a.no_payment, a.no_booking, a.payment_date, a.customer_code, (SELECT customer_name from customers where customer_code = a.customer_code) customer_name, (SELECT payment_method from payment_methods where id_payment_method=a.payment_method) payment_method, a.payment from payments a where a.deleted_at is null and a.payment_date >= '$first_date' and a.payment_date <= '$last_date' $filter_payment_method $filter_search";
    $query = mysqli_query($connect,$sql) or die(mysqli_error($connect));
    $html = "";
    $no = 1;

    // echo $sql;
    while ($row = mysqli_fetch_array($query)) {
        $html .= "<tr>
                        <td>".$no++."</td>
                        <td>".$row['no_payment']."</td>
                        <td>".$row['no_booking']."</td>
                        <td>".$row['payment_date']."</td>
                        <td>".$row['customer_name']."</td>
                        <td>".$row['payment_method']."</td>
                        <td>".$row['payment']."</td>
                        <td>
                            <div class='btn-group' role='group'>
                                
                            </div>
                        </td>
                    </tr>";
    }

    echo $html;
}

function get_reservation_by_id(){
    require_once "../../config/connection.php";
    $id = $_GET['data'];
    $sql = "SELECT *,(SELECT payment_method from payments where no_payment=a.no_payment and note='DP') payment_method, a.total - (SELECT ifnull(SUM(payment),0) from payments where no_payment=a.no_payment and deleted_at is null) tobepaid  from payments a where a.id_payment='$id' and a.deleted_at is null";
    $query = mysqli_query($connect,$sql);
    $data = mysqli_fetch_assoc($query);
    echo json_encode($data);
}

function store(){
    require_once "../../config/connection.php";
    $date = $_POST['date'];
    $count = mysqli_num_rows(mysqli_query($connect,"SELECT * from payments where payment_date='$date'"));
    $new_num = $count+1;
    $dateformat = date('dmy',strtotime($date));
    $code = "BF/".$dateformat.'/'.sprintf('%03d',$new_num);

    $count = mysqli_num_rows(mysqli_query($connect,"SELECT * from payments where payment_date='$date'"));
    $new_num = $count+1;
    $dateformat = date('dmy',strtotime($date));
    $codepayment = "PY/".$dateformat.'/'.sprintf('%03d',$new_num);

    $customer_code = $_POST['customer'];
    $customer = mysqli_fetch_array(mysqli_query($connect,"SELECT * from customers where customer_code = '$customer_code'"));
    $pic = $customer['pic'];
    $phone = $customer['phone'];

    $start = $date.' '.$_POST['start'];
    $end = $date.' '.$_POST['end'];
    $field = $_POST['field'];
    $price = mysqli_fetch_array(mysqli_query($connect,"SELECT price from fields where id_field=$field"));

    $starttime = $_POST['start'];
    $stoptime = $_POST['end'];
    $diff = (strtotime($stoptime) - strtotime($starttime));
    $total = $diff/60;
    $hour = $total/60;

    $totalprice = $hour * $price['price'];
    // $minutes_to_hour = round(($total%60)/60);
    // $totaltime = $hour + $minutes_to_hour;

    // echo $totaltime;
    // echo sprintf("%02dh %02dm", floor($total/60), $total%60).'<br>';
    // echo $minutes_to_hour;
    // echo $hour;
    $dp = $_POST['dp'];
    $status = "Partially Paid";
    if ($totalprice == $dp) {
        $status = "Paid Off";
    }

    $payment_method = $_POST['payment_method'];

    $stmt = $conn->prepare("INSERT INTO payments (no_payment, customer_code, pic, phone, payment_date, start_time, end_time, id_field, dp, total, status, hour, id_user) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1)");
    $stmt->bind_param("sssssssiiisi", $code, $customer_code, $pic, $phone, $date, $start, $end, $field, $dp, $totalprice, $status, $hour);

    if ($stmt->execute()) {

        $stmt = $conn->prepare("INSERT INTO payments (no_payment, no_payment, customer_code, payment, payment_method, payment_date, note, id_user) VALUES (?, ?, ?, ?, ?, ?, 'DP', 1)");
        $stmt->bind_param("sssiis", $codepayment, $code, $customer_code, $dp, $payment_method, $date);
        if ($stmt->execute()) {
            $data = [
                "status" => 'success',
                "message" => 'hore',
                "date" => $date
            ];
        }else{
            $error_log = $stmt->error;
            $data = [
                "status" => 'failed on payment',
                "message" => $error_log,
                "date" => $date
            ];
        }
        
    }else{
        $error_log = $stmt->error;
        $data = [
            "status" => 'failed on payment',
            "message" => $error_log,
            "date" => $date
        ];
    }

    echo json_encode($data);


}


function update(){
    require_once "../../config/connection.php";
    $id_payment = $_POST['id_payment'];
    $date = $_POST['date'];
    $customer_code = $_POST['customer'];
    $customer = mysqli_fetch_array(mysqli_query($connect,"SELECT * from customers where customer_code = '$customer_code'"));
    $pic = $customer['pic'];
    $phone = $customer['phone'];

    $start = $date.' '.$_POST['start'];
    $end = $date.' '.$_POST['end'];
    $field = $_POST['field'];
    $price = mysqli_fetch_array(mysqli_query($connect,"SELECT price from fields where id_field=$field"));

    $starttime = $_POST['start'];
    $stoptime = $_POST['end'];
    $diff = (strtotime($stoptime) - strtotime($starttime));
    $total = $diff/60;
    $hour = $total/60;

    $totalprice = $hour * $price['price'];
    // $minutes_to_hour = round(($total%60)/60);
    // $totaltime = $hour + $minutes_to_hour;

    // echo $totaltime;
    // echo sprintf("%02dh %02dm", floor($total/60), $total%60).'<br>';
    // echo $minutes_to_hour;
    // echo $hour;
    $dp = $_POST['dp'];
    $status = "Partially Paid";
    if ($totalprice == $dp) {
        $status = "Paid Off";
    }

    $payment_method = $_POST['payment_method'];
    $stmt = $conn->prepare("UPDATE payments set customer_code = ?, pic = ?, phone = ?, payment_date = ?, start_time = ?, end_time = ?, id_field = ?, dp = ?, total = ?, status = ?, hour = ? where id_payment= ?");
    $stmt->bind_param("ssssssiiisii", $customer_code, $pic, $phone, $date, $start, $end, $field, $dp, $totalprice, $status, $hour, $id_payment);

    if ($stmt->execute()) {
        $stmt = $conn->prepare("UPDATE payments set payment = ?,  payment_method = ? WHERE note='DP' and no_payment = (SELECT no_payment from payments where id_payment=$id_payment)");
        $stmt->bind_param("ii", $dp, $payment_method);
        if ($stmt->execute()) {
            $data = [
                "status" => 'success',
                "message" => 'hore',
                "date" => $date
            ];
        }else{
            $error_log = $stmt->error;
            $data = [
                "status" => 'failed on payment',
                "message" => $error_log,
                "date" => $date
            ];
        }
        
    }else{
        $error_log = $stmt->error;
        $data = [
            "status" => 'failed on payment',
            "message" => $error_log,
            "date" => $date
        ];
    }

    echo json_encode($data);
}

function delete(){
    require_once "../../config/connection.php";
    $id_payment = $_GET['id_payment'];
    $stmt = $conn->prepare("UPDATE payments set status = 'Canceled' where id_payment = ?");
    $stmt->bind_param("i", $id_payment);
    

    if ($stmt->execute()) {
        $data = [
            "status" => 'success',
            "message" => 'hore',
            "date" => $date
        ];
        
    }else{
        $error_log = $stmt->error;
        $data = [
            "status" => 'failed',
            "message" => $error_log,
            "date" => $date
        ];
    }

    echo json_encode($data);
}

function get_selected_field(){
    require_once "../../config/connection.php";
    $id_field = $_GET['id_field'];
    $query = mysqli_query($connect, "SELECT * from fields where id_field = $id_field") or die(mysqli_error($connect));
    $data = mysqli_fetch_assoc($query);
    echo json_encode($data);

}

function pay(){
    require_once "../../config/connection.php";
    $date = date('Y-m-d');
    $id_payment = $_POST['id_payment'];
    $payment = $_POST['paid'];
    $payment_method = $_POST['payment_method'];
    $query_payment = "SELECT * from payments where id_payment=$id_payment";
    $data_payment = mysqli_fetch_array(mysqli_query($connect,$query_payment));

    $count = mysqli_num_rows(mysqli_query($connect,"SELECT * from payments where payment_date='$date'"));
    $new_num = $count+1;
    $dateformat = date('dmy',strtotime($date));
    $codepayment = "PY/".$dateformat.'/'.sprintf('%03d',$new_num);

    $stmt = $conn->prepare("INSERT into payments(no_payment,no_payment,customer_code,payment,payment_method,payment_date,note,id_user) values(?, ?, ?, ?, ?, ?, 'Payment', 1)");
    $stmt->bind_param("sssiis", $codepayment, $data_payment['no_payment'], $data_payment['customer_code'], $payment, $payment_method, $date);

    if ($stmt->execute()) {
        $paid = mysqli_fetch_array(mysqli_query($connect,"SELECT sum(payment) payment from payments where no_payment = '".$data_payment['no_payment']."' and deleted_at is null"));
        if ($data_payment['total'] == $paid['payment']) {
            $stmt = $conn->prepare("UPDATE payments set status='Paid Off' where id_payment=?");
            $stmt->bind_param("i", $id_payment);

            if ($stmt->execute()) {
                $data = [
                    "status" => 'success',
                    "message" => 'hore',
                    "date" => $data_payment['payment_date']
                ];
            }else{
                $error_log = $stmt->error;
                $data = [
                    "status" => 'failed on update status',
                    "message" => $error_log,
                    "date" => $data_payment['payment_date']
                ];
            }

        }else{
            $data = [
                "status" => 'success',
                "message" => 'hore',
                "date" => $data_payment['payment_date']
            ];
        }
        
        
    }else{
        $error_log = $stmt->error;
        $data = [
            "status" => 'failed on save payment',
            "message" => $error_log,
            "date" => $date
        ];
    }

    echo json_encode($data);
}


?>