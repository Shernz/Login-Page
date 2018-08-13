<?php
    include "header.php";
    //session_start();
?>
    <section class="main-container">
        <div class="main-wrapper">
            <h2>Home</h2>
            <?php
                if (isset($_SESSION['uid'])){//Basically used to change any content on any pg when the user is logged in
                   echo "You are logged in";//The user name can be echoed using the session variable within echo
               }
            ?>
        </div>
    </section>
<?php
    include "footer.php";
?>