<?php

namespace Galoa\ExerciciosPhp2022\War\GamePlay\Country;

/**
 * Defines a country, that is also a player.
 */
class BaseCountry implements CountryInterface
{

  /**
   * The name of the country.
   *
   * @var string
   */
  protected string $name;
  protected array $neighbors;
  protected bool $conquered;
  protected int $troops;
  protected array $conqueredCountries;

  /**
   * Builder.
   *
   * @param string $name
   *   The name of the country.
   */
  public function __construct(string $name)
  {
    $this->name = $name;
    $this->conquered = false;
    $this->neighbors = [];
    $this->troops = 3;
    $this->conqueredCountries = [];
  }

  public function getName(): string
  {
    return $this->name;
  }

  public function setNeighbors(array $neighbors): void
  {
    foreach ($neighbors as $contry) {
      if (!array_key_exists($contry->getName(), $this->neighbors)) {
        $this->neighbors += [$contry->getName() => $contry];
      } else if ($contry->isConquered()) {
        unset($this->neighbors[$contry->getName()]);
      }
    }
  }

  public function getNeighbors(): array
  {
    return $this->neighbors;
  }

  public function getNumberOfTroops(): int
  {
    return $this->troops;
  }
  public function isConquered(): bool
  {
    return $this->conquered;
  }
  public function conquer(CountryInterface $conqueredCountry): void
  {
    $this->conqueredCountries += [$conqueredCountry->getName() => $conqueredCountry];
    $newneighbors = $conqueredCountry->getNeighbors();
    foreach ($newneighbors as $name => $contry) {
      if (!array_key_exists($name, $this->neighbors) && $name != $this->name) {
        $this->neighbors += [$name => $contry];
        $contry->setNeighbors([0 => $this, 1 => $conqueredCountry]);
      }
    }
  }
  public function killTroops(int $killedTroops): void
  {
    $this->troops -= $killedTroops;
    if ($this->troops <= 0) {
      $this->troops = 0;
      $this->conquered = true;
    }
  }
  public function nextRound(): void
  {
    $total = 3 + count($this->conqueredCountries);
    $this->troops += $total;
  }
}
