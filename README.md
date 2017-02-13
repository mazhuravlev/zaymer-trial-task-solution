Trial task solution made for zaymer.ru
====

How to install and run
----
- Run "composer install" command, during install you will be prompted to enter database credentials
- Run "php bin/console doctrine:database:create"
- Run "php bin/console doctrine:schema:update --force"
- Run "php bin/console users:create" to create some users for tests
- Run "php bin/console users:money-transfer \[SENDER-ID\] \[RECIPIENT-ID\] \[MONEY-AMOUNT\]" to transfer money between users

