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

namespace HomedoctorEs\Laravel\Intercom\Exceptions;

use HomedoctorEs\Laravel\Intercom\Notifications\Messages\IntercomMessage;
use Throwable;

/**
 * Class MessageIsNotCompleteException
 *
 * @author Juan Solá <juan.sola@homedoctor.es>
 */
class MessageIsNotCompleteException extends IntercomException
{

    /**
     * @var IntercomMessage
     */
    private $intercomMessage;

    /**
     * @param IntercomMessage $intercomMessage
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(
        IntercomMessage $intercomMessage,
        string $message = '',
        int $code = 0,
        Throwable $previous = null
    ) {
        $this->intercomMessage = $intercomMessage;

        parent::__construct($message, $code, $previous);
    }

    /**
     * @return IntercomMessage
     */
    public function getIntercomMessage(): IntercomMessage
    {
        return $this->intercomMessage;
    }

}