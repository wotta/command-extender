<?php

namespace Wotta\IlluminateExtender;

use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class Shell
{
    public function exec($command)
    {
        /** @var Process $process */
        $process = app()->make(Process::class, [
            'command' => $command,
        ]);

        $process->setTimeout(null);
        $process->setTty(true);

        try {
            $process->run(function ($type, $buffer) /*use ($showOutput)*/ {
                echo $buffer;

                // if (Process::ERR === $type) {
                // echo 'ERR > ' . $buffer;
                // } elseif ($showOutput) {
                // echo $buffer;
                // }
            });
        } catch (ProcessFailedException $e) {
            echo $e->getMessage();
        }
    }
}
