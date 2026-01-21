# TODO: Buat Tampilan Login User dengan Registrasi Wajib

## Langkah-langkah:
1. **Edit register.php**: Ubah input username menjadi email, update query database.
2. **Buat login_user.php**: Halaman login untuk user dengan input email dan password.
3. **Buat proses_login_user.php**: Proses verifikasi login user berdasarkan email.
4. **Update index.php**: Tambah link login dan register user di navbar.
5. **Test Implementasi**: Uji registrasi dan login user.

## Status:
- [x] Langkah 1: Edit register.php
- [x] Langkah 2: Buat login_user.php
- [x] Langkah 3: Buat proses_login_user.php
- [x] Langkah 4: Update index.php
- [ ] Langkah 5: Test Implementasi

## Catatan:
- Asumsikan tabel database `users` memiliki kolom `email` (ubah dari `username` jika perlu: `ALTER TABLE users CHANGE username email VARCHAR(255);`).
