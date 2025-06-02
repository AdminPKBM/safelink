<?php
$target = $_GET['url'] ?? 'https://google.com';
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Menuju Link Download...</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="refresh" content="5;url=<?= htmlspecialchars($target) ?>">
  <style>
    body { font-family: sans-serif; text-align: center; margin-top: 100px; }
    .countdown { font-size: 22px; margin-top: 20px; }
    .btn { margin-top: 30px; padding: 10px 20px; font-size: 16px; background: #2196F3; color: white; text-decoration: none; border-radius: 8px; display: inline-block; }
  </style>
</head>
<body>
  <h2>Tunggu sebentar...</h2>
 <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-4454451699877502"
     crossorigin="anonymous"></script>
  <div>
   <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-4454451699877502"
     crossorigin="anonymous"></script>
  </div>

  <div class="countdown">Anda akan dialihkan dalam <span id="timer">5</span> detik</div>
  <a href="<?= htmlspecialchars($target) ?>" class="btn" id="lanjut" style="display:none;">Klik jika tidak otomatis</a>

  <script>
    let time = 5;
    const timer = document.getElementById('timer');
    const btn = document.getElementById('lanjut');
    const countdown = setInterval(() => {
      time--;
      timer.innerText = time;
      if (time <= 0) {
        clearInterval(countdown);
        btn.style.display = 'inline-block';
      }
    }, 1000);
  </script>
</body>
</html>
