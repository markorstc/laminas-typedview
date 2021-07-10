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


#### Use model in controller

To render your model, simply return it in Laminas controller action as you do it with standard `Laminas\View\Model\ViewModel`.

https://user-images.githubusercontent.com/12954262/124972750-0494ac80-e02b-11eb-9987-914681ba1775.mp4

If you want to use common layout for multiple controllers or actions, you have to implement `TypedView\Controller\LayoutModelAware` interface in your controller.

At the same time, you specify callback, that will set rendered child model to the parent model (in this case rendered `MyListViewModel` to parent `MyLayoutModel`).

https://user-images.githubusercontent.com/12954262/124978106-a0c1b200-e031-11eb-9775-b85f93e0e28e.mp4

#### Use Laminas view helpers

It's possible to use Laminas standard view helpers, but you have to extend `TypedView\Entity\LaminasBridgeModel` when creating your typed view model.

If you want to use single particular Laminas view helper and keep clean scope in your template, you can use helper traits e.g. `TypedView\Helper\UrlViewHelper`.

https://user-images.githubusercontent.com/12954262/125169570-18671c80-e1ab-11eb-88d9-be7676b30ab7.mp4

#### Nesting view models

It's possible to use view models as individual components and combine them.

To add one model to another use `TypedView\Entity\ViewModel::addChild()` method and specify capture callback the same way like in the layout model example.

https://user-images.githubusercontent.com/12954262/125174821-37c07280-e1c8-11eb-9cf2-1f49bdecfa45.mp4


