<?php
session_start();
$isAdmin = isset($_SESSION['admin']);
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
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

<div id="chat" style="max-width:800px;margin:0 auto;border:1px brown solid;padding:10px;">
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

<a href="https://www.cstudio-go.com/main.html"
   class="btn btn-secondary"
   style="display:block;max-width:100px;text-align:center;margin:20px auto;">回到網站</a>

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

</body>
</html>
