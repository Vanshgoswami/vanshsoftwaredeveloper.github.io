<?php
  if(isset($_POST['send'])){

    $url = 'https://www.google.com/recaptcha/api/siteverify';
    $privatekey ="6Ld04ywUAAAAAEjzQ0PjNCqkYLUWTuBLaAOJNVwS";

    $response = file_get_contents($url."?secret=".$privatekey."&response=".$_POST['g-recaptcha-response']."&remoteip=".$_SERVER['REMOTE_ADDR']);
    $data = json_decode($response);

    if(isset($data->success) AND $data->success==true){


      header('Location: index.php?CaptchaPass=True');


      $errors = '';
      $myemail = 'vanshgoswami.17@gmail.com';//<-----Put Your email address here.
      if(empty($_POST['name'])  ||
         empty($_POST['email']) ||
         empty($_POST['message']))
      {
          $errors .= "\n Error: all fields are required";
      }

      $name = $_POST['name'];
      $email_address = $_POST['email'];
      $message = $_POST['message'];

      if (!preg_match(
      "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/i",
      $email_address))
      {
          $errors .= "\n Error: Invalid email address";
      }

      if( empty($errors))
      {
      	$to = $myemail;
      	$email_subject = "Customer from my website: $name";
      	$email_body = "You have received a new message. ".
      	" Here are the details:\n Name: $name \n Email: $email_address \n Message: $message";

      	$headers = "From: $myemail\n";
      	$headers .= "Reply-To: $email_address";

      	mail($to,$email_subject,$email_body,$headers);
      	//redirect to the 'thank you' page
      	header('Location: thank-you.html');
      }


  }else{

        header('Location: captchafailed.php?CaptchaFail=True');
  }

  }

?>
