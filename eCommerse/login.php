<?php  
     ob_start();
     session_start();
   $tittlepage = "login"; // tittle page
   if(isset($_SESSION['user'])){
   	 header('location: index.php'); // redirect to the home page
     }

    include 'initialize.php'; 

     if($_SERVER['REQUEST_METHOD']== "POST"){

        if(isset($_POST['login'])){

    	$user         = $_POST["name"];
    	$password     = $_POST["password"];
      $sha1password = sha1($_POST["password"]);
      	// chek ifuser exit in database
        $stmt = $db->prepare("select userID, username, password FROM users WHERE username = ? AND password = ?");
        $stmt->execute(array($user, $sha1password));
        $get = $stmt->fetch();
        $count = $stmt->rowcount();
           //if count > 0 mean the count containte the record of username
          if($count >	0){

             $_SESSION['user'] = $user;  //register session name
             $_SESSION['getuser'] = $get['userID'];  //register session userID
        
             header('location: index.php');// redirect to the home page
   
             exit();      	
          }
        }else{
           $formerror = array();

           $username  = $_POST["name"];
           $password  = $_POST["password"];
           $password2 = $_POST['password2'];
           $email     = $_POST['email'];
             // chek if username exist
           if(isset($username)){
               // filter username 
               $filteruser = filter_var($username, FILTER_SANITIZE_STRING);

                if(strlen($filteruser) < 4){
                   $formerror[]  = 'the username cant be less than 4 string';
                }
                if(strlen($filteruser)  > 14){
                   $formerror[]  = 'the username cant be more than 14 string';
                }
                  // chek if password exist
                if(isset($password) && isset($password2)){
                   if(empty($password)){
                    $formerror[] = 'password cant be empty';
                   }
                   if(sha1($password) !==  sha1($password2)){
                       $formerror[] = 'The Password Not Match';
                  }
                }
                   // chek if email exist
                if(isset($email)){
                          // filter email
                     $filteremail = filter_var($email, FILTER_SANITIZE_EMAIL);
                          // validate email 
                     if(filter_var($filteremail, FILTER_VALIDATE_EMAIL) != true){
                     
                          $formerror[] = 'email not match';
                     }
                 }          
           // empty error
            if(empty($formerror)){
                // chek if username exist
                $chek = chekitem('username', 'users', $username);
                if($chek == 1){
                   $formerror[] = 'sorry this user exist';
        
                }else{

                  $stmt = $db->prepare('INSERT INTO users 
                                (username, password, email, RegStatus, time) 
                                    VALUES(:user, :pass, :email, 0, now())');
                  $stmt->execute(array(
                       'user' => $username,
                       'pass' => sha1($password),
                      'email' => $email,));

                     $msgsucces = 'User Inser';
        
                 }
               }
               //empty error 
          }
        }
    }

?>
 <div class="container may-form">
 	<h1 class="text-center"><span data-class="login" class="select">login</span> | 
 		             <span data-class="SignUp">SignUp</span></h1>
 	
 	<form class="login" action="<?php $_SERVER['PHP_SELF']?>" method="POST">
 	 <div class="form-control">
 	  	<input type="text" 
 		       name="name" 
 		       class="form-control"
 		       autocomplete="off"
 		       required
 		       placeholder="Enter Your Name"/>
 	 </div>
   <div class="form-contro">
 		<input type="password" 
 		       name="password" 
 		       class="form-control" 
 		       required
           autocomplete="new-password"
 		       placeholder="Enter Your Password"/>
 	 </div>
 	    <input type="submit" class="btn btn-primary btn-block" name="login" value="Enter" />
 	</form>
 	<form class="SignUp"  action="<?php $_SERVER['PHP_SELF']?>" method="POST">
 	 <div class="form-contro">
 		<input type="text" 
 		       name="name" 
           pattern='.{4,}'
           title='Name Must Be More 4 Chars'
 		       class="form-control"
           autocomplete="off"
 		       placeholder="Enter Your Name"
           required/>
     </div>
     <div class="form-contro">
	    <input type="password" 
 		       name="password" 
           minlength= '4'
 		       class="form-control"
 		        autocomplete="new-password"
 		       placeholder="Enter Your Password"
           required/>
 	 </div>
 	 <div class="form-contro">
 		<input type="password2" 
 		       name="password2" 
           minlength= '4'
 		       class="form-control"
 		       autocomplete="new-password"
 		       placeholder="Enter Your Password Again"
           required/>
 	 </div>
 	 <div class="form-contro">
 		<input type="Email" 
 		       name="email" 
 		       class="form-control"
 		       placeholder="Enter A Valid Email"
           required/>
 	 </div>
 	    <input type="submit" class="btn btn-success btn-block" name="logout" value="SignUp" />
 	
 	</form>
    <div class="text-center">
      <?php 
        if(! empty($formerror)){
          foreach ($formerror as $error) {
            echo '<div class="dv-error">'. $error . '</div>';
          }
        }
        if(isset($msgsucces)){
          echo '<div class="dv-succes"><i class="fa fa-check pull-right"></i>'. $msgsucces . '</div>';
        
        }

       ?>
    </div>
</div>
          
<?php   include  $inctem . "footer.php";
  ob_end_flush();
  ?>






