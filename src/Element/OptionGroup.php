<?php

declare(strict_types=1);

namespace Blueprinting\Element;

class OptionGroup
{
    private string $text;
    private array $options;

    public function __construct(array $options, ?string $text = null)
    {
        $this->setOptions($options);

        if ($text !== null) {
            $this->setText($text);
        }
    }

    public function setText(string $text): self
    {
        $this->text = $text;
        return $this;
    }

    public function setOptions(array $options): self
    {
        $this->options = $options;
        return $this;
    }

    public function getText(): ?string
    {
        return $this->text ?? null;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * @param string|int $key
     * @param string|int $value
     */
    public function addOption($key, $value): self
    {
        $this->options = $this->options ?? [];
        $this->options[$key] = $value;
        return $this;
    }
}
