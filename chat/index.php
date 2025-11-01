<?php
session_start();
$isAdmin = isset($_SESSION['admin']);
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
   <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-TSC3GPD1M0"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-TSC3GPD1M0');
</script>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Chat Room - 瑋語老師的教室</title>
  <link href="../bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
      <!--bootstrap icon css-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<!--Amplitude js-->
<script src="../jslib/amplitude.min.js"></script>
  <style>
    .selected-color { border:3px solid #555; transform:scale(1.2); }
    .color-btn { width:20px; height:20px; border:none; cursor:pointer; margin-top:4px; }

    .accordion{
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
<body>

<h6 style="text-align:center; margin-top:5vw;">
  管理者：瑋語老師 ｜<span style="font-size:smaller;">此名稱登入後才能使用</span>
</h6>

<div id="chat" style="max-width:800px;margin:0 auto 9px auto;border: 1.5px brown solid; box-shadow: 30px 30px 80px rgba(44, 21, 21, 0.7);;padding:10px;">
  <div style="display:flex;justify-content:space-between;">
    <div style="margin-bottom:10px;">
      <?php if (!$isAdmin): ?>
        <a href="admin.html" class="btn btn-warning">管理者登入</a>
      <?php else: ?>
        <span class="text-success">已登入管理員</span>
        <a href="logout.php" class="btn btn-danger btn-sm">登出</a>
      <?php endif; ?>
      <span id="loginStatus" style="margin-left:10px;font-weight:bold;">
        <?php echo $isAdmin ? "管理者目前在線" : "管理者目前不在喔"; ?>
      </span>
    </div>
    <i class="fa-solid fa-dog fa-bounce" style="margin-top:6px;margin-right:10px;color:#d6d6d6"
       data-bs-toggle="tooltip" data-bs-placement="top" title="你也喜歡動物嗎?"></i>
  </div>

  <div class="alert alert-danger" style="border:1px solid #ccc; padding:0 5px; margin:0 auto 2px auto; font-weight:400;">
    <div style="display: flex; justify-content: space-between;">
      <div>
    <span>當前在線人數：</span><span id="visitorCount">0</span><br>
    *禁止攻擊與不當言論
  </div>
  <div>
  <button class="btn btn-danger  btn-sm" id="like-btn"><i class="bi bi-heart">  <span id="like-count">0</span></i></button>
      </div>
</div>
</div>
  <div id="messages" style="border:1px solid #ccc; height:300px; overflow:auto; padding:5px;"></div>

  <div style="display:flex;justify-content:left;gap:10px;margin-top:5px;">
    <input type="text" id="name" placeholder="姓名" class="form-control form-control-sm" style="max-width:90px;">
    <input type="text" id="msg" placeholder="輸入訊息" class="form-control form-control-sm">
    <div>
      <button type="button" class="color-btn" onclick="setColor('black', this)" style="background:black;"></button>
      <button type="button" class="color-btn" onclick="setColor('rgb(48,153,244)', this)" style="background:rgb(48,153,244);"></button>
    </div>
    <button onclick="sendMsg()" class="btn btn-secondary btn-sm">送出</button>
  </div>
</div>

<div style="max-width:800px;margin:0 auto;">
  <p style="text-align:center;font-size:smaller;color:#d5d2d2;">
    ＊請以友善與尊重的態度交流，共同營造良好討論環境。
  </p>
</div>
<div style="display: flex; justify-content: center; gap: 10px;">
<a href="https://www.cstudio-go.com/main.html"
   class="btn btn-secondary"
   style="display:block;max-width:100px;">回到網站</a> 
   <button onclick="appear()" class="btn btn-outline-primary" id="buttonText">放點音樂</button>
      </div>
      <br>
 



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
            "name": "Les Miserable Ost",
            "artist": "Artist Name",
            "album": "Album Name",
            "url": "https://app.koofr.net/content/links/807ae71d-36db-42e3-a7fc-58eee3f2c9eb/files/get/les%20miserable.mp3?path=%2F",
            "cover_art_url": "/cover/art/url.jpg"
        },
        {
            "name": "Ghibli Jazz",
            "artist": "Artist Name",
            "album": "Album Name",
            "url": "https://app.koofr.net/content/links/3a330c69-d44a-421f-959b-9049a7807332/files/get/Ghibli%20Jazz.mp3?path=%2F",
            "cover_art_url": "/cover/art/url.jpg"
        }
    ]
});
</script>


<script>
let userColor = 'black';

function setColor(color, btn) {
  userColor = color;
  document.querySelectorAll('.color-btn').forEach(b => b.classList.remove('selected-color'));
  btn.classList.add('selected-color');
}

async function sendMsg() {
  const isAdmin = <?php echo json_encode($isAdmin); ?>;
  const name = document.getElementById('name').value || "Anonymous";
  const msg = document.getElementById('msg').value;
  if (!msg) return;

  const adminNames = ["瑋語老師","瑋語","張瑋語","張老師","玮语老师","玮语","张玮语"];
  if (adminNames.includes(name) && !isAdmin) {
    alert("只有管理者才能使用這個名字喔!");
    return;
  }

  await fetch('chat_api.php', {
    method:'POST',
    headers:{'Content-Type':'application/x-www-form-urlencoded'},
    body: new URLSearchParams({ name, msg, color: userColor })
  });
  document.getElementById('msg').value='';
  loadMessages();
}

//enter key can send message
const msgInput = document.getElementById("msg");

msgInput.addEventListener("keydown", function(event) {
  if (event.key === "Enter") {
    event.preventDefault(); // prevent default action
    sendMsg();              // call your existing sendMsg function
  }
});




async function loadMessages() {
  const res = await fetch('chat_api.php');
  const data = await res.json();
  const box = document.getElementById('messages');

  // Check if user is near the bottom (within 50px)
  const atBottom = box.scrollHeight - box.scrollTop - box.clientHeight < 50;

  box.innerHTML = data.map(m => {
    let color;
  if (m.name === "瑋語老師") {
    // If the old message color was black, override to #9e3c39
    color = (m.color === "black" || m.color === "#000000") ? "#9e3c39" : (m.color || "#9e3c39");
  } else {
    color = m.color || 'black';
  }
  let bold = (m.name === "瑋語老師") ? 'font-weight:bold;' : '';
  return `<div style="color:${color};${bold}">${m.name}: ${m.msg}</div>`;
}).join('');



 const distanceFromBottom = box.scrollHeight - box.scrollTop - box.clientHeight;
  if (distanceFromBottom < 120) {
    box.scrollTop = box.scrollHeight;
  }
}

async function updateVisitors() {
  const res = await fetch('visitors.php');
  const count = await res.text();
  document.getElementById('visitorCount').textContent = count;
}

setInterval(loadMessages, 2000);
setInterval(updateVisitors, 5000);
loadMessages();
updateVisitors();
</script>

<script src="../bootstrap.bundle.min.js"></script>
<script>
const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
[...tooltipTriggerList].map(el => new bootstrap.Tooltip(el));
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

<script>
const pageId = 'index';
const likeBtn = document.getElementById('like-btn');
const likeCount = document.getElementById('like-count');

// Load current like count
async function loadLikes() {
    const res = await fetch('like_api.php', {
        method:'POST',
        headers:{'Content-Type':'application/x-www-form-urlencoded'},
        body: new URLSearchParams({ page_id: pageId })
    });
    const data = await res.json();
    likeCount.textContent = data.likes || 0;
}
loadLikes();

// Click handler
likeBtn.addEventListener('click', async () => {
    const res = await fetch('like_api.php', {
        method:'POST',
        headers:{'Content-Type':'application/x-www-form-urlencoded'},
        body: new URLSearchParams({ page_id: pageId })
    });
    const data = await res.json();
    likeCount.textContent = data.likes || 0;

  

});
</script>


</body>
</html>
