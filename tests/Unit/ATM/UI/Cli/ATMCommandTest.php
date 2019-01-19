<?php

namespace Tests\Unit\ATM\UI\Cli;

use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class ATMCommandTest extends KernelTestCase
{
    public function amountDataProvider(): array
    {
        return [
            [-130],
            [-135],
            [-130.00],
            ['-130'],
        ];
    }

    /**
     * @test
     * @dataProvider amountDataProvider
     */
    public function commandShouldThrowErrorOnNegativeValues($amount)
    {
        $kernel = static::createKernel();
        $application = new Application($kernel);

        $command = $application->find('atm');
        $commandTester = new CommandTester($command);
        $commandTester->setInputs([$amount]);
        $this->expectException(InvalidArgumentException::class);
        $commandTester->execute([
            'command'  => $command->getName(),
        ]);
    }
}