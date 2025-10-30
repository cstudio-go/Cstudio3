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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
  <style>
    .selected-color { border:3px solid #555; transform:scale(1.2); }
    .color-btn { width:20px; height:20px; border:none; cursor:pointer; margin-top:4px; }
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
    <span>當前在線人數：</span><span id="visitorCount">0</span><br>
    *禁止攻擊與不當言論
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
   <div class="accordion" id="accordionExample" style="margin: 0 auto; max-width: 800px;">
  <div class="accordion-item">
    <h2 class="accordion-header" id="headingOne">
      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
        🎵 Sonata No. 1 in G minor, BWV 1001
      </button>
    </h2>
    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
      <div class="accordion-body">
        <div style="display: flex; align-items: center; margin-bottom: 10px;">
        <em style="font-size:smaller; margin-right: 20px;">Adagio</em> <audio controls controlslist="nodownload"><source src="https://app.koofr.net/content/links/94375355-1a51-4f93-85be-572045ab2cfd/files/get/Sonata%20No.1%20Adagio.mp3?path=%2F" type="audio/mpeg"> Your browser does not support the audio element.</audio></div>
        <div style="display: flex; align-items: center; margin-bottom: 10px;">
        <em style="font-size:smaller; margin-right: 20px;">Fuga</em> </div>
        <div style="display: flex; align-items: center; margin-bottom: 10px;">
        <em style="font-size:smaller; margin-right: 20px;">Siciliana</em></div>
        <div style="display: flex; align-items: center; margin-bottom: 10px;">
        <em style="font-size:smaller; margin-right: 20px;">Presto</em> </div>
    </div>
    </div>
  </div>
  <div class="accordion-item">
    <h2 class="accordion-header" id="headingTwo">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
        🎵 Partita No. 1 in B minor, BWV 1002
      </button>
    </h2>
    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
      <div class="accordion-body">
        <div style="display: flex; align-items: center; margin-bottom: 10px;">
        <em style="font-size:smaller; margin-right: 20px;">Allemanda</em> </div>
        <div style="display: flex; align-items: center; margin-bottom: 10px;">
        <em style="font-size:smaller; margin-right: 20px;">Double</em> </div>
        <div style="display: flex; align-items: center; margin-bottom: 10px;">
        <em style="font-size:smaller; margin-right: 20px;">Corrente</em> </div>
        <div style="display: flex; align-items: center; margin-bottom: 10px;">
        <em style="font-size:smaller; margin-right: 20px;">Double (Presto)</em> </div>
        <div style="display: flex; align-items: center; margin-bottom: 10px;">
          <em style="font-size:smaller; margin-right: 20px;">Sarabande</em> </div>
          <div style="display: flex; align-items: center; margin-bottom: 10px;">
          <em style="font-size:smaller; margin-right: 20px;">Double</em> </div>
          <div style="display: flex; align-items: center; margin-bottom: 10px;">
          <em style="font-size:smaller; margin-right: 20px;">Tempo di Borea</em> </div>
          <div style="display: flex; align-items: center; margin-bottom: 10px;">
          <em style="font-size:smaller; margin-right: 20px;">Double (Presto)</em> </div>
    </div>
    </div>
  </div>
  <div class="accordion-item">
    <h2 class="accordion-header" id="headingThree">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
        🎵 Sonata No. 2 in A minor, BWV 1003
      </button>
    </h2>
    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
      <div class="accordion-body">
        <div style="display: flex; align-items: center; margin-bottom: 10px;">
        <em style="font-size:smaller; margin-right: 20px;">Grave</em> </div>
        <div style="display: flex; align-items: center; margin-bottom: 10px;">
        <em style="font-size:smaller; margin-right: 20px;">Fuga</em> </div>
        <div style="display: flex; align-items: center; margin-bottom: 10px;">
        <em style="font-size:smaller; margin-right: 20px;">Andante</em></div>
        <div style="display: flex; align-items: center; margin-bottom: 10px;">
        <em style="font-size:smaller; margin-right: 20px;">Allegro</em> </div>
    </div>
    </div>
  </div>

  <div class="accordion-item">
    <h2 class="accordion-header" id="headingFour">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
        🎵 Partita No. 2 in D minor, BWV 1004
      </button>
    </h2>
    <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
      <div class="accordion-body">
        <div style="display: flex; align-items: center; margin-bottom: 10px;">
        <em style="font-size:smaller; margin-right: 20px;">Allemanda</em></div>
        <div style="display: flex; align-items: center; margin-bottom: 10px;">
        <em style="font-size:smaller; margin-right: 20px;">Corrente</em> </div>
        <div style="display: flex; align-items: center; margin-bottom: 10px;">
        <em style="font-size:smaller; margin-right: 20px;">Sarabanda</em><audio controls controlslist="nodownload"><source src="https://app.koofr.net/content/links/b7886d77-093d-4402-b2e3-3ba7476d518c/files/get/Partita%20No.2%20Sarabande.mp3?path=%2F" type="audio/mpeg"> Your browser does not support the audio element.</audio> </div>
        <div style="display: flex; align-items: center; margin-bottom: 10px;">
        <em style="font-size:smaller; margin-right: 20px;">Giga</em> </div>
        <div style="display: flex; align-items: center; margin-bottom: 10px;">
        <em style="font-size:smaller; margin-right: 20px;">Ciaccona (Chaconne)</em></div>
    </div>
    </div>
  </div>

  <div class="accordion-item">
    <h2 class="accordion-header" id="headingFive">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
        🎵 Sonata No. 3 in C major, BWV 1005
      </button>
    </h2>
    <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#accordionExample">
      <div class="accordion-body">
        <div style="display: flex; align-items: center; margin-bottom: 10px;">
        <em style="font-size:smaller; margin-right: 20px;">Adagio</em> </div>
        <div style="display: flex; align-items: center; margin-bottom: 10px;">
        <em style="font-size:smaller; margin-right: 20px;">Fuga</em> </div>
        <div style="display: flex; align-items: center; margin-bottom: 10px;">
        <em style="font-size:smaller; margin-right: 20px;">Largo</em> </div>
        <div style="display: flex; align-items: center; margin-bottom: 10px;">
        <em style="font-size:smaller; margin-right: 20px;">Allegro assai</em> </div>
    </div>
    </div>
  </div>

  <div class="accordion-item">
    <h2 class="accordion-header" id="headingSix">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
        🎵 Partita No. 3 in E major, BWV 1006
      </button>
    </h2>
    <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix" data-bs-parent="#accordionExample">
      <div class="accordion-body">
        <div style="display: flex; align-items: center; margin-bottom: 10px;">
        <em style="font-size:smaller; margin-right: 20px;">Preludio</em></div>
        <div style="display: flex; align-items: center; margin-bottom: 10px;">
        <em style="font-size:smaller; margin-right: 20px;">Loure</em></div>
        <div style="display: flex; align-items: center; margin-bottom: 10px;">
        <em style="font-size:smaller; margin-right: 20px;">Gavotte en Rondeau</em> <audio controls  controlslist="nodownload"><source src="https://app.koofr.net/content/links/8242ef18-6ac1-463f-a26c-07a5dd1e0b34/files/get/Partita%20No.3%20Gavotte.mp3?path=%2F" type="audio/mpeg"> Your browser does not support the audio element.</audio></div>
        <div style="display: flex; align-items: center; margin-bottom: 10px;">
        <em style="font-size:smaller; margin-right: 20px;">Menuet I</em> </div>
        <div style="display: flex; align-items: center; margin-bottom: 10px;">
        <em style="font-size:smaller; margin-right: 20px;">Menuet II</em></div>
        <div style="display: flex; align-items: center; margin-bottom: 10px;">
        <em style="font-size:smaller; margin-right: 20px;">Bourrée</em></div>
        <div style="display: flex; align-items: center; margin-bottom: 10px;">
        <em style="font-size:smaller; margin-right: 20px;">Gigue</em></div>
    </div>
    </div>
  </div>

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
    let color = (m.name === "瑋語老師") ? "#9e3c39" : (m.color || 'black');
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
[...tooltipTriggerList].map(el => new bootstrap.Tooltip(el));
</script>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
  function appear() {
    const $music = $('#accordionExample');
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
