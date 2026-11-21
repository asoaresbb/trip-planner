# Descobrir Portugal — trip-planner

A tourism site about Portugal, built for the Web Systems and Services Lab
course (**Laboratório de Sistemas e Serviços Web**) at Universidade Aberta.

- **e-fólio A** (first assignment): client-side site (HTML, CSS, JavaScript).
- **e-fólio B** (second assignment): server-side component in **PHP**, with
  **MySQL** persistence, a back office and a small REST API.

## Requirements

- PHP 8+ (with the `pdo_mysql` extension)
- MySQL 8 / MariaDB
- Node.js (only for the end-to-end tests with Playwright)

## Setup

1. **Password**: choose a password for the `lei` user and put it in
   [`database.sql`](database.sql), in place of `MUDAR_AQUI` (it appears
   twice).

2. **Database**: in MySQL Workbench (connected as root), run
   `database.sql`. It creates the `trip_planner` database, the `lei` user,
   the tables and the initial data.

3. **Credentials**: copy `config/credentials.example.php` to
   `config/credentials.php` (ignored by git) and put the same password there.
   The application connects as the `lei` user.

4. **Start the site** (the document root is the `public/` folder):

   ```bash
   php -S localhost:8000 -t public
   ```

   Open <http://localhost:8000/index.php>.

## Structure

The document root is `public/`; everything else (config, credentials,
includes, SQL, tests) stays **out of** the browser's reach.

```
public/                    document root (the only folder the browser can reach)
├── index.php  destinos.php  lisboa.php  porto.php  natureza.php
├── planear.php  backoffice.php  about.php
├── tests.php              test page (database/integrity)
├── api/destinos.php       REST API (GET + PUT)
└── css/  js/  img/        static assets
config/                    db.php + credentials.php   (private)
includes/                  header.php + footer.php
database.sql               database creation/initialisation script (private)
tests/                     tests.sh + e2e/ (Playwright)
```

| Path | Description |
|---|---|
| `public/*.php` | public pages (dynamic content from the database) |
| `public/api/destinos.php` | REST API (GET + PUT) for the destinations |
| `config/db.php`, `config/credentials.php` | PDO connection (outside the web root) |
| `includes/header.php`, `includes/footer.php` | shared header and footer |
| `database.sql` | database creation and initialisation script (outside the web root) |

### Database

Three tables linked by foreign keys (InnoDB engine):

- `categorias` (destination types) → `destinos` (FK `categoria_id`) → `pedidos` (FK `destino_id`).

### REST API

`destinos` resource, JSON responses:

```bash
# get all
curl http://localhost:8000/api/destinos.php

# get one
curl "http://localhost:8000/api/destinos.php?id=2"

# update (JSON body)
curl -X PUT -H "Content-Type: application/json" \
  -d '{"nome":"Porto","descricao_pt":"...","descricao_en":"...","categoria_id":1}' \
  "http://localhost:8000/api/destinos.php?id=2"
```

Status codes: `200` OK · `400` invalid data · `404` not found · `405` method not allowed.

## Security

- **SQL injection**: every query uses PDO *prepared statements*.
- **XSS**: all data is escaped on output with `htmlspecialchars()`.
- Validation happens on the server; foreign keys guarantee integrity; the
  `lei` user only has permissions on this database.

## Tests

A three-level strategy (test pyramid):

| Level | File | How to run | How I know it passed |
|---|---|---|---|
| Unit + integration (database) | `public/tests.php` | open <http://localhost:8000/tests.php> in the browser | the table shows **8/8 testes passaram** (in green) and every row says **PASS** |
| Integration: HTTP (pages + API) | `tests/tests.sh` | in the terminal: `./tests/tests.sh` | ends with **Resultado: 16 passaram, 0 falharam** (and exit code 0) |
| End-to-end (browser) | `tests/e2e/*.spec.js` | in the terminal: `npm run test:e2e` (first, once: see below) | Playwright prints **5 passed** (in green) |

Before the end-to-end tests, once per machine:

```bash
npm install                       # downloads the dependencies in package-lock.json into node_modules/
npx playwright install chromium   # downloads the browser Playwright uses
```

The `node_modules/` folder isn't in git: `package.json` lists the packages
needed and `package-lock.json` pins their exact versions, and `npm install`
rebuilds the folder from them. The browsers don't ship with the Playwright
package, so they're downloaded separately. The PHP server must be running.

Notes on "how I know it passed":

- **`public/tests.php`** runs when you open the URL; just **refresh (F5)** to run it again. Green means everything passed; any red row (**FAIL**) shows the error message next to it.
- **`tests/tests.sh`** prints `PASS`/`FAIL` for each check and the count at the end. In a terminal, `echo $?` returns `0` if everything passed (useful for automation/CI).
- **`npm run test:e2e`** fails with a non-zero exit code and lists the tests that failed; to watch it step by step in the browser, use `npx playwright test --headed`, and for the visual report `npx playwright show-report`.

The tests that write data use transactions with *rollback* or clean up the
data they create, so they don't change the real data in the database.
