.PHONY: dev build install fresh migrate seed clear logs tinker

# Lance Laravel + Vite en parallèle
dev:
	@trap 'kill 0' INT; \
	php artisan serve & \
	npm run dev & \
	wait

# Build assets pour la prod
build:
	npm run build

# Install toutes les dépendances
install:
	composer install
	npm install

# Reset complet de la DB (migrate + seed)
fresh:
	php artisan migrate:fresh --seed

# Migrations uniquement
migrate:
	php artisan migrate

# Vide tous les caches
clear:
	php artisan config:clear
	php artisan cache:clear
	php artisan route:clear
	php artisan view:clear

# Logs en temps réel
logs:
	tail -f storage/logs/laravel.log

# Tinker
tinker:
	php artisan tinker
