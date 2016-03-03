# symfony_tt
symfony test task

1) clone git repository, run in console one of these commands(ssh or https): 
git clone git@github.com:Belgiets/symfony_tt.git
git clone https://github.com/Belgiets/symfony_tt.git

2) install and update dependencies, run in console in a root repository dir:    
composer install

3) setup your db-connection and mail settings in app/config/parameters.yml    
parameters:   
  database_host:    
  database_port:    
  database_name:    
  database_user:    
  database_password:    
  mailer_transport: gmail   
  mailer_host: smtp.gmail.com   
  mailer_user:    
  mailer_password: 
  
4) generate db, run in console in a root repository dir:    
php bin/console doctrine:database:create

5) setup db migrations, run in console in a root repository dir:    
php bin/console doctrine:migrations:migrate

6) populate fake data, run in console in a root repository dir:   
php bin/console faker:populate

7) run phpunit test, run in console in a root repository dir:   
phpunit

8) to start app run in console in a root repository dir:    
php bin/console server:run
