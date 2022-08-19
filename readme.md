## Fraame

What to watch?

### Installation

```bash
cp .env.example .env
composer install
php artisan sail:install
php artisan sail-ssl:install
sail up -d
sail artisan key:generate
sail artisan migrate
sail npm install
sail npm run dev
```

### Notes

```
For import row count discrepancies

vi laravel-{Y-m-d}.log
enter command mode then type `/xlsx`

---

When creating a new data, movies can be queried by either `title` or `tmdbid:{id}`

example:
tmdbid:11645 for Ran (1985)
tmdbid:752 for V for Vendetta (2005)

---

Puppeteer dependencies https://gist.github.com/iceforeon/060bafb856ada51534c96fa256c8bca7
```

### Attribution

[TMDB](https://www.themoviedb.org)

[IMDB](https://www.imdb.com)

[Tiptap](https://tiptap.dev)
