<?php
$pageTitle = 'About';
require __DIR__ . '/../includes/header.php';
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

      <section class="section">
        <article class="card">
          <h2>Server-side info</h2>
          <p>No e-fólio B foi acrescentada uma componente do lado do servidor, em <strong>PHP</strong>, com
            persistência numa base de dados <strong>MySQL</strong> (<code>trip_planner</code>). Todas as operações
            são efetuadas pelo utilizador <code>lei</code>. A ligação é feita por <strong>PDO</strong> com
            <em>prepared statements</em>.</p>

          <h3>Esquema da base de dados</h3>
          <p>A informação está organizada em três tabelas relacionadas por chaves estrangeiras:</p>
          <ul>
            <li><strong>categorias</strong> (<code>id</code> PK, <code>nome</code>, <code>nome_en</code>,
              <code>slug</code>) — tipos de destino (Cidade, Costa, Interior, Natureza).</li>
            <li><strong>destinos</strong> (<code>id</code> PK, <code>nome</code>, <code>descricao_pt</code>,
              <code>descricao_en</code>, <code>imagem</code>, <code>categoria_id</code> FK → categorias) — os destinos
              turísticos.</li>
            <li><strong>pedidos</strong> (<code>id</code> PK, <code>nome</code>, <code>telemovel</code>,
              <code>destino_id</code> FK → destinos, <code>criado_em</code>) — pedidos submetidos no formulário de
              planeamento.</li>
          </ul>
          <p>Relações: uma <em>categoria</em> tem muitos <em>destinos</em>; um <em>destino</em> pode ter muitos
            <em>pedidos</em>. As tabelas usam o motor InnoDB para garantir a integridade das chaves estrangeiras.</p>

          <h3>Página de back office</h3>
          <p>Inserção de novos destinos através de formulário:</p>
          <pre><code>http://localhost:8000/backoffice.php</code></pre>

          <h3>API REST</h3>
          <p>Recurso <code>destinos</code>, com respostas em JSON. Base do endpoint:
            <code>http://localhost:8000/api/destinos.php</code></p>

          <h4>GET — consulta</h4>
          <p>Parâmetro opcional <code>id</code> (na query string). Sem <code>id</code> devolve todos os destinos; com
            <code>id</code> devolve um único.</p>
          <p>Exemplos:</p>
          <pre><code># todos os destinos
curl http://localhost:8000/api/destinos.php

# um destino (id = 2)
curl "http://localhost:8000/api/destinos.php?id=2"</code></pre>

          <h4>PUT — manipulação (atualizar)</h4>
          <p>Parâmetro obrigatório <code>id</code> (query string) e corpo em JSON com os campos
            <code>nome</code>, <code>descricao_pt</code>, <code>descricao_en</code>, <code>categoria_id</code>
            (obrigatórios) e <code>imagem</code> (opcional).</p>
          <p>Exemplo:</p>
          <pre><code>curl -X PUT \
  -H "Content-Type: application/json" \
  -d '{"nome":"Porto","descricao_pt":"Cidade do Douro.","descricao_en":"The Douro city.","categoria_id":1,"imagem":null}' \
  "http://localhost:8000/api/destinos.php?id=2"</code></pre>

          <p>Códigos de estado: <code>200</code> (sucesso), <code>400</code> (dados inválidos), <code>404</code>
            (destino inexistente), <code>405</code> (método não suportado).</p>

          <h3>Segurança</h3>
          <p>Foram aplicadas duas defesas em todo o código do lado do servidor:</p>
          <ul>
            <li><strong>Prevenção de SQL injection</strong> — todas as interrogações à base de dados que dependem de
              valores externos usam <em>prepared statements</em> do PDO: o SQL leva marcadores <code>?</code> e os
              valores são passados à parte, em <code>execute([...])</code>. Assim o que vem do utilizador é sempre
              tratado como <em>dado</em> e nunca como <em>código</em> SQL.</li>
            <li><strong>Prevenção de XSS</strong> — todos os dados vindos da base de dados ou do utilizador são
              passados por <code>htmlspecialchars()</code> antes de serem escritos no HTML. Caracteres como
              <code>&lt;</code> e <code>&gt;</code> aparecem como texto e não são interpretados como marcação,
              impedindo a injeção de <em>scripts</em>.</li>
          </ul>
          <p>Exemplos do código:</p>
          <pre><code>// SQL injection: valor separado do SQL (prepared statement)
$stmt = $pdo-&gt;prepare('SELECT * FROM destinos WHERE id = ?');
$stmt-&gt;execute([$id]);

// XSS: escape na saída para HTML
echo htmlspecialchars($destino['nome']);</code></pre>
          <p>Como reforço: a validação dos dados é feita no servidor (e não só no cliente), as chaves estrangeiras
            garantem integridade referencial, e o utilizador da base de dados (<code>lei</code>) tem permissões
            limitadas apenas a esta base de dados (princípio do menor privilégio).</p>
        </article>
      </section>

      <section class="section">
        <article class="card">
          <h2>Estratégia de testes</h2>
          <p>O projeto é testado a três níveis, seguindo a ideia da <strong>pirâmide de testes</strong> (muitos
            testes rápidos na base, poucos testes lentos e realistas no topo):</p>
          <ul>
            <li><strong>Unitário</strong> — verificação de regras isoladas (ex.: a regra de validação do telemóvel),
              incluída em <code>tests.php</code>.</li>
            <li><strong>Integração / serviço</strong> — <code>tests.php</code> testa a base de dados (existência das
              tabelas, integridade das chaves estrangeiras, inserções com <em>rollback</em>) e <code>tests.sh</code>
              testa o servidor por HTTP (páginas e endpoints da API, com os códigos de estado esperados).</li>
            <li><strong>End-to-end / aceitação</strong> — testes <strong>Playwright</strong> em
              <code>tests/e2e/</code> que abrem um browser real e verificam o comportamento client-side (troca de
              idioma, modo escuro, galeria, validação do telemóvel e submissão do formulário).</li>
          </ul>
          <p>Os testes de escrita usam transações com <em>rollback</em> ou limpam os dados que criam, por isso não
            alteram a informação real da base de dados.</p>
          <p>Como executar:</p>
          <pre><code># testes de base de dados/integridade (browser)
http://localhost:8000/tests.php

# testes de integração HTTP (páginas + API)
./tests/tests.sh

# testes end-to-end no browser (Playwright)
npm run test:e2e</code></pre>
        </article>
      </section>
    </main>
    <footer>
      <div class="container">

      </div>
    </footer>
<?php require __DIR__ . '/../includes/footer.php'; ?>