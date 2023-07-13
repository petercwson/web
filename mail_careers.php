<?php
// 이메일 발송
// toname, toemail = 받는 사람
// fromname, fromemail = 보내는 사람
// title = 제목
// content = 본문내용
// charset = 언어, 기본값: euc-kr
// mode = TEXT/HTML
// att = 첨부파일, 예제: $_FILES['userfile']['tmp_name']
// 파일이 여러 개일 경우
// 하나의 파일에 대한 정보를 :로 구분해서 묶어 주어 ,로 구분해 줍니다.
// $_FILES['userfile']['tmp_name']:$_FILES['userfile']['name']:MIMETYPE
//  tmp_name[0]:name[0]:mime[0],tmp_name[1]:name[1]:mime[1]
$prevPage=$_SERVER['HTTP_REFERER'];

$name_01=$_POST['name'];
$phone_01=$_POST['phone'];
$subject_01=$_POST['subject'];
$message_01=$_POST['message'];
// $att = $_FILES['userfile']['tmp_name'] ;
$att = $_POST['fileupload'];

$toemail = "cwson@syinfo.kr";
$fromemail = $_POST['email'];
$title = $_POST['subject'];
$content = "보낸사람 : "."$name_01\n"."phone : "."$phone_01\n"."subject : "."$subject_01\n"."메세지 : \n"."$message_01\n";

$charset='euc-kr';
$mode='TEXT/HTML';

      $Arrayfile = explode(',',$_FILES['userfile']['tmp_name']);

      // 받는 사람
      $recipient = $toname." <".$toemail.">\r\n";

      // 기본 헤더 코드
      $header .= "Return-path: <".$fromemail.">\r\n";
      $header .= "From: ".$fromname."<".$fromemail.">\r\n";

      // 에러발생시 반송될 주소
      $header .= "Reply-To:".$fromname."<".$fromemail.">\r\n";
      $header .= "MIME-Version: 1.0\r\n";
      $header .= "X-Sender: <".$fromemail.">\r\n";
      $header .= "X-Mailer: PHP\r\n";

      // 첨부파일이 없다면...
      if(empty($att)){

            // 내용 첨부
            $header .= "Content-Type: ".$mode.
                         "; charset=".$charset."\r\n";
            $body = $content."\r\n\r\n";
      }
      // 첨부파일이 있다면...
      else{

           for($i=0; $i                   list($upfile[$i],$filename[$i],$mimetype[$i])
                   = explode(':',$Arrayfile[$i]);

                 // 파일열기
                 $fp[$i] = @fopen($upfile[$i],"r");
                 $file[$i] = @fread($fp[$i],@filesize($upfile[$i]));
                 @fclose($fp[$i]);

                 // 파일 타입
                 if(empty($mimetype[$i])){
                       $mime[$i] = "application/octet-stream";
                 } else {
                       $mime[$i] = $mimetype[$i];
                 }
            }

            $boundary = "--".uniqid("gmForm editor");
            $header .= "Content-type: MULTIPART/MIXED;
                         BOUNDARY=\"$boundary\"";
            $body = "This is a multi-part message in MIME format.\r\n\r\n";
            $body .= "--$boundary\r\n";

            // 내용 첨부
            $body .= "Content-Type: ".$mode."; charset=".$lang."\r\n";
            $body .= "Content-Transfer-Encoding: base64\r\n\r\n";
            $body .= chunk_split(base64_encode($content))."\r\n\r\n";

            for($i=0; $i
                  // 파일 첨부
                 $body .= "--$boundary\r\n";
                 $body .= "Content-Type: $mime[$i];
                            name=\"$filename[$i]\"\r\n";
                 $body .= "Content-Transfer-Encoding: base64\r\n\r\n\r\n";
                 $body .=
                        chunk_split(base64_encode($file[$i]))."\r\n";
            }
            $body .= "\r\n--$boundary--\r\n";
     }

     // return @mail($recipient,$title,$body,$header);

     $result = mail($recipient,$title,$body,$header);

     if($result){
         echo '<script>alert("담당자에게 메일이 발송되었습니다.")</script>';
         echo "<script>history.back()</script>";
     } else {
         echo "mail fail";
     }
?>
