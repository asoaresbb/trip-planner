<?php
$pageTitle = 'Planear';
/** @var PDO $pdo */
$pdo = require __DIR__ . '/../config/db.php';

// Destinos para o select (JOIN com a categoria)
$destinos = $pdo->query(
    'SELECT d.id, d.nome, c.nome AS categoria
     FROM destinos d
     JOIN categorias c ON c.id = d.categoria_id
     ORDER BY d.nome'
)->fetchAll();

$errors  = [];                                          // erros por campo
$old     = ['nome' => '', 'telemovel' => '', 'destino_id' => ''];  // valores submetidos
$sucesso = isset($_GET['ok']);                          // chegou aqui depois de gravar

// Processar a submissão do formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $old['nome']       = trim($_POST['nome'] ?? '');
    $old['telemovel']  = trim($_POST['telemovel'] ?? '');
    $old['destino_id'] = $_POST['destino_id'] ?? '';

    // Nome obrigatório
    if ($old['nome'] === '') {
        $errors['nome'] = ['pt' => 'Indique o seu nome.', 'en' => 'Please enter your name.'];
    }

    // Telemóvel: mesma regra do JS (9 dígitos, prefixo 91/92/93/96)
    if (!preg_match('/^9[1236]\d{7}$/', $old['telemovel'])) {
        $errors['telemovel'] = [
            'pt' => 'Telemóvel inválido (9 dígitos, começado por 91/92/93/96).',
            'en' => 'Invalid phone number (9 digits, starting with 91/92/93/96).',
        ];
    }

    // Destino: tem de ser um dos que vêm da BD
    $idsValidos = array_map('intval', array_column($destinos, 'id'));
    if ($old['destino_id'] === '' || !in_array((int) $old['destino_id'], $idsValidos, true)) {
        $errors['destino_id'] = ['pt' => 'Escolha um destino.', 'en' => 'Choose a destination.'];
    }

    // Sem erros -> grava e redireciona (padrão Post/Redirect/Get)
    if (!$errors) {
        $stmt = $pdo->prepare(
            'INSERT INTO pedidos (nome, telemovel, destino_id) VALUES (?, ?, ?)'
        );
        $stmt->execute([$old['nome'], $old['telemovel'], (int) $old['destino_id']]);

        // redireciona para a própria página: atualizar (F5) já não reenvia o pedido
        header('Location: planear.php?ok=1');
        exit;
    }
}

require __DIR__ . '/../includes/header.php';
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
        <?php if ($sucesso): ?>
          <p class="validation valid" data-pt="Pedido submetido com sucesso. Entraremos em contacto em breve."
            data-en="Request submitted successfully. We will get in touch soon.">
            Pedido submetido com sucesso. Entraremos em contacto em breve.</p>
        <?php endif; ?>
        <form id="planForm" method="post" action="planear.php" novalidate>
          <div>
            <label for="name" data-pt="Nome" data-en="Name">Nome</label>
            <input id="name" name="nome" type="text" value="<?= htmlspecialchars($old['nome']) ?>"
              data-placeholder-pt="Nome do viajante" data-placeholder-en="Traveller name" placeholder="Nome do viajante">
            <?php if (isset($errors['nome'])): ?>
              <small class="validation invalid" data-pt="<?= htmlspecialchars($errors['nome']['pt']) ?>" data-en="<?= htmlspecialchars($errors['nome']['en']) ?>"><?= htmlspecialchars($errors['nome']['pt']) ?></small>
            <?php endif; ?>
          </div>

          <div>
            <label for="number" data-pt="Telemóvel" data-en="Mobile Phone">Telemóvel</label>
            <input id="number" name="telemovel" type="text" maxlength="9" inputmode="numeric" value="<?= htmlspecialchars($old['telemovel']) ?>"
              data-placeholder-pt="Introduza 9 dígitos" data-placeholder-en="Enter 9 digits" placeholder="Introduza 9 dígitos">
            <small id="numberMessage" class="validation"></small>
            <?php if (isset($errors['telemovel'])): ?>
              <small class="validation invalid" data-pt="<?= htmlspecialchars($errors['telemovel']['pt']) ?>" data-en="<?= htmlspecialchars($errors['telemovel']['en']) ?>"><?= htmlspecialchars($errors['telemovel']['pt']) ?></small>
            <?php endif; ?>
          </div>

          <div>
            <label for="city" data-pt="Destino principal" data-en="Main destination">Destino principal</label>
            <select id="city" name="destino_id">
              <option value="" data-pt="Selecione" data-en="Select">Selecione</option>
              <?php foreach ($destinos as $d): ?>
                <option value="<?= (int) $d['id'] ?>" <?= (string) $old['destino_id'] === (string) $d['id'] ? 'selected' : '' ?>>
                  <?= htmlspecialchars($d['nome']) ?> (<?= htmlspecialchars($d['categoria']) ?>)
                </option>
              <?php endforeach; ?>
            </select>
            <?php if (isset($errors['destino_id'])): ?>
              <small class="validation invalid" data-pt="<?= htmlspecialchars($errors['destino_id']['pt']) ?>" data-en="<?= htmlspecialchars($errors['destino_id']['en']) ?>"><?= htmlspecialchars($errors['destino_id']['pt']) ?></small>
            <?php endif; ?>
          </div>

          <button id="submitRequest" type="submit" data-pt="Enviar pedido" data-en="Send request">Enviar
            pedido</button>
        </form>
      </section>
    </main>
    <footer>

    </footer>
<?php require __DIR__ . '/../includes/footer.php'; ?>
