<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: admin.html');
    exit;
}

// Ensure session admin name is set
$adminName = '瑋語老師';
$_SESSION['admin'] = $adminName;
?>
<!DOCTYPE html>
<html lang="zh-TW">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>聊天室 - 管理員模式</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<!--Amplitude js-->
<script src="../jslib/amplitude.min.js"></script>
<style>
.selected-color { border:3px solid #555; transform:scale(1.2); }
.color-btn { width:20px; height:20px; border:none; cursor:pointer; margin-top:4px; }
.accordion {
  display: none;
}

#amplitude-player {
      margin: 10px auto 10px auto;
      border: 2px solid #ccc;
      padding: 10px;
      border-radius: 3px;
      background-color: #f9f9f9;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      max-width: 300px;

    }

    /* amplitude style*/
.btnamp {
  
  border: none;
  padding: 10px 14px;
  margin: 0 5px;
  border-radius: 20px;
  font-size: 18px;
  cursor: pointer;
  transition: transform 0.2s, background 0.3s;
}

.btnamp:hover {
  transform: scale(1.12);
  
}

.amplitude-play-pause {
  font-size: 22px;
}

/* Optional: style progress bar */
.amplitude-song-slider {
  height: 6px;
  appearance: none;
  background: #ddd;
  border-radius: 3px;
  outline: none;
}

.amplitude-song-slider::-webkit-slider-thumb {
  appearance: none;
  width: 14px;
  height: 14px;
  background: #713838ff;
  border-radius: 50%;
  cursor: pointer;
}

</style>
</head>
<body class="p-3">
<img src="https://www.cstudio-go.com/cover.png" style="width:100%; max-width: 800px; margin: 0 auto; display: block; height:auto;">

<h4 style="background-color:rgb(114, 42, 40); color: rgb(212, 206, 206) ;text-align: center; max-width: 800px; margin: 0 auto;">聊天室（管理員模式）</h4>

<div id="messages" style="border:1px solid #ccc; height:300px; overflow:auto; padding:5px; max-width: 800px; margin: 0 auto;"></div>

<div class="mt-2">
  <input type="text" id="msg" style="max-width: 800px; margin: 0 auto; display: block;" class="form-control form-control-sm" placeholder="輸入訊息">
  <div class="mt-1">
  <div style="margin: o auto; display: flex; justify-content: center; gap: 5px;">
  <button type="button" class="color-btn" onclick="setColor('#9e3c39', this)" style="background:#9e3c39;"></button>
  <button type="button" class="color-btn" onclick="setColor('#b08227', this)" style="background:#b08227;"></button>
  <button class="btn btn-primary btn-sm" onclick="sendMsg()">送出</button>
  <button onclick="appear()" class="btn btn-outline-primary btn-sm" id="buttonText">放點音樂</button>
  <div>
  <button onclick="window.location.href='logout.php'" class="btn btn-danger btn-sm" style="float:right; margin-left: 10px;">
  登出
</button>
</div>
</div>
</div>
</div>

        <!-- Amplitude JS-->
<div id="amplitude-player" class="accordion" style="text-align:center;">
  
  <span data-amplitude-song-info="name"></span><br>
  <button class="amplitude-prev btnamp">⏮️</button>
  <button class="amplitude-play-pause btnamp">▶️ / ⏸️</button>
  <button class="amplitude-next btnamp">⏭️</button>
  
  <input type="range" class="amplitude-song-slider" style="width:70%;"><br>
  <span class="amplitude-current-time"></span> /
  <span class="amplitude-duration-time"></span>
</div>

       <script>
       Amplitude.init({
    songs: [
        {
            "name": "方大同精選",
            "artist": "Artist Name",
            "album": "Album Name",
            "url": "https://app.koofr.net/content/links/8af01056-37a5-4f45-832e-e8ec2b1a326c/files/get/方大同精選.mp3?path=%2F",
            "cover_art_url": "/cover/art/url.jpg"
        },
        {
            "name": "relax爵士精選",
            "artist": "Artist Name",
            "album": "Album Name",
            "url": "https://app.koofr.net/content/links/f6dd9c43-6ada-4d2e-8b85-25e0fbf39c3a/files/get/relax%20jazz.mp3?path=%2F",
            "cover_art_url": "/cover/art/url.jpg"
        },
        {
            "name": "Ori will of the wisps",
            "artist": "Artist Name",
            "album": "Album Name",
            "url": "https://app.koofr.net/content/links/2e1cd13f-d2ab-47b8-8eaf-160ddf461833/files/get/ori%20w%20of%20the%20wisps.mp3?path=%2F",
            "cover_art_url": "/cover/art/url.jpg"
        },
        {
            "name": "陳綺貞合集",
            "artist": "Artist Name",
            "album": "Album Name",
            "url": "https://app.koofr.net/content/links/7a51530a-72f1-466a-b93d-24f8adaca5b7/files/get/陳綺貞合集.mp3?path=%2F",
            "cover_art_url": "/cover/art/url.jpg"
        },
        {
            "name": "Ghibli Jazz",
            "artist": "Artist Name",
            "album": "Album Name",
            "url": "https://app.koofr.net/content/links/3a330c69-d44a-421f-959b-9049a7807332/files/get/Ghibli%20Jazz.mp3?path=%2F",
            "cover_art_url": "/cover/art/url.jpg"
        },
        {
            "name": "Jay合集",
            "artist": "Artist Name",
            "album": "Album Name",
            "url": "https://app.koofr.net/content/links/f1ef790e-c852-4ee6-a1e7-d2106628a4b5/files/get/jay合集.mp3?path=%2F",
            "cover_art_url": "/cover/art/url.jpg"
        },
        {
            "name": "Les Miserable Ost",
            "artist": "Artist Name",
            "album": "Album Name",
            "url": "https://app.koofr.net/content/links/807ae71d-36db-42e3-a7fc-58eee3f2c9eb/files/get/les%20miserable.mp3?path=%2F",
            "cover_art_url": "/cover/art/url.jpg"
        },
        {
            "name": "Relax Piano",
            "artist": "Artist Name",
            "album": "Album Name",
            "url": "https://app.koofr.net/content/links/ffdf6099-1bcd-4414-ac86-bade7ba96d8f/files/get/relax%20piano.mp3?path=%2F",
            "cover_art_url": "/cover/art/url.jpg"
        }
    ]
});
</script>

<script>
let userColor = '#9e3c39'; // default
function setColor(color, btn){
    userColor = color;
    document.querySelectorAll('.color-btn').forEach(b => b.classList.remove('selected-color'));
    btn.classList.add('selected-color');
}

async function sendMsg(){
    const msg = document.getElementById('msg').value;
    if(!msg) return;

    const displayName = '瑋語老師';

    await fetch('chat_api.php', {
        method:'POST',
        headers:{'Content-Type':'application/x-www-form-urlencoded'},
        body:new URLSearchParams({ name: displayName, msg, color: userColor })
    });
    document.getElementById('msg').value='';
    loadMessages();
}

async function loadMessages(){
    const res = await fetch('chat_api.php');
    const data = await res.json();
    const box = document.getElementById('messages');
    box.innerHTML = data.map(m => {
        // Use message color if set, otherwise default to #9e3c39 for admin
        let color = m.color || (m.name==='瑋語老師' ? '#9e3c39' : 'black');
        let bold = (m.name==='瑋語老師') ? 'font-weight:bold;' : '';
        return `<div style="color:${color};${bold}">${m.name}: ${m.msg}</div>`;
    }).join('');
    const distanceFromBottom = box.scrollHeight - box.scrollTop - box.clientHeight;
    if (distanceFromBottom < 120) {
        box.scrollTop = box.scrollHeight;
    }
}

// load chat messages
setInterval(loadMessages, 2000);
loadMessages();
</script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
  function appear() {
    const $music = $('.accordion');
    const $button = $('#buttonText');
  
    if ($music.is(':visible')) {
      $music.slideUp(400);
      $button.text('放點音樂');
    } else {
      $music.slideDown(400);
      $button.slideDown(400);
      $button.text('收回');
    }
  }
  </script>

</body>
</html>
