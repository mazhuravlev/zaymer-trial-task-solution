Trial task solution made for zaymer.ru
====

Requirements
----
- PHP 7.1
- Composer
- MySQL server

How to install and run
----
- Run "composer install" command, during install you will be prompted to enter database credentials
- Run "php bin/console doctrine:database:create"
- Run "php bin/console doctrine:schema:update --force"
- Run "php bin/console users:create" to create some users for tests
- Run "php bin/console users:money-transfer \[SENDER-ID\] \[RECIPIENT-ID\] \[MONEY-AMOUNT\]" to transfer money between users.
 **Id** must be integer, **amount** must be decimal with a dot as a divider 
(example: php bin/console users:money-transfer 1 2 11.54)

