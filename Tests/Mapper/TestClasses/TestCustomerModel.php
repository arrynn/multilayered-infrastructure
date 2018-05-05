<?php
declare(strict_types=1);


namespace Arrynn\MultilayeredInfrastructure\Tests\Mapper\TestClasses;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Class TestCustomerModel
 * @package Arrynn\MultilayeredInfrastructure\Tests\Mapper\TestClasses
 *
 * @property string $name
 * @property string $surname
 * @property string $email
 * @property TestAddressModel $address
 * @property TestPhoneModel[] $phones
 * @property Carbon $created_at
 */
class TestCustomerModel extends Model
{

    public $phones = [];

    public static function sampleCustomer(): TestCustomerModel
    {
        $model = new self();
        $model->name = 'Anthony';
        $model->surname = 'Kipps';
        $model->email = 'antho.kipps@mailprovider.io';
        $model->address = new TestAddressModel();
        $model->address->street = 'Main rd.';
        $model->address->street_number = '102';
        $model->address->zip = '0124 44';
        $model->address->city = 'Metropol';
        $model->address->country = 'Longtavernland';
        $model->phones = [];
        $phone1 = new TestPhoneModel();
        $phone1->country_code = '299';
        $phone1->number = '949838272';
        $phone2= new TestPhoneModel();
        $phone2->country_code = '301';
        $phone2->number = '558448446';
        $model->phones[] = $phone1;
        $model->phones[] = $phone2;
        $model->created_at = Carbon::create(2018, 2, 18, 13, 59, 23)->timezone('UTC');

        return $model;
    }
}