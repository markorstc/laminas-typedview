<?php

declare(strict_types=1);

namespace TypedView\Controller;

use Laminas\EventManager\EventManagerAwareInterface;
use Laminas\EventManager\EventManagerInterface;
use TypedView\Entity\ViewModel;

/**
 * @see https://github.com/markorstc/laminas-typedview for the canonical source repository
 * @license https://github.com/markorstc/laminas-typedview/blob/main/LICENSE New BSD License
 * @copyright Copyright (c) 2021, Marko Ristić
 */
interface LayoutModelAware extends EventManagerAwareInterface
{
    public function getLayoutModel(): ?ViewModel;

    /** @return EventManagerInterface */
    public function getEventManager();
}
