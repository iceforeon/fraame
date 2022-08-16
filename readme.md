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
Searching for movies can be done by `title` or `tmdbid`
```

### Attribution

[TMDB](https://www.themoviedb.org)

[IMDB](https://www.imdb.com)

[Tiptap](https://tiptap.dev)
