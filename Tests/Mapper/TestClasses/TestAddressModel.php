<?php
declare(strict_types=1);


namespace Arrynn\MultilayeredInfrastructure\Tests\Mapper\TestClasses;


use Illuminate\Database\Eloquent\Model;

/**
 * Class TestCustomerModel
 * @package Arrynn\MultilayeredInfrastructure\Tests\Mapper\TestClasses
 *
 * @property string $street
 * @property string $street_number
 * @property string $zip
 * @property string $city
 * @property string $country
 */
class TestAddressModel extends Model
{

}