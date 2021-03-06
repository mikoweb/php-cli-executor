# PHP CLI Executor library

Library for CLI application execution with output parsing and validation.

## Installation

    composer require mikoweb/php-cli-executor

## Example of use

In your app file:

```php
require_once __DIR__ . '/vendor/autoload.php';

use Mikoweb\CLIExecutor\Executor;
use Mikoweb\CLIExecutor\Config;
use Mikoweb\CLIExecutor\Validator\Validator;
use Mikoweb\CLIExecutor\Validator\Exceptions\InvalidOutputException;

$config = new Config(__DIR__ . '/sample-cli.php'); // set path to your CLI script
// $config = new Config('cli_path', 'php_bin_or_other'); // you can set php bin path

$executor = new Executor($config);
$validator = new Validator();

$output = $executor->execute(['app:test']); // set command options, arguments etc.

try {
    $validator->validate($output);
    // $validator->validate($output, false); // if set false in second argument method not throw exception and return ValidationResultInterface

    echo $output->isSuccessful());
    echo $output->getStatus()); // output status code like http
    echo $output->getData()->get('message')); // you can get result property
    // echo $output->getData()->getData(); // or you can get full data
} catch (InvalidOutputException $exception) {
    echo $output->getErrorMessage());
    echo $output->getStatus());
    
    // you can access to $exception->getValidationResult(), $exception->getMessage(), $exception->getCode() etc. 
}
```

Successful with WriterBuilder `sample-cli.php`:

```php
require_once __DIR__ . '/vendor/autoload.php';

use Mikoweb\CLIExecutor\Writer\WriterBuilder;

$writer = new WriterBuilder();
$writer
    ->setMessage('ok')
    ->printMessageAsSuccess(true)
    ->write()
;

exit(0);
```

Failed example with WriterBuilder `sample-cli.php`:

```php
$writer = new WriterBuilder();
$writer
    ->setErrorMessage("something's wrong")
    ->printErrorMessageAsError(true)
    ->setStatus(OutputStatus::STATUS_INTERNAL_ERROR)
    ->write()
;
```

Successful Raw Example `sample-cli.php`:

```php
echo '
Lorem ipsum // unnecessary, example

<output>
{
    "message": "ok",
    "status": 200
}
</output>

Lorem ipsum // unnecessary, example
';

exit(0);
```

Failed Raw Example `sample-cli.php`:

```php
echo '
<output>
{
    "error_message": "something\'s wrong",
    "status": 500
}
</output>
';

exit(0);
```

Failed too `sample-cli.php`:

```php
exit(1);
```

## Custom Output Parser

By default, it is used JsonOutputParser. You can create your own parser e.g. XmlOutputParser:

```php
class XmlOutputParser extends AbstractOutputParser
{
    public function decode(string $data): array
    {
        return simplexml_to_assoc(simplexml_load_string($data));
    }
}
```

Set the parser as an Executor argument:

```php
$executor = new Executor($config, new XmlOutputParser());
```

## Custom Writer Serializer

By default, it is used JsonSerializer. You can create your own serializer e.g. XmlSerializer:

```php
class XmlSerializer implements SerializerInterface
{
    public function serialize(array $data): string
    {
        return JMS::serialize($data, 'xml');
    }
}
```

Set the serializer as an WriterBuilder argument:

```php
$writer = new WriterBuilder(new XmlSerializer());
```

## Tests

    php7.1 composer.phar install --dev
    php7.1 ./vendor/bin/phpunit tests

## Copyrights

Copyright (c) Rafa?? Miko??ajun 2022.