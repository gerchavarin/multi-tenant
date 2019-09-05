# Multi Tenant Laravel App

## Installation

### Database setup

For PostgreSQL:

```sql
CREATE DATABASE tenancy;
CREATE USER tenancy WITH CREATEDB CREATEROLE PASSWORD 'tenancy';
GRANT ALL PRIVILEGES ON DATABASE tenancy TO tenancy WITH GRANT OPTION;
```

### Run the following commands on your host machine:

*  Clone the repository with git clone
*  `cp .env.example .env`
*  (Edit .env file)
*  `composer install`
*  `php artisan key:generate`
*  `php artisan migrate --database=system`
*  `php artisan db:seed --class="CrearTenantSeeder"`
*  `npm install`
*  `npm run dev` or `npm run production`

### Domain names

Set your hosts file, for correct DNS resolution:

```bash
127.0.0.1 demo.test
```