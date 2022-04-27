<?php

namespace Galoa\ExerciciosPhp2022\War\GamePlay\Country;

/**
 * Defines a country that is managed by a human player.
 */
class HumanPlayerCountry extends BaseCountry {

    public function __construct(string $name)
    {
      parent::__construct($name);
    }
}
