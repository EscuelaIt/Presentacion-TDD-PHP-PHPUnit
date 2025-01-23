<?php

namespace App\Lib;

class DistanceConverter {

  private $fromUnit = null;
  private $toUnit = null;

  public function convert($distance) {
    if(!$this->fromUnit || !$this->toUnit || $this->fromUnit == $this->toUnit) {
      return $distance;
    }
    switch($this->fromUnit) {
      case 'meter': 
        if($this->toUnit == 'km') {
          return $distance / 1000;    
        }
        if($this->toUnit == 'mile') {
          return $distance / 1609.34;    
        }
        return $distance;
      case 'km': 
          if($this->toUnit == 'meter') {
            return $distance * 1000;    
          }
          if($this->toUnit == 'mile') {
            return $distance / 0.621371;    
          }
          return $distance;
      case 'mile': 
            if($this->toUnit == 'meter') {
              return $distance * 1609.34;    
            }
            if($this->toUnit == 'km') {
              return $distance * 1.60934;    
            }
            return $distance;
      default:
        return $distance;
    }
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