<?php

declare(strict_types=1);

namespace TypedView\Service;

use JetBrains\PhpStorm\Pure;
use RecursiveIterator;
use TypedView\Entity\ViewModel;

use function key;
use function next;
use function reset;

/**
 * @see https://github.com/markorstc/laminas-typedview for the canonical source repository
 * @license https://github.com/markorstc/laminas-typedview/blob/main/LICENSE New BSD License
 * @copyright Copyright (c) 2021, Marko Ristić
 */
class ViewModelChildrenIterator implements RecursiveIterator
{
    private ViewModel | false $currentChild = false;

    /** @param array<ViewModel> $children */
    public function __construct(private array $children)
    {
        // php8 ctor
    }

    #[Pure]
    public function current(): ViewModel | false
    {
        return $this->currentChild;
    }

    public function next(): void
    {
        $this->currentChild = next($this->children);
    }

    #[Pure]
    public function key(): ?int
    {
        return key($this->children);
    }

    #[Pure]
    public function valid(): bool
    {
        return $this->currentChild !== false;
    }

    public function rewind(): void
    {
        $this->currentChild = reset($this->children);
    }

    #[Pure]
    public function hasChildren(): bool
    {
        return $this->currentChild->count() > 0;
    }

    #[Pure]
    public function getChildren(): ViewModelChildrenIterator
    {
        return new ViewModelChildrenIterator($this->currentChild->getChildren());
    }
}
