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

namespace HomedoctorEs\Laravel\Intercom;

use Intercom\IntercomClient;

/**
 * Class Intercom
 *
 * @author Juan Solá <juan.sola@homedoctor.es>
 */
class Intercom
{

    protected $intercom;

    public function __construct(IntercomClient $intercom)
    {
        $this->intercom = $intercom;
    }

    /**
     * @param $method
     * @param array $args
     * @return false|mixed
     */
    public function __call($method, array $args)
    {
        if (method_exists($this->intercom, $method)) {
            return call_user_func_array([$this->intercom, $method], $args);
        }

        return $this->intercom->{$method};
    }

}