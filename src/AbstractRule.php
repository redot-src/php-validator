<?php

namespace Validator;

use Validator\Contracts\Rule;

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
     */
    final public function setMessage(string $message): void
    {
        $this->message = $message;
    }
}