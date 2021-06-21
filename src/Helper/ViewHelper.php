<?php

declare(strict_types=1);

namespace TypedView\Helper;

use Laminas\ServiceManager\ServiceManager;
use Laminas\View\HelperPluginManager;

/**
 * @see https://github.com/markorstc/laminas-typedview for the canonical source repository
 * @license https://github.com/markorstc/laminas-typedview/blob/main/LICENSE New BSD License
 * @copyright Copyright (c) 2021, Marko Ristić
 */
trait ViewHelper
{
    protected ?HelperPluginManager $helpers = null;

    public function setViewHelperManager(HelperPluginManager $helpers): self
    {
        $this->helpers = $helpers;

        return $this;
    }

    public function getViewHelperManager(): HelperPluginManager
    {
        if ($this->helpers === null) {
            $this->setViewHelperManager(new HelperPluginManager(new ServiceManager()));
        }

        return $this->helpers;
    }
}
