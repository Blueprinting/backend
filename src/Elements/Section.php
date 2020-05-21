<?php

namespace Blueprinting\Elements;

use Blueprinting\Element;
use Blueprinting\Elements;
use Blueprinting\Interfaces\ElementsInterface;

/**
 * Class Section
 * @package Blueprinting\Elements
 * @property ElementsInterface $toolbar
 */
class Section extends Element
{
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
    public function setTitle(string $title, array $replacements = [], bool $translate = null): self
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
    public function setDescription(string $description, array $replacements = [], bool $translate = null): self
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
        return array_replace(
            parent::serialize(),
            array_filter(
                [
                    'toolbar' => $this->toolbar->serialize(),
                ],
                fn($value) => $value !== null
            )
        );
    }
}
