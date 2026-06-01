#!/usr/bin/env bash
# =====================================================================
#  Testes de aceitação (smoke) - páginas, API REST e sanidade da BD.
#  Arranca o seu próprio servidor PHP numa porta de teste, corre os
#  testes e desliga o servidor. Não altera os dados reais.
#
#  Uso:  ./tests/tests.sh   (a partir da raiz do projeto)
# =====================================================================
set -u
# corre a partir da raiz do projeto (este script está em tests/)
cd "$(dirname "$0")/.."

PORT=8799
BASE="http://127.0.0.1:$PORT"

php -S 127.0.0.1:$PORT -t public >/tmp/tests_srv.log 2>&1 &
SVPID=$!
trap 'kill $SVPID 2>/dev/null' EXIT
sleep 1

pass=0
fail=0
check() { # descrição  esperado  obtido
  if [ "$2" = "$3" ]; then
    printf '  PASS  %-45s %s\n' "$1" "$3"
    pass=$((pass + 1))
  else
    printf '  FAIL  %-45s (esperado %s, obtido %s)\n' "$1" "$2" "$3"
    fail=$((fail + 1))
  fi
}
code() { curl -s -o /dev/null -w '%{http_code}' "$@"; }

echo "== Páginas (HTTP 200) =="
for p in index destinos lisboa porto natureza planear about backoffice; do
  check "$p.php" 200 "$(code "$BASE/$p.php")"
done
check "tests.php" 200 "$(code "$BASE/tests.php")"

echo "== API REST =="
check "GET lista"            200 "$(code "$BASE/api/destinos.php")"
check "GET ?id=1"            200 "$(code "$BASE/api/destinos.php?id=1")"
check "GET ?id inexistente"  404 "$(code "$BASE/api/destinos.php?id=999999")"
check "PUT sem id"           400 "$(code -X PUT -d '{}' "$BASE/api/destinos.php")"
check "POST não suportado"   405 "$(code -X POST "$BASE/api/destinos.php")"

echo "== Formulário planear (validação no servidor) =="
# POST inválido (sem nome, telemóvel curto, sem destino) -> volta a mostrar a página (200), não grava
check "POST inválido devolve página" 200 "$(code -X POST -d 'nome=&telemovel=123&destino_id=' "$BASE/planear.php")"

echo "== Base de dados =="
DBOK=$(php -r '$c=require "config/credentials.php";try{$p=new PDO("mysql:host={$c["host"]};dbname={$c["dbname"]}",$c["user"],$c["pass"]);$cat=$p->query("SELECT COUNT(*) FROM categorias")->fetchColumn();$p->query("SELECT 1 FROM destinos LIMIT 1");$p->query("SELECT 1 FROM pedidos LIMIT 1");echo ($cat==4)?"OK":"NOK";}catch(Throwable $e){echo "NOK";}')
check "tabelas + 4 categorias" OK "$DBOK"

echo
echo "Resultado: $pass passaram, $fail falharam"
[ "$fail" -eq 0 ]
