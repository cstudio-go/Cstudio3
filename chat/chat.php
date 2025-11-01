<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: admin.html');
    exit;
}

// --- Update admin_status in DB ---
$host = "localhost";
$db = "cstusybk_chatdb";
$user = "cstusybk_cstudio";
$pass = "Aaron176!!!!@@@@";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$adminName = '瑋語老師'; // use same name everywhere
$_SESSION['admin'] = $adminName;

// Ensure a row for this admin exists
$stmt = $conn->prepare("SELECT id FROM admin_status WHERE admin_username=?");
$stmt->bind_param("s", $adminName);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    // Update existing row
    $update = $conn->prepare("UPDATE admin_status SET online=1, last_seen=NOW() WHERE admin_username=?");
    $update->bind_param("s", $adminName);
    $update->execute();
    $update->close();
} else {
    // Insert new row
    $insert = $conn->prepare("INSERT INTO admin_status (admin_username, online, last_seen) VALUES (?, 1, NOW())");
    $insert->bind_param("s", $adminName);
    $insert->execute();
    $insert->close();
}

$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="zh-TW">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>聊天室 - 管理員模式</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
.selected-color { border:3px solid #555; transform:scale(1.2); }
.color-btn { width:20px; height:20px; border:none; cursor:pointer; margin-top:4px; }
</style>
</head>
<body class="p-3">
<img src="https://www.cstudio-go.com/cover.png" style="width:100%; height:auto;">
<button onclick="window.location.href='logout.php'" class="btn btn-danger btn-sm" style="float:right;">
  登出
</button>
<h4>聊天室（管理員模式）</h4>

<div id="messages" style="border:1px solid #ccc; height:300px; overflow:auto; padding:5px;"></div>

<div class="mt-2">
  <input type="text" id="msg" class="form-control form-control-sm" placeholder="輸入訊息">
  <div class="mt-1">
    <button type="button" class="color-btn" onclick="setColor('black', this)" style="background:black;"></button>
    <button type="button" class="color-btn" onclick="setColor('rgb(48,153,244)', this)" style="background:rgb(48,153,244);"></button>
    <button class="btn btn-primary btn-sm" onclick="sendMsg()">送出</button>
  </div>
</div>

<script>
let userColor = 'black';
function setColor(color, btn){
    userColor = color;
    document.querySelectorAll('.color-btn').forEach(b => b.classList.remove('selected-color'));
    btn.classList.add('selected-color');
}

async function sendMsg(){
    const msg = document.getElementById('msg').value;
    if(!msg) return;

    // Display name shown in chat
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
        const color = (m.name==='瑋語老師') ? '#9e3c39' : (m.color||'black');
        const bold = (m.name==='瑋語老師') ? 'font-weight:bold;' : '';
        return `<div style="color:${color};${bold}">${m.name}: ${m.msg}</div>`;
    }).join('');
    const distanceFromBottom = box.scrollHeight - box.scrollTop - box.clientHeight;
    if (distanceFromBottom < 120) {
        box.scrollTop = box.scrollHeight;
    }
}

// load chat + keepalive
setInterval(loadMessages, 2000);
loadMessages();

// keep admin online
setInterval(async () => {
    await fetch('admin_keepalive.php');
}, 5000);
</script>
</body>
</html>
