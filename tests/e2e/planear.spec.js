const { test, expect } = require('@playwright/test');

test.describe('Página Planear', () => {

  test('valida o telemóvel ao vivo', async ({ page }) => {
    await page.goto('/planear.php');
    const number = page.locator('#number');
    const msg = page.locator('#numberMessage');

    await number.fill('123456789');                 // 9 dígitos, prefixo inválido
    await expect(msg).toHaveClass('validation invalid');

    await number.fill('912345678');                 // válido (91...)
    await expect(msg).toHaveClass('validation valid');
  });

  test('submete um pedido válido, grava e mostra confirmação', async ({ page }) => {
    await page.goto('/planear.php');
    await page.locator('#name').fill('Playwright Teste');
    await page.locator('#number').fill('912345678');
    await page.locator('#city').selectOption({ index: 1 });   // primeiro destino real
    await page.locator('#submitRequest').click();

    await expect(page).toHaveURL(/ok=1/);                      // Post/Redirect/Get
    await expect(page.locator('.validation.valid')).toBeVisible();
  });
});
