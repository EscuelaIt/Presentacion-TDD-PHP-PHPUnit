<?php

namespace Tests;

use App\Lib\DistanceConverter;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;

class DistanceConverterTest extends TestCase {
  
  // interfaz de la clase que estoy probando
  // $distanceConverter->fromMeter()->toKm()->convert(10);
  // $distanceConverter->fromMile()->toMeter()->convert(1);

  protected DistanceConverter $distanceConverter;

  protected function setUp() :void {
    $this->distanceConverter = new DistanceConverter();
  }

  #[Test]
  public function it_returns_same_value_if_no_conversion_defined() {
    // Given / Arrange => Dado / Preparar
    // Lo estoy haciendo en el setup

    // When / Act => Cuando / Actuar
    $result = $this->distanceConverter->convert(100);

    // Then / Assert => Entonces / Afirmar
    $this->assertEquals(100, $result);
  }

  #[Test]
  public function it_returns_same_value_if_no_target_unit_is_provided() {
    $this->assertEquals(10, $this->distanceConverter->fromMeter()->convert(10));
  }

  #[Test]
  public function it_returns_same_value_if_no_source_unit_is_provided() {
    $convertedValue = $this->distanceConverter->toMeter()->convert(100);
    $this->assertEquals(100, $convertedValue);
  }

  #[Test]
  public function it_returns_same_value_on_same_source_and_target() {
    $convertedValue = $this->distanceConverter->fromMeter()->toMeter()->convert(1);
    $this->assertEquals(1, $convertedValue);
  }

  public static function converterData(): array {
    return [
      '10.000 metros a Km'    => ['fromMeter', 'toKm', 10000, 10],
      'Valores muy pequeños'  => ['fromMeter', 'toKm', 0.33333333333, 0.00033333333333],
      '100km a metros'        => ['fromKm', 'toMeter', 100, 100000],
      '10.000 m a millas'     => ['fromMeter', 'toMile', 10000, 6.213712],
      '10 millas a km'        => ['fromMile', 'toKm', 10, 16.0934],
      '0,1 millas a metros'   => ['fromMile', 'toMeter', 0.1, 160.934],
    ];
  }

  #[Test]
  #[DataProvider('converterData')]
  public function convert_data_cases($fromMethod, $toMethod, $value, $expectedResult) {
    $convertedValue = $this->distanceConverter->$fromMethod()->$toMethod()->convert($value);
    $this->assertEqualsWithDelta($expectedResult, $convertedValue, 0.0001);
  }

  public static function identityConversionProvider(): array {
    return [
      'Meter to meter' => ['fromMeter', 'toMeter', 1],
      'Km to Km'       => ['fromKm', 'toKm', 100],
      'Mile to mile'   => ['fromMile', 'toMile', 50],
    ];
  }

  #[Test]
  #[DataProvider('identityConversionProvider')]
  public function it_returns_same_value_for_identity_conversions($fromMethod, $toMethod, $input) {
      $convertedValue = $this->distanceConverter->$fromMethod()->$toMethod()->convert($input);
      $this->assertEquals($input, $convertedValue);
  }

  #[Test]
  public function string_parameter_methods_should_be_fluent() {
    $convertedValue = $this->distanceConverter->from('meter')->to('meter')->convert(1);
    $this->assertEquals(1, $convertedValue);
  }

  public static function conversionProviderToFromStrings(): array {
    return [
      'strings 1 metros a Km'    => ['meter', 'km', 1, 0.001], 
      '0 km a millas'        => ['km', 'meter', 0, 0], 
      '1 m a millas'     =>  ['meter', 'mile', 1, 0.0006213712], 
      '1 millas a km'        =>  ['mile', 'km', 1, 1.60934], 
    ];
  }
  
  #[Test]
  #[DataProvider('conversionProviderToFromStrings')]
  public function it_returns_correct_values_when_callin_string_name_method($fromUnit, $toUnit, $input, $expectation) {
    $convertedValue = $this->distanceConverter->from($fromUnit)->to($toUnit)->convert($input);
    $this->assertEqualsWithDelta($expectation, $convertedValue, 0.0001);
  }

  #[Test]
  public function it_throws_exception_on_invalid_from_unit() {
    $this->expectException(InvalidArgumentException::class);
    $this->expectExceptionMessage("From unit not supported");
    $this->distanceConverter->from('nanometer')->convert(1);
  }

  #[Test]
  public function it_throws_exception_on_invalid_to_unit() {
    $this->expectException(InvalidArgumentException::class);
    $this->expectExceptionMessage("To unit not supported");
    $this->distanceConverter->to('nanometer')->convert(1);
  }
}
