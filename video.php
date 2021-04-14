<?php
//$ht = "13.125.227.50";
$ht = "localhost";
$un = "ubuntu";
$pw = "bell5works";
$db = "testdb";
$pt = "3306";

$connect = mysqli_connect($ht, $un, $pw, $db, $pt) or die("실패2");

mysqli_select_db($connect, $db) or die("실패");

$sql = "SELECT * FROM save_progress ORDER BY created_at LIMIT 1";
$result = $connect->query($sql);
$res = $result->fetch_assoc();

?>
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="https://kit.fontawesome.com/9bf1b593b9.js" crossorigin="anonymous"></script>

<link rel="stylesheet" href="css/style.css">

<div id='player' class="test">
    <video id='video-element'>
        <source src='https://www.w3schools.com/html/mov_bbb.mp4' type='video/mp4'>
    </video>
    <div id='controls'>
        <progress id="progress-bar" value="0"></progress>
        <button id="btnReplay" class="video-btn"><i class="fas fa-undo"></i></button>
        <button id="btnPlayPause" class="video-btn">
            <i class="fas fa-play"></i>
            <i class="fas fa-pause disabled"></i>
        </button>
        <span id="volume" class="video-btn">
            <span id="btnMute" class="volume_wrap">
                <i class="fas fa-volume-up"></i>
                <i class="fas fa-volume-mute disabled"></i>
            </span>
            <input type="range" id="volume-bar" title="volume" value="50" step="5">
        </span>
        <button id="btnFullScreen" class="fullscreen video-btn"><i class="fas fa-expand"></i></button>
    </div>
    <div id="save_btn">
        진행률 저장
    </div>
</div>

<script>
    // Get a handle to the player
    let player       = document.getElementById('video-element');
    let player_wrap_jq = $("#player");
    let player_wrap = document.getElementById("player");
    let btnPlayPause = document.getElementById('btnPlayPause');
    let btnReplay      = document.getElementById('btnReplay');
    let btnMute      = document.getElementById('btnMute');
    let progressBar  = document.getElementById('progress-bar');
    let volumeBar    = document.getElementById('volume-bar');
    let btnFullScreen = document.getElementById('btnFullScreen');
    let save_btn = document.getElementById('save_btn');
    let isPlayerFullScreen = false;

    // document.addEventListener("fullscreenchange", function(){exitFullscreen("change")});
    btnFullScreen.addEventListener("click", toggleFullScreen);
    btnPlayPause.addEventListener("click", playPauseVideo);
    btnReplay.addEventListener("click", replayVideo);
    btnMute.addEventListener("click", muteVolume);
    save_btn.addEventListener("click", function(){setTimeToDB(getCurrentTime(), "clicksavebtn")});
    volumeBar.addEventListener("change", function(evt) {
        console.log(evt.target.value);
        player.volume = evt.target.value/100;
        console.log(player.volume);
        console.log(player.muted);
    });

    player.addEventListener('timeupdate', updateProgressBar, false);
    player.addEventListener('ended', function() { this.pause(); }, false);
    player.addEventListener("ontimeupdate", checkChangeCurrentTime);
    window.addEventListener("beforeunload", function(e){
        setTimeToDB(getCurrentTime(), "beforeEscape");
    });

    function checkChangeCurrentTime() {
        let currentTime = getCurrentTime();
        setTimeToDB(currentTime, "ontimeupdate");
    }

    function setTimeToDB(currentTime, type){
        $.ajax({
            url: "setTime_ajax.php",
            type: 'get',
            data: {time: currentTime, type: type},
            dataType: 'json',
        });
    }

    function getTimeToDB() {
        $.ajax({
            url: "getTime_ajax.php",
            type: 'get',
            dataType: "json",
            success: function (res) {
                player.currentTime = res;
            },
            error: function (err) {
                console.log(err);
            },
        });
    }

    function getCurrentTime() {
        return Math.floor(player.currentTime * 100) / 100;
    }

    progressBar.addEventListener("click", seek);

    function seek(e) {
        let percent = e.offsetX / this.offsetWidth;
        player.currentTime = percent * player.duration;
        e.target.value = percent;
        setTimeToDB(getCurrentTime(), "seektimeupdate")
    }

    function playPauseVideo() {
        let bp = $(btnPlayPause);
        if (player.paused || player.ended) {
            bp.find("i.fa-play").addClass("disabled");
            bp.find("i.fa-pause").removeClass("disabled");
            player.play();
        } else {
            bp.find("i.fa-play").removeClass("disabled");
            bp.find("i.fa-pause").addClass("disabled");
            player.pause();
        }
    }

    function stopVideo() {
        player.pause();
        if (player.currentTime) player.currentTime = 0;
    }

    let prevVolume = 0;
    function muteVolume() {
        let bm = $(btnMute);
        let v = $("#volume");
        if (player.muted) {
            player.muted = false;
            v.find("input").val(prevVolume);
            bm.find("i.fa-volume-mute").addClass("disabled");
            bm.find("i.fa-volume-up").removeClass("disabled");
        } else {
            player.muted = true;
            prevVolume = v.find("input").val();
            v.find("input").val(0)
            bm.find("i.fa-volume-mute").removeClass("disabled");
            bm.find("i.fa-volume-up").addClass("disabled");
        }
    }

    function replayVideo() {
        resetPlayer();
        player.play();
        playPauseVideo();
    }

    function updateProgressBar() {
        let percentage = Math.floor((1 / player.duration) * player.currentTime * 100) / 100;
        progressBar.value = percentage;
    }

    function resetPlayer() {
        progressBar.value = 0;
        player.currentTime = 0;
    }

    function toggleFullScreen() {
        player_wrap_jq.toggleClass("fullscreen");
        if(isPlayerFullScreen){
            exitFullscreen()
        }else{
            openFullscreen(player_wrap);
        }

        isPlayerFullScreen = !isPlayerFullScreen;
    }

    function openFullscreen(elem) {
        if(!isPlayerFullScreen){
            if (elem.requestFullscreen) {
                elem.requestFullscreen();
            } else if (elem.webkitRequestFullscreen) { /* Safari */
                elem.webkitRequestFullscreen();
            } else if (elem.msRequestFullscreen) { /* IE11 */
                elem.msRequestFullscreen();
            }
        }
    }

    function exitFullscreen(type) {
        if(isPlayerFullScreen){
            if (document.exitFullscreen) {
                document.exitFullscreen();
            } else if (document.msExitFullscreen) {
                document.msExitFullscreen();
            } else if (document.mozCancelFullScreen) {
                document.mozCancelFullScreen();
            } else if (document.webkitExitFullscreen) {
                document.webkitExitFullscreen();
            }
        }
    }

    //실행코드3
    getTimeToDB();
</script>
