<?php
session_start();

// collecting data
$email = $_POST['email'];

$errorCount = 0;

// verifying data
$email == "" ? $errorCount++ : $email;
$_SESSION['email'] = $email;

if ($errorCount == 1) {
    //Give feedback to user
    $_SESSION["error"] = "You have " . $errorCount . " error in your form submission";
    header("Location: login.php");
}else if($errorCount > 1){
    $_SESSION["error"] = "You have " . $errorCount . " errors in your form submission";
    header("Location: login.php");
}else{
    $allUsers = scandir("db/users");
    $countAllUsers = count($allUsers);

    //check if the user already exists.
    for ($counter = 0; $counter < $countAllUsers; $counter++){
        $currentUser = $allUsers[$counter];
        if($currentUser == $email .".json"){
            //add email
            
            $token = ""; //TODO on token generation
            // Generate Token generation
            $alphabet = ['a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','A','B','C','D','E','F','G',
            'H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];

            for ($i = 0; $i < 20; $i++){
                $index = mt_rand(0,count($alphabet));
                $token = $token . $alphabet[$index];
            }
            
            $subject = "Password Reset Link";
            $message = "A password reset has been inittiated from your account, 
            if you did not initiate this reset, please ignore this message, otherwise, 
            visit localhost:81/startnghospital/reset.php?token=".$token;
            $headers = "From: no-reply@smh.org" . "\r\n" . "CC: josh@smh.org";
            file_put_contents( "db/tokens/" . $email . ".json", json_encode(['token'=> $token]));
            $try = mail($email,$subject,$message,$headers);
            if ($try){
                //success message
                $_SESSION["error"] = "Password reset has been sent to your mail " . $email;
                header("Location: login.php");
            }else{
                //display error message
                $_SESSION["error"] = "Something went wrong, we could not send password reset to " . $email;
                header("Location: login.php");
            }
            die();
        }
         
    }

    $_SESSION["error"] = "Email not registered with us";
    header("Location: login.php");
    die();
}