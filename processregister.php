<?php
session_start();


//collecting the data

$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$password = $_POST['password'];
$gender = $_POST['gender'];
$designation  = $_POST['designation'];
$department = $_POST['department'];


// error count
$errorCount = 0;


//Verifying the data, validation
(!preg_match("/^[a-zA-Z]{2,}$/",$first_name)) ? $errorCount++ : null;
(!preg_match("/^[a-zA-Z]{2,}$/",$last_name)) ? $errorCount++ : null;
(!filter_var($email, FILTER_VALIDATE_EMAIL)) ? $errorCount++ : null;

$password == "" ? $errorCount++ : $password;
$gender == "" ? $errorCount++ : $gender;
$designation  == "" ? $errorCount++ : $designation;
$department == "" ? $errorCount++ : $department;

// Saving data to Session

$_SESSION['first_name'] = $first_name;
$_SESSION['last_name'] = $last_name;
$_SESSION['email'] = $email;
$_SESSION['gender'] = $gender;
$_SESSION['designation'] = $designation;
$_SESSION['department'] = $department;


// checking error count and displaying appropriate message
if ($errorCount == 1) {
    //Give feedback to user
    $_SESSION["error"] = "You have " . $errorCount . " error in your form submission";
    header("Location: register.php");
}else if($errorCount > 1){
    $_SESSION["error"] = "You have " . $errorCount . " errors in your form submission";
    header("Location: register.php");
}

else {
    // count all users
    $allUsers = scandir("db/users");
    $countAllUsers = count($allUsers);
    $newcountAllUsers = $countAllUsers - 1;
    // Asign ID to the user,
    $newUserId = $newcountAllUsers;
    // collecting date of registration
    $dateofregistration = date("Y.m.d"); 

    // creating user object
    $userObject =  [
        'id' => $newUserId,
        'first_name'=> $first_name,
        'last_name' => $last_name,
        'email' => $email,
        'password' => password_hash($password, PASSWORD_DEFAULT),
        'gender' => $gender,
        'designation' => $designation,
        'department' => $department,
        'dateofregistration' => $dateofregistration
    ];
    

    //check if the user already exists.
    for ($counter = 0; $counter < $countAllUsers; $counter++){
        $currentUser = $allUsers[$counter];
        if($currentUser == $email .".json"){
            $_SESSION["error"] = "Registration Failed, User already exists";
            header("Location: register.php");
            die();
        }
         
    }

    //save userobject to database
    file_put_contents( "db/users/" . $email . ".json", json_encode($userObject));
    if ($_SESSION['role'] == 'Super Admin'){
        $_SESSION["message"] = "Registration Successful, " . $first_name . " can now login";
        header("Location: dashboard.php");
    }else{
        $_SESSION["message"] = "Registration Successful, you can now login " . $first_name;
    header("Location: login.php");
    }
    
    
}

?>