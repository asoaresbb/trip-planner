<?php
// =====================================================================
//  Página de testes (browser) - base de dados e integridade dos dados.
//  Aceder em: http://localhost:8000/tests/tests.php
//  Para os testes HTTP de páginas + API, usar tests/tests.sh.
//  Os testes de escrita usam transações com ROLLBACK -> não alteram os
//  dados reais.
// =====================================================================
/** @var PDO $pdo */
$pdo = require __DIR__ . '/../config/db.php';

$resultados = [];
function teste(array &$r, string $tipo, string $nome, callable $fn): void
{
    try {
        $r[] = ['tipo' => $tipo, 'nome' => $nome, 'ok' => (bool) $fn(), 'msg' => ''];
    } catch (Throwable $e) {
        $r[] = ['tipo' => $tipo, 'nome' => $nome, 'ok' => false, 'msg' => $e->getMessage()];
    }
}

// --- Unitário: regra isolada, sem BD ---------------------------------
// Validação do telemóvel (mesma regra do site): 9 dígitos, prefixo 91/92/93/96
teste($resultados, 'Unitário', 'Regra do telemóvel aceita válidos e rejeita inválidos', function () {
    $valida = fn($n) => (bool) preg_match('/^9[1236]\d{7}$/', $n);
    return $valida('912345678') && $valida('961112223')
        && !$valida('123456789') && !$valida('91234') && !$valida('990000000');
});

// --- Integração: PHP comunicando com a base de dados ---------------------
teste($resultados, 'Integração', 'Ligação à BD (PDO)', fn() => $pdo->query('SELECT 1')->fetchColumn() == 1);

teste($resultados, 'Integração', 'categorias tem os 4 slugs esperados', function () use ($pdo) {
    $slugs = $pdo->query('SELECT slug FROM categorias ORDER BY slug')->fetchAll(PDO::FETCH_COLUMN);
    return $slugs === ['cidade', 'costa', 'interior', 'natureza'];
});

teste($resultados, 'Integração', 'destinos tem registos e faz JOIN a categorias', function () use ($pdo) {
    return $pdo->query('SELECT COUNT(*) FROM destinos d JOIN categorias c ON c.id = d.categoria_id')->fetchColumn() >= 1;
});

teste($resultados, 'Integração', 'pedidos existe e é consultável', function () use ($pdo) {
    $pdo->query('SELECT COUNT(*) FROM pedidos');
    return true;
});

teste($resultados, 'Integração', 'FK destinos→categorias rejeita categoria inexistente', function () use ($pdo) {
    $pdo->beginTransaction();
    try {
        $pdo->prepare('INSERT INTO destinos (nome, descricao_pt, descricao_en, categoria_id) VALUES (?,?,?,?)')
            ->execute(['TST', 'x', 'y', 999999]);
        return false; // não devia deixar inserir
    } catch (PDOException $e) {
        return true;  // rejeitado = correto
    } finally {
        if ($pdo->inTransaction()) $pdo->rollBack();
    }
});

teste($resultados, 'Integração', 'FK pedidos→destinos rejeita destino inexistente', function () use ($pdo) {
    $pdo->beginTransaction();
    try {
        $pdo->prepare('INSERT INTO pedidos (nome, telemovel, destino_id) VALUES (?,?,?)')
            ->execute(['Teste', '912345678', 999999]);
        return false;
    } catch (PDOException $e) {
        return true;
    } finally {
        if ($pdo->inTransaction()) $pdo->rollBack();
    }
});

teste($resultados, 'Integração', 'INSERT válido num pedido (rollback)', function () use ($pdo) {
    $pdo->beginTransaction();
    try {
        $destinoId = $pdo->query('SELECT id FROM destinos LIMIT 1')->fetchColumn();
        $pdo->prepare('INSERT INTO pedidos (nome, telemovel, destino_id) VALUES (?,?,?)')
            ->execute(['Teste', '912345678', $destinoId]);
        return $pdo->lastInsertId() > 0;
    } finally {
        if ($pdo->inTransaction()) $pdo->rollBack();
    }
});

$total = count($resultados);
$ok    = count(array_filter($resultados, fn($r) => $r['ok']));
?>
<!DOCTYPE html>
<html lang="pt-PT">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Testes - Descobrir Portugal</title>
    <link rel="stylesheet" href="css/styles.css">
  </head>

  <body>
    <main class="container">
      <section class="hero">
        <div class="card hero-card">
          <p class="kicker">Qualidade</p>
          <h1>Testes (base de dados e integridade)</h1>
          <p class="muted">Verificações automáticas à base de dados (tabelas, chaves estrangeiras, inserções) e à
            regra de validação. Os testes de escrita usam transações com <em>rollback</em>, por isso não alteram os
            dados reais. Para os testes HTTP de páginas e API, executa <code>tests/tests.sh</code>.</p>
        </div>
      </section>
      <section class="section">
        <p class="validation <?= $ok === $total ? 'valid' : 'invalid' ?>">
          Resultado: <?= $ok ?>/<?= $total ?> testes passaram.
        </p>
        <table class="table">
          <thead>
            <tr><th>Tipo</th><th>Teste</th><th>Resultado</th></tr>
          </thead>
          <tbody>
            <?php foreach ($resultados as $r): ?>
              <tr>
                <td><span class="tag"><?= htmlspecialchars($r['tipo']) ?></span></td>
                <td><?= htmlspecialchars($r['nome']) ?><?= $r['msg'] !== '' ? ' — ' . htmlspecialchars($r['msg']) : '' ?></td>
                <td><span class="<?= $r['ok'] ? 'pass' : 'fail' ?>"><?= $r['ok'] ? 'PASS' : 'FAIL' ?></span></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
        <p class="muted">Outros níveis da pirâmide correm fora desta página: <strong>Integração HTTP</strong>
          (páginas + API) em <code>tests/tests.sh</code>, e <strong>End-to-end</strong> no browser em
          <code>tests/e2e/</code> (Playwright).</p>
      </section>
    </main>
  </body>

</html>
