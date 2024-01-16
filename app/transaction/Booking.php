<?php 
if (function_exists($_GET['f_name'])) {
    $_GET['f_name']();
}

function get_all_booking(){
    require_once "../../config/connection.php";
    $date = $_GET['date'];
    $sql = "SELECT * from booking_fields a, fields b, customers c where a.customer_code = c.customer_code and a.id_field = b.id_field and a.booking_date = '$date' and a.deleted_at is null";
    $query = mysqli_query($connect,$sql);
    $html = "";
    $no = 1;
    while ($row = mysqli_fetch_array($query)) {
        if ($row['status'] == 'Canceled') {
            $button = "<button type='button' class='btn btn-sm btn-info' onclick='getReservationById(".$row['id_booking'].", 1)'><i class='fa fa-eye'></i></button>";
        }else{
            $button = "
            <button type='button' class='btn btn-sm btn-info' onclick='getReservationById(".$row['id_booking'].", 1)'><i class='fa fa-eye'></i></button>
            <button type='button' class='btn btn-sm btn-warning' onclick='getReservationById(".$row['id_booking'].")'><i class='fa fa-pen'></i></button>
            <button type='button' id='warning' onclick='deleteReservation(".$row['id_booking'].")' class='btn btn-sm btn-danger warning'><i class='fa fa-trash'></i></button>
            ";
        }
        $html .= "<tr>
                        <td>".$no++."</td>
                        <td>".$row['start_time']."</td>
                        <td>".$row['end_time']."</td>
                        <td>".$row['field_name']."</td>
                        <td>".$row['customer_name']."</td>
                        <td>".$row['status']."</td>
                        <td>
                            <div class='btn-group' role='group'>
                                $button
                            </div>
                        </td>
                    </tr>";
    }

    echo $html;
}

function get_reservation_by_id(){
    require_once "../../config/connection.php";
    $id = $_GET['data'];
    $sql = "SELECT *,(SELECT payment_method from payments where no_booking=a.no_booking and note='DP') payment_method, a.total - (SELECT ifnull(SUM(payment),0) from payments where no_booking=a.no_booking and deleted_at is null) tobepaid  from booking_fields a where a.id_booking='$id' and a.deleted_at is null";
    $query = mysqli_query($connect,$sql);
    $data = mysqli_fetch_assoc($query);
    echo json_encode($data);
}

function store(){
    require_once "../../config/connection.php";
    $date = $_POST['date'];
    $count = mysqli_num_rows(mysqli_query($connect,"SELECT * from booking_fields where booking_date='$date'"));
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

    $stmt = $conn->prepare("INSERT INTO booking_fields (no_booking, customer_code, pic, phone, booking_date, start_time, end_time, id_field, dp, total, status, hour, id_user) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1)");
    $stmt->bind_param("sssssssiiisi", $code, $customer_code, $pic, $phone, $date, $start, $end, $field, $dp, $totalprice, $status, $hour);

    if ($stmt->execute()) {

        $stmt = $conn->prepare("INSERT INTO payments (no_payment, no_booking, customer_code, payment, payment_method, payment_date, note, id_user) VALUES (?, ?, ?, ?, ?, ?, 'DP', 1)");
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
            "status" => 'failed on booking',
            "message" => $error_log,
            "date" => $date
        ];
    }

    echo json_encode($data);


}


function update(){
    require_once "../../config/connection.php";
    $id_booking = $_POST['id_booking'];
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
    $stmt = $conn->prepare("UPDATE booking_fields set customer_code = ?, pic = ?, phone = ?, booking_date = ?, start_time = ?, end_time = ?, id_field = ?, dp = ?, total = ?, status = ?, hour = ? where id_booking= ?");
    $stmt->bind_param("ssssssiiisii", $customer_code, $pic, $phone, $date, $start, $end, $field, $dp, $totalprice, $status, $hour, $id_booking);

    if ($stmt->execute()) {
        $stmt = $conn->prepare("UPDATE payments set payment = ?,  payment_method = ? WHERE note='DP' and no_booking = (SELECT no_booking from booking_fields where id_booking=$id_booking)");
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
            "status" => 'failed on booking',
            "message" => $error_log,
            "date" => $date
        ];
    }

    echo json_encode($data);
}

function delete(){
    require_once "../../config/connection.php";
    $id_booking = $_GET['id_booking'];
    $stmt = $conn->prepare("UPDATE booking_fields set status = 'Canceled' where id_booking = ?");
    $stmt->bind_param("i", $id_booking);
    

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
    $id_booking = $_POST['id_booking'];
    $payment = $_POST['paid'];
    $payment_method = $_POST['payment_method'];
    $query_booking = "SELECT * from booking_fields where id_booking=$id_booking";
    $data_booking = mysqli_fetch_array(mysqli_query($connect,$query_booking));

    $count = mysqli_num_rows(mysqli_query($connect,"SELECT * from payments where payment_date='$date'"));
    $new_num = $count+1;
    $dateformat = date('dmy',strtotime($date));
    $codepayment = "PY/".$dateformat.'/'.sprintf('%03d',$new_num);

    $stmt = $conn->prepare("INSERT into payments(no_payment,no_booking,customer_code,payment,payment_method,payment_date,note,id_user) values(?, ?, ?, ?, ?, ?, 'Payment', 1)");
    $stmt->bind_param("sssiis", $codepayment, $data_booking['no_booking'], $data_booking['customer_code'], $payment, $payment_method, $date);

    if ($stmt->execute()) {
        $paid = mysqli_fetch_array(mysqli_query($connect,"SELECT sum(payment) payment from payments where no_booking = '".$data_booking['no_booking']."' and deleted_at is null"));
        if ($data_booking['total'] == $paid['payment']) {
            $stmt = $conn->prepare("UPDATE booking_fields set status='Paid Off' where id_booking=?");
            $stmt->bind_param("i", $id_booking);

            if ($stmt->execute()) {
                $data = [
                    "status" => 'success',
                    "message" => 'hore',
                    "date" => $data_booking['booking_date']
                ];
            }else{
                $error_log = $stmt->error;
                $data = [
                    "status" => 'failed on update status',
                    "message" => $error_log,
                    "date" => $data_booking['booking_date']
                ];
            }

        }else{
            $data = [
                "status" => 'success',
                "message" => 'hore',
                "date" => $data_booking['booking_date']
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