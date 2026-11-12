import { Page, Locator, expect } from '@playwright/test';
import { BasePage } from './BasePage';

export class VenuePage extends BasePage {
  readonly venueCards: Locator;
  readonly searchInput: Locator;
  readonly slotCards: Locator;
  readonly bookButton: Locator;

  constructor(page: Page) {
    super(page);
    this.venueCards = page.locator('a[href^="/venues/"]');
    this.searchInput = page.getByPlaceholder(/Cari/i);
    this.slotCards = page.locator('.schedule-card');
    this.bookButton = page.getByRole('button', { name: 'Pesan' });
  }

  async gotoList() {
    await this.navigateTo('/venues');
    await expect(this.venueCards.first()).toBeVisible();
  }

  async openFirstVenue() {
    const firstVenue = this.venueCards.first();
    await firstVenue.click();
    await expect(this.page).toHaveURL(/\/venues\/\d+/);
  }

  async selectAvailableSlot() {
    await expect(this.slotCards.first()).toBeVisible();
    await this.slotCards.first().click();
  }

  async clickBook() {
    await expect(this.bookButton).toBeEnabled();
    await this.bookButton.click();
  }
}
