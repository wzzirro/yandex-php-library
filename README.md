PHP библиотека к API Яндекса
============================

[![Gitter](https://badges.gitter.im/Join%20Chat.svg)](https://gitter.im/nixsolutions/yandex-php-library?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)

[![Build Status](https://secure.travis-ci.org/nixsolutions/yandex-php-library.png?branch=master)](https://travis-ci.org/nixsolutions/yandex-php-library)
[![Latest Stable Version](https://poser.pugx.org/nixsolutions/yandex-php-library/v/stable.png)](https://packagist.org/packages/nixsolutions/yandex-php-library)
[![Total Downloads](https://poser.pugx.org/nixsolutions/yandex-php-library/downloads.png)](https://packagist.org/packages/nixsolutions/yandex-php-library)

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/nixsolutions/yandex-php-library/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/nixsolutions/yandex-php-library/?branch=master)
[![Coverage Status](https://coveralls.io/repos/nixsolutions/yandex-php-library/badge.png)](https://coveralls.io/r/nixsolutions/yandex-php-library)
[![Dependency Status](https://www.versioneye.com/user/projects/53a1549983add72cb9000014/badge.svg?style=flat)](https://www.versioneye.com/user/projects/53a1549983add72cb9000014)

[![License](https://poser.pugx.org/nixsolutions/yandex-php-library/license.svg)](https://packagist.org/packages/nixsolutions/yandex-php-library)

## Установка

### composer

Установка с использованием менеджера пакетов [Composer](http://getcomposer.org):

```bash
$ curl -s https://getcomposer.org/installer | php
```

Теперь вносим изменения в ваш `composer.json`:

```yaml
{
    "require": {
        "nixsolutions/yandex-php-library": "dev-master"
    }
}
```

### phar-архив

Работа с [phar архивом](http://php.net/manual/en/book.phar.php):

1. Скачиваем по [ссылке](http://yadi.sk/d/26YmC3hRByBd7) phar-файл или bz2-архив с ним, последней или конкретной версии.
2. Сохраняем в папку с проектом.
3. Используем!

Пример подключения и работа с библиотекой из phar-архива:
```php
<?php
//Подключаем autoload.php из phar-архива
require_once 'phar://yandex-php-library_master.phar/vendor/autoload.php';

use Yandex\Disk\DiskClient;

$disk = new DiskClient();
//Устанавливаем полученный токен
$disk->setAccessToken(TOKEN);

//Получаем список файлов из директории
$files = $disk->directoryContents();
```

## Использование

* [Yandex Disk](https://github.com/nixsolutions/yandex-php-library/wiki/Yandex-Disk)
* [Yandex Market for Partner](https://github.com/nixsolutions/yandex-php-library/wiki/Yandex-Market-for-Partner)
* [Yandex OAuth](https://github.com/nixsolutions/yandex-php-library/wiki/Yandex-OAuth)
* [Yandex Site Search Pinger](https://github.com/nixsolutions/yandex-php-library/wiki/Yandex-Site-Search-Pinger)
* [Yandex Safe Browsing](https://github.com/nixsolutions/yandex-php-library/wiki/Yandex-Safe-Browsing)
* [Yandex Metrica](https://github.com/nixsolutions/yandex-php-library/wiki/Yandex-Metrica)

## Лицензия

Пакет `yandex-php-library` распространяется под лицензией MIT (текст лицензии вы найдёте в файле
[LICENSE](https://raw.github.com/nixsolutions/yandex-php-library/master/LICENSE)), данная лицензия
распространяется на код данной библиотеки и только на неё, использование сервисов Яндекс регулируются
документами, которые вы сможете найти на странице [Правовые документы](http://legal.yandex.ru/)
