<?php

declare(strict_types=1);

namespace Blueprinting\Elements;

use Blueprinting\Element;
use Blueprinting\Elements;
use Blueprinting\Interfaces\Element\WithChildren;
use Blueprinting\Interfaces\ElementInterface;
use Blueprinting\Interfaces\ElementsInterface;
use Blueprinting\Traits\HasChildren;

/**
 * Class Section
 * @package Blueprinting\Elements
 * @property ElementsInterface $toolbar
 */
class Section extends Element implements WithChildren
{
    use HasChildren;

    private string $title;
    private string $description;
    private ElementsInterface $internalToolbar;

    /**
     * Section constructor.
     *
     * @param ElementInterface[]|null $elements
     */
    public function __construct(?string $title = null, ?string $description = null, ?array $elements = null)
    {
        if ($title !== null) {
            $this->setTitle($title);
        }

        if ($description !== null) {
            $this->setDescription($description);
        }

        if ($elements !== null) {
            $this->getChildren()->add($elements);
        }
    }

    /**
     * @inheritDoc
     */
    public function getType(): string
    {
        return 'section';
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title ?? null;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description ?? null;
    }

    public function getToolbar(): ElementsInterface
    {
        if (!isset($this->internalToolbar)) {
            $this->internalToolbar = new Elements();
        }

        return $this->internalToolbar;
    }

    public function getToolbarAttribute(): ElementsInterface
    {
        return $this->getToolbar();
    }

    /**
     * @inheritDoc
     */
    public function serialize(): array
    {
        $serialization = parent::serialize();
        $serialization['toolbar'] = $this->toolbar->serialize();
        $serialization['title'] = $this->getTitle();
        $serialization['description'] = $this->getDescription();

        return array_filter(
            $serialization,
            static fn($value) => $value !== null
        );
    }

    /**
     * @param ElementInterface[]|null $elements
     */
    public static function make(?string $title = null, ?string $description = null, ?array $elements = null): Section
    {
        return new Section($title, $description, $elements);
    }
}
