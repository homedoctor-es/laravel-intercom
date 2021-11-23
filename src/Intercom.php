<?php

namespace HomedoctorEs\Laravel\Intercom;

use Intercom\IntercomClient;

class Intercom
{
    protected $intercom;

    public function __construct(IntercomClient $intercom)
    {
        $this->intercom = $intercom;
    }

    public function __call($method, array $args)
    {
        if (method_exists($this->intercom, $method)) {
            return call_user_func_array([$this->intercom, $method], $args);
        }

        return $this->intercom->{$method};
    }

}