All notable changes to this project will be documented in this file.
We follow the [Semantic Versioning 2.0.0](http://semver.org/) format.

## 0.1-alpha

### Changed
First stage: Main descriptions made on README.md. All classes have public variables. They are tightly coupled.
No unit tests. Where to go next: Getters and Setters, tests, no front controller. Typed and Optional Properties.

### Added
- Started with open source templates
- Created classes
- Front Controller is index.php

## 0.2-alpha

### Changed
Added getters and setters. There many getter and setter methods. Encapsulation shown.
Typed parameters and properties exist but still objects are not immutable.
Responses from objects are array hell. Some doccomments. No defined responsibilities.
No tests yet.

### Added
- getters and setters
- private properties
- parameter and return types
- some doccomments

### Removed
- App class

## 0.3-alpha

### Changed
Why we need OOP? Procedural approach. There is too much repeated code also almost no readability. Even though 
the prezifinder is a class it's very difficult to change things. Still we dont have routers for http requests.
And use of json_encode is not good.

### Added
Trivia PreziFinder class and tests. Database installer and model file.


### Removed
Classes to show why we need oop.

## 1.0.1-beta

### Changed
Added Interfaces using strategy pattern. There still could be some SOLID issues.
Classes are object oriented but some of them seem to have godly behavior. Did not use any framework.
All tests are complete and passing. Will also add CLIQueryParser for command line interface. Docs need to be updated.
Classes needs their description and what they do.

### Added
QueryParserInterface, ListInterface, RequestHandlerInterface, URLQueryParser.

### Removed
PreziFinder implements RequestHandlerInterface, is not depending on any db.

## 1.0.2

### Changed
Added slim framework for better HTTP handling.

### Added
Slim Framework and routes

### Removed
PreziFinder as RequestHandler from index.php