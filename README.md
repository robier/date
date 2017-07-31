Date
====

Simple date implementation of ISO 8601 standard.

[![Build Status](https://travis-ci.org/robier/date.svg?branch=master)](https://travis-ci.org/robier/date)
[![Test Coverage](https://codeclimate.com/github/robier/date/badges/coverage.svg)](https://codeclimate.com/github/robier/date/coverage)


### Introduction

The Date class follows the [ISO 8601](http://en.wikipedia.org/wiki/ISO_8601) standard for representing date.

Also allows easy getting range of two dates.


### Installation

You can install this library with composer.

```bash
composer require robier/date
```

### Requirements

This library requires PHP 7.1.

### Overview

This library contains of 3 classes:
- `Date` - representation of actual date
- `Date\Factory` - factory for creating `Date` object in different ways
- `Date\Range` - generator that represents range between 2 dates


### Samples

Creating new instance of Date (various ways how to get date 1991-11-14):

```php
use Robier\Date;

$date = new Date(1991, 11, 14); // or
$date = Date/Factory::new(1991, 11, 14); // or
$date = Date/Factory::dateTime(DateTime::createFromFormat('Y-m-d', '1991-11-14')); // or
$date = Date/Factory::string('1991-11-14'); // or
$date = Date/Factory::iso(1991, 46, 4);

```

------

Get today date:

```php
$today = Date/Factory::today();
```

------

Get tomorrows date:

```php
$tomorrow = Date/Factory::tomorrow(); // or
$tomorrow = Date/Factory::today()->next();
```

------

Get yesterday date:

```php
$yesterday = Date/Factory::yesterday(); // or
$yesterday = Date/Factory::today()->previous();
```

------

Get any date in future of provided date (ie. 5 days after 1991-11-14):

```php
$date = new Date(1991, 11, 14);
$date->next(5);
```

------

Get any date in past of provided date (ie. 6 days before 1991-11-14):

```php
$date = new Date(1991, 11, 14);
$date->previous(6);
```

------

Range between 2 dates (ie. get dates between 1991-11-14 and 1991-12-01):

```php
$start = new Date(1991, 11, 14);
$end = new Date(1991, 12, 1);

$range = new Date\Range($start, $end); // or
$range = $start->to($end);
```
