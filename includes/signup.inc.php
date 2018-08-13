<?php
echo "Sign up page";
if (isset($_POST['submit'])){
    include_once "dbh.inc.php";
    $first = pg_escape_string($db, $_POST['first']);
    $last = pg_escape_string($db, $_POST['last']);
    $email = pg_escape_string($db, $_POST['email']);
    $uid = pg_escape_string($db, $_POST['uid']);
    $pwd = pg_escape_string($db, $_POST['pwd']);
    /*Error handlers are included for letting the user know
     that he can't sign up without the feild being filled
     Likewise the errors are checked first and then the else block is executed*/

    if (empty($first)||empty($email)||empty($last)||empty($pwd)||empty($uid)){
        header("Location: ..\signup.php?signup=empty");//The signup up page is loaded again
        exit();
    }
    else{
        if (!preg_match('/^[a-zA-Z]*$/',$first)||!preg_match('/^[a-zA-Z]*$/',$last)){
            header("Location: ..\signup.php?signup=invalid");/*The signup up page is loaded again 
                                                        as the signup was not valid:if any characters is involved*/ 
            exit();
        }
        else{
            if (!filter_var($email,FILTER_VALIDATE_EMAIL)){
                header("Location: ..\signup.php?signup=email");//The signup up page is loaded again
                exit();                                         //as the email is not valid
            }
            else{
                //connect to the db and check whether the uid is unique i.e not duplicated
                $sql = "SELECT * FROM login.users WHERE user_uid='$uid'";
                $result = pg_query($db,$sql);
                $resultCheck = pg_num_rows($result);//Should return 0 as new user signup
                //Check the condition for row existence
                if ($resultCheck > 0){
                    header("Location: ..\signup.php?signup=userTaken");//The signup up page is loaded again
                    exit();
                }
                else{
                    //Hash the password to make it confidential
                    $hashPwd = password_hash($pwd,PASSWORD_DEFAULT);
                    //Finally insert the user inside the db...Insertion because it is signup
                    $sql = "INSERT INTO login.users VALUES('$first','$last','$email','$uid','$hashPwd')";
                    pg_query($db,$sql);
                    header("Location: ..\signup.php?signup=success");//Signup success + page
                    exit();
                }
            }
        }

    }
}
else{
    header("Location: ..\signup.php");
    exit();//stops any progress of the current script
}
?>