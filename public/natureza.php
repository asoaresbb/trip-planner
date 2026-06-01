<?php
$pageTitle = 'Natureza';
/** @var PDO $pdo */
$pdo = require __DIR__ . '/../config/db.php';

// Apenas os destinos da categoria "natureza" (filtro por slug, com prepared statement)
$stmt = $pdo->prepare(
    'SELECT d.nome, d.descricao_pt, d.descricao_en, d.imagem
     FROM destinos d
     JOIN categorias c ON c.id = d.categoria_id
     WHERE c.slug = ?
     ORDER BY d.nome'
);
$stmt->execute(['natureza']);
$destinos = $stmt->fetchAll();

require __DIR__ . '/../includes/header.php';
?>
    <main class="container">
      <section class="hero">
        <div class="card hero-card">
          <p class="kicker" data-pt="Paisagens" data-en="Landscapes">Paisagens</p>
          <h1 data-pt="Natureza e ar livre" data-en="Nature and outdoors">Natureza e ar livre</h1>
          <p data-pt="Além das cidades, Portugal oferece serras, parques naturais, vales e zonas costeiras protegidas."
            data-en="Beyond the cities, Portugal offers mountains, natural parks, valleys and protected coastal areas.">
            Além das cidades, Portugal oferece serras, parques naturais, vales e zonas costeiras protegidas.</p>
          <p id="visitCount" class="notice"></p>
        </div>
      </section>
      <section class="section grid-3">
        <?php foreach ($destinos as $d): ?>
          <article class="card">
            <h2><?= htmlspecialchars($d['nome']) ?></h2>
            <?php if (!empty($d['imagem'])): ?>
              <p class="photo"><img src="<?= htmlspecialchars($d['imagem']) ?>" alt="<?= htmlspecialchars($d['nome']) ?>"></p>
            <?php endif; ?>
            <p data-pt="<?= htmlspecialchars($d['descricao_pt']) ?>" data-en="<?= htmlspecialchars($d['descricao_en']) ?>"><?= htmlspecialchars($d['descricao_pt']) ?></p>
          </article>
        <?php endforeach; ?>
      </section>
    </main>
    <footer>
      <div class="container">
        <p data-pt="Página dedicada ao lado natural do país."
          data-en="Page dedicated to the natural side of the country.">Página dedicada ao lado natural do país.</p>
      </div>
    </footer>
<?php require __DIR__ . '/../includes/footer.php'; ?>
