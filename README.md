# Suka News Tiga

Tema klasik WordPress untuk portal berita keluarga Suka News.

## Fitur utama

- Header 3 baris: tanggal/menu sekunder, logo/banner, menu utama/sosial.
- Homepage multi-section: slider, list berita, banner, berita utama, dan sidebar.
- Template single, archive, search, page, 404, dan sidebar.
- Integrasi plugin Suka Core untuk banner, views, share, SEO, dan schema.

## Opsi Customizer

- **Header → Tampilkan ticker berita terkini** (`suka_news_satu_ticker`, default aktif): mematikannya menghilangkan baris berjalan di bawah menu utama sekaligus melewati query 8 berita terbarunya.

## Quality gate

```bash
php -d zend.assertions=1 -d assert.exception=1 tests/test-theme-contract.php
find . -name '*.php' -not -path './.git/*' -print0 | xargs -0 -n1 php -l
```
