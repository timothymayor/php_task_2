<?php  
    include_once("lib/header.php"); 
    //redirect to dashboard if the user is already logged in
    if (isset($_SESSION['loggedIn']) && !empty($_SESSION['loggedIn'])){
    header("Location: dashboard.php");
    }
?>

<h3>Register</h3>
    <p>Welcome, Please Register</p>
    <p>All Fields are required</p>

<form method="POST" action="processregister.php">
    <p>
    <?php
        //display error message if vallidation fails
        if(isset($_SESSION['error']) && !empty($_SESSION['error'])){
            echo "<span style='color:red'>" . $_SESSION['error'] . "</span";    
            // session_unset
            session_destroy();
        }
    ?>
    </p>

    <p>
        <label for="">First name</label>
        <input 
        value="<?php 
                    //display firstname if saved in session
                    if(isset($_SESSION['first_name'])){
                        echo(!empty($_SESSION['first_name']) ? $_SESSION['first_name'] : " ");
                    }
                ?>"
        type="text" name="first_name" placeholder="First Name" pattern="^[a-zA-Z]{2,}$" 
        title="Name should not have numbers, less than 2 or blank" required>
    </p>

    <p>
        <label for="">Last name</label>
        <input 
        value="<?php
                    //display last name if saved in session 
                    if(isset($_SESSION['last_name'])){
                        echo(!empty($_SESSION['last_name']) ? $_SESSION['last_name'] : " ");
                    } 
                ?>"
        type="text" name="last_name" placeholder="Last Name"  
        title="Name should not have numbers, less than 2 or blank" pattern="^[a-zA-Z]{2,}$" required>
        </p>

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

    <hr />

    <p>
        <label for="">Gender</label>
        <select name="gender" required>
            <option value="">Select One</option>
            <option
            <?php
                //display gender if saved in session 
                if(isset($_SESSION['gender']) && $_SESSION['gender'] == "Female"){
                    echo "selected";
                } 
            ?>
            >Female</option>

            <option
            <?php
                //display gender if saved in session 
                if(isset($_SESSION['gender']) && $_SESSION['gender'] == "Male"){
                    echo "selected";
                } 
            ?>
            >Male</option>
        </select>
    </p>

    <p>
        <label for="">Designation</label>
        <select name="designation" required>
            <option value="">Select One</option>
            <option
            <?php
                //display designation if saved in session 
                if(isset($_SESSION['designation']) && $_SESSION['designation'] == "Medical Team"){
                    echo "selected";
                } 
            ?>
            >Medical Team</option>
            <option
            <?php
                //display designation if saved in session 
                if(isset($_SESSION['designation']) && $_SESSION['designation'] == "Patients"){
                    echo "selected";
                } 
            ?>
            >Patients</option>
        </select>
    </p>

    <p>
        <label for="">Department</label>
        <input required
        <?php
            //display department if saved in session 
            if(isset($_SESSION['department'])){
                echo "value=" . $_SESSION['department'];
            } 
        ?>
        type="text" name="department" placeholder="Department" required />
    </p>

    <p>
        <button type="submit">Register</button>
    </p>
    </form>

<?php include_once("lib/footer.php") ?>