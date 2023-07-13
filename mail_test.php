<?php
  header("Content-Type: text/html; charset=UTF-8");

  $prevPage=$_SERVER['HTTP_REFERER'];

  $name_01='손창우';
  $email_01='petercwson@gmail.com';
  $company_01='(주)고객';
  $phone_01='010-6254-9140';
  $subject_01='제목입니다.';
  $message_01='내용입니다.';

  $to='petercwson@gmail.com';

  $subject="=?utf-8?B?".base64_encode($subject_01)."?=\n";

  $msg="보낸사람 : "."$name_01\n"."email : "."$email_01\n"."company : "."$company_01\n"."phone : "."$phone_01\n"."메세지 : \n"."$message_01\n";

  $result = mail($to,$subject,chunk_split($msg));

  if($result){
      echo 'ok';
      
    //   echo "<script>history.back()</script>";
  } else {
      echo "mail fail";
  }
?>
