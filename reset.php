<?php include_once("lib/header.php"); ?> 
<p> 
<?php
    // checks if user is authorized to view the reset page
    if(!isset($_SESSION['loggedIn']) && !isset($_GET['token']) && !isset($_SESSION['token'])){
        $_SESSION["error"] = "You are not authorized to view that page";
        header("Location: login.php");
    }
?>
</p>

<h3>Reset Password</h3>
<p>Reset Password associated with your account </p>

<form action="processreset.php" method="POST">
    <p> 
        <input type="hidden" name="token" 
        value="<?php
                    //display token if saved in GET object
                    if (isset($_GET['token'])){
                        echo $_GET['token'];
                    } 
                ?>">
    </p>
    <p>
        <label for="">Email</label>
        <input value="<?php
                        //display email if saved in session
                        if(isset($_SESSION['email'])){
                            echo $_SESSION['email'];
                        } 
                      ?>"
        type="email" name="email" placeholder="Email" >
    </p>
        
    <p>
        <label for="">Password</label>
        <input type="password" name="password" placeholder="Password" required>
    </p>

    <p>
        <button type="submit">Reset Password</button>
    </p>
    
   </form>
<?php include_once("lib/footer.php") ?>