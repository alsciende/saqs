composer-validate:
	composer validate

phpunit:
	php vendor/bin/phpunit

phpstan:
	php vendor/bin/phpstan

ecs:
	php vendor/bin/ecs --fix

ci: composer-validate ecs phpstan phpunit
