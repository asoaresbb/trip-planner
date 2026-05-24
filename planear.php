<?php
$pageTitle = 'Planear';
require __DIR__ . '/includes/header.php';
?>
    <main class="container">
      <section class="hero">
        <div class="grid-2">
          <article class="card hero-card">
            <p class="kicker" data-pt="Preparação" data-en="Preparation">Preparação</p>
            <h1 data-pt="Planear uma viagem" data-en="Plan a trip">Planear uma viagem</h1>
            <p data-pt="Esta página inclui um pequeno formulário ilustrativo e uma validação em JavaScript do número de telemóvel inserido."
              data-en="This page includes a small illustrative form and a JavaScript validation for the entered mobile phone number.">
              Esta página inclui um pequeno formulário ilustrativo e uma validação em JavaScript do número de telemóvel
              inserido.
            </p>
            <p id="visitCount" class="notice"></p>
          </article>
          <article class="card">
            <h2 data-pt="Conselhos" data-en="Tips">Conselhos</h2>
            <ul>
              <li data-pt="Definir cidades e duração" data-en="Define cities and duration">Definir cidades e duração
              </li>
              <li data-pt="Escolher época do ano" data-en="Choose the season">Escolher época do ano</li>
              <li data-pt="Reservar alojamento com antecedência" data-en="Book accommodation in advance">Reservar
                alojamento com antecedência</li>
            </ul>
          </article>
        </div>
      </section>
      <section class="section">
        <form id="planForm">
          <div>
            <label for="name" data-pt="Nome" data-en="Name">Nome</label>
            <input id="name" type="text" data-placeholder-pt="Nome do viajante" data-placeholder-en="Traveller name"
              placeholder="Nome do viajante">
          </div>

          <div>
            <label for="number" data-pt="Telemóvel" data-en="Mobile Phone">Telemóvel</label>
            <input id="number" type="text" maxlength="9" inputmode="numeric" data-placeholder-pt="Introduza 9 dígitos"
              data-placeholder-en="Enter 9 digits" placeholder="Introduza 9 dígitos">
            <small id="numberMessage" class="validation"></small>
          </div>

          <div>
            <label for="city" data-pt="Destino principal" data-en="Main destination">Destino principal</label>
            <select id="city">
              <option value="" data-pt="Selecione" data-en="Select">Selecione</option>
              <option>Lisboa</option>
              <option>Porto</option>
              <option data-pt="Parque Natural" data-en="Natural Park">Parque Natural</option>
            </select>
          </div>

          <button id="submitRequest" type="button" data-pt="Simular pedido" data-en="Simulate request">Simular
            pedido</button>

          <small id="formMessage" class="validation"></small>
        </form>
      </section>
    </main>
    <footer>

    </footer>
    <div class="modal" id="imageModal">
      <div class="modal-box"><img id="modalImage" src="" alt="Imagem ampliada">
        <p id="modalCaption"></p>
      </div>
    </div>
    <script src="js/script.js"></script>
  </body>

</html>