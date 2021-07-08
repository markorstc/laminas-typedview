# Typed View Layer for Laminas
#### Key features

- strongly typed view layer
- clean template scope
- easy code navigation
- type hinting

## Installation
#### Install module via Composer

```
$ composer require markorstc/laminas-typedview
```

#### Enable module via config

https://user-images.githubusercontent.com/12954262/124970331-145ec180-e028-11eb-82f3-acf8d0ef3e58.mp4

## Getting started
#### Create view model and template

You create a typed view model by extending abstract class `TypedView\Entity\ViewModel`. Then you specify path to your `.phtml` template file in `TypedView\Entity\ViewModel::getTemplate()` method.

https://user-images.githubusercontent.com/12954262/124970100-c9dd4500-e027-11eb-9c17-993ccf338a44.mp4
