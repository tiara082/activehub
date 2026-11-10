import { test, expect } from '@playwright/test';

const USER = {
  login: 'e2e-user@activehub.test',
  password: 'user123',
};

test('Main flow: login -> venue -> booking -> payment', async ({ page }) => {
  // 1. Login
  await page.goto('/login');
  await page.locator('#login').fill(USER.login);
  await page.locator('#password').fill(USER.password);
  await page.getByRole('button', { name: 'Masuk', exact: true }).click();

  await page.waitForURL((url) => !url.pathname.includes('/login'));

  // 2. Pilih venue
  await page.goto('/venues');

  const venueLink = page
    .locator('a[href*="/venues/"]:not([href*="nearby"]):not([href*="create"]):not([href*="fields"])')
    .first();

  await expect(venueLink).toBeVisible();
  await venueLink.click();

  await expect(page).toHaveURL(/\/venues\/\d+/);

  // 3. Pilih jadwal
  const slot = page.locator('.schedule-card').first();

  await expect(slot).toBeVisible();
  await slot.click();

  // 4. Booking
  await expect(page.locator('#bookingBar')).toBeVisible();
  await expect(page.locator('#selectedSlotId')).not.toHaveValue('');

  await page.locator('#bookingBar')
    .getByRole('button', { name: 'Pesan' })
    .click();

  // 5. Payment
  await expect(page).toHaveURL(/\/payment\/\d+/);
});
