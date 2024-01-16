<?php
require_once "../../config/connection.php";
$email = $_POST['email'];
$password = base64_encode($_POST['password']);
session_start();
$data = [];
$stmt = $conn->prepare("SELECT id_user, username, user_image, email, level FROM users WHERE (email=? or username=?) AND password=? LIMIT 1");
$stmt->bind_param('sss', $email, $email, $password);
$stmt->execute();
$stmt->bind_result($id_user, $username, $image, $email, $level);
$stmt->store_result();
if($stmt->num_rows == 1)  //To check if the row exists
    {
        while($stmt->fetch()) //fetching the contents of the row
            {
        
                $_SESSION['logged'] = 1;
                $_SESSION['id_user'] = $id_user;
                $_SESSION['username'] = $username;
                $_SESSION['image'] = $image;
                $_SESSION['email'] = $email;
                $_SESSION['level'] = $level;

                $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
                $payload = json_encode($id_user);

                $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
                $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));

                $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, 'ssttinirahasia!', true);
                $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));
                $jwt = $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;
                
                $_SESSION['token'] = $jwt;
                
                $data = [
                    "code" => 200,
                    "message" => "Login success",
                    "token" => $jwt
                ];
           
           }
        
    }
    else {
        $data = [
             "code" => 500,
             "message" => "Invalid email or password",
       ];
    }
    $stmt->close();

    echo json_encode($data);

?>