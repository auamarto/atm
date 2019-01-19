<?php
declare(strict_types=1);

namespace ATM\UI\Cli;

use ATM\Domain\Query\WithdrawMoneyQuery;
use ATM\Infrastructure\QueryBus;
use InvalidArgumentException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class ATMCommand extends Command
{
    /** @var QueryBus  */
    private $queryBus;

    public function __construct(QueryBus $queryBus)
    {
        $this->queryBus = $queryBus;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setName('atm')
            ->setDescription('ATM by Infinite Bank.')
            ->setHelp('ATM by Infinite Bank.');

        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $input->validate();
        $output->writeln([
            '===================================',
            '$$$$ Welcome Infinite Bank ATM $$$$',
            '===================================',
        ]);
        $helper = $this->getHelper('question');
        $output->writeln('Please Enter The Withdrawal Amouint in Multiples Of $10.00?');
        $question = new Question('Amount: ', null);
        $amount = $helper->ask($input, $output, $question);
        if (!null === $amount || !is_numeric($amount) || $amount < 0) {
            throw new InvalidArgumentException('Provide positive number.');
        }
        $notes = $this->queryBus->handle(new WithdrawMoneyQuery((int)$amount));

        foreach ($notes as $note => $qty) {
            if ($qty > 0) {
                $output->writeln(sprintf('Note: %s x %s', $note, $qty));
            }
        }

        $output->writeln([
            '===================================',
            '$         HAVE A NICE DAY         $',
            '===================================',
        ]);
    }
}
