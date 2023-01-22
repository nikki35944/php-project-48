install: # установка зависимостей
	composer install
lint: # линтер
	composer exec --verbose phpcs -- --standard=PSR12 src bin tests/DifferTest.php
test: # тесты
	composer exec --verbose phpunit tests/DifferTest.php
coverage: # покрытие
	composer exec --verbose phpunit tests/DifferTest.php -- --coverage-clover build/logs/clover.xml