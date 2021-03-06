<?php

/**
 * Part of the Intercom Laravel package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the 3-clause BSD License.
 *
 * This source file is subject to the 3-clause BSD License that is
 * bundled with this package in the LICENSE file.
 *
 * @package    Intercom Laravel
 * @version    1.0.0
 * @author     Juan Solá
 * @license    BSD License (3-clause)
 * @copyright (c) 2021, Homedoctor Smart Medicine
 */

namespace HomedoctorEs\Laravel\Intercom\Notifications\Messages;

/**
 * Class IntercomMessage
 *
 * @author Juan Solá <juan.sola@homedoctor.es>
 */
class IntercomMessage
{

    const TYPE_EMAIL = 'email';

    const TYPE_INAPP = 'inapp';

    const TEMPLATE_PLAIN = 'plain';

    const TEMPLATE_PERSONAL = 'personal';

    /**
     * @param string $body
     *
     * @return IntercomMessage
     */
    public static function create(string $body = null): self
    {
        return new static($body);
    }

    /**
     * @var array
     */
    public $payload;

    /**
     * @param string|null $body
     */
    public function __construct(string $body = null)
    {
        if (null !== $body) {
            $this->body($body);
        }

        $this->inapp();
    }

    /**
     * @param string $body
     *
     * @return IntercomMessage
     */
    public function body(string $body): self
    {
        $this->payload['body'] = $body;

        return $this;
    }

    /**
     * @return IntercomMessage
     */
    public function email(): self
    {
        $this->payload['message_type'] = self::TYPE_EMAIL;

        return $this;
    }

    /**
     * @return IntercomMessage
     */
    public function inapp(): self
    {
        $this->payload['message_type'] = self::TYPE_INAPP;

        return $this;
    }

    /**
     * @param string $value
     *
     * @return IntercomMessage
     */
    public function subject(string $value): self
    {
        $this->payload['subject'] = $value;

        return $this;
    }

    /**
     * @return IntercomMessage
     */
    public function plain(): self
    {
        $this->payload['template'] = self::TEMPLATE_PLAIN;

        return $this;
    }

    /**
     * @return IntercomMessage
     */
    public function personal(): self
    {
        $this->payload['template'] = self::TEMPLATE_PERSONAL;

        return $this;
    }

    /**
     * @param string $adminId
     *
     * @return IntercomMessage
     */
    public function from(string $adminId): self
    {
        $this->payload['from'] = [
            'type' => 'admin',
            'id' => $adminId
        ];

        return $this;
    }

    /**
     * @param array $value
     *
     * @return IntercomMessage
     */
    public function to(array $value): self
    {
        $this->payload['to'] = $value;

        return $this;
    }

    /**
     * @param string $id
     *
     * @return IntercomMessage
     */
    public function toUserId(string $id): self
    {
        $this->payload['to'] = [
            'type' => 'user',
            'id' => $id
        ];

        return $this;
    }

    /**
     * @param string $email
     *
     * @return IntercomMessage
     */
    public function toUserEmail(string $email): self
    {
        $this->payload['to'] = [
            'type' => 'user',
            'email' => $email
        ];

        return $this;
    }

    /**
     * @param string $id
     *
     * @return IntercomMessage
     */
    public function toContactId(string $id): self
    {
        $this->payload['to'] = [
            'type' => 'contact',
            'id' => $id
        ];

        return $this;
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        return isset(
            $this->payload['body'],
            $this->payload['from'],
            $this->payload['to']
        );
    }

    /**
     * @return bool
     */
    public function toIsGiven(): bool
    {
        return isset($this->payload['to']);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->payload;
    }

}