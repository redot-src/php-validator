<?php

namespace Redot\Validator;

use Redot\Validator\Contracts\Rule;

abstract class AbstractRule implements Rule
{
    /**
     * Rule failure message.
     *
     * @var string
     */
    protected string $message = '';

    /**
     * {@inheritdoc}
     */
    final public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * Set validation message.
     *
     * @param string $message
     * @return void
     *
     * @noinspection PhpUnused
     */
    final public function setMessage(string $message): void
    {
        $this->message = $message;
    }
}