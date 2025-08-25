phpunit:
	php vendor/bin/phpunit

phpstan:
	php vendor/bin/phpstan

ecs:
	php vendor/bin/ecs --fix

ci: ecs phpstan phpunit
