<?php

namespace Galoa\ExerciciosPhp2022\War\GamePlay\Country;

/**
 * Defines a country that is managed by the Computer.
 */
class ComputerPlayerCountry extends BaseCountry
{

  /**
   * Choose one country to attack, or none.
   *
   * The computer may choose to attack or not. If it chooses not to attack,
   * return NULL. If it chooses to attack, return a neighbor to attack.
   *
   * It must NOT be a conquered country.
   *
   * @return \Galoa\ExerciciosPhp2022\War\GamePlay\Country\CountryInterface|null
   *   The country that will be attacked, NULL if none will be.
   */

  public function __construct(string $name)
  {
    parent::__construct($name);
  }

  /**
   * Gera um número aleatório e o ultiliza para escolher um dos paises vizinhos (neighbors)
   * ou não escolher nada.
   */
  public function chooseToAttack(): ?CountryInterface
  {
    // @TODO
    $sorte = random_int(0, count($this->neighbors));
    if ($sorte == 0)
      return null;
    else
      return $this->neighbors[array_keys($this->neighbors)[$sorte - 1]];
  }
}
