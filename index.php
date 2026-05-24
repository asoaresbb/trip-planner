<!DOCTYPE html>
<html lang="pt-PT">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Descobrir Portugal</title>
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

    <main>
      <section class="hero">
        <div class="container hero-grid">
          <div class="card hero-card">
            <p class="kicker" data-pt="Guia digital" data-en="Digital guide">Guia digital</p>
            <h1 data-pt="Descubra Portugal por cidade, costa e montanha"
              data-en="Discover Portugal through cities, coast and mountains">Descubra Portugal por cidade, costa e
              montanha</h1>
            <p class="muted"
              data-pt="Este site apresenta sugestões de viagem, destaques culturais e ideias práticas para visitar Portugal. Use o menu para explorar as diferentes páginas do trabalho."
              data-en="This site presents travel suggestions, cultural highlights and practical ideas for visiting Portugal. Use the menu to explore the different pages of the project.">
              Este site apresenta sugestões de viagem, destaques culturais e ideias práticas para visitar Portugal. Use
              o menu para explorar as diferentes páginas do trabalho.</p>
            <p>
              <a class="button" href="destinos.php" data-pt="Explorar destinos" data-en="Explore destinations">Explorar
                destinos</a>
            </p>
          </div>
          <div class="card hero-card">
            <img alt="Paisagem ilustrativa de Portugal" src="img/lisbon_downtown.jpg" </div>
          </div>
      </section>

      <section class="section">
        <div class="container grid-3">
          <article class="stat"><strong>7</strong><span data-pt="Páginas HTML ligadas entre si"
              data-en="HTML pages linked together">Páginas HTML ligadas entre si</span></article>
          <article class="stat"><strong>4</strong><span data-pt="Elementos dinâmicos em JavaScript"
              data-en="Dynamic JavaScript elements">Elementos dinâmicos em JavaScript</span></article>
          <article class="stat"><strong>1</strong><span data-pt="Folha de estilos central"
              data-en="Central stylesheet">Folha de estilos central</span></article>
          <p id="visitCount" class="notice"></p>
        </div>
      </section>

      <section class="section">
        <div class="container grid-2">
          <article class="card">
            <h2 data-pt="O que pode encontrar" data-en="What you can find">O que pode encontrar</h2>
            <ul>
              <li data-pt="Sugestões de cidades para visitar" data-en="City suggestions to visit">Sugestões de cidades
                para visitar</li>
              <li data-pt="Locais naturais e paisagens emblemáticas" data-en="Natural sites and iconic landscapes">
                Locais naturais e paisagens emblemáticas</li>
              <li data-pt="Ideias para organizar uma viagem" data-en="Ideas to plan a trip">Ideias para organizar uma
                viagem</li>
              <li data-pt="Resumo do trabalho na página about.html" data-en="Project summary on about.html">Resumo do
                trabalho na página about.html</li>
            </ul>
          </article>
          <article class="card">
            <h2 data-pt="Navegação rápida" data-en="Quick navigation">Navegação rápida</h2>
            <ul class="inline-list">
              <li><a class="tag" href="lisboa.php">Lisboa</a></li>
              <li><a class="tag" href="porto.php">Porto</a></li>
              <li><a class="tag" href="natureza.php" data-pt="Natureza" data-en="Nature">Natureza</a></li>
              <li><a class="tag" href="planear.php" data-pt="Planear" data-en="Plan">Planear</a></li>
            </ul>
            <p class="muted"
              data-pt="Explore destinos turísticos em Portugal, descubra paisagens únicas, cultura rica e experiências inesquecíveis de norte a sul do país."
              data-en="Explore tourist destinations in Portugal, discover unique landscapes, rich culture, and unforgettable experiences from north to south.">
              Explore destinos turísticos em Portugal, descubra paisagens únicas, cultura rica e experiências
              inesquecíveis de norte a sul do país.
            </p>
          </article>
        </div>
      </section>
    </main>

    <footer>
      <div class="container">
        <p data-pt="Trabalho académico desenvolvido com HTML, CSS e JavaScript."
          data-en="Academic work developed with HTML, CSS and JavaScript.">Trabalho académico desenvolvido com HTML, CSS
          e JavaScript.</p>
      </div>
    </footer>

    <div class="modal" id="imageModal">
      <div class="modal-box">
        <img id="modalImage" src="" alt="Imagem ampliada">
        <p id="modalCaption"></p>
      </div>
    </div>

    <script src="js/script.js"></script>
  </body>

</html>