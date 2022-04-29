<?php
session_start();
require_once("Includes/connection.php");
$UserN = $_SESSION["username"];
$albumid = $_SESSION["album_id"];
if(!isset($_SESSION['username'])){
    header("Location: http://localhost/Project/index.php");
  
  }
  if(isset($_POST["doneuploading"])){
    header("Location: http://localhost/Project/mainpage.php");

  }
if (isset($_POST["SubmitAdd"])) {


    /*     $photocontent = $_FILES["photofile"]["tmp_name"];
 */
    $songcontent = $_FILES["songfile"]["tmp_name"];

    if (
        /* $_POST["albumname"] == '' || $_POST["artistname"] == ''
        ||  */
        $_POST["songname"] == '' /* || $_FILES["photofile"]["error"] == 4 */
        || $_FILES["songfile"]["error"] == 4
    ) {
        echo "<script>alert('Please upload all the files required!  and fill all the text boxes');</script>";
    } elseif (
        /* getimagesize($_FILES["photofile"]["tmp_name"]) == 0
        || preg_match('/(base64_|eval|system|shell_|exec|php_)/i',$photocontent)
 */
        preg_match('/(base64_|eval|system|shell_|exec|php_)/i', $songcontent)
    ) {
        echo "<script>alert('ERROR!');</script>";
    } else {
        $songname = $_POST["songname"];
        $songpath = "music_uploads/song.mp3";
        while (file_exists($songpath)) {
            $songpath = "music_uploads/" . "song" . rand(0, 9999) . ".mp3";
        }
        move_uploaded_file($_FILES["songfile"]["tmp_name"], $songpath);
        $cn;
        $query = "INSERT INTO songs_table(song_name, album_id, song_path)
                  values(?, ?, ?)";
        $stmt = $cn->prepare($query);

        $exec = $stmt->execute([$songname, $albumid, $songpath]);
        if ($exec) {
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
    <script type='text/javascript' src='http://code.jquery.com/jquery-2.0.2.js'></script>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
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
            <li><a href="#" class="nav-link px-2 link-dark">Albums</a></li>
        </ul>

        <div class="col-md-3 text-end">
            <button type="button" class="btn btn-outline-primary me-2">Logout</button>
        </div>
    </header>

    <section>
        <div class="container">
            <div class="" id="music-container" style="display: flex;">
                <div class="col-md-6">
                    <div class="p-3 card">
                        <div class="logo"> <img src="<?php echo $_SESSION["photo_path"] ?>" alt=""> </div>
                        <style>
                            .logo img {
                                height: 70px;
                                border-radius: 50%;
                                width: auto;
                                margin: 0 40% 10px;
                            }
                        </style>


                        
                        <?php
                        $cn;
                        $query2 = "SELECT * from songs_table where album_id = '$albumid'";
                        $stmt2 = $cn->query($query2);
                        $countquery = "SELECT count(*) from songs_table where album_id = '$albumid'";
                        $stmt3 = $cn->query($countquery);
                        $countsongs = $stmt3->fetchColumn();
                        $i = 0;
                        if ($DATAROWS = $stmt2->fetchAll()) {
                            for ($n = 0; $n < $countsongs; $n++) {
                                $i++;
                                echo "<div class='xxx'>
                            <div class='song-container'>
                                <div class='song-n'>" . "$i" . "</div>
                                <div class='song-name'>".$DATAROWS[$n][1]."</div>
                            </div>
                        </div>";
                            }
                        }

                        ?>



                        <style>
                            .xxx {
                                background-color: #eff5f5;
                                padding: 10px 10px 0;
                                border-radius: 10px;
                            }

                            .song-container {
                                display: flex;
                                justify-content: space-between;
                                height: 40px;
                                border-bottom: solid 1px #d1e0e0;
                            }

                            .delete-btn {
                                border: 0;
                            }
                        </style>


                            <form action="" method="post">
                        <button type="submit" name="doneuploading" class="btn btn-info btn-block playlist text-uppercase"><i class=""></i>Done
                        </button>
                        </form>
                    </div>
                </div>
                <div class="col-md-6">
                    <form action="songs_upload.php" method="POST" enctype="multipart/form-data">
                        <div class="p-3 card">

                            <label for="">Songs name: <input type="text" name="songname"></label>
                            <br>
                            <label for="">SongFile:
                                <input type="file" name="songfile" id="" accept="audio/*"></label>
                            <br>
                            <input type="submit" name="SubmitAdd" value="ADD" class="btn btn-info btn-block playlist text-uppercase">


                        </div>
                    </form>
                </div>


            </div>

        </div>



    </section>
</body>

</html>