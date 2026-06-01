<?php
$pageTitle = 'Destinos';
/** @var PDO $pdo */
$pdo = require __DIR__ . '/../config/db.php';

// Todos os destinos com a respetiva categoria
$destinos = $pdo->query(
    'SELECT d.nome, d.descricao_pt, d.descricao_en, d.imagem, c.nome AS categoria
     FROM destinos d
     JOIN categorias c ON c.id = d.categoria_id
     ORDER BY c.nome, d.nome'
)->fetchAll();

require __DIR__ . '/../includes/header.php';
?>
    <main class="container">
      <section class="hero">
        <div class="card hero-card">
          <p class="kicker" data-pt="Roteiros" data-en="Routes">Roteiros</p>
          <h1 data-pt="Destinos em destaque" data-en="Featured destinations">Destinos em destaque</h1>
          <p class="muted"
            data-pt="Portugal combina centros históricos, praias atlânticas, gastronomia e natureza. Aqui estão quatro tipos de experiência para diferentes visitantes."
            data-en="Portugal combines historic centers, Atlantic beaches, gastronomy and nature. Here are four types of experiences for different visitors.">
            Portugal combina centros históricos, praias atlânticas, gastronomia e natureza. Aqui estão quatro tipos de
            experiência para diferentes visitantes.</p>
          <p id="visitCount" class="notice"></p>
        </div>
      </section>
      <section class="section grid-2">
        <?php foreach ($destinos as $d): ?>
          <article class="card">
            <h2><?= htmlspecialchars($d['nome']) ?></h2>
            <p class="kicker" data-pt="<?= htmlspecialchars($d['categoria']) ?>" data-en="<?= htmlspecialchars($d['categoria']) ?>"><?= htmlspecialchars($d['categoria']) ?></p>
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
        <p data-pt="Escolha um destino e continue a navegação." data-en="Choose a destination and continue browsing.">
          Escolha um destino e continue a navegação.</p>
      </div>
    </footer>
<?php require __DIR__ . '/../includes/footer.php'; ?>
