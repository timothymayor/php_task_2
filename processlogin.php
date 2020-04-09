<?php
session_start();

// collecting data
$email = $_POST['email'];
$password = $_POST['password'];

// error count
$errorCount = 0;

// verifying data
$email == "" ? $errorCount++ : $email;
$password == "" ? $errorCount++ : $password;

// Saving data to Session
$_SESSION['email'] = $email;

// checking error count and displaying appropriate message
if ($errorCount == 1) {
    //Give feedback to user
    $_SESSION["error"] = "You have " . $errorCount . " error in your form submission";
    header("Location: login.php");
}else if($errorCount > 1){
    $_SESSION["error"] = "You have " . $errorCount . " errors in your form submission";
    header("Location: login.php");
}
else {
    //Get and count all users
    $allUsers = scandir("db/users");
    $countAllUsers = count($allUsers);

    //check if the user already exists.
    for ($counter = 0; $counter < $countAllUsers; $counter++){
        $currentUser = $allUsers[$counter];
        if($currentUser == $email .".json"){
            // get user fro the database
            $userString = file_get_contents("db/users/" . $currentUser);
            // decode user
            $userObject = json_decode($userString);
            $passwordFromDb = $userObject->password;
            
            // compare database password with user-input password
            if (password_verify($password,$passwordFromDb)){
                
                // Saving more data to Session if user password is correct

                $_SESSION['loggedIn'] = $userObject->id;
                $_SESSION["fullname"] = $userObject->first_name . " " . $userObject->last_name;
                $_SESSION["role"] = $userObject->designation;
                $_SESSION["department"] = $userObject->department;
                $_SESSION["date-of-registration"] = $userObject->dateofregistration;
                $_SESSION["last-login-time"] = $userObject->lastlogintime;
                $_SESSION["last-login-date"] = $userObject->lastlogindate;
                //set time zone
                date_default_timezone_set("Africa/Lagos");
                // converting userobject to array in order to add more items
                $userObject = (array)$userObject;
                $userObject["lastlogintime"] = date("h:i:sa");
                $userObject["lastlogindate"] = date("Y.m.d");
                $userObject = (object)$userObject;

                // add user object to database
                file_put_contents( "db/users/" . $email . ".json", json_encode($userObject));
                
                // redirect user to patients dashboard if user is a patient
                if($userObject->designation == 'Patients'){
                    header("Location: patient.php");
                    die();
                // redirect user to Medical Team dashboard if user is part of the Medical Team
                }else if ($userObject->designation == 'Medical Team') {
                    header("Location: mt.php");
                    die();
                // redirect user to Super Admin Dashboard
                }else {
                    header("Location: dashboard.php");
                    die();
                }
               
            }
            
           
        }
         
    }

    $_SESSION["error"] = "Invalid Email or Password";
    header("Location: login.php");
    die();

}


?>