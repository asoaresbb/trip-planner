<?php
// =====================================================================
//  API REST - recurso "destinos"
//  GET  api/destinos.php           -> lista todos os destinos
//  GET  api/destinos.php?id=N      -> consulta um destino
//  PUT  api/destinos.php?id=N      -> atualiza um destino (corpo em JSON)
//  Respostas em JSON.
// =====================================================================

header('Content-Type: application/json; charset=utf-8');

/** @var PDO $pdo */
$pdo = require __DIR__ . '/../../config/db.php';

// pequena ajuda para responder em JSON e terminar
function responder(int $codigo, $dados): void
{
    http_response_code($codigo);
    echo json_encode($dados, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    exit;
}

$metodo = $_SERVER['REQUEST_METHOD'];

// ---------------------------------------------------------------------
// GET -> consulta
// ---------------------------------------------------------------------
if ($metodo === 'GET') {
    $id = $_GET['id'] ?? null;

    if ($id !== null) {
        // um destino
        $stmt = $pdo->prepare(
            'SELECT d.id, d.nome, d.descricao_pt, d.descricao_en, d.imagem, c.nome AS categoria
             FROM destinos d JOIN categorias c ON c.id = d.categoria_id
             WHERE d.id = ?'
        );
        $stmt->execute([(int) $id]);
        $destino = $stmt->fetch();

        if (!$destino) {
            responder(404, ['erro' => 'Destino não encontrado.']);
        }
        responder(200, $destino);
    }

    // todos os destinos
    $destinos = $pdo->query(
        'SELECT d.id, d.nome, d.descricao_pt, d.descricao_en, d.imagem, c.nome AS categoria
         FROM destinos d JOIN categorias c ON c.id = d.categoria_id
         ORDER BY d.id'
    )->fetchAll();

    responder(200, $destinos);
}

// ---------------------------------------------------------------------
// PUT -> manipulação (atualizar um destino existente)
// ---------------------------------------------------------------------
if ($metodo === 'PUT') {
    $id = $_GET['id'] ?? null;
    if ($id === null) {
        responder(400, ['erro' => 'Falta o parâmetro id (ex.: ?id=1).']);
    }

    // o corpo de um PUT vem em php://input, aqui em JSON
    $corpo = json_decode(file_get_contents('php://input'), true);
    if (!is_array($corpo)) {
        responder(400, ['erro' => 'Corpo do pedido inválido (esperado JSON).']);
    }

    $nome         = trim($corpo['nome'] ?? '');
    $descricao_pt = trim($corpo['descricao_pt'] ?? '');
    $descricao_en = trim($corpo['descricao_en'] ?? '');
    $imagem       = isset($corpo['imagem']) ? trim($corpo['imagem']) : '';
    $categoria_id = $corpo['categoria_id'] ?? null;

    // validação
    $erros = [];
    if ($nome === '')         $erros[] = 'nome é obrigatório';
    if ($descricao_pt === '') $erros[] = 'descricao_pt é obrigatório';
    if ($descricao_en === '') $erros[] = 'descricao_en é obrigatório';

    $cat = $pdo->prepare('SELECT id FROM categorias WHERE id = ?');
    $cat->execute([(int) $categoria_id]);
    if (!$cat->fetch()) {
        $erros[] = 'categoria_id inválido';
    }

    if ($erros) {
        responder(400, ['erros' => $erros]);
    }

    // o destino a atualizar tem de existir
    $chk = $pdo->prepare('SELECT id FROM destinos WHERE id = ?');
    $chk->execute([(int) $id]);
    if (!$chk->fetch()) {
        responder(404, ['erro' => 'Destino não encontrado.']);
    }

    // atualizar (prepared statement)
    $upd = $pdo->prepare(
        'UPDATE destinos
         SET nome = ?, descricao_pt = ?, descricao_en = ?, imagem = ?, categoria_id = ?
         WHERE id = ?'
    );
    $upd->execute([
        $nome,
        $descricao_pt,
        $descricao_en,
        $imagem !== '' ? $imagem : null,
        (int) $categoria_id,
        (int) $id,
    ]);

    // devolver o registo já atualizado
    $stmt = $pdo->prepare(
        'SELECT d.id, d.nome, d.descricao_pt, d.descricao_en, d.imagem, c.nome AS categoria
         FROM destinos d JOIN categorias c ON c.id = d.categoria_id
         WHERE d.id = ?'
    );
    $stmt->execute([(int) $id]);
    responder(200, ['mensagem' => 'Destino atualizado.', 'destino' => $stmt->fetch()]);
}

// ---------------------------------------------------------------------
// Qualquer outro método não é suportado
// ---------------------------------------------------------------------
header('Allow: GET, PUT');
responder(405, ['erro' => 'Método não suportado. Use GET ou PUT.']);
