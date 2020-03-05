<?php

namespace Wotta\CommandExtender;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

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
