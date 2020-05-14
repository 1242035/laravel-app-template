
## Technology

- PHP version > 7.2.*
- Laravel 5.8.*.
- MySQL 5.7.* or MariaDB 10.1.*
- Line Message API
- Https
- wkhtmltopdf (Export PDF)
## Install

**1.Clone source code with SSH**

```shell
$ git clone git@bitbucket.org:user/template.git
```

**2.Run composer & config file `.env`**

```shell
$ cd /path/project
$ composer install
$ cp .env.example .env
```

- Change some contents in file `.env`
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=template
DB_USERNAME=root
DB_PASSWORD=
```

**3.Database & Migrate**
- Data master(Market, Store, Category)
```shell
$ php artisan migrate
$ php artisan db:seed
```
- Data develop(Table Order, User, Supplier, Product)
```shell
$ php artisan db:seed --class=DevelopSeeder
```

**4.Config apache & Start**

```apacheconfig
<VirtualHost *:80>
    ServerAdmin admin@gmail.com
    DocumentRoot "/path/project/public"
    ServerName  domain.com
    ErrorLog "logs/domain.com-error.log"
    CustomLog "logs/domain.com-access.log" common
    <Directory "/path/project/public">
        Options FollowSymLinks
        AllowOverride All
        DirectoryIndex index.php index.html
        Require all granted
    </Directory>
</VirtualHost>
```

**5.Setting Email**

- Email: Change some contents in file `.env`
```
MAIL_DRIVER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=email@gmail.com
MAIL_PASSWORD=password
MAIL_ENCRYPTION=tls
MAIL_FROM_NAME="SUPPORT"
MAIL_FROM_ADDRESS=email@gmail.com
```
**6.Install & Configure Supervisor**

[Guide Install Supervisor](https://laravel.com/docs/5.8/queues#supervisor-configuration)

- Configure Supervisor

Create a config file `/etc/supervisor/conf.d/worker.conf` and add below content.
Change `user=login user on enviroment`

```
[program:worker]
process_name=%(program_name)s_%(process_num)02d
command=php /path/project/artisan queue:work --sleep=3 --tries=3
autostart=true
autorestart=true
user=deployer
numprocs=8
redirect_stderr=true
stdout_logfile=/path/project/storage/logs/worker.log
```

- Starting `Supervisor`

```shell
$ sudo supervisorctl reread

$ sudo supervisorctl update

$ sudo supervisorctl start worker:*
```
**7.Install wkhtmltopdf**
[Guide Install wkhtmltopdf](https://gist.github.com/akhmadkresna/9a61fb89c13ccbb1c55a0ae2d303af81)

```shell
$ sudo wget https://builds.wkhtmltopdf.org/0.12.1.3/wkhtmltox_0.12.1.3-1~bionic_amd64.deb

$ sudo dpkg -i wkhtmltox_0.12.1.3-1~bionic_amd64.deb

$ sudo apt-get install -f

$ sudo ln -s /usr/local/bin/wkhtmltopdf /usr/bin
```

- Change some contents in file `.env`
```
WKHTMLTOPDF_BIN=/usr/bin/wkhtmltopdf
```