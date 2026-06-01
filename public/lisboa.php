<?php
$pageTitle = 'Lisboa';
/** @var PDO $pdo */
$pdo = require __DIR__ . '/../config/db.php';

// Descrição deste destino vem da BD
$stmt = $pdo->prepare('SELECT descricao_pt, descricao_en FROM destinos WHERE nome = ?');
$stmt->execute(['Lisboa']);
$destino = $stmt->fetch();

require __DIR__ . '/../includes/header.php';
?>
    <main class="container">
      <section class="hero">
        <div class="grid-2">
          <article class="card hero-card">
            <p class="kicker">Lisboa</p>
            <h1 data-pt="Entre colinas, miradouros e tradição" data-en="Between hills, viewpoints and tradition">Entre
              colinas, miradouros e tradição</h1>
            <?php if ($destino): ?>
              <p data-pt="<?= htmlspecialchars($destino['descricao_pt']) ?>" data-en="<?= htmlspecialchars($destino['descricao_en']) ?>"><?= htmlspecialchars($destino['descricao_pt']) ?></p>
            <?php endif; ?>
            <ul>
              <li data-pt="Belém e os seus monumentos" data-en="Belém and its monuments">Belém e os seus monumentos</li>
              <li data-pt="Alfama e os bairros antigos" data-en="Alfama and the old neighborhoods">Alfama e os bairros
                antigos</li>
              <li data-pt="Praça do Comércio e frente ribeirinha" data-en="Praça do Comércio and waterfront">Praça do
                Comércio e frente ribeirinha</li>
            </ul>
            <p id="visitCount" class="notice"></p>
          </article>
          <article class="card">
            <h2 data-pt="Sugestão de visita" data-en="Suggested visit">Sugestão de visita</h2>
            <p data-pt="Começar num miradouro, atravessar o centro histórico e terminar junto ao rio é uma boa forma de sentir a cidade."
              data-en="Starting at a viewpoint, crossing the old center and ending by the river is a good way to experience the city.">
              Começar num miradouro, atravessar o centro histórico e terminar junto ao rio é uma boa forma de sentir a
              cidade.</p>
            <ul class="inline-list">
              <li class="tag" data-pt="Cultura" data-en="Culture">Cultura</li>
              <li class="tag" data-pt="Gastronomia" data-en="Food">Gastronomia</li>
              <li class="tag" data-pt="História" data-en="History">História</li>
            </ul>
          </article>
        </div>
      </section>
      <section class="section">
        <h2 data-pt="Galeria" data-en="Gallery">Galeria</h2>
        <div class="gallery">
          <figure class="photo"><img alt="Palácio da Fronteira" src="img/Palacio_Fronteira.jpg">
          </figure>
          <figure class="photo"><img alt="Interior do Oceanário" src="img/oceanario.jpg">
          </figure>
          <figure class="photo"><img alt="MAAT - Museu de Arte, Arquitetura e Tecnologia junto ao Rio Tejo"
              src="img/maat.jpg">
          </figure>
        </div>
      </section>
    </main>
    <footer>
      <div class="container">
        <p data-pt="Clique numa imagem para a ver ampliada." data-en="Click an image to enlarge it.">Clique numa imagem
          para a ver ampliada.</p>
      </div>
    </footer>
<?php require __DIR__ . '/../includes/footer.php'; ?>
