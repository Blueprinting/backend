<?php

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

    /**
     * @var string
     */
    private string $title;

    /**
     * @var string
     */
    private string $description;

    /**
     * @var ElementsInterface
     */
    private ElementsInterface $internalToolbar;

    /**
     * Section constructor.
     *
     * @param string|null $title
     * @param string|null $description
     * @param ElementInterface|ElementInterface[]|null $elements
     */
    public function __construct(string $title = null, string $description = null, $elements = null)
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

    /**
     * @param string $title
     * @param array $replacements
     * @param bool|null $translate
     *
     * @return $this
     */
    public function setTitle(string $title, array $replacements = null, bool $translate = null): self
    {
        $this->title = ($translate || $translate === null ? (string)__($title, $replacements ?? []) : $title);
        return $this;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title ?? null;
    }

    /**
     * @param string $description
     * @param array $replacements
     * @param bool|null $translate
     *
     * @return $this
     */
    public function setDescription(string $description, array $replacements = null, bool $translate = null): self
    {
        $this->description = ($translate || $translate === null ?
            (string)__($description, $replacements ?? []) :
            $description
        );

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description ?? null;
    }

    /**
     * @return ElementsInterface
     */
    public function getToolbar(): ElementsInterface
    {
        if (!isset($this->internalToolbar)) {
            $this->internalToolbar = new Elements();
        }

        return $this->internalToolbar;
    }

    /**
     * @return ElementsInterface
     */
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
            fn($value) => $value !== null
        );
    }
}
