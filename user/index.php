<?php include $_SERVER['DOCUMENT_ROOT'] . "/scripts/base.php";?>
<?php include $_SERVER['DOCUMENT_ROOT'] . "/scripts/get_user_info.php";?>

<?php
if (isset($_GET['username'])) {
    $username = $_GET['username'];
}
elseif (!empty($_SESSION['LoggedIn']))
{
    $username = $_SESSION['username'];
    $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $http_query = http_build_query(array('username'=>$username));
    ?>
    <meta http-equiv='refresh' content='0;<?php echo $_SERVER['PHP_SELF']; ?>?<?php echo $http_query; ?>' />
<?php
}
else{
    header("HTTP/1.0 404 Not Found");
    die();
}
    $user = get_user_info($conn,$username);
?>

<!DOCTYPE html>
<html>
<head>
    <link href="/css/BuildIT_User_Profile_style.css" type="text/css" rel="stylesheet">
    <link href="/css/navbar.css" type="text/css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<title>Profile</title>
<body>

<?php include $_SERVER['DOCUMENT_ROOT'] . "/common/navbar.php";?>

<!-- PARENT CONTAINING LEFT AND RIGHT PROFILE DIVS SO THEY TAKE UP THE WHOLE PAGE EQUALLY -->
<div class="parent">
    <!-- LEFT PROFILE -->
    <div class="profileLeft">
        <!-- Profile Picture -->
        <img src="/img/users/default.jpg" alt="profile_pic">>

        <div class="userFollow">
            <a href="#"><i class="fa fa-group"></i> Follow <?=$user['firstname']?></a>
        </div>
        <div class="userMessage">
            <a href="#"><i class="fa fa-envelope-o"></i> Message <?=$user['firstname']?></a>
        </div>
    </div>
    <!-- RIGHT PROFILE -->
    <div class="profileRight">
        <div class="Name_Bio">
            <h1><?=$user['firstname']?> <?=$user['lastname']?></h1>
            <?php
            if (!empty($user['city']) && !empty($user['state'])) {
                ?>
                <div class="userLocation">
                    <p><i class="fa fa-map-marker"></i> <?=$user['city']?>, <?=$user['state']?></p>
                    <br></br>
                </div>
                <?php
            }
            ?>
            <?php

            if (!empty($_SESSION['LoggedIn']) && $user['userid'] === $_SESSION['userid']){
                if (empty($user['bio'])){
                    echo "<p contenteditable='true' id='bio'>Edit your bio!</p>";
                }
                else {
                    echo "<p contenteditable='true' id='bio'>" . $user['bio'] . "</p>";
                }
                echo "<br>";
                echo "<button type='button' id='bio-submit' style='visibility: hidden'>Save Bio Changes</Button>";
            }
            else
            {
                echo "<p> " . $user['bio'] . "</p>";
                echo "<br>";
            }
            ?>
        </div>

        <!-- PARENT CONTAINING USER DESIGNS AND PROJECTS DIV SO THEY ARE ON THE SAME LINE -->
        <div class="parent2">

            <div class="userDesigns">
                <h2 class="header2">Designs</h2>
                <?php
                    $sql_query = 'SELECT * from contracts where userid = '.$user['userid'].';';
                    $raw_results = mysqli_query($conn, $sql_query) or die("error");
                    if (mysqli_num_rows($raw_results) == 0){
                        echo" Error finding contracts";
                    }
                    else {
                        while($results = mysqli_fetch_array($raw_results)){
                            echo "<p>" . $results['description'] . "</p>";
//                            $i++;
                        }
                    }

                ?>
            </div>

            <div class="userProjects">
                <h2 class="header2">Projects</h2>
                <?php
                    $querystring = "SELECT * FROM designs
                    WHERE userid=".$user['userid'].";";
                    $raw_results = mysqli_query($conn, $querystring) or die(mysqli_error());
                    if(mysqli_num_rows($raw_results) > 0){ // if one or more rows are returned do following
                        while($results = mysqli_fetch_array($raw_results)){
                            // $results = mysql_fetch_array($raw_results) puts data from database into array, while it's valid it does the loop
                            echo "<a href='/design-page/index.php?design_id=".$results['design_id'] ."'>".
                                    "<div class='result'>".
                                        "<p class='name'>".$results['project_name']."</p>".
                                    "</div>".
                                 "</a>";
                        }
                    }
                    else{ // if there is no matching rows do following
                        echo "No results";
                    }
                ?>

            </div>

        </div>
        <div class="userForums">
            <h2>Forums</h2>
            <?php
            $sql_query = "SELECT * FROM  forum_posts WHERE post_by = " . $user['userid'] . ";";
            $raw_results = mysqli_query($conn, $sql_query);
            if(mysqli_num_rows($raw_results) > 0){ // if one or more rows are returned do following
                while($results = mysqli_fetch_array($raw_results)){
                    // $results = mysql_fetch_array($raw_results) puts data from database into array, while it's valid it does the loop
                    echo "<p>" . $results['post_content'] . "</p>";
                }
            }
            else{
                echo "No Results.";
            }
            ?>
        </div>
    </div>
</div>
<?php include $_SERVER['DOCUMENT_ROOT']."/common/footer.php";?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="/js/update_bio.js"></script>

</body>

</html>