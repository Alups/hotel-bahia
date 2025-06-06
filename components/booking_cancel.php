<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';

$mail = new PHPMailer(true);
  
   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $rooms = $_POST['rooms'];
   $rooms = filter_var($rooms, FILTER_SANITIZE_STRING);
   $check_in = $_POST['check_in'];
   $check_in = filter_var($check_in, FILTER_SANITIZE_STRING);
   $check_out = $_POST['check_out'];
   $check_out = filter_var($check_out, FILTER_SANITIZE_STRING);
   $adults = $_POST['adults'];
   $adults = filter_var($adults, FILTER_SANITIZE_STRING);
   $childs = $_POST['childs'];
   $childs = filter_var($childs, FILTER_SANITIZE_STRING);
   $room_category = $_POST['room_category'];
   $room_category = filter_var($room_category, FILTER_SANITIZE_STRING);
   $method = $_POST['collapseGroup'];
   $method = filter_var($method, FILTER_SANITIZE_STRING);
   $room_price = $_POST['room_price'];
   $room_price = filter_var($room_price, FILTER_SANITIZE_STRING);

try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'hotelbahiasubic00@gmail.com';
    $mail->Password = 'tmdwkeufaywvgbdo';
    $mail->Port = 465;
    $mail->SMTPSecure = 'ssl';
    $mail->isHTML(true);
    $mail->setFrom($email, 'Hotel Bahia');
    $mail->addAddress($email);
    $mail->Subject = 'Details of your booking';
    $mail->Body = "<p>Dear $name,</p>
    <p>We are informing you that you cancel your booking, here are your booking details</p>
    <p>Booking ID: $booking_id</p>
    <p>Email: $email</p>
    <p>Check-in: $check_in</p>
    <p>Check-out: $check_out</p>
    <p>Adults: $adults</p>
    <p>Children: $childs</p>
    <p>Room Category: $room_category</p>
    <p>Payment Method: $method</p>
    <p>Room Price: ₱$room_price.00</p>
    <p>Thank you and have a nice day!</p>";

    $mail->send();

    // $success_register[] = 'Booked successfully. Check your email for your details!';
} catch (Exception $e) {
    $erro_msg[] = $mail->ErrorInfo;
}
?>
