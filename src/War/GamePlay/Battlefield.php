<?php

namespace Galoa\ExerciciosPhp2022\War\GamePlay;

use Galoa\ExerciciosPhp2022\War\GamePlay\Country\CountryInterface;

/**
 * A manager that will roll the dice and compute the winners of a battle.
 */
class Battlefield implements BattlefieldInterface
{
    public function rollDice(CountryInterface $country, bool $isAtacking): array
    {
        $dicerolls = [];
        if ($isAtacking) {
            for ($i = 0; $i < $country->getNumberOfTroops() - 1; $i++) {
                array_push($dicerolls, random_int(1, 6));
            }
        } else {
            for ($i = 0; $i < $country->getNumberOfTroops(); $i++) {
                array_push($dicerolls, random_int(1, 6));
            }
        }
        rsort($dicerolls);
        return $dicerolls;
    }

    public function computeBattle(CountryInterface $attackingCountry, array $attackingDice, CountryInterface $defendingCountry, array $defendingDice): void
    {
        
    }
}
