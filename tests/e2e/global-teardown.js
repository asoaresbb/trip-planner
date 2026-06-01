const { execSync } = require('child_process');

// Remove da BD os pedidos criados pelos testes e2e (não deixa lixo).
module.exports = async () => {
  try {
    execSync(
      'php -r \'$c=require "config/credentials.php";'
      + '$p=new PDO("mysql:host={$c["host"]};dbname={$c["dbname"]}",$c["user"],$c["pass"]);'
      + '$p->prepare("DELETE FROM pedidos WHERE nome = ?")->execute(["Playwright Teste"]);\'',
      { stdio: 'ignore' }
    );
  } catch (e) {
    // se falhar a limpeza, não faz o conjunto de testes falhar
  }
};
