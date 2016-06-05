# Find Prezis
> A small RESTFULL app to retrieve Prezis based on search.

[![Build Status][travis-image]][travis-url]

This app allows to search retrieve one or a list of different Prezis based on user's request parameters.

## Installation

After you go into the app directory, you should execute following commands.
OS X & Linux:

```sh
composer install
```

## Usage example

This app requires a working webserver. You can make HTTP requests to specified endpoints.

## Development setup

To run all tests of the app, execute these commands in the app directory.

```sh
composer install
phpunit
```

## Release History

* 0.2.1
    * CHANGE: Update docs (module code remains unchanged)
* 0.2.0
    * CHANGE: Remove `setDefaultXYZ()`
    * ADD: Add `init()`
* 0.1.1
    * FIX: Crash when calling `baz()` (Thanks @GenerousContributorName!)
* 0.1.0
    * The first proper release
    * CHANGE: Rename `foo()` to `bar()`
* 0.0.1
    * Work in progress

## Meta

Midori Kocak – [@midorikocak](https://twitter.com/midorikocak) – midori@mynameismidori.com

Distributed under the MIT license. See ``LICENSE`` for more information.

[https://github.com/midorikocak/prezis](https://github.com/prezis/)

[travis-image]: https://img.shields.io/travis/dbader/node-datadog-metrics/master.svg?style=flat-square
[travis-url]: https://travis-ci.org/dbader/node-datadog-metrics