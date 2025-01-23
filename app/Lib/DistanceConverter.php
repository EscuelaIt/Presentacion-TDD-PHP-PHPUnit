<?php

namespace App\Lib;

class DistanceConverter {

  private $fromUnit = null;
  private $toUnit = null;

  public function convert($distance) {
    switch($this->fromUnit) {
      case 'meter': 
        return $this->convertToMeter($distance);
      case 'km': 
        return $this->convertToKm($distance);
      case 'mile': 
        return $this->convertToMile($distance);
      default:
        return $distance;
    }
  }

  private function convertToMeter($distance) {
    if($this->toUnit == 'km') {
      return $distance / 1000;    
    }
    if($this->toUnit == 'mile') {
      return $distance / 1609.34;    
    }
    return $distance;
  }

  public function convertToKm($distance) {
    if($this->toUnit == 'meter') {
      return $distance * 1000;    
    }
    if($this->toUnit == 'mile') {
      return $distance / 0.621371;    
    }
    return $distance;
  }

  public function convertToMile($distance) {
    if($this->toUnit == 'meter') {
      return $distance * 1609.34;    
    }
    if($this->toUnit == 'km') {
      return $distance * 1.60934;    
    }
    return $distance;
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
}