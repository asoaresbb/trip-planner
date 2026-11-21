# Descobrir Portugal — trip-planner

Site sobre turismo em Portugal, desenvolvido para a unidade curricular de
**Laboratório de Sistemas e Serviços Web**.

- **e-fólio A**: site client-side (HTML, CSS, JavaScript).
- **e-fólio B**: componente do lado do servidor em **PHP**, com persistência em
  **MySQL**, um back office e uma pequena API REST.

## Requisitos

- PHP 8+ (com extensão `pdo_mysql`)
- MySQL 8 / MariaDB
- Node.js (apenas para os testes end-to-end com Playwright)

## Instalação

1. **Palavra-passe** — escolher uma palavra-passe para o utilizador `lei` e
   pô-la no [`database.sql`](database.sql), no lugar de `MUDAR_AQUI` (aparece
   duas vezes).

2. **Base de dados** — no MySQL Workbench (ligado como root), executar o
   `database.sql`. Ele cria a base de dados `trip_planner`, o utilizador `lei`,
   as tabelas e os dados iniciais.

3. **Credenciais** — copiar `config/credentials.example.php` para
   `config/credentials.php` (ignorado pelo git) e pôr lá a mesma palavra-passe.
   A aplicação liga como o utilizador `lei`.

4. **Arrancar o site** (o document root é a pasta `public/`):

   ```bash
   php -S localhost:8000 -t public
   ```

   Abrir <http://localhost:8000/index.php>.

## Estrutura

O document root é `public/`; tudo o resto (config, credenciais, includes, SQL,
testes) fica **fora** do alcance do browser.

```
public/                    document root (único servido pelo browser)
├── index.php  destinos.php  lisboa.php  porto.php  natureza.php
├── planear.php  backoffice.php  about.php
├── tests.php              página de testes (BD/integridade)
├── api/destinos.php       API REST (GET + PUT)
└── css/  js/  img/        recursos estáticos
config/                    db.php + credentials.php   (privado)
includes/                  header.php + footer.php
database.sql               script de criação/inicialização da BD (privado)
tests/                     tests.sh + e2e/ (Playwright)
```

| Caminho | Descrição |
|---|---|
| `public/*.php` | páginas públicas (conteúdo dinâmico da BD) |
| `public/api/destinos.php` | API REST (GET + PUT) sobre os destinos |
| `config/db.php`, `config/credentials.php` | ligação PDO (fora do web root) |
| `includes/header.php`, `includes/footer.php` | cabeçalho e rodapé partilhados |
| `database.sql` | script de criação e inicialização da BD (fora do web root) |

### Base de dados

Três tabelas relacionadas por chaves estrangeiras (motor InnoDB):

- `categorias` (tipos de destino) → `destinos` (FK `categoria_id`) → `pedidos` (FK `destino_id`).

### API REST

Recurso `destinos`, respostas em JSON:

```bash
# consultar todos
curl http://localhost:8000/api/destinos.php

# consultar um
curl "http://localhost:8000/api/destinos.php?id=2"

# atualizar (corpo JSON)
curl -X PUT -H "Content-Type: application/json" \
  -d '{"nome":"Porto","descricao_pt":"...","descricao_en":"...","categoria_id":1}' \
  "http://localhost:8000/api/destinos.php?id=2"
```

Códigos de estado: `200` ok · `400` dados inválidos · `404` não encontrado · `405` método não suportado.

## Segurança

- **SQL injection** — todas as interrogações usam *prepared statements* do PDO.
- **XSS** — todos os dados são escapados na saída com `htmlspecialchars()`.
- Validação feita no servidor; chaves estrangeiras garantem integridade; o
  utilizador `lei` tem permissões limitadas apenas a esta base de dados.

## Testes

Estratégia em três níveis (pirâmide de testes):

| Nível | Ficheiro | Como correr | Como sei que passou |
|---|---|---|---|
| Unitário + Integração (BD) | `public/tests.php` | abrir no browser <http://localhost:8000/tests.php> | a tabela mostra **8/8 testes passaram** (a verde) e cada linha em **PASS** |
| Integração — HTTP (páginas + API) | `tests/tests.sh` | no terminal: `./tests/tests.sh` | termina com **Resultado: 16 passaram, 0 falharam** (e código de saída 0) |
| End-to-end (browser) | `tests/e2e/*.spec.js` | no terminal: `npm run test:e2e` (antes, uma vez: ver abaixo) | o Playwright imprime **5 passed** (a verde) |

Antes dos testes end-to-end, uma vez por máquina:

```bash
npm install                       # descarrega as dependências do package-lock.json para node_modules/
npx playwright install chromium   # descarrega o browser que o Playwright usa
```

A pasta `node_modules/` não vai no git: o `package.json` diz que pacotes são
precisos e o `package-lock.json` fixa as versões exatas, e o `npm install`
recria-a a partir daí. Os browsers não vêm no pacote do Playwright, por isso
descarregam-se à parte. O servidor PHP tem de estar a correr.

Notas sobre "como sei que passou":

- **`public/tests.php`** — corre ao abrir o URL; basta **atualizar (F5)** para correr de novo. Verde = tudo passou; qualquer linha a vermelho (**FAIL**) mostra a mensagem do erro ao lado.
- **`tests/tests.sh`** — cada verificação imprime `PASS`/`FAIL`; no fim dá a contagem. Em terminal, `echo $?` devolve `0` se passou tudo (útil para automação/CI).
- **`npm run test:e2e`** — falha com código diferente de 0 e lista os testes que falharam; para ver passo a passo no browser, usar `npx playwright test --headed`, e para o relatório visual `npx playwright show-report`.

Os testes de escrita usam transações com *rollback* ou limpam os dados que
criam, por isso não alteram a informação real da base de dados.
