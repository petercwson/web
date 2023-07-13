<?php
  header("Content-Type: text/html; charset=UTF-8");

  $prevPage=$_SERVER['HTTP_REFERER'];

  $name_01=$_POST['name'];
  $email_01=$_POST['email'];
  $company_01=$_POST['company'];
  $phone_01=$_POST['phone'];
  $subject_01=$_POST['subject'];
  $message_01=$_POST['message'];

  if($subject_01=="No"){
    echo '<script>alert("Select Services")</script>';
    echo "<script>history.back()</script>";
  } else {
    $to='cwson@syinfo.kr';

    $subject="=?utf-8?B?".base64_encode($subject_01)."?=\n";

    $msg="보낸사람 : "."$name_01\n"."email : "."$email_01\n"."company : "."$company_01\n"."phone : "."$phone_01\n"."메세지 : \n"."$message_01\n";

    $result = mail($to,$subject,chunk_split($msg));

    if($result){
        echo '<script>alert("담당자에게 메일이 발송되었습니다.")</script>';
        echo "<script>history.back()</script>";
    } else {
        echo "mail fail";
    }
  }  
?>
