# Suka News Tiga

Tema klasik WordPress untuk portal berita keluarga Suka News.

## Fitur utama

- Header 3 baris: tanggal/menu sekunder, logo/banner, menu utama/sosial.
- Homepage multi-section: slider, list berita, banner, berita utama, dan sidebar.
- Template single, archive, search, page, 404, dan sidebar.
- Integrasi plugin Suka Core untuk banner, views, share, SEO, dan schema.

## Opsi Customizer

- **Warna → Warna Teks** (`suka_news_satu_text_color`, bawaan `#1f2937`): warna teks isi di seluruh halaman. Dikirim sebagai `--color-text` dan dipakai `body`, sehingga semua teks yang tidak punya warna khusus ikut berubah. Judul berita di semua template (beranda, single, arsip, terkait, 404, berita pilihan) serta heading di dalam isi artikel juga memakai warna ini. Yang tetap memakai `--color-base` hanya elemen navigasi: menu, ticker, tombol header, kotak cari, nomor halaman, navigasi antar-pos, tag, dan judul komentar.
- **Header → Tampilkan ticker berita terkini** (`suka_news_satu_ticker`, default aktif): mematikannya menghilangkan baris berjalan di bawah menu utama sekaligus melewati query 8 berita terbarunya.

## Akun sosial

Section **Footer dan Akun Sosial** menyediakan URL dan warna untuk Facebook, Instagram, X, YouTube, TikTok, Threads, dan WhatsApp. Yang diisi saja yang tampil, urutannya mengikuti urutan di `suka_news_satu_get_social_links()`.

## Quality gate

```bash
php -d zend.assertions=1 -d assert.exception=1 tests/test-theme-contract.php
find . -name '*.php' -not -path './.git/*' -print0 | xargs -0 -n1 php -l
```
