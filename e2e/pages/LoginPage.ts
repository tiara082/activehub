import { Page, Locator, expect } from '@playwright/test';
import { BasePage } from './BasePage';

export class LoginPage extends BasePage {
  readonly loginInput: Locator;
  readonly passwordInput: Locator;
  readonly submitButton: Locator;
  readonly errorMessage: Locator;
  readonly pageHeading: Locator;

  constructor(page: Page) {
    super(page);
    // User-facing resilient locators
    this.loginInput = page.getByLabel('Email / No. Hp');
    this.passwordInput = page.getByLabel('Password');
    this.submitButton = page.getByRole('button', { name: 'Masuk' });
    this.errorMessage = page.locator('.error-text');
    this.pageHeading = page.getByRole('heading', { name: /Masuk/i });
  }

  async goto() {
    await this.navigateTo('/login');
    await expect(this.submitButton).toBeVisible();
  }

  async login(loginValue: string, pass: string) {
    await this.loginInput.fill(loginValue);
    await this.passwordInput.fill(pass);
    await this.submitButton.click();
  }

  async expectSuccessLogin() {
    // Web-first assertion auto-waiting redirect ke dashboard pengguna
    await expect(this.page).toHaveURL(/\/user\/dashboard/);
  }

  async expectLoginError(expectedText?: string) {
    await expect(this.page).toHaveURL(/\/login/);
    if (expectedText) {
      await expect(this.page.getByText(expectedText)).toBeVisible();
    }
  }
}
