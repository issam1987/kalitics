
### Kalitics – Exercice de développement Symfony4  

__Symfony version__: 4  
__Symfony skeleton__: symfony/skeleton  
__Template engine__: Twig  
__Object Relational Mapper (ORM)__: Doctrine  

![crud](https://www.olive-craft.com/Kalitics/Capture.PNG "CRUD App With Symfony 4")


## How to start

``` bash
# clone project
git clone https://github.com/issam1987/kalitics.git

#cd folder
cd kalitics

# Install dependencies
composer install

# Edit the .env file (or create .env.local) and add DB params
# DATABASE_URL="mysql://root:@127.0.0.1:3306/kalitics?serverVersion=5.7&charset=utf8mb4"
php bin/console doctrine:database:create

# Run migrations
php bin/console doctrine:migrations:migrate

# Create host and Check on browser
php -S 127.0.0.1:8000 -t public

