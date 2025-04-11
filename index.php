<?php
// خواندن فایل JSON
$data_file = 'data.json';
$json_data = file_get_contents($data_file);
$data = json_decode($json_data, true);
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>رزومه <?php echo htmlspecialchars($data['name']); ?></title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Vazirmatn:wght@400;700;900&display=swap');
    body { font-family: 'Vazirmatn', sans-serif; }
    .audio-wrapper {
      position: relative;
      background-color: #7c3aed;
      color: white;
      border-radius: 12px;
      padding: 12px;
      text-align: center;
      overflow: hidden;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }
    .audio-wrapper:hover {
      background-color: #6d28d9;
    }
    .audio-wrapper.active {
      background-color: #6d28d9;
    }
  </style>
</head>
<body class="bg-gradient-to-r from-purple-100 to-blue-100 dark:from-gray-900 dark:to-gray-800 text-gray-800 dark:text-gray-200 transition-colors duration-500">
  <div class="max-w-7xl mx-auto p-8">
    <!-- بخش بالای صفحه -->
    <div class="flex justify-between items-center mb-16 space-x-4 space-x-reverse">
      <!-- سمت راست: آهنگ‌های مورد علاقه -->
      <div class="bg-white dark:bg-gray-700 rounded-xl shadow-lg p-4 w-1/3 text-center">
        <h2 class="text-xl font-bold text-purple-600 dark:text-purple-300 mb-3">🎶 آهنگ‌های مورد علاقه</h2>
        <ul class="space-y-3 text-gray-700 dark:text-gray-200 text-sm">
          <?php foreach($data['favoriteMusic'] as $music): ?>
            <li class="audio-wrapper" data-src="<?php echo htmlspecialchars($music['src']); ?>">
              <?php echo htmlspecialchars($music['title']); ?>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
      <!-- وسط: عکس، نام و پلیر -->
      <div class="bg-white dark:bg-gray-700 rounded-xl shadow-lg p-4 w-1/3 text-center">
        <img src="<?php echo htmlspecialchars($data['profileImage']); ?>" alt="<?php echo htmlspecialchars($data['name']); ?>" class="mx-auto rounded-full shadow-lg w-24 h-24 mb-3">
        <h1 class="text-2xl font-extrabold text-purple-700 dark:text-purple-400"><?php echo htmlspecialchars($data['name']); ?></h1>
        <h1 class="text-2xl font-extrabold text-purple-700 dark:text-purple-400"><?php echo htmlspecialchars($data['englishName']); ?></h1>
        <div class="mt-4">
          <button id="playPauseButton" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded-full transition transform hover:scale-105">
            ▶️ پخش موزیک
          </button>
          <button id="nextButton" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded-full transition transform hover:scale-105 ml-2">
            ⏭ بعدی
          </button>
          <audio id="centralAudio" class="hidden"></audio>
        </div>
      </div>
      <!-- سمت چپ: چیزهای مورد علاقه -->
      <div class="bg-white dark:bg-gray-700 rounded-xl shadow-lg p-4 w-1/3 text-center">
        <h2 class="text-xl font-bold text-purple-600 dark:text-purple-300 mb-3">🎯 چیزهای مورد علاقه</h2>
        <ul class="space-y-1 text-gray-700 dark:text-gray-200 text-sm">
          <?php foreach($data['favorites'] as $fav): ?>
            <li><?php echo htmlspecialchars($fav); ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>

    <!-- درباره من -->
    <section class="mb-16 bg-white dark:bg-gray-700 rounded-2xl shadow-xl p-8 hover:shadow-2xl transition-shadow">
      <h2 class="text-3xl font-bold mb-4 text-purple-600 dark:text-purple-300">درباره من</h2>
      <p class="leading-relaxed text-gray-700 dark:text-gray-200">
        <?php echo nl2br(htmlspecialchars($data['aboutMe'])); ?>
      </p>
    </section>

    <!-- گواهینامه‌ها و مهارت‌ها -->
    <div class="flex flex-nowrap justify-between items-stretch mb-16 gap-4">
      <!-- گواهینامه‌ها -->
      <div class="flex-1 flex flex-col bg-white dark:bg-gray-700 p-4 rounded-xl shadow hover:shadow-2xl transition-shadow">
        <h2 class="text-3xl font-bold mb-4 text-purple-600 dark:text-purple-300">گواهینامه‌ها</h2>
        <ul class="space-y-3 text-gray-700 dark:text-gray-200 flex-grow">
          <?php foreach($data['certificates'] as $cert): ?>
            <li class="flex items-center space-x-3 space-x-reverse">
              <img src="<?php echo htmlspecialchars($cert['icon']); ?>" alt="Certificate Icon" class="w-8 h-8">
              <a href="<?php echo htmlspecialchars($cert['url']); ?>" class="text-purple-600 dark:text-purple-400 hover:underline"><?php echo htmlspecialchars($cert['title']); ?></a>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
      <!-- مهارت‌ها -->
      <div class="flex-1 flex flex-col bg-white dark:bg-gray-700 p-4 rounded-xl shadow hover:shadow-2xl transition-shadow">
        <h2 class="text-3xl font-bold mb-4 text-purple-600 dark:text-purple-300">مهارت‌ها</h2>
        <div class="flex-grow">
          <canvas id="skillsChart"></canvas>
        </div>
      </div>
    </div>

    <!-- تجربه کاری -->
    <section class="mb-16">
      <h2 class="text-3xl font-bold mb-6 text-purple-600 dark:text-purple-300">تجربه کاری</h2>
      <div class="relative w-full overflow-x-auto">
        <div class="flex space-x-8 space-x-reverse min-w-max py-4">
          <?php foreach($data['experience'] as $exp): ?>
            <div class="flex flex-col items-center text-center">
              <div class="bg-white dark:bg-gray-700 p-4 rounded-full shadow-md mb-2">
                <img src="<?php echo htmlspecialchars($exp['logo']); ?>" alt="<?php echo htmlspecialchars($exp['title']); ?>" class="w-12 h-12">
              </div>
              <h3 class="text-lg font-semibold"><?php echo htmlspecialchars($exp['title']); ?></h3>
              <p class="text-gray-600 dark:text-gray-400 text-sm"><?php echo htmlspecialchars($exp['company']); ?></p>
            </div>
            <div class="w-10 h-1 bg-purple-500 self-center"></div>
          <?php endforeach; ?>
        </div>
      </div>
    </section>

    <!-- فوتر -->
    <footer class="text-center text-gray-600 dark:text-gray-300 pt-8 border-t dark:border-gray-600">
      <p class="mb-2">با من در تماس باشید 🌟</p>
      <a href="mailto:<?php echo htmlspecialchars($data['contactEmail']); ?>" class="text-purple-600 dark:text-purple-400 hover:text-purple-800 dark:hover:text-purple-200 transition-colors"><?php echo htmlspecialchars($data['contactEmail']); ?></a>
    </footer>
  </div>

  <script>
    // رسم نمودار مهارت‌ها
    const ctx = document.getElementById('skillsChart')?.getContext('2d');
    <?php if(isset($data['skills'])): ?>
    new Chart(ctx, {
      type: 'radar',
      data: {
        labels: <?php echo json_encode($data['skills']['labels']); ?>,
        datasets: [{
          label: 'مهارت‌ها',
          data: <?php echo json_encode($data['skills']['data']); ?>,
          backgroundColor: 'rgba(168, 85, 247, 0.3)',
          borderColor: 'rgba(168, 85, 247, 1)',
          borderWidth: 2
        }]
      },
      options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: { r: { ticks: { backdropColor: 'transparent', color: '#666' }, grid: { color: '#888' } } }
      }
    });
    <?php endif; ?>

    // پلیر موسیقی
    const playlistItems = document.querySelectorAll('.audio-wrapper');
    const centralAudio = document.getElementById('centralAudio');
    const playPauseButton = document.getElementById('playPauseButton');
    const nextButton = document.getElementById('nextButton');

    let currentTrackIndex = 0;
    const tracks = Array.from(playlistItems).map(item => item.getAttribute('data-src'));

    function updateActiveTrack() {
      playlistItems.forEach((item, index) => {
        if(index === currentTrackIndex) {
          item.classList.add('active');
        } else {
          item.classList.remove('active');
        }
      });
    }

    function playTrack(index) {
      if(index < 0 || index >= tracks.length) return;
      currentTrackIndex = index;
      centralAudio.src = tracks[currentTrackIndex];
      centralAudio.play();
      playPauseButton.innerHTML = '⏸️ توقف موزیک';
      updateActiveTrack();
    }

    playlistItems.forEach((item, index) => {
      item.addEventListener('click', () => {
        playTrack(index);
      });
    });

    playPauseButton.addEventListener('click', () => {
      if(centralAudio.paused) {
        centralAudio.play();
        playPauseButton.innerHTML = '⏸️ توقف موزیک';
      } else {
        centralAudio.pause();
        playPauseButton.innerHTML = '▶️ پخش موزیک';
      }
      updateActiveTrack();
    });

    nextButton.addEventListener('click', () => {
      let nextIndex = (currentTrackIndex + 1) % tracks.length;
      playTrack(nextIndex);
    });

    centralAudio.addEventListener('ended', () => {
      let nextIndex = (currentTrackIndex + 1) % tracks.length;
      playTrack(nextIndex);
    });
  </script>
</body>
</html>
