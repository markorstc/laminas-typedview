<?php

declare(strict_types=1);

namespace TypedView\Helper;

use Laminas\View\HelperPluginManager;

/**
 * @see https://github.com/markorstc/laminas-typedview for the canonical source repository
 * @license https://github.com/markorstc/laminas-typedview/blob/main/LICENSE New BSD License
 * @copyright Copyright (c) 2021, Marko Ristić
 */
interface ViewHelperAware
{
    public function setViewHelperManager(HelperPluginManager $helpers): ViewHelperAware;
}
