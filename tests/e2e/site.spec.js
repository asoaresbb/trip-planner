const { test, expect } = require('@playwright/test');

// Funcionalidades client-side (JavaScript) herdadas do e-fólio A.
test.describe('Funcionalidades client-side', () => {

  test('alterna o idioma PT <-> EN', async ({ page }) => {
    await page.goto('/index.php');

    const langBtn = page.locator('#langToggle');
    await expect(langBtn).toHaveText('EN');                 // arranca em PT
    await expect(page.locator('nav a').first()).toHaveText('Início');

    await langBtn.click();                                   // muda para EN
    await expect(langBtn).toHaveText('PT');
    await expect(page.locator('nav a').first()).toHaveText('Home');
  });

  test('liga o modo escuro', async ({ page }) => {
    await page.goto('/index.php');
    await expect(page.locator('body')).not.toHaveClass(/dark/);

    await page.locator('#themeToggle').click();
    await expect(page.locator('body')).toHaveClass(/dark/);
  });

  test('a galeria abre o modal de imagem', async ({ page }) => {
    await page.goto('/lisboa.php');
    await page.locator('.gallery .photo img').first().click();
    await expect(page.locator('#imageModal')).toHaveClass(/open/);
  });
});
