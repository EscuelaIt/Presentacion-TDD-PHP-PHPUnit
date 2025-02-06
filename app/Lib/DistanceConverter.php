<?php

namespace App\Lib;

use InvalidArgumentException;

class DistanceConverter {

  private $fromUnit = null;
  private $toUnit = null;

  private $factor = [
    'mile' => [
        'km' => 1.60934,      // 1 milla = 1.60934 kilómetros
        'meter' => 1609.34,   // 1 milla = 1609.34 metros
    ],
    'km' => [
        'mile' => 0.621371,   // 1 kilómetro = 0.621371 millas
        'meter' => 1000,      // 1 kilómetro = 1000 metros
    ],
    'meter' => [
        'mile' => 0.000621371, // 1 metro = 0.000621371 millas
        'km' => 0.001,         // 1 metro = 0.001 kilómetros
    ],
  ];

  public function convert($distance) {
    if(! $this->fromUnit || ! $this->toUnit || $this->fromUnit == $this->toUnit) {
      return $distance;
    }
    return $distance * $this->factor[$this->fromUnit][$this->toUnit];
  }

  public function fromMeter() {
    $this->fromUnit = 'meter';
    return $this;
  }

  public function fromKm() {
    $this->fromUnit = 'km';
    return $this;
  }

  public function fromMile() {
    $this->fromUnit = 'mile';
    return $this;
  }

  public function toMeter() {
    $this->toUnit = 'meter';
    return $this;
  }

  public function toKm() {
    $this->toUnit = 'km';
    return $this;
  }

  public function toMile() {
    $this->toUnit = 'mile';
    return $this;
  }

  public function from($unit) {
    if(!in_array($unit, $this->validUnits())) {
      throw new InvalidArgumentException("From unit not supported: $unit");
    }

    $this->fromUnit = $unit;
    return $this;
  }

  public function to($unit) {
    if(!in_array($unit, $this->validUnits())) {
      throw new InvalidArgumentException("To unit not supported: $unit");
    }

    $this->toUnit = $unit;
    return $this;
  }

  private function validUnits() {
    return array_keys($this->factor);
  }
}