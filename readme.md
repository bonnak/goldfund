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

### Update .env file
``` bash
BROADCAST_DRIVER=pusher

PUSHER_APP_ID=299192
PUSHER_APP_KEY=e283fce33a446bb48093
PUSHER_APP_SECRET=0477974f486aa0ddca77
```

### Fix error index or unique key out-of-range in db
``` bash
> SET GLOBAL default_storage_engine = 'InnoDB'
```