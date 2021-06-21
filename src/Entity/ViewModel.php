<?php

declare(strict_types=1);

namespace TypedView\Entity;

use Closure;
use Countable;
use IteratorAggregate;
use JetBrains\PhpStorm\Pure;
use TypedView\Service\ViewModelChildrenIterator;

use function count;

/**
 * @see https://github.com/markorstc/laminas-typedview for the canonical source repository
 * @license https://github.com/markorstc/laminas-typedview/blob/main/LICENSE New BSD License
 * @copyright Copyright (c) 2021, Marko Ristić
 */
abstract class ViewModel implements IteratorAggregate, Countable
{
    public const MVC_EVENT_PARAM = 'typed-view-model';

    protected ?Closure $captureCallback = null;

    /** @var array<ViewModel> */
    protected array $children = [];

    abstract public function getTemplate(): string;

    #[Pure]
    public function getCaptureCallback(): ?callable
    {
        return $this->captureCallback;
    }

    public function setCaptureCallback(callable $callback): self
    {
        if (! $callback instanceof Closure) {
            $callback = Closure::fromCallable($callback);
        }

        $this->captureCallback = $callback;

        return $this;
    }

    public function addChild(ViewModel $model): self
    {
        $this->children[] = $model;

        return $this;
    }

    #[Pure]
    /** @return array<ViewModel> */
    public function getChildren(): array
    {
        return $this->children;
    }

    #[Pure]
    public function getIterator(): ViewModelChildrenIterator
    {
        return new ViewModelChildrenIterator([$this]);
    }

    #[Pure]
    public function count(): int
    {
        return count($this->children);
    }
}
