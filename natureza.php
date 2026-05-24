<?php
$pageTitle = 'Natureza';
require __DIR__ . '/includes/header.php';
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
        <article class="card">
          <h2 data-pt="Peneda-Gerês" data-en="Peneda-Gerês">Peneda-Gerês</h2>
          <p data-pt="Trilhos, cascatas e aldeias de montanha." data-en="Trails, waterfalls and mountain villages.">
            Trilhos, cascatas e aldeias de montanha.</p>
        </article>
        <article class="card">
          <h2 data-pt="Serra da Estrela" data-en="Serra da Estrela">Serra da Estrela</h2>
          <p data-pt="Ponto mais alto de Portugal continental, ideal para paisagens amplas."
            data-en="The highest point in mainland Portugal, ideal for wide landscapes.">Ponto mais alto de Portugal
            continental, ideal para paisagens amplas.</p>
        </article>
        <article class="card">
          <h2 data-pt="Ria Formosa" data-en="Ria Formosa">Ria Formosa</h2>
          <p data-pt="Sistema lagunar com biodiversidade e ilhas-barreira."
            data-en="A lagoon system with biodiversity and barrier islands.">Sistema lagunar com biodiversidade e
            ilhas-barreira.</p>
        </article>
      </section>
    </main>
    <footer>
      <div class="container">
        <p data-pt="Página dedicada ao lado natural do país."
          data-en="Page dedicated to the natural side of the country.">Página dedicada ao lado natural do país.</p>
      </div>
    </footer>
    <div class="modal" id="imageModal">
      <div class="modal-box"><img id="modalImage" src="" alt="Imagem ampliada">
        <p id="modalCaption"></p>
      </div>
    </div>
    <script src="js/script.js"></script>
  </body>

</html>