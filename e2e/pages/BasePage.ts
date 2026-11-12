import { Page, expect, Locator } from '@playwright/test';

export abstract class BasePage {
  readonly page: Page;

  constructor(page: Page) {
    this.page = page;
  }

  /**
   * Helper navigasi ke path relatif terhadap baseURL
   */
  async navigateTo(path: string) {
    await this.page.goto(path);
  }

  /**
   * Web-first assertion untuk memastikan URL mengandung path tertentu
   */
  async expectURL(pathRegexOrString: string | RegExp) {
    await expect(this.page).toHaveURL(pathRegexOrString);
  }
}
