# tomload

[![Total Downloads](https://poser.pugx.org/178inaba/tomload/downloads)](https://packagist.org/packages/178inaba/tomload)
[![Latest Stable Version](https://poser.pugx.org/178inaba/tomload/v/stable)](https://packagist.org/packages/178inaba/tomload)
[![Latest Unstable Version](https://poser.pugx.org/178inaba/tomload/v/unstable)](https://packagist.org/packages/178inaba/tomload)
[![License](https://poser.pugx.org/178inaba/tomload/license)](https://packagist.org/packages/178inaba/tomload)

helper for loading [toml](https://github.com/toml-lang/toml).

## install

```bash
$ composer require 178inaba/tomload
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

## licence

MIT
