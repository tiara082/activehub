import { Page, Locator, expect } from '@playwright/test';
import { BasePage } from './BasePage';

export class BookingPaymentPage extends BasePage {
  readonly checkoutHeading: Locator;
  readonly orderDetailsHeading: Locator;
  readonly paymentMethodHeading: Locator;
  readonly qrisButton: Locator;
  readonly snapButton: Locator;
  readonly totalPriceText: Locator;

  constructor(page: Page) {
    super(page);
    this.checkoutHeading = page.getByRole('heading', { name: 'Checkout' });
    this.orderDetailsHeading = page.getByRole('heading', { name: 'Detail Pesanan' });
    this.paymentMethodHeading = page.getByRole('heading', { name: 'Metode Pembayaran' });
    this.qrisButton = page.locator('button[data-method="qris"]');
    this.snapButton = page.locator('button[data-method="snap"]');
    this.totalPriceText = page.locator('div:has-text("Rp ")').last();
  }

  async expectOnCheckoutPage() {
    await expect(this.page).toHaveURL(/\/payment\/\d+/);
    await expect(this.checkoutHeading).toBeVisible();
    await expect(this.orderDetailsHeading).toBeVisible();
    await expect(this.paymentMethodHeading).toBeVisible();
  }

  async selectPaymentMethod(method: 'qris' | 'snap') {
    if (method === 'qris') {
      await expect(this.qrisButton).toBeVisible();
      await this.qrisButton.click();
    } else {
      await expect(this.snapButton).toBeVisible();
      await this.snapButton.click();
    }
  }
}
