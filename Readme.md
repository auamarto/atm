# ATM Infinite Bank

## Assumptions
Installed php7.2+, Composer

## Install
````
composer install
OR
make install
```` 

## Run
````
php bin/console atm
````

## Run Tests
````
phpunit --configuration phpunit.xml
````

## Presentation

### Why Symfony for such simple program
Just because i like symphony. Also i have ready 2 go skeleton project.

### Why CQRS for such simple program
Just for fun. If writing code is not entertaining why bother?
``WithdrawMoneyQueryHandler`` const ``AVAILABLE_NOTES`` in normal situation this will be provided via repository.
This repository would have connection with external banking system.

## The Problem

Develop a solution that simulate the delivery of notes when a client does a withdraw in a cash machine.

#### The basic requirements are the follow:

Always deliver the lowest number of possible notes;
It’s possible to get the amount requested with available notes;
The client balance is infinite;
Amount of notes is infinite;
Available notes $ 100,00; $ 50,00; $ 20,00 e $ 10,00

## Example:

Entry: 30.00
Result: [20.00, 10.00]

Entry: 80.00
Result: [50.00, 20.00, 10.00]

Entry: 125.00
Result: throw NoteUnavailableException

Entry: -130.00
Result: throw InvalidArgumentException

Entry: NULL
Result: [Empty Set]