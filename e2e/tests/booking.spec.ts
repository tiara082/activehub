import { test, expect } from '@playwright/test';
import { LoginPage } from '../pages/LoginPage';
import { VenuePage } from '../pages/VenuePage';
import { BookingPaymentPage } from '../pages/BookingPaymentPage';

test.describe('Critical Flow 2: Venue Exploration, Slot Selection & Booking Transaction Flow', () => {
  let loginPage: LoginPage;
  let venuePage: VenuePage;
  let paymentPage: BookingPaymentPage;

  test.beforeEach(async ({ page }) => {
    loginPage = new LoginPage(page);
    venuePage = new VenuePage(page);
    paymentPage = new BookingPaymentPage(page);

    // Otentikasi sebelum memulai transaksi reservasi lapangan
    await loginPage.goto();
    await loginPage.login('rizkypratama@gmail.com', 'rizky123');
    await loginPage.expectSuccessLogin();
  });

  test('User can browse venues, select an available court slot, and initiate booking to checkout page', async ({ page }) => {
    // 1. Navigasi ke katalog venue
    await venuePage.gotoList();

    // 2. Pilih venue pertama
    await venuePage.openFirstVenue();

    // 3. Verifikasi jadwal lapangan tersedia dan pilih slot
    await venuePage.selectAvailableSlot();

    // 4. Klik tombol pesan untuk melakukan booking
    await venuePage.clickBook();

    // 5. Web-first assertion: pastikan sampai pada halaman checkout/pembayaran
    await paymentPage.expectOnCheckoutPage();

    // 6. Pilih metode pembayaran QRIS & validasi interaksi UI
    await paymentPage.selectPaymentMethod('qris');
    await expect(page.locator('button[data-method="qris"]')).toHaveClass(/border/);
  });
});
