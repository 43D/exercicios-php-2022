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
        $troopAttacking = 0;
        $troopDefending = 0;
        $j = min(count($attackingDice), count($defendingDice));
        for ($i = 0; $i < $j; $i++) {
            if ($attackingDice[$i] > $defendingDice[$i])
                $troopDefending++;
            else
                $troopAttacking++;
        }
        $attackingCountry->killTroops($troopAttacking);
        $defendingCountry->killTroops($troopDefending);
    }
}
