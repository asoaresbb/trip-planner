<?php
$pageTitle = 'About';
require __DIR__ . '/includes/header.php';
?>
    <main class="container">
      <section class="hero">
        <article class="card hero-card">
          <p class="kicker" data-pt="Relatório" data-en="Report">Relatório</p>
          <h1>about.html</h1>
          <p id="visitCount" class="notice"></p>
        </article>
      </section>
      <section class="section">
        <article class="card">
          <p>O site “Descobrir Portugal” foi criado com o objetivo de apresentar alguns destinos turísticos em Portugal
            e, ao mesmo tempo, demonstrar a construção de um site client-side com HTML, CSS e JavaScript. Destina-se a
            pessoas que queiram ter uma ideia geral de locais a visitar e algumas sugestões para planear uma viagem.</p>

          <p>O site está dividido em sete páginas HTML ligadas entre si através de um menu comum. A página inicial,
            <strong>index.php</strong>, funciona como ponto de entrada. A página <strong>destinos.html</strong>
            apresenta os principais temas. As páginas <strong>lisboa.php</strong> e <strong>porto.html</strong> mostram
            duas cidades, enquanto <strong>natureza.html</strong> apresenta opções de turismo natural. A página
            <strong>planear.html</strong> inclui um formulário simples, e a página <strong>about.html</strong> descreve
            o trabalho realizado.</p>

          <p>A parte visual foi separada do conteúdo através do ficheiro <strong>styles.css</strong>, o que permite
            alterar o aspeto do site sem modificar o HTML. O ficheiro <strong>script.js</strong> é usado para toda a
            lógica em JavaScript e é comum a todas as páginas.</p>

          <p>Foram implementadas várias funcionalidades dinâmicas, como a mudança de idioma (português/inglês), o
            destaque de links e botões ao passar o rato, o modo claro/escuro e a validação do número de telemóvel.
            Também foi incluído um contador de visitas com <strong>localStorage</strong>, uma galeria com imagens
            ampliáveis e a criação dinâmica de caixas de seleção. Na página de planeamento, ao clicar em “Simular
            pedido”, é apresentada uma mensagem de confirmação ao utilizador. O site foi testado nos navegadores Chrome,
            Edge, Firefox e Safari.</p>
        </article>
      </section>
    </main>
    <footer>
      <div class="container">

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