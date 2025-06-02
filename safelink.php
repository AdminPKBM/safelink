<?php
// Validasi dasar untuk URL target demi keamanan tambahan (opsional tapi direkomendasikan)
// Misalnya, Anda bisa memeriksa apakah URL menggunakan http atau https
$target_url = $_GET['url'] ?? 'https://google.com';
if (!filter_var($target_url, FILTER_VALIDATE_URL) || !preg_match('/^https?:\/\//i', $target_url)) {
    // Jika URL tidak valid atau tidak dimulai dengan http/https, alihkan ke default yang aman
    $target_url = 'https://google.com'; // Atau halaman error/beranda Anda
}

// Amankan output URL
$safe_target_url = htmlspecialchars($target_url, ENT_QUOTES, 'UTF-8');
$target_domain = htmlspecialchars(parse_url($target_url, PHP_URL_HOST), ENT_QUOTES, 'UTF-8');

// Durasi tunggu (dalam detik)
$wait_time = 5;
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Anda Segera Dialihkan...</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="robots" content="noindex, nofollow">

  <style>
    body {
      font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
      text-align: center;
      margin: 0;
      padding: 20px;
      background-color: #f0f2f5;
      color: #333;
      display: flex;
      flex-direction: column;
      justify-content: center;
      min-height: 100vh;
      box-sizing: border-box;
    }
    .container {
      background-color: #fff;
      padding: 30px 40px;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      max-width: 500px;
      width: 100%;
      margin: 20px auto;
    }
    h2 {
      color: #1a73e8; /* Warna biru yang lebih modern */
      margin-top: 0;
      margin-bottom: 15px;
      font-size: 1.8em;
    }
    p {
      font-size: 1.1em;
      line-height: 1.6;
      margin-bottom: 20px;
    }
    .countdown {
      font-size: 1.5em; /* Sedikit diperbesar */
      font-weight: bold;
      color: #d93025; /* Warna merah untuk penekanan */
      margin-top: 25px;
      margin-bottom: 25px;
    }
    .countdown #timer {
      padding: 5px 10px;
      background-color: #fce8e6; /* Latar belakang lembut untuk timer */
      border-radius: 6px;
    }
    .btn {
      display: none; /* Akan ditampilkan oleh JavaScript */
      margin-top: 20px;
      padding: 12px 25px;
      font-size: 1.1em;
      font-weight: bold;
      background-color: #1a73e8;
      color: white;
      text-decoration: none;
      border-radius: 8px;
      border: none;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }
    .btn:hover, .btn:focus {
      background-color: #1558b0; /* Warna hover yang lebih gelap */
      outline: none;
    }
    .ads-placeholder {
        /* Anda bisa mengatur tinggi minimum agar layout tidak bergeser saat iklan dimuat */
        min-height: 50px; /* Sesuaikan dengan ukuran iklan Anda */
        margin: 20px 0;
    }
    .destination-info {
        font-size: 0.9em;
        color: #5f6368;
        margin-top: 15px;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Harap Tunggu Sebentar...</h2>
    <p>Anda sedang dalam proses pengalihan ke tujuan yang Anda minta.</p>

    <div class="ads-placeholder">
      <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-4454451699877502"
            crossorigin="anonymous"></script>
      </div>

    <div class="countdown">Anda akan dialihkan dalam <span id="timer"><?= $wait_time ?></span> detik</div>
    <p class="destination-info">Tujuan: <?= $target_domain ? $target_domain : 'situs eksternal'; ?></p>

    <a href="<?= $safe_target_url ?>" class="btn" id="manualRedirectButton" rel="noopener noreferrer nofollow">Lanjutkan Sekarang</a>
  </div>

  <script>
    let timeLeft = <?= $wait_time ?>;
    const timerElement = document.getElementById('timer');
    const manualRedirectButton = document.getElementById('manualRedirectButton');
    const targetUrl = '<?= $safe_target_url ?>'; // Gunakan variabel PHP yang sudah di-escape

    const countdownInterval = setInterval(() => {
      timeLeft--;
      if (timerElement) {
        timerElement.innerText = timeLeft;
      }

      if (timeLeft <= 0) {
        clearInterval(countdownInterval);
        if (manualRedirectButton) {
            // Tampilkan tombol sebelum redirect, jika pengguna ingin klik lebih cepat
            // manualRedirectButton.style.display = 'inline-block';
        }
        // Tunggu sebentar agar pengguna sempat melihat tombol (jika ada) atau langsung redirect
        // setTimeout(() => {
        window.location.href = targetUrl;
        // }, 250); // Penundaan kecil opsional
      }
    }, 1000);

    // Tampilkan tombol setelah beberapa saat, atau jika JS tidak berjalan dengan baik (meskipun href sudah ada)
    // Ini juga membantu jika pengguna ingin skip countdown.
    setTimeout(() => {
        if (manualRedirectButton) {
            manualRedirectButton.style.display = 'inline-block';
        }
    }, Math.min(2000, (<?= $wait_time ?> -1) * 1000) ); // Tampilkan tombol setelah 2 detik atau 1 detik sebelum akhir

    // Jika pengguna mengklik tombol, batalkan interval dan alihkan
    if (manualRedirectButton) {
        manualRedirectButton.addEventListener('click', function(event) {
            event.preventDefault(); // Mencegah perilaku default tautan jika JS berjalan
            clearInterval(countdownInterval);
            window.location.href = targetUrl;
        });
    }
  </script>
</body>
</html>
