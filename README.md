# duplicate-in-ddev

A simple plugin to give wp devs a starting point to setup their wordpress site in [DDEV](https://ddev.readthedocs.io/en/stable/). 

Status: First quick draft, use with caution / not on production.

## Setup local development

```
ddev start

ddev exec 'cd web/ && wp core download && wp core install --url=https://duplicate-in-ddev.ddev.site --title="Blank WordPress" --admin_user=admin --admin_email=admin@example.com --prompt=admin_password'

ddev exec 'ln -sfv /var/www/html/duplicate-in-ddev /var/www/html/web/wp-content/plugins/duplicate-in-ddev'

ddev exec 'cd web/ && wp plugin activate duplicate-in-ddev'

ddev launch '/wp-admin/options-general.php?page=duplicate-in-ddev-page'
```

## Technical background / credits

- plugin directory created with `wp scaffold plugin`-command
- currently just copied from https://www.sitepoint.com/wordpress-settings-api-build-custom-admin-page/ tutorial

License: Own source code additions - [CC0](https://creativecommons.org/publicdomain/zero/1.0/), do what you like with it. :-) I'll add proper credits if reworked.