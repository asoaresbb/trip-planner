const { defineConfig, devices } = require('@playwright/test');

// Configuração dos testes end-to-end.
// Arranca automaticamente um servidor PHP e corre os testes no Chromium.
module.exports = defineConfig({
  testDir: './tests/e2e',
  timeout: 30000,
  use: {
    baseURL: 'http://127.0.0.1:8788',
    headless: true,
  },
  projects: [
    { name: 'chromium', use: { ...devices['Desktop Chrome'] } },
  ],
  // servidor da aplicação para os testes
  webServer: {
    command: 'php -S 127.0.0.1:8788 -t public',
    url: 'http://127.0.0.1:8788/index.php',
    reuseExistingServer: true,
    timeout: 15000,
  },
  // limpa os pedidos de teste gravados na BD no fim
  globalTeardown: require.resolve('./tests/e2e/global-teardown.js'),
});
