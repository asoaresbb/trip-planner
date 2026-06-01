<?php
$pageTitle = 'Back Office';
/** @var PDO $pdo */
$pdo = require __DIR__ . '/../config/db.php';

// Categorias para o select do formulário
$categorias = $pdo->query('SELECT id, nome FROM categorias ORDER BY nome')->fetchAll();

$errors  = [];
$old     = ['nome' => '', 'categoria_id' => '', 'descricao_pt' => '', 'descricao_en' => '', 'imagem' => ''];
$sucesso = isset($_GET['ok']);

// Processar a inserção de um novo destino
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($old as $campo => $_) {
        $old[$campo] = trim($_POST[$campo] ?? '');
    }

    if ($old['nome'] === '') {
        $errors['nome'] = 'Indique o nome do destino.';
    }
    if ($old['descricao_pt'] === '') {
        $errors['descricao_pt'] = 'Indique a descrição em português.';
    }
    if ($old['descricao_en'] === '') {
        $errors['descricao_en'] = 'Indique a descrição em inglês.';
    }
    $idsCategorias = array_map('intval', array_column($categorias, 'id'));
    if ($old['categoria_id'] === '' || !in_array((int) $old['categoria_id'], $idsCategorias, true)) {
        $errors['categoria_id'] = 'Escolha uma categoria.';
    }

    // Sem erros -> grava e redireciona (Post/Redirect/Get)
    if (!$errors) {
        $stmt = $pdo->prepare(
            'INSERT INTO destinos (nome, descricao_pt, descricao_en, imagem, categoria_id)
             VALUES (?, ?, ?, ?, ?)'
        );
        $stmt->execute([
            $old['nome'],
            $old['descricao_pt'],
            $old['descricao_en'],
            $old['imagem'] !== '' ? $old['imagem'] : null,  // imagem é opcional
            (int) $old['categoria_id'],
        ]);

        header('Location: backoffice.php?ok=1');
        exit;
    }
}

// Lista atual de destinos (para confirmar o que está na BD)
$destinos = $pdo->query(
    'SELECT d.nome, c.nome AS categoria
     FROM destinos d
     JOIN categorias c ON c.id = d.categoria_id
     ORDER BY d.id DESC'
)->fetchAll();

require __DIR__ . '/../includes/header.php';
?>
    <main class="container">
      <section class="hero">
        <div class="card hero-card">
          <p class="kicker">Back Office</p>
          <h1>Adicionar destino</h1>
          <p class="muted">Página de gestão: insere novos destinos na base de dados. Os destinos adicionados passam
            a aparecer automaticamente na página pública de destinos.</p>
        </div>
      </section>

      <section class="section">
        <?php if ($sucesso): ?>
          <p class="validation valid">Destino adicionado com sucesso.</p>
        <?php endif; ?>

        <form method="post" action="backoffice.php">
          <div>
            <label for="nome">Nome do destino</label>
            <input id="nome" name="nome" type="text" value="<?= htmlspecialchars($old['nome']) ?>" placeholder="Ex.: Sintra">
            <?php if (isset($errors['nome'])): ?>
              <small class="validation invalid"><?= htmlspecialchars($errors['nome']) ?></small>
            <?php endif; ?>
          </div>

          <div>
            <label for="categoria_id">Categoria</label>
            <select id="categoria_id" name="categoria_id">
              <option value="">Selecione</option>
              <?php foreach ($categorias as $c): ?>
                <option value="<?= (int) $c['id'] ?>" <?= (string) $old['categoria_id'] === (string) $c['id'] ? 'selected' : '' ?>>
                  <?= htmlspecialchars($c['nome']) ?>
                </option>
              <?php endforeach; ?>
            </select>
            <?php if (isset($errors['categoria_id'])): ?>
              <small class="validation invalid"><?= htmlspecialchars($errors['categoria_id']) ?></small>
            <?php endif; ?>
          </div>

          <div>
            <label for="descricao_pt">Descrição (português)</label>
            <textarea id="descricao_pt" name="descricao_pt" rows="3" placeholder="Descrição em português"><?= htmlspecialchars($old['descricao_pt']) ?></textarea>
            <?php if (isset($errors['descricao_pt'])): ?>
              <small class="validation invalid"><?= htmlspecialchars($errors['descricao_pt']) ?></small>
            <?php endif; ?>
          </div>

          <div>
            <label for="descricao_en">Descrição (inglês)</label>
            <textarea id="descricao_en" name="descricao_en" rows="3" placeholder="Description in English"><?= htmlspecialchars($old['descricao_en']) ?></textarea>
            <?php if (isset($errors['descricao_en'])): ?>
              <small class="validation invalid"><?= htmlspecialchars($errors['descricao_en']) ?></small>
            <?php endif; ?>
          </div>

          <div>
            <label for="imagem">Imagem (opcional)</label>
            <input id="imagem" name="imagem" type="text" value="<?= htmlspecialchars($old['imagem']) ?>" placeholder="Ex.: img/sintra.jpg">
          </div>

          <button type="submit">Adicionar destino</button>
        </form>
      </section>

      <section class="section">
        <h2>Destinos atuais</h2>
        <table class="table">
          <thead>
            <tr>
              <th>Nome</th>
              <th>Categoria</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($destinos as $d): ?>
              <tr>
                <td><?= htmlspecialchars($d['nome']) ?></td>
                <td><?= htmlspecialchars($d['categoria']) ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </section>
    </main>
    <footer>

    </footer>
<?php require __DIR__ . '/../includes/footer.php'; ?>
