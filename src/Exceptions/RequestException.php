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

use GuzzleHttp\Exception\RequestException as BaseRequestException;
use Throwable;

/**
 * Class RequestException
 *
 * @author Juan Solá <juan.sola@homedoctor.es>
 */
class RequestException extends IntercomException
{

    /**
     * @var BaseRequestException
     */
    private $baseException;

    /**
     * {@inheritdoc}
     */
    public function __construct(
        BaseRequestException $baseException,
        string $message = '',
        int $code = 0,
        Throwable $previous = null
    ) {
        $this->baseException = $baseException;

        parent::__construct($message, $code, $previous);
    }

    /**
     * @return BaseRequestException
     */
    public function getBaseException(): BaseRequestException
    {
        return $this->baseException;
    }

}