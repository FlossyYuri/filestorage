<?php
session_start();
$username = "admin";
$password = "admin";
?>

<!DOCTYPE html>
<html>
    <head>
        
        <title>PHP File Storage</title>
        <link rel="shortcut icon" href="https://dev.festivo.co/amd/favicon.ico" type="image/x-icon">
        <meta charset="utf-8">
        <meta http-equiv="Pragma" content="no-cache" />
        <meta http-equiv="Expires" content="0" />
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        
        <link rel="stylesheet" type="text/css" href="css/font-awesome.css">
        
        <script
          src="https://code.jquery.com/jquery-3.4.1.min.js"
          integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
          crossorigin="anonymous"></script>
        <link href="https://fonts.googleapis.com/css2?family=Dosis:wght@300&display=swap" rel="stylesheet">
        
        <style>
        
            <?php
            if(isset($_SESSION["username"]) && isset($_SESSION["password"])){
                ?>
                body{
                    background: url(adminbg.jpg) no-repeat fixed center; 
                    -webkit-background-size: cover;
                    -moz-background-size: cover;
                    -o-background-size: cover;
                    background-size: cover; 
                    color: white;
                }
                <?php
            }else{
                ?>
                body{
                    background: url(bg.jpg) no-repeat fixed center; 
                    -webkit-background-size: cover;
                    -moz-background-size: cover;
                    -o-background-size: cover;
                    background-size: cover;
                }
                <?php
            }
            ?>
            body{
                
                margin: 0;
                padding: 20px;
                font-family: 'Dosis', sans-serif;
            }
            
            input{
                padding: 20px;
                margin-bottom: 10px;
                border-radius: 5px;
            }
            
            label{
                display: block;
            }
            
            h1, h2, h3, h4, h5, p{
                margin: 0;
                margin-bottom: 15px;
            }
            
            .filethumb{
                display: inline-block; vertical-align: top; text-align: center;
                width: 96px;
                border: 2px solid white;
                border-radius: 10px;
                margin: 20px;
                padding: 10px;
                transition: border .5s;
                
            }
            
            .filethumb:hover{
                border: 2px solid lime;
            }
            
            a{
                color: inherit;
                text-decoration: none;
            }
            
            .alert{
                padding: 15px;
                background-color: black;
                border-radius: 5px;
                margin: 30px;
                color: white;
                font-weight: bold;
                position: fixed;
                left: 0;
                bottom: 0;
            }
        </style>
        
    </head>
    <body>

        <?php 
        if(isset($_POST["username"])){
            if($_POST["username"] == $username && $_POST["password"] == $password){
                $_SESSION["username"] = $username;
                $_SESSION["password"] = $password;
                ?>
                <p>Login success!</p>
                <?php
            }else{
                ?>
                <p>Login failed</p>
                <?php
            }
            ?>
            <script>
                setTimeout(function(){
                    window.history.back();
                }, 2000);
            </script>
            <?php
        }else{
            
            if(isset($_SESSION["username"]) && isset($_SESSION["password"])){
                
                ?>
                <h1>PHP File Storage</h1>
                <?php
                
                if(isset($_POST["submitfile"])){
                    $target_dir = "uploads/";
                    $target_file = $target_dir . basename($_FILES["newfile"]["name"]);
                    move_uploaded_file($_FILES["newfile"]["tmp_name"], $target_file);
                }
                
                if(isset($_GET["delete"])){
					if(file_exists("uploads/" . $_GET["delete"])){
						unlink("uploads/" . $_GET["delete"]);
						echo "<div class='alert'>File is deleted successfully.</div>";
					}
				}
                
                
                $dirpath = "uploads/*";
				$files = array();
				$files = glob($dirpath);
				usort($files, function($x, $y) {
					return filemtime($x) < filemtime($y);
				});
				
				foreach($files as $item){
					echo "<div class='filethumb'>";
					//echo "<div>" . $item . "</div>";
					echo "<a href='" .$item. "' target='_blank'><div><i class='fa fa-file' style='font-size: 40px;'></i></div>";
					echo "<div>" . str_replace("uploads/", "", $item) . "</div></a>";
					echo "<a href='?delete=" .str_replace("uploads/", "", $item). "'><div style='color: red; margin-top: 20px; font-size: 10px;'><i class='fa fa-trash'></i> Delete</div></a>";
					echo "</div>";
				}
				
				if(count($files) == 0){
    				?>
                    <p>You have no file here.</p>
                    <?php    
				}
                
                ?>
                <form method="post" enctype="multipart/form-data" style="margin-top: 75px;">
					<label><i class="fa fa-file"></i> Upload new file</label>
					<input class="fileinput" name="newfile" type="file">
					<input name = "submitfile" type="submit" value="Upload">
				</form>
				
				
				<script>
				    setTimeout(function(){
				        $(".alert").fadeOut();
				    }, 2500);
				</script>
                <?php
                
            }else{
                ?>
                <div align="left">
                    <h1>Please login to access</h1>
                    <form method="post">
                        <div>
                            <label>Username:</label>
                            <input type="text" name="username" placeholder="Email">
                        </div>
                        <div>
                            <label>Password:</label>
                            <input type="password" name="password" placeholder="Password">
                        </div>
                        <div>
                        <input type="submit" value="Login">
                        </div>
                    </form>
                </div>
                <?php
            }
            
            
        }
        ?>
                
        
                
    </body>
</html>