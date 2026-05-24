<?php
$pageTitle = 'Destinos';
require __DIR__ . '/includes/header.php';
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
        <article class="card">
          <h2>Lisboa</h2>
          <p data-pt="Capital vibrante, cheia de bairros históricos, miradouros e elétricos tradicionais."
            data-en="A vibrant capital full of historic neighborhoods, viewpoints and traditional trams.">Capital
            vibrante, cheia de bairros históricos, miradouros e elétricos tradicionais.</p>
          <p><a class="button" href="lisboa.php" data-pt="Ver página" data-en="Open page">Ver página</a></p>
        </article>
        <article class="card">
          <h2>Porto</h2>
          <p data-pt="Cidade do Douro, famosa pelas pontes, pelo centro antigo e pelo vinho do Porto."
            data-en="The Douro city, famous for its bridges, old center and Port wine.">Cidade do Douro, famosa pelas
            pontes, pelo centro antigo e pelo vinho do Porto.</p>
          <p><a class="button" href="porto.php" data-pt="Ver página" data-en="Open page">Ver página</a></p>
        </article>
        <article class="card">
          <h2 data-pt="Costa e sol" data-en="Coast and sun">Costa e sol</h2>
          <p data-pt="O litoral português oferece praias extensas, falésias e surf para todos os níveis."
            data-en="The Portuguese coast offers long beaches, cliffs and surfing for all levels.">O litoral português
            oferece praias extensas, falésias e surf para todos os níveis.</p>
        </article>
        <article class="card">
          <h2 data-pt="Parques naturais" data-en="Natural parks">Parques naturais</h2>
          <p data-pt="Da serra ao vale, há trilhos, lagoas e observação de paisagens protegidas."
            data-en="From mountain to valley, there are trails, lagoons and protected landscapes.">Da serra ao vale, há
            trilhos, lagoas e observação de paisagens protegidas.</p>
          <p><a class="button" href="natureza.php" data-pt="Explorar natureza" data-en="Explore nature">Explorar
              natureza</a></p>
        </article>
      </section>
    </main>
    <footer>
      <div class="container">
        <p data-pt="Escolha um destino e continue a navegação." data-en="Choose a destination and continue browsing.">
          Escolha um destino e continue a navegação.</p>
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