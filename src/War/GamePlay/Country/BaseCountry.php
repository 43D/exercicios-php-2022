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
   * Recebe o nome do pais no construtor.
   * Declara as variaveis com valores padrões de inicio de jogo
   */
  public function __construct(string $name)
  {
    $this->name = $name;
    $this->conquered = false;
    $this->neighbors = [];
    $this->troops = 3;
    $this->conqueredCountries = [];
  }

  //Método get de name.
  public function getName(): string
  {
    return $this->name;
  }
  /**
   * Método set de Neighbors.
   * Neighbors não recebe novos valores repetidos.
   * Neighbors remove paises já conquistados.
   */
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

  //Método get de neighbors.
  public function getNeighbors(): array
  {
    return $this->neighbors;
  }

  //Método get de troops.
  public function getNumberOfTroops(): int
  {
    return $this->troops;
  }

  //Método get de conquered.
  public function isConquered(): bool
  {
    return $this->conquered;
  }

  /**
   * Método conquer recebe um país conquistado.
   * Ele atualizar as fronteiras (Neighbors) de todos com todos
   */
  public function conquer(CountryInterface $conqueredCountry): void
  {
    $this->conqueredCountries += [$conqueredCountry->getName() => $conqueredCountry];
    $newneighbors = $conqueredCountry->getNeighbors();
    foreach ($newneighbors as $name => $contry) {
      if (!array_key_exists($name, $this->neighbors)) {
        if ($name != $this->name) {
          $this->neighbors += [$name => $contry];
        }
        $contry->setNeighbors([0 => $this, 1 => $conqueredCountry]);
      }
    }
  }

  /**
   * Decrementa a quantidade de Troops de acordo com resultados da batalha.
   * Caso as Troops fiquem abaixo de 0, o pais é considerado conquistado (conquered) 
   */
  public function killTroops(int $killedTroops): void
  {
    $this->troops -= $killedTroops;
    if ($this->troops <= 0) {
      $this->troops = 0;
      $this->conquered = true;
    }
  }

  /** 
   * Incrementa mais Troops a cada rodada.
   * Os valores são 3 + a quantidade de paises conquistados (conqueredCountries)
   */
  public function nextRound(): void
  {
    $total = 3 + count($this->conqueredCountries);
    $this->troops += $total;
  }
}
