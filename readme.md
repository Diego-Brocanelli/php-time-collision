# PHP Time Collision

![PHP Version](https://img.shields.io/badge/php-%5E7.4.0-blue)
![License](https://img.shields.io/badge/license-MIT-blue)
![TDD](https://img.shields.io/badge/tdd-Tested%20100%25-blue)
[![Build Status](https://travis-ci.org/ricardopedias/php-time-collision.svg?branch=master)](https://travis-ci.org/ricardopedias/php-time-collision)
[![Codacy Badge](https://app.codacy.com/project/badge/Grade/5d9844c598e9425a98059e3d08c78f92)](https://www.codacy.com/manual/ricardopedias/php-time-collision?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=ricardopedias/php-time-collision&amp;utm_campaign=Badge_Grade)
[![Follow](https://img.shields.io/github/followers/ricardopedias?label=Siga%20no%20GitHUB&style=social)](https://github.com/ricardopedias)
[![Twitter](https://img.shields.io/twitter/follow/ricardopedias?label=Siga%20no%20Twitter)](https://twitter.com/ricardopedias)

PHP Time Collision é uma biblioteca para lidar com colisão temporal, podendo identificar horários livres em um período especificado. Útil especialmente para gerenciamento de horários em agendas, onde é preciso encaixar um determinado tempo em um horário disponível.

Sinta-se à vontade para conferir o [changelog](https://github.com/ricardopedias/php-time-collision/blob/master/changelog.md), os [releases](https://github.com/ricardopedias/php-time-collision/releases) e a [licença](https://github.com/ricardopedias/php-time-collision/blob/master/license.md).

## Como usar

Existem várias formas de trabalhar com colisões de tempo dentro da biblioteca e podem ser conferidas na [documentação](docs/index.md). Um exemplo simples é explicado a seguir:

```php
// Gera um range de 24 horas no dia 10/01/2020
$object = new Collision('2020-01-10');

// Libera dois períodos dentro do range
$object->allowDefaultPeriod('13:00', '14:00');
$object->allowDefaultPeriod('15:00', '18:00');

// Obtém os períodos onde 01h30m pode se encaixar
$fittings = $object->fittingsFor(90);
```

O resultado será um array contendo todos os períodos disponíveis onde
1h30m podem ser alocados.
No exemplo acima, a variável *"$fittings"* terá o seguinte conteúdo:

```
[
    0 => [
        0 => DateTime("2020-01-10 15:00:00"),
        1 => DateTime("2020-01-10 18:00:00")
    ]
]
```

Ou seja, apenas o período das 15:00 às 18:00 podem alocar 01h30m. O valor, constituído de um array com dois elementos, corresponde ao início e ao fim dos períodos, ou seja, das 15:00 às 18:00.

Para mais informações, consulte a [Documentação da Biblioteca](docs/index.md) para descobrir outras funcionalidades.

## Características

-   Feito para o PHP 7 ou superior;
-   Codificado com boas práticas e máxima qualidade;
-   Bem documentado e amigável para IDEs;
-   Feito para TDD (Test Driven Development);
-   Feito com :heart: & :coffee:.

## Créditos 

[Ricardo Pereira Dias](http://www.ricardopedias.com.br)
