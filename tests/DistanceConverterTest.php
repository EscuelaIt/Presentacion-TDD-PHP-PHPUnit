<?php

namespace Tests;

use App\Lib\DistanceConverter;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;

class DistanceConverterTest extends TestCase {
  
  #[Test]
  public function it_returns_same_value_if_no_conversion_defined() {
    
    // Given / Arrange => Dado / Preparar
    $distanceConverter = new DistanceConverter();

    // When / Act => Cuando / Actuar
    $result = $distanceConverter->convert(100);

    // Then / Assert => Entonces / Afirmar
    $this->assertEquals(100, $result);

  }

  // $distanceConverter->fromMeter()->toKm()->convert(10);
  // $distanceConverter->fromMile()->toMeter()->convert(1);

  #[Test]
  public function it_returns_same_value_if_no_target_unit_is_provided() {
    $distanceConverter = new DistanceConverter();
    $this->assertEquals(10, $distanceConverter->fromMeter()->convert(10));
  }

  #[Test]
  public function it_returns_same_value_if_no_source_unit_is_provided() {
    $distanceConverter = new DistanceConverter();
    $convertedValue = $distanceConverter->toMeter()->convert(100);
    $this->assertEquals(100, $convertedValue);
  }

  #[Test]
  public function it_returns_same_value_on_same_source_and_target() {
    $distanceConverter = new DistanceConverter();
    $convertedValue = $distanceConverter->fromMeter()->toMeter()->convert(1);
    $this->assertEquals(1, $convertedValue);
  }

  #[Test]
  public function it_returns_correct_value_converting_meters_to_km() {
    $distanceConverter = new DistanceConverter();
    $convertedValue = $distanceConverter->fromMeter()->toKm()->convert(10000);
    $this->assertEqualsWithDelta(10, $convertedValue, 0.0001);
  }

  #[Test]
  public function it_returns_correct_value_converting_few_meters_to_km() {
    $distanceConverter = new DistanceConverter();
    $convertedValue = $distanceConverter->fromMeter()->toKm()->convert(0.33333333333);
    $this->assertEqualsWithDelta(0.00033333333333, $convertedValue, 0.0001);
  }

  #[Test]
  public function it_returns_correct_value_converting_km_to_meters() {
    $distanceConverter = new DistanceConverter();
    $convertedValue = $distanceConverter->fromKm()->toMeter()->convert(100);
    $this->assertEquals(100000, $convertedValue);
  }

  #[Test]
  public function it_returns_correct_value_converting_meters_to_miles() {
    $distanceConverter = new DistanceConverter();
    $convertedValue = $distanceConverter->fromMeter()->toMile()->convert(10000);
    $this->assertEqualsWithDelta(6.213712, $convertedValue, 0.0001);
  }

  #[Test]
  public function it_returns_correct_value_converting_miles_to_km() {
    $distanceConverter = new DistanceConverter();
    $convertedValue = $distanceConverter->fromMile()->toKm()->convert(10);
    $this->assertEquals(16.0934, $convertedValue);
  }

}
