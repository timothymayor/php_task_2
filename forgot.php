<?php include_once("lib/header.php") ?>
<p> 
<?php
   if(isset($_SESSION['error']) && !empty($_SESSION['error'])){
         echo "<span style='color:red'>" . $_SESSION['error'] . "</span";    
         
         // session_unset
         session_destroy();
   }
      ?></p>
   <h3>Forgot Password</h3>
   <p>Provide the email address associated with your account</p>

   <form action="processforgot.php" method="POST">
   <p>
      <label for="">Email</label>
      <input value="
      <?php if(isset($_SESSION['email'])){
            echo(!empty($_SESSION['email']) ? $_SESSION['email'] : " ");
      } ?>"
      type="email" name="email" placeholder="Email" >
        </p>

        <p>
            <button type="submit">Send Reset Code</button>
        </p>
   </form>
<?php include_once("lib/footer.php") ?>