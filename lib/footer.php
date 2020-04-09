
<p>
<a href="index.php">Home</a> |
    <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'Super Admin'){
        echo "<a href='dashboard.php'>Dashboard</a>" . " | " .  "<a href='adminregister.php'>Add Users</a>" . " | " . "<a href='logout.php'>Logout</a>" . " | " . "<a href='reset.php'>Reset Password</a>"; 
    }else if(isset($_SESSION['loggedIn']) && $_SESSION['role'] == 'Medical Team'){
        echo "<a href='mt.php'>Dashboard</a>" . " | " . "<a href='logout.php'>Logout</a>" . " | " . "<a href='reset.php'>Reset Password</a>";
    }else if(isset($_SESSION['loggedIn']) && $_SESSION['role'] == 'Patients'){
        echo "<a href='patient.php'>Dashboard</a>" . " | " . "<a href='logout.php'>Logout</a>" . " | " . "<a href='reset.php'>Reset Password</a>";
    }else{
        echo "<a href='login.php'>Login</a>" . " | " . "<a href='register.php'>Register</a>" . " | ".  "<a href='forgot.php'>Forgot Password</a>";
    }?>
   </p>
</body>

</html>

