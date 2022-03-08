<?php

namespace App\Logging;

use Monolog\Processor\ProcessorInterface;

class SampleProcessor implements ProcessorInterface
{
    public function __invoke(array $record)
    {
        $record['extra']['custom'] = 'sample_extra';
        return $record;
    }
}