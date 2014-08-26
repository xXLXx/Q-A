Yii 2 Question and Answer Application
================================

Uses Yii 2 Basic Application Template.

*Application description goes here*


DIRECTORY STRUCTURE
-------------------

      assets/             contains assets definition
      commands/           contains console commands (controllers)
      config/             contains application configurations
      controllers/        contains Web controller classes
      mail/               contains view files for e-mails
      models/             contains model classes
      runtime/            contains files generated during runtime
      tests/              contains various tests for the basic application
      vendor/             contains dependent 3rd-party packages
      views/              contains view files for the Web application
      web/                contains the entry script and Web resources



REQUIREMENTS
------------

The minimum requirement by this application is your Web server supports PHP 5.4.0.


INSTALLATION
------------

### Get a copy of the application

You can either `download the zip` file:

~~~
https://github.com/xXLXx/Q-A/archive/master.zip
~~~

then extract, or `fork` this repository, then clone from yours,
or `clone` this repository using the following command:

~~~
git clone https://github.com/xXLXx/Q-A/ path/to/dir/
~~~


### Install dependencies via Composer

If you do not have [Composer](http://getcomposer.org/), you may install it by following the instructions
at [getcomposer.org](http://getcomposer.org/doc/00-intro.md#installation-nix).

You can then install dependencies using the following command:

~~~
php composer.phar install
~~~

Now you should be able to access the application through the following URL:

~~~
http://localhost/basic/web/
~~~


CONFIGURATION
-------------

### Database

Edit the file `config/db.php` with real data, for example:

```php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=yii2basic',
    'username' => 'root',
    'password' => '1234',
    'charset' => 'utf8',
];
```

**NOTE:** Yii won't create the database for you, this has to be done manually before you can access it.
