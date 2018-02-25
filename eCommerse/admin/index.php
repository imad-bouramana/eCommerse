<?php 
session_start();
$noNavbar = "";
$tittlepage = "login"; // tittle page
if(isset($_SESSION['username'])){
	    header('location: home.php'); // redirect to the home page
    }
    include 'initialize.php';
 // chek if user coming from http post request
    if($_SERVER['REQUEST_METHOD']== "POST"){

     $username = $_POST["user"];
     $password = $_POST["pass"];
     $sha1password = sha1($_POST["pass"]);
  	// chek ifuser exit in database
     $stmt = $db->prepare("SELECT userID, username, password FROM users WHERE username = ? AND password = ? AND groupID = 1  LIMIT 1");
     $stmt->execute(array($username, $sha1password));
     $row  =$stmt->fetch();
     $count = $stmt->rowcount();
   //if count > 0 mean the count containte the record of username
     if($count >	0){

         $_SESSION['username'] = $username;  //register session name
         $_SESSION['ID'] = $row['userID'];
         header('location: home.php');// redirect to the home page

         exit();      	

       }
     }

     ?>

     <form class="login" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
      <h3 class="text-center">Login Form</h3>
      <input class="form-control" type="test" name="user" placeholder="Username" autocomplete="false" />
      <input class="form-control" type="password" name="pass" placeholder="Password" autocomplete="false" />
      <input class="btn btn-primary btn-block" type="submit" value="login" />
    </form>



    <?php 
    include  $inctem . "footer.php";

    ?>