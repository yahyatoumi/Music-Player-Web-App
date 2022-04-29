<?php
session_start();
require_once("Includes/connection.php");
if(!isset($_SESSION['username'])){
    header("Location: http://localhost/Project/index.php");
  
  }
if (isset($_POST["SubmitAdd"])) {
    $photocontent = $_FILES["photofile"]["tmp_name"];
    /*     $songcontent = $_FILES["songfile"]["tmp_name"];
 */
    if (
        $_POST["albumname"] == '' || $_POST["artistname"] == ''
        || /* $_POST["songname"] == '' || */ $_FILES["photofile"]["error"] == 4
        /* || $_FILES["songfile"]["error"]==4 */
    ) {
        echo "<script>alert('Please upload all the files required!  and fill all the text boxes');</script>";
    } elseif (
        getimagesize($_FILES["photofile"]["tmp_name"]) == 0
        || preg_match('/(base64_|eval|system|shell_|exec|php_)/i', $photocontent)
        /* || preg_match('/(base64_|eval|system|shell_|exec|php_)/i',$songcontent )*/
    ) {
        echo "<script>alert('ERROR!');</script>";
    } else {
        $albumaname = $_POST["albumname"];
        $UserN = $_SESSION["username"];
        $artistName = $_POST["artistname"];
        $photoPath = "albums_covers/cover.jpg";
        while (file_exists($photoPath)) {
            $photoPath = "albums_covers/" . "cover" . rand(0, 9999)."cover.jpg";
        }

        move_uploaded_file($_FILES["photofile"]["tmp_name"], $photoPath);
        $cn;
        $query = "INSERT INTO albums_table(album_name, add_by_username, artist_name, photo_path)
                  values(?, ?, ?, ?)";
        $stmt = $cn->prepare($query);

        $exec = $stmt->execute([$albumaname, $UserN, $artistName, $photoPath]);
        if ($exec) {
            $query2 = "SELECT LAST_INSERT_ID()";
            $stmt2 = $cn->query($query2);

            $_SESSION["album_id"] = $stmt2->fetchColumn();
            $_SESSION["photo_path"] = $photoPath;

            header("Location: http://localhost/Project/songs_upload.php");
        } else {
            echo "somthing wrong";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.css">
    <title>Document</title>
</head>

<body>
    <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
        <a href="/" class="d-flex align-items-center col-md-3 mb-2 mb-md-0 text-dark text-decoration-none">
            <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap">
                <use xlink:href="#bootstrap"></use>
            </svg>
        </a>

        <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
            <li><a href="mainpage.php" class="nav-link px-2 link-secondary">Home</a></li>
        </ul>

        <div class="col-md-3 text-end">
            <form action="mainpage.php" method="post">
            <button type="submit" name="logout" class="btn btn-outline-primary me-2">Logout</button>
            </form>
        </div>
    </header>

    <section>
        <div class="container">
            <div class="" id="music-container" style="display: flex;">
                <div class="col-md-6">
                    <div class="p-3 card">
                        <div class="logo"> <img src="<?php echo $photoPath ?>" alt=""> </div>


                        <div class="d-flex justify-content-between align-items-center p-3 music">

                        </div>


                        
                    </div>
                </div>
                <div class="col-md-6">
                    <form action="album_upload.php" method="POST" enctype="multipart/form-data">
                        <div class="p-3 card">
                            <label for="">Album name:
                                <input type="text" name="albumname"> </label>
                            <br>
                            <label for="">Album cover photo:
                                <input type="file" name="photofile" id="" accept="image/png, image/jpeg"></label>
                            <br>
                            <label for="">Artist name:
                                <input type="text" name="artistname"> </label>
                            <br>
                            <!-- 
                            <label for="">Songs name: <input type="text" name="songname"></label>
                            <br>
                            <label for="">SongFile:
                                <input type="file" name="songfile" id="" accept="audio/*"></label>
                            <br> -->
                            <input type="submit" name="SubmitAdd" value="ADD" class="btn btn-info btn-block playlist text-uppercase">


                        </div>
                    </form>
                    <!--<script>alert("erreeeer");</script>-->
                </div>

            </div>

        </div>



    </section>
</body>

</html>