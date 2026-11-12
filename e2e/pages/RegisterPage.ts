import { Page, Locator, expect } from '@playwright/test';
import { BasePage } from './BasePage';

export interface RegisterUserData {
  name: string;
  email: string;
  phone: string;
  gender: 'male' | 'female';
  password: string;
}

export class RegisterPage extends BasePage {
  readonly nameInput: Locator;
  readonly emailInput: Locator;
  readonly phoneInput: Locator;
  readonly genderSelect: Locator;
  readonly passwordInput: Locator;
  readonly passwordConfirmInput: Locator;
  readonly submitButton: Locator;

  constructor(page: Page) {
    super(page);
    // User-facing resilient locators
    this.nameInput = page.getByLabel('Nama Lengkap');
    this.emailInput = page.getByLabel('Email');
    this.phoneInput = page.getByLabel('Nomor HP');
    this.genderSelect = page.getByLabel('Gender / Jenis Kelamin');
    this.passwordInput = page.getByLabel('Password');
    this.passwordConfirmInput = page.getByLabel('Konfirmasi Password');
    this.submitButton = page.getByRole('button', { name: 'Buat Akun' });
  }

  async goto() {
    await this.navigateTo('/register');
    await expect(this.submitButton).toBeVisible();
  }

  async register(data: RegisterUserData) {
    await this.nameInput.fill(data.name);
    await this.emailInput.fill(data.email);
    await this.phoneInput.fill(data.phone);
    await this.genderSelect.selectOption(data.gender);
    await this.passwordInput.fill(data.password);
    await this.passwordConfirmInput.fill(data.password);
    await this.submitButton.click();
  }

  async expectRegistrationSuccess() {
    // Assert redirect ke login page dengan flash message
    await expect(this.page).toHaveURL(/\/login/);
    await expect(this.page.getByText(/Registrasi berhasil/i)).toBeVisible();
  }
}
