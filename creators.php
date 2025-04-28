<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Sentimo — Creators Page</title>
  <link rel="stylesheet" href="./assets/styles.css?v=2">
</head>
<body>
  <nav class="navbar">
    <div class="logo">
        <a href="index.php" class="logo">
            <img src="./assets/logo-icon.png" alt="Sentimo icon">
            <img src="./assets/logo-text.png" alt="Sentimo text">
        </a>
    </div>
    <ul class="nav-links">
      <li><a href="about.php">About</a></li>
      <li><a href="creators.php">Creators</a></li>
    </ul>
  </nav>

  <main class="creators-page">
  <a href="javascript:history.back()" class="back-button" aria-label="Go back">
    ←
  </a>

  <!-- page header -->
  <div class="creators-header">
    <img src="./assets/logo-full.png" alt="Sentimo logo" class="creators-logo">
    <h1>Meet the Creators</h1>
  </div>

  <!-- Creators Card -->
   <!-- cards grid -->
  <div class="creators-grid">
    <!-- Card 1 -->
     <article class="creator-card">
        <img src="./assets/catherine.png" alt="Catherine Tayer" class="creator-photo">
        <h3 class="creator-name">Catherine Tayer</h3>
        <p class="creator-role">Frontend</p>
        </article>


    <!-- Card 2 -->
    <article class="creator-card">
      <img
        src="./assets/walter.png"
        alt="Photo of Walter Ursua"
        class="creator-photo"
      >
      <h3 class="creator-name">Walter Ursua</h3>
      <p class="creator-role">Backend</p>
    </article>

    <!-- Card 3 -->
    <article class="creator-card">
      <img
        src="./assets/lovely.png"
        alt="Photo of Lovely Cunanan"
        class="creator-photo"
      >
      <h3 class="creator-name">Lovely Cunanan</h3>
      <p class="creator-role">Backend</p>
    </article>
  </div>
  </main>
</body>
</html>
