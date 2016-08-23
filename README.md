# toml helper

[![Build Status](https://travis-ci.org/178inaba/toml-helper.svg?branch=master)](https://travis-ci.org/178inaba/toml-helper)
[![Total Downloads](https://poser.pugx.org/178inaba/toml-helper/downloads)](https://packagist.org/packages/178inaba/toml-helper)
[![Latest Stable Version](https://poser.pugx.org/178inaba/toml-helper/v/stable)](https://packagist.org/packages/178inaba/toml-helper)
[![Latest Unstable Version](https://poser.pugx.org/178inaba/toml-helper/v/unstable)](https://packagist.org/packages/178inaba/toml-helper)
[![License](https://poser.pugx.org/178inaba/toml-helper/license)](https://packagist.org/packages/178inaba/toml-helper)

helper for loading [toml](https://github.com/toml-lang/toml).

## install

```bash
$ composer require 178inaba/toml-helper
```

## env

### TOML_DIR

default toml directory is `../tomls`.  
change toml directory to set `TOML_DIR`.

## usage

directory structure is

```
app
|-- public
|    +-- index.php
|-- foo
|    +-- bar
|         +-- example.toml
...
```

example.toml is

```toml
[author]
PHP = "Rasmus Lerdorf"
```

index.php is

```php
<?php

require __DIR__.'/../vendor/autoload.php';
putenv('TOML_DIR='.__DIR__.'/../foo/bar');

$phpAuthor = toml('example.author.PHP');
echo $phpAuthor."\n";
```

run

```bash
$ php index.php
Rasmus Lerdorf
```

## License

[MIT](LICENSE)
