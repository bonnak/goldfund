### Back-end Setup

``` bash
> composer install
```

### Front-end Setup

``` bash
> npm install
```

### Front-end compilation for VueJS

``` bash
> npm run dev
> npm run watch
> npm run production
```

### Fix error index or unique key out-of-range in db
``` bash
> SET GLOBAL default_storage_engine = 'InnoDB';
```

### Create database utf8mb4 (recommend)
``` bash
> CREATE DATABASE mydb CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### Fix error mailer
``` bash
> php artisan config:cache
```
