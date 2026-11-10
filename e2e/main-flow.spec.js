import { test, expect } from '@playwright/test';

test('halaman utama ActiveHub bisa dibuka', async ({ page }) => {
  const response = await page.goto('/');
  expect(response.status()).toBeLessThan(400);
  await expect(page).toHaveTitle(/.+/);
});