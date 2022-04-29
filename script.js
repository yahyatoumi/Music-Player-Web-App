
document.addEventListener("DOMContentLoaded", function () {
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

    volumRange.addEventListener('change', function () {
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
    audioprogress.addEventListener('change', function () {
        audio.currentTime = Math.floor((audioprogress.value * audio.duration) / 100);
    });
    audio.onloadedmetadata = function () {
        let zero;
        if (Math.floor(Math.floor(audio.duration % 60) / 10) == 0) {
            zero = 0;
        } else {
            zero = '';
        }
        audioduration.innerHTML = Math.floor(audio.duration / 60) + "." + zero + Math.floor(audio.duration % 60);
        console.log(audio.duration);
    };
    audio.ontimeupdate = function () {

        let zero;
        if (Math.floor(Math.floor(audio.currentTime % 60) / 10) == 0) {
            zero = 0;
        } else {
            zero = '';
        }
        songcurrenttime.innerHTML = Math.floor(audio.currentTime / 60) + "." + zero + Math.floor(audio.currentTime % 60);

        audioprogress.value = (audio.currentTime * 100) / audio.duration;
    };
    audio.onended = function (e) {
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
    shuflebtn.addEventListener('click', function (e) {
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
    repeatbtn.addEventListener('click', function (e) {
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

    playbtn.addEventListener('click', function (e) {
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
    prevbtn.addEventListener('click', function (e) {
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
    nextbtn.addEventListener('click', function (e) {

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