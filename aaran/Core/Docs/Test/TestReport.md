
# 31-03-2025

## Tests:    36 passed (100 assertions)

PASS  Tests\Unit\ExampleTest
✓ that true is true                                                                                                                                                                                                        0.01s

PASS  Tests\Feature\Auth\AuthenticationTest
✓ login screen can be rendered                                                                                                                                                                                             7.48s  
✓ users can authenticate using the login screen                                                                                                                                                                            0.16s  
✓ users can not authenticate with invalid password                                                                                                                                                                         0.35s  
✓ users can logout                                                                                                                                                                                                         0.07s

PASS  Tests\Feature\Auth\EmailVerificationTest
✓ email verification screen can be rendered                                                                                                                                                                                0.07s  
✓ email can be verified                                                                                                                                                                                                    0.06s  
✓ email is not verified with invalid hash                                                                                                                                                                                  0.07s

PASS  Tests\Feature\Auth\PasswordConfirmationTest
✓ confirm password screen can be rendered                                                                                                                                                                                  0.15s  
✓ password can be confirmed                                                                                                                                                                                                0.11s  
✓ password is not confirmed with invalid password                                                                                                                                                                          0.32s

PASS  Tests\Feature\Auth\PasswordResetTest
✓ reset password link screen can be rendered                                                                                                                                                                               0.06s  
✓ reset password link can be requested                                                                                                                                                                                     0.10s  
✓ reset password screen can be rendered                                                                                                                                                                                    0.09s  
✓ password can be reset with valid token                                                                                                                                                                                   0.19s

PASS  Tests\Feature\Auth\RegistrationTest
✓ registration screen can be rendered                                                                                                                                                                                      0.08s  
✓ new users can register                                                                                                                                                                                                   0.16s

PASS  Tests\Feature\DashboardTest
✓ guests are redirected to the login page                                                                                                                                                                                  0.07s  
✓ authenticated users can visit the dashboard                                                                                                                                                                              0.08s

PASS  Tests\Feature\ExampleTest
✓ returns a successful response                                                                                                                                                                                            0.06s

PASS  Tests\Feature\Settings\PasswordUpdateTest
✓ password can be updated                                                                                                                                                                                                  0.25s  
✓ correct password must be provided to update password                                                                                                                                                                     0.17s

PASS  Tests\Feature\Settings\ProfileUpdateTest
✓ profile page is displayed                                                                                                                                                                                                0.14s  
✓ profile information can be updated                                                                                                                                                                                       0.14s  
✓ email verification status is unchanged when email address is unchanged                                                                                                                                                   0.14s  
✓ user can delete their account                                                                                                                                                                                            0.07s  
✓ correct password must be provided to delete account                                                                                                                                                                      0.12s

PASS  Aaran\Core\Sys\Tests\Feature\AaranApplicationTest
✓ application is running                                                                                                                                                                                                   0.06s  
✓ aaran service provider is registered                                                                                                                                                                                     0.05s  
✓ configuration is loaded                                                                                                                                                                                                  0.03s  
✓ application key is set                                                                                                                                                                                                   0.05s  
✓ database connection is working                                                                                                                                                                                           0.08s

PASS  Aaran\Core\Tenant\Tests\Feature\TenantCrudTest
✓ it can create a tenant with nullable fields                                                                                                                                                                              0.04s  
✓ it can read a tenant                                                                                                                                                                                                     0.06s  
✓ it can update a tenant                                                                                                                                                                                                   0.08s  
✓ it can delete a tenant  
