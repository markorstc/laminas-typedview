<?php

declare(strict_types=1);

namespace TypedView\Helper;

use Laminas\View\Helper\Url;
use Traversable;

/**
 * @see https://github.com/markorstc/laminas-typedview for the canonical source repository
 * @license https://github.com/markorstc/laminas-typedview/blob/main/LICENSE New BSD License
 * @copyright Copyright (c) 2021, Marko Ristić
 */
trait UrlViewHelper
{
    use ViewHelper;

    /**
     * @param string|null $name
     * @param array<string, mixed> | Traversable $params
     * @param array<string, mixed> $options
     * @param bool $reuseMatchedParams
     * @return string
     * @see Url::__invoke()
     */
    public function url(
        ?string $name = null,
        array | Traversable $params = [],
        array $options = [],
        bool $reuseMatchedParams = false,
    ): string {
        return $this->helpers->get(Url::class)($name, $params, $options, $reuseMatchedParams);
    }
}
