
## Setup local developme

```
ddev start

ddev exec 'cd web/ && wp core download && wp core install --url=https://duplicate-in-ddev.ddev.site --title="Blank WordPress" --admin_user=admin --admin_email=admin@example.com --prompt=admin_password'

ddev exec 'ln -sfv /var/www/html/duplicate-in-ddev /var/www/html/web/wp-content/plugins/duplicate-in-ddev

ddev exec 'cd web/ && wp plugin activate duplicate-in-ddev'
```

## Technical background

- created with `wp scaffold plugin`-command
- currently just copied from https://www.sitepoint.com/wordpress-settings-api-build-custom-admin-page/ tutorial