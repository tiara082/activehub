import { test, expect } from '@playwright/test';
import { RegisterPage } from '../pages/RegisterPage';
import { LoginPage } from '../pages/LoginPage';

test.describe('Critical Flow 1: User Onboarding & Authentication Flow', () => {
  let registerPage: RegisterPage;
  let loginPage: LoginPage;

  test.beforeEach(async ({ page }) => {
    registerPage = new RegisterPage(page);
    loginPage = new LoginPage(page);
  });

  test('New user can successfully register with valid details', async () => {
    // Generate deterministic yet isolated dynamic user data
    const timestamp = Date.now();
    const uniqueEmail = `testuser_${timestamp}@polinema.ac.id`;
    const uniquePhone = `8123${String(timestamp).slice(-7)}`;

    await registerPage.goto();
    await registerPage.register({
      name: `QA Student ${timestamp.toString().slice(-4)}`,
      email: uniqueEmail,
      phone: uniquePhone,
      gender: 'male',
      password: 'Password123!',
    });

    // Web-First Assertion: redirect ke login page dengan flash notification
    await registerPage.expectRegistrationSuccess();
  });

  test('Existing user can successfully log in and reach user dashboard', async () => {
    // Menggunakan credential akun terdaftar (seeder / default test user)
    await loginPage.goto();
    await loginPage.login('rizkypratama@gmail.com', 'rizky123');

    // Web-First Assertion: redirect ke dashboard pengguna
    await loginPage.expectSuccessLogin();
    await expect(loginPage.page.getByRole('heading', { level: 1 })).toBeVisible();
  });

  test('User cannot log in with invalid credentials (negative test)', async () => {
    await loginPage.goto();
    await loginPage.login('invalid_user@activehub.test', 'WrongPassword123');

    // Web-First Assertion: tetap di login page dan pesan error tampil
    await loginPage.expectLoginError('Email / No. HP atau password salah.');
  });
});
