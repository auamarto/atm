<?php
declare(strict_types=1);

namespace ATM\Domain\Query;

use ATM\Domain\Exception\NoteUnavailableException;

class WithdrawMoneyQueryHandler
{
    public const AVAILABLE_NOTES = [100, 50, 20, 10];
    /**
     * @param WithdrawMoneyQuery $query
     * @return int[]
     */
    public function handle(WithdrawMoneyQuery $query): array
    {
        $amount = $query->getAmount();
        if (0 !== $amount % 10) {
            throw new NoteUnavailableException('Note Unavailable');
        }
        $notes = [];
        $noteIterator = 0;
        while ($amount > 0) {
            $note = sprintf('$%s.00', self::AVAILABLE_NOTES[$noteIterator]);
            $qty = (int) ($amount / self::AVAILABLE_NOTES[$noteIterator]);
            if ($qty > 0) {
                $notes[$note] = $qty;
                $amount %= self::AVAILABLE_NOTES[$noteIterator];
            }
            $noteIterator++;
        }

        return $notes;
    }
}
