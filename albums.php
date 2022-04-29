<?php
require_once('Includes/connection.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
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
    </ul>

    <div class="col-md-3 text-end">
    </div>
  </header>

  <section>
    <div class="container">
      <form action="" method="POST">
        <div class="input-group ml-5 mb-2">
          <div class="form-outline">
            <input type="search" name="searchInput" id="searchInput" class="form-control" placeholder="Search for album" />
          </div>
          <button type="submit" name="searchbtn" id="searchbtn" class="btn btn-info">
            <i class="bi bi-search"></i>
          </button>
        </div>
      </form>
      <div class="" id="music-container" style="display: flex;">
        <div class="col-md-6">
          <div class="p-3 card">

            <script>
              var searchbtn = document.getElementById('searchbtn');
              var searchInput = document.getElementById('searchInput');

              searchbtn.addEventListener('click', function(e) {
                e.preventDefault();
                window.location.replace('http://localhost/Project/albums.php?Search=' + searchInput.value);
              });
            </script>
            <?php
            if (isset($_GET['Search'])) {
              $SearchInput = $_GET['Search'];
              $cn;
              $query = "SELECT * from albums_table WHERE album_name LIKE '%$SearchInput%' ORDER BY album_id DESC";
              $stmt = $cn->query($query);
              $countquery = "SELECT count(*) from albums_table WHERE album_name LIKE '%$SearchInput%'";
              $stmt2 = $cn->query($countquery);
              $countAlbums = $stmt2->fetchColumn();
              if ($DATAROWS = $stmt->fetchAll()) {
                echo "Search result";
                for ($i = 0; $i < $countAlbums; $i++) {
                  $clickedalbumid = $DATAROWS[$i][0];
                  $albumname = $DATAROWS[$i][1];
                  $cover_path = $DATAROWS[$i][4];
                  $artist_name = $DATAROWS[$i][3];
                  echo "<button type='button' id='$clickedalbumid' class=' albumbtn btn btn-light albumbtn mb-2'>
            <div class='album'>
              <img src=" . "$cover_path" . " alt=''>
              <div class='album-name'>$albumname</div>
              <div class='album-name'>(by $artist_name)</div>

            </div>
            </button>
            


            ";

                  $clicked = false;
                  echo "<script>
    albumClick" . "$clickedalbumid = document.getElementById ('$clickedalbumid');

    
    albumClick" . "$clickedalbumid.addEventListener('click', (e) => {
      
    window.location.href = 'http://localhost/Project/albums.php?Search=$SearchInput&albumid=$clickedalbumid';
    });

    

    

  </script>";
                }
              } else {
                echo "Nothing found";
              }
            } else if (!isset($_GET['Search'])) {
              $cn;
              $query = "SELECT * from albums_table ORDER BY album_id DESC LIMIT 5";
              $stmt = $cn->query($query);
              $countquery = "SELECT count(*) from albums_table";
              $stmt2 = $cn->query($countquery);
              $countAlbums = $stmt2->fetchColumn();
              echo "5 Albums been recently added";
              if ($DATAROWS = $stmt->fetchAll()) {
                for ($i = 0; $i < 5; $i++) {
                  $clickedalbumid = $DATAROWS[$i][0];
                  $albumname = $DATAROWS[$i][1];
                  $cover_path = $DATAROWS[$i][4];
                  $artist_name = $DATAROWS[$i][3];
                  echo "<button type='button' id='$clickedalbumid' class=' albumbtn btn btn-light albumbtn mb-2'>
              <div class='album'>
                <img src=" . "$cover_path" . " alt=''>
                <div class='album-name'>$albumname</div>
                <div class='album-name'>(by $artist_name)</div>
  
              </div>
              </button>
              
  
  
              ";

                  $clicked = false;
                  echo "<script>
      albumClick" . "$clickedalbumid = document.getElementById ('$clickedalbumid');
  
      
      albumClick" . "$clickedalbumid.addEventListener('click', (e) => {
        
      window.location.href = 'http://localhost/Project/albums.php?albumid=$clickedalbumid';
      });
  
      
  
      
  
    </script>";
                }
              }
            }


            ?>
            <style>
              .album img {
                height: 70px;
                border-radius: 50%;
              }

              .album {
                display: flex;
                justify-content: space-between;
                height: 70px;
                height: 100%;
              }

              .album-name {
                padding-left: 10px;
                padding-top: 20px;
                text-overflow: ellipsis;
              }

              .albumbtn {
                display: block;
                float: left;
              }
            </style>



          </div>
        </div>
        <div class="col-md-6">
          <form action="album_upload.php" method="POST" enctype="multipart/form-data">
            <div class="p-3 card">
              <?php
              if (isset($_GET["albumid"])) {
                $albumid = $_GET["albumid"];
                $cn;
                $query2 = "SELECT * from songs_table where album_id = '$albumid'";
                $stmt2 = $cn->query($query2);
                $countquery = "SELECT count(*) from songs_table where album_id = '$albumid'";
                $stmt3 = $cn->query($countquery);
                $countsongs = $stmt3->fetchColumn();
                $i = 0;
                if ($DATAROWS = $stmt2->fetchAll()) {
                  echo "<script>
                              let playedtrack = 1;

                            const songsarray = [];
                            const idsarray = [];
                            </script>";


                  for ($n = 0; $n < $countsongs; $n++) {
                    $songpath = $DATAROWS[$n][3];
                    $songid = $DATAROWS[$n][0];

                    echo "<script>
              
                              
                                songsarray.push('$songpath');
                                idsarray.push('$songid');
                              
                          
                            </script>";
                    $i++;
                    echo "            
                                <div class='xxx'>
                              <form action='mainpage.php' method='post'>
                              <div class='song-container mb-4'>
                                  <div class='song-n'><button type='submit' name='$n' id='song" . "$songid' class='btn btn-info bi bi-play' style='font-size: 20px;'></button></div>
                                  <div class='song-name ml-4 mt-2'>" . $DATAROWS[$n][1] . "</div>
                              </div>
                              </form>
                              
              
                          </div>
                          <script>
                                var play" . $songid . " = document.getElementById('song" . "$songid');
                          play" . $songid . ".addEventListener('click', function (e) {
                            e.preventDefault();
                            audio.pause();
                            audio.setAttribute('src', '$songpath');
                            audio.load();
                            audio.play();
                            playbtn.className = 'btn bi bi-pause-circle-fill ml-2 mr-2';
                            var pt = this.id;
                            playedtrack = this.name;
                            playedtrack++;
                        });
                        </script>
                          ";
                  }
                }
              }



              ?>
              <style>
                .song-container {
                  display: flex;
                  height: 40px;
                  border-bottom: solid 1px grey;
                }
              </style>

            </div>
          </form>
        </div>

      </div>

    </div>



  </section>
  <footer class="fixed-bottom bg-info" style="height: 80px;">
    <div>
      <audio id="audio">
        <source src="">
      </audio>
    </div>
    <div class="row">
      <div class="col-3 align-items-center">
        <div class="media">
          <div class="media-body">
            <h5 class="mt-5 ml-5" id='songname' style="font-weight: bold;"></h5>
          </div>
        </div>
      </div>
      <div class="col-6 ">
        <div class="icons-container mt-2 mb-1 align-items-center d-flex justify-content-center">
          <button id="shuflebtn" type="submit" class="btn bi bi-shuffle ml-2 mr-2" style="font-size: 20px; padding-top: 0;"></button>
          <button id="prevbtn" type="submit" class="btn bi bi-skip-start-fill ml-2 mr-2" style="font-size: 20px; padding-top: 0;"></button>
          <button id="playbtn" type="submit" class="btn bi bi-play-circle-fill ml-2 mr-2" style="font-size: 20px; padding-top: 0;"></button>
          <button id="nextbtn" type="submit" class="btn bi bi-skip-end-fill ml-2 mr-2" style="font-size: 20px; padding-top: 0;"></button>
          <button id="repeatbtn" type="submit" class="btn bi bi-arrow-repeat ml-2 mr-2" style="font-size: 20px; padding-top: 0;"></button>
        </div>
        <?php


        ?>
        <div class="progress-containe d-flex align-items-center">
          <div class="mr-2" id="songcurrenttime">0.00</div>
          <div class="progress w-100">
            <input type="range" id="audioprogress" class="progress-bar bg-success w-100" value="0">
          </div>
          <div class="ml-2" id="audioduration"></div>

        </div>

      </div>
      <div class="col-3 d-inline-flex align-items-center">
        <i class="bi bi-volume-down-fill mt-3 " style="font-size: 25px;"></i>
        <div class="progress volume-progress ml-4 mt-5 ">
          <input type="range" id="volumRange" max="1" min="0" step="0.01" class="progress-bar w-100" value="0">
        </div>
      </div>
    </div>

    <style>
      body {
        padding: 10px;
        padding-bottom: 150px;
        /* Height of the footer */
      }

      footer {
        position: absolute;
        bottom: 0;
      }

      .progress {
        height: 3px;
      }

      .volume-progress {
        width: 100px;
      }
    </style>
  </footer>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      var volumRange = document.getElementById('volumRange');
      var songcurrenttime = document.getElementById('songcurrenttime');
      var audioduration = document.getElementById('audioduration');




      var audio = document.getElementById('audio');
      /* idsarray.forEach(songid => {
        alert(songid);
        document.getElementById(songid).addEventListener('click', function(e){
          e.preventDefault();
          alert("wayway");
        });
      }); */

      volumRange.addEventListener('change', function() {
        audio.volume = volumRange.value;
      });
      var repeatbtn = document.getElementById("repeatbtn");
      var shuflebtn = document.getElementById("shuflebtn");
      var playbtn = document.getElementById("playbtn");
      var prevbtn = document.getElementById("prevbtn");
      var nextbtn = document.getElementById("nextbtn");

      var isRepeatOn = false;
      var isShufeleOn = false;
      let count = 0;

      var audioprogress = document.getElementById('audioprogress');
      audioprogress.addEventListener('change', function() {
        audio.currentTime = Math.floor((audioprogress.value * audio.duration) / 100);
      });
      audio.onloadedmetadata = function() {
        let zero;
        if (Math.floor(Math.floor(audio.duration % 60) / 10) == 0) {
          zero = 0;
        } else {
          zero = '';
        }
        audioduration.innerHTML = Math.floor(audio.duration / 60) + "." + zero + Math.floor(audio.duration % 60);
        console.log(audio.duration);
      };
      audio.ontimeupdate = function() {

        let zero;
        if (Math.floor(Math.floor(audio.currentTime % 60) / 10) == 0) {
          zero = 0;
        } else {
          zero = '';
        }
        songcurrenttime.innerHTML = Math.floor(audio.currentTime / 60) + "." + zero + Math.floor(audio.currentTime % 60);

        audioprogress.value = (audio.currentTime * 100) / audio.duration;
      };
      const numberOfTracks = <?php echo $countsongs ?>;
      audio.onended = function(e) {
        if (playedtrack < numberOfTracks) {
          audio.pause();
          audio.src = songsarray[playedtrack++];
          audio.load();
          audio.play();
          playbtn.className = 'btn bi bi-pause-circle-fill ml-2 mr-2';
        } else if (playedtrack == numberOfTracks) {
          audio.pause();
          audio.src = songsarray[0];
          audio.load();
          audio.play();
          playbtn.className = 'btn bi bi-pause-circle-fill ml-2 mr-2';
          playedtrack = 1;
        }
      };
      shuflebtn.addEventListener('click', function(e) {
        if (!isShufeleOn) {
          repeatbtn.style.color = "black";
          shuflebtn.style.color = "white";
          isShufeleOn = true;
          isRepeatOn = false;
        } else {
          shuflebtn.style.color = "black";
          isShufeleOn = false;
        }

      });
      repeatbtn.addEventListener('click', function(e) {
        if (!isRepeatOn) {
          shuflebtn.style.color = "black";
          repeatbtn.style.color = "white";
          isRepeatOn = true;
          isShufeleOn = false;
        } else {
          repeatbtn.style.color = "black";
          isRepeatOn = false;
        }

      });

      playbtn.addEventListener('click', function(e) {
        if (audio.src == '') {
          audio.src = songsarray[0];
          playedtrack = 1;
        }


        if (count == 0) {
          audio.play();
          playbtn.className = 'btn bi bi-pause-circle-fill ml-2 mr-2';
          count = 1;
        } else {
          audio.pause();
          playbtn.className = 'btn bi bi-play-circle-fill ml-2 mr-2';
          count = 0;
        }

      });
      prevbtn.addEventListener('click', function(e) {
        if (playedtrack >= 1) {
          alert(playedtrack);
          playedtrack--;
          audio.pause();
          audio.src = songsarray[playedtrack];
          audio.load();
          audio.play();
          playbtn.className = 'btn bi bi-pause-circle-fill ml-2 mr-2';
          alert(playedtrack);
        } else {
          alert(playedtrack);
          audio.pause();
          playedtrack = numberOfTracks - 1;
          audio.src = songsarray[playedtrack];
          audio.load();
          audio.play();
          playbtn.className = 'btn bi bi-pause-circle-fill ml-2 mr-2';
          alert(playedtrack);

        }
      });
      nextbtn.addEventListener('click', function(e) {

        if (playedtrack < numberOfTracks) {
          alert(playedtrack);
          audio.pause();
          audio.src = songsarray[playedtrack];
          playedtrack++;
          audio.load();
          audio.play();
          playbtn.className = 'btn bi bi-pause-circle-fill ml-2 mr-2';
          alert(playedtrack);
        } else if (playedtrack == numberOfTracks) {
          alert(playedtrack);
          audio.pause();
          audio.src = songsarray[0];
          audio.load();
          audio.play();
          playbtn.className = 'btn bi bi-pause-circle-fill ml-2 mr-2';
          playedtrack = 1;
          alert(playedtrack);
        } else {
          playedtrack = numberOfTracks - 1;
        }
      });


    });
  </script>
</body>

</html>