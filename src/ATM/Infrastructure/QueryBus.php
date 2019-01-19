<?php

namespace ATM\Infrastructure;

use ATM\Domain\Query\QueryInterface;

class QueryBus
{
    public function handle(QueryInterface $query)
    {
        $handlerClass = sprintf('%sHandler', get_class($query));
        $handler = new $handlerClass();
        return $handler->handle($query);
    }
}