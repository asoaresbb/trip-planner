<?php
$pageTitle = 'Porto';
/** @var PDO $pdo */
$pdo = require __DIR__ . '/../config/db.php';

// Descrição deste destino vinda da BD
$stmt = $pdo->prepare('SELECT descricao_pt, descricao_en FROM destinos WHERE nome = ?');
$stmt->execute(['Porto']);
$destino = $stmt->fetch();

require __DIR__ . '/../includes/header.php';
?>
    <main class="container">
      <section class="hero">
        <div class="grid-2">
          <article class="card hero-card">
            <p class="kicker">Porto</p>
            <h1 data-pt="Pontes, azulejos e rio Douro" data-en="Bridges, tiles and the Douro river">Pontes, azulejos e
              rio Douro</h1>
            <?php if ($destino): ?>
              <p data-pt="<?= htmlspecialchars($destino['descricao_pt']) ?>" data-en="<?= htmlspecialchars($destino['descricao_en']) ?>"><?= htmlspecialchars($destino['descricao_pt']) ?></p>
            <?php endif; ?>
            <p id="visitCount" class="notice"></p>
          </article>
          <article class="card">
            <h2 data-pt="Pontos de interesse" data-en="Points of interest">Pontos de interesse</h2>
            <ul>
              <li data-pt="Ribeira" data-en="Riverside district">Ribeira</li>
              <li data-pt="Ponte D. Luís I" data-en="Dom Luís I Bridge">Ponte D. Luís I</li>
              <li data-pt="Livraria Lello" data-en="Lello Bookshop">Livraria Lello</li>
              <li data-pt="Caves em Vila Nova de Gaia" data-en="Cellars in Vila Nova de Gaia">Caves em Vila Nova de Gaia
              </li>
            </ul>
          </article>
        </div>
      </section>
      <section class="section grid-3">
        <article class="card">
          <h3 data-pt="Ambiente" data-en="Atmosphere">Ambiente</h3>
          <p data-pt="Ruas inclinadas, fachadas em azulejo e vistas sobre o Douro."
            data-en="Sloped streets, tiled façades and views over the Douro.">Ruas inclinadas, fachadas em azulejo e
            vistas sobre o Douro.</p>
        </article>
        <article class="card">
          <h3 data-pt="Sabores" data-en="Flavours">Sabores</h3>
          <p data-pt="Francesinha, tripas à moda do Porto e doçaria regional."
            data-en="Francesinha, traditional dishes and regional sweets.">Francesinha, tripas à moda do Porto e doçaria
            regional.</p>
        </article>
        <article class="card">
          <h3 data-pt="Cultura" data-en="Culture">Cultura</h3>
          <p data-pt="Museus, estações históricas e festas populares junto ao rio."
            data-en="Museums, historic stations and popular festivities by the river.">Museus, estações históricas e
            festas populares junto ao rio.</p>
        </article>
      </section>
    </main>
    <footer>
      <div class="container">

      </div>
    </footer>
<?php require __DIR__ . '/../includes/footer.php'; ?>