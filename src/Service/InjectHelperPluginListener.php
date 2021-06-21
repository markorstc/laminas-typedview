<?php

declare(strict_types=1);

namespace TypedView\Service;

use Laminas\EventManager\AbstractListenerAggregate;
use Laminas\EventManager\EventManagerInterface;
use Laminas\View\HelperPluginManager;
use Laminas\View\ViewEvent;
use TypedView\Entity\ViewEvent as TypedViewEvent;
use TypedView\Helper\ViewHelperAware;

use function method_exists;

/**
 * @see https://github.com/markorstc/laminas-typedview for the canonical source repository
 * @license https://github.com/markorstc/laminas-typedview/blob/main/LICENSE New BSD License
 * @copyright Copyright (c) 2021, Marko Ristić
 */
class InjectHelperPluginListener extends AbstractListenerAggregate
{
    public function __construct(protected HelperPluginManager $helpers)
    {
        // php8 ctor
    }

    public function attach(EventManagerInterface $events, $priority = 1): void
    {
        $events->attach(ViewEvent::EVENT_RENDERER_POST, [$this, 'injectHelperPluginManager'], $priority);
    }

    public function injectHelperPluginManager(ViewEvent $e): void
    {
        if (! $e instanceof TypedViewEvent) {
            return;
        }

        $model = $e->getTypedModel();

        if ($model instanceof ViewHelperAware || method_exists($model, 'setViewHelperManager')) {
            $model->setViewHelperManager($this->helpers);
        }
    }
}
