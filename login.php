<?php 
   include_once("lib/header.php");
   //redirect to dashboard if the user is already logged in
   if (isset($_SESSION['loggedIn']) && !empty($_SESSION['loggedIn'])){
   //redirect to dashboard
   header("Location: dashboard.php");
}
?>
   
<p>
<?php
   //display success message if vallidation pass
   if(isset($_SESSION['message']) && !empty($_SESSION['message'])){
      echo "<span style='color:green'>" . $_SESSION['message'] . "</span";    
      // session_unset - Empty Session Object
      session_destroy();
   }
?>
<?php
   //display error message if vallidation fails
   if(isset($_SESSION['error']) && !empty($_SESSION['error'])){
      echo "<span style='color:red'>" . $_SESSION['error'] . "</span";    
      // session_unset - Empty Session Object
      session_destroy();
   }
?>
</p>

<h3>Login</h3>
<form action="processlogin.php" method="POST">
   <p>
      <label for="">Email</label>
         <input 
         value="<?php 
                   //display email if saved in session
                  if(isset($_SESSION['email'])){
                     echo(!empty($_SESSION['email']) ? $_SESSION['email'] : " ");
                  } 
            ?>"
         type="email" name="email" placeholder="Email" >
   </p>

   <p>
      <label for="">Password</label>
      <input type="password" name="password" placeholder="Password" required>
   </p>

   <p>
      <button type="submit">Login</button>
   </p>
   
   </form>
<?php include_once("lib/footer.php") ?>