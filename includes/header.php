<?php
$title = 'Descobrir Portugal';
if (!empty($pageTitle)) {
    $title .= ' - ' . $pageTitle;
}
?>
<!DOCTYPE html>
<html lang="pt-PT">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?></title>
    <link rel="stylesheet" href="css/styles.css">
  </head>

  <body>
    <header>
      <div class="container topbar">
        <a class="brand" href="index.php">Descobrir Portugal</a>
        <nav>
          <ul>
            <li><a href="index.php" data-pt="Início" data-en="Home">Início</a></li>
            <li><a href="destinos.php" data-pt="Destinos" data-en="Destinations">Destinos</a></li>
            <li><a href="lisboa.php" data-pt="Lisboa" data-en="Lisbon">Lisboa</a></li>
            <li><a href="porto.php" data-pt="Porto" data-en="Porto">Porto</a></li>
            <li><a href="natureza.php" data-pt="Natureza" data-en="Nature">Natureza</a></li>
            <li><a href="planear.php" data-pt="Planear" data-en="Plan">Planear</a></li>
            <li><a href="about.php" data-pt="Sobre" data-en="About">Sobre</a></li>
          </ul>
        </nav>
        <div class="actions">
          <button id="langToggle" type="button">EN</button>
          <button id="themeToggle" type="button">🌙</button>
        </div>
      </div>
    </header>
