<?php
session_start();//inorder to start the session

if (isset($_POST['submit'])){
    include 'dbh.inc.php';
    $uid = pg_escape_string($db,$_POST['uid']);
    $pwd = pg_escape_string($db,$_POST['pwd']);

    if (empty($uid)||empty($pwd)){
        header("Location: ../index.php?login=emptyUserIdOrPassword");
        exit();
    }
    else{
        $sql = "SELECT * FROM login.user WHERE user_uid='$uid'";
        $result = pg_query($db , $sql);
        $resultCheck = pg_num_rows($result);
        if ($resultCheck < 1){
            header("Location: ../index.php?login=noUser");
            exit();
        }
        else{
            if ($row = pg_fetch_assoc($result)){//Returns an associative array
                echo $row['user_uid'];//prints the corresponding value for the key
                //De hash the password to check for validity
                $hashPwdCheck = password_verify($pwd,$row['user_pwd']);
                if ($hashPwdCheck == false){
                    header("Location: ../index.php?login=InvalidPassword");
                    exit();
                }
                elseif($hashPwdCheck == true){
                    $_SESSION['u_id'] = $row['user_uid'];//Can access any page in the website
                    $_SESSION['u_first'] = $row['user_first'];
                    $_SESSION['u_last'] = $row['user_last'];
                    $_SESSION['u_pwd'] = $row['user_pwd'];
                    $_SESSION['u_email'] = $row['user_email'];
                    header("Location: ../index.php?login=success");
                    exit();
                }
            }
        }
    }
}
else{
    header("Location: ../index.php?login=error");
    exit();
}


?>
<html>
    <body>
        <header>
            <div class="main-wrapper">
            <p>
            <center><h2>Login Page</h2></center>
            </p>
            <form action="includes/logout.inc.php" method="POST">
                <button type="submit" name="submit">Logout</button>
            </form>
            </div>
        </header>
    </body>
</html>