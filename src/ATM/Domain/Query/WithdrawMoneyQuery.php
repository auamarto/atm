<?php
declare(strict_types=1);

namespace ATM\Domain\Query;

class WithdrawMoneyQuery implements QueryInterface
{
    /** @var int  */
    private $amount;

    public function __construct(?int $amount)
    {
        $this->amount = (int) $amount;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }
}
