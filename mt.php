<?php include_once("lib/header.php"); 
if (!isset($_SESSION['loggedIn'])){
    //redirect to login page
    header("Location: login.php");
}

?>

<h3>Medical Team Dashboard</h3>
    <p>LoggedIn User ID: <?php echo $_SESSION["loggedIn"] ?></p>
    <p>Welcome <?php echo $_SESSION['fullname'] ?></p>
    <p>Role : <?php echo $_SESSION["role"] ?></p>
    <p>Department : <?php echo $_SESSION["department"] ?></p>
    <p>Date of Registration : <?php echo $_SESSION["date-of-registration"] ?></p>
    <p> <?php echo isset($_SESSION["last-login-date"]) ? "Last login Date : " . $_SESSION["last-login-date"] . " | " . $_SESSION["last-login-time"] : " "; ?></p>
    
    



<?php include_once("lib/footer.php") ?>