<?php session_start();

// error count
$errorCount = 0;

// get token if user is not loggedIn
if(!$_SESSION['loggedIn']){
    $token = $_POST['token'];
    $token == "" ? $errorCount++ : $token;
    $_SESSION['token'] = $token;
}

//collecting the data
$email = $_POST['email'];
$password = $_POST['password'];

//Verifying the data, validation
$email == "" ? $errorCount++ : $email;
$password == "" ? $errorCount++ : $password;

// Saving data to Session
$_SESSION['email'] = $email;

// checking error count and displaying appropriate message
if ($errorCount == 1) {
    //Give feedback to user
    $_SESSION["error"] = "You have " . $errorCount . " error in your form submission";
    header("Location: reset.php");
}else if($errorCount > 1){
    $_SESSION["error"] = "You have " . $errorCount . " errors in your form submission";
    header("Location: reset.php");
}else {
    
    // check that the email is regustered in tokens folder
    $allUsersTokens = scandir("db/tokens");
    $countAllUsersTokens = count($allUsersTokens);
    

    for ($counter = 0; $counter < $countAllUsersTokens; $counter++){
        $currentTokenFile = $allUsersTokens[$counter];
       
        if($currentTokenFile == $email .".json"){
            $usertoken = file_get_contents("db/tokens/" . $currentTokenFile);
            $tokenObject = json_decode($usertoken);
            $tokenFrmDB = $tokenObject->token;


            //Make it better
            if($_SESSION['loggedIn']){
                $checkToken = true;
            }else{
                $checkToken = $tokenFrmDB == $token;
            }
            
            if($checkToken){
                $allUsers = scandir("db/users");
                $countAllUsers = count($allUsers);
                
            
                //check if the user already exists.
                for ($counter = 0; $counter < $countAllUsers; $counter++){
                    $currentUser = $allUsers[$counter];
                    if($currentUser == $email .".json"){
                        $userString = file_get_contents("db/users/" . $currentUser);
                        $userObject = json_decode($userString);

                        $userObject->password = password_hash($password, PASSWORD_DEFAULT);
                        unlink("db/users/" . $currentUser); //delete previous file

                        
                        file_put_contents( "db/users/" . $email . ".json", json_encode($userObject));
                        

                        //imform user of password reset
                       
                        $subject = "Password Reset Successful";
                        $message = "Your account on smh has been updated, your password has changed, 
                        if you did not initiate the password change, please visi smh.org and reset the password now.";
                        $headers = "From: no-reply@smh.org" . "\r\n" . "CC: josh@smh.org";
                        $try = mail($email,$subject,$message,$headers);
                        if ($try){
                            $_SESSION["message"] = "Password Reset Successful, you can now login ";
                            header("Location: login.php");
                            die();
                        }else{
                            header("Location: login.php");
                            die();
                        }
                        
                       
                        
                    }
                
            }
            
            
    
        }     
         
    }else if ($_SESSION['loggedIn']){
        $allUsers = scandir("db/users");
        $countAllUsers = count($allUsers);

        for ($counter = 0; $counter < $countAllUsers; $counter++){
            $currentUser = $allUsers[$counter];
            if($currentUser == $email .".json"){
                $userString = file_get_contents("db/users/" . $currentUser);
                $userObject = json_decode($userString);

                $userObject->password = password_hash($password, PASSWORD_DEFAULT);
                unlink("db/users/" . $currentUser); //delete previous file

                
                file_put_contents( "db/users/" . $email . ".json", json_encode($userObject));
                

                //imform user of password reset
               
                $subject = "Password Reset Successful";
                $message = "Your account on smh has been updated, your password has changed, 
                if you did not initiate the password change, please visi smh.org and reset the password now.";
                $headers = "From: no-reply@smh.org" . "\r\n" . "CC: josh@smh.org";
                $try = mail($email,$subject,$message,$headers);
                if ($try){
                    $_SESSION["message"] = "Password Reset Successful, you can now login ";
                    header("Location: login.php");
                    die();
                }else{
                    header("Location: login.php");
                    die();
                }
                
               
                
            }
        
    }
        
    }
    //check if the content of the registered token is the same
}



$_SESSION["message"] = "Password Reset Failed, token or email invalid or expired";
header("Location: login.php");
die();

}
?>