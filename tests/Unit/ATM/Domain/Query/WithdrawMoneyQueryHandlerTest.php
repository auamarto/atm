<?php
/**
 * Created by PhpStorm.
 * User: szymo
 * Date: 19.01.2019
 * Time: 14:09
 */

namespace Tests\Unit\ATM\Domain\Query;

use ATM\Domain\Exception\NoteUnavailableException;
use ATM\Domain\Query\WithdrawMoneyQuery;
use ATM\Domain\Query\WithdrawMoneyQueryHandler;
use PHPUnit\Framework\TestCase;

class WithdrawMoneyQueryHandlerTest extends TestCase
{
    public function amountProvider(): array
    {
        return [
            [30, ['$20.00' => 1, '$10.00' => 1]],
            [80, ['$50.00' => 1, '$20.00' => 1, '$10.00' => 1]],
            [30.00, ['$20.00' => 1, '$10.00' => 1]],
            [80.00, ['$50.00' => 1, '$20.00' => 1, '$10.00' => 1]],
            [null, []],
        ];
    }

    /**
     * @test
     * @dataProvider amountProvider
     * @param int|null $amount
     * @param array $expected
     */
    public function handleShouldReturnNotes($amount, array $expected)
    {
        $query = new WithdrawMoneyQuery($amount);
        $handler = new WithdrawMoneyQueryHandler();
        $notes = $handler->handle($query);
        $this->assertEquals($expected, $notes);
    }

    /**
     * @test
     */
    public function handleShoudThrowExceptionOnUnevenAmount()
    {
        $query = new WithdrawMoneyQuery(125);
        $handler = new WithdrawMoneyQueryHandler();
        $this->expectException(NoteUnavailableException::class);
        $notes = $handler->handle($query);
    }
}
