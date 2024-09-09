# PHP-Laravel-BigQuery-Migrations

## Examples 

```shell

docker compose exec -it app php artisan bigquery:create {name} # Create BigQuery migration
docker compose exec -it app php artisan bigquery:migrate # Run BigQuery migrations
docker compose exec -it app php artisan bigquery:rollback # Run BigQuery migrations rollback
docker compose exec -it app php artisan bigquery:reset # Drop all BigQuery tables and run migrate

```
