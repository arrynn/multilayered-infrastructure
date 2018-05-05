<?php
declare(strict_types=1);


namespace Arrynn\MultilayeredInfrastructure\Tests\Mapper\Unit;

use Arrynn\MultilayeredInfrastructure\Mapper\Mapper;
use Arrynn\MultilayeredInfrastructure\Tests\Mapper\TestClasses\FifthTestClass;
use Arrynn\MultilayeredInfrastructure\Tests\Mapper\TestClasses\FirstTestClass;
use Arrynn\MultilayeredInfrastructure\Tests\Mapper\TestClasses\FourthTestClass;
use Arrynn\MultilayeredInfrastructure\Tests\Mapper\TestClasses\SecondTestClass;
use Arrynn\MultilayeredInfrastructure\Tests\Mapper\TestClasses\SeventhTestClass;
use Arrynn\MultilayeredInfrastructure\Tests\Mapper\TestClasses\SixthTestClass;
use Arrynn\MultilayeredInfrastructure\Tests\Mapper\TestClasses\ThirdTestClass;
use Tests\TestCase;

class MapperTest extends TestCase
{
    /**
     * @test
     */
    public function directAndIndirectMapping_forCompatibleAndValidObjects_withOneSetAttribute_mapsCorrectly()
    {
        $source = FirstTestClass::createWithFirstAttrAs("Foo");
        $target = SecondTestClass::createEmpty();

        /**
         * @var SecondTestClass $result
         */
        $result = Mapper::map($source, $target);
        self::assertEquals($source->firstAttribute, $result->firstAttribute);
        self::assertNull($result->secondAttributeDifferent);
        self::assertNull($result->thirdAttribute);

    }

    /**
     * @test
     */
    public function directAndIndirectMapping_forCompatibleAndValidObjects_withAllSetAttributes_mapsCorrectly()
    {
        $source = FirstTestClass::createWithEachAttrDifferent("Foo");
        $target = SecondTestClass::createEmpty();

        /**
         * @var SecondTestClass $result
         */
        $result = Mapper::map($source, $target);
        self::assertEquals($source->firstAttribute, $result->firstAttribute);
        self::assertEquals($source->secondAttribute, $result->secondAttributeDifferent);
        self::assertEquals($source->thirdAttribute, $result->thirdAttribute);
    }

    /**
     * @test
     */
    public function directAndIndirectMapping_forCompatibleAndValidObjects_withAllSetAttributesAndChangedOrder_succeeds()
    {
        // The interface IMappable is now implemented by $target
        $source = SecondTestClass::createWithEachAttrDifferent("Foo");
        $target = ThirdTestClass::createEmpty();

        /**
         * @var ThirdTestClass $result
         */
        $result = Mapper::map($source, $target);
        self::assertEquals($source->firstAttribute, $result->firstAttribute);
        self::assertEquals($source->secondAttributeDifferent, $result->secondAttribute);
        self::assertEquals($source->thirdAttribute, $result->thirdAttributeDifferent);
    }

    /**
     * @test
     * @expectedException Arrynn\MultilayeredInfrastructure\Mapper\Exceptions\MappingException
     */
    public function mappingCall_withoutContractImplementation_throwsMappingException()
    {
        $source = SecondTestClass::createEmpty();
        $target = SecondTestClass::createEmpty();

        Mapper::map($source, $target);
    }

    /**
     * @deprecated MappingCollectionBuilder now ignores non-existing attributes therefore no exception is thrown
     * @test
     * @expectedException Arrynn\MultilayeredInfrastructure\Mapper\Exceptions\MappingException
     */
    /*
    public function mapping_withBadMapping_inSourceClass_throwsMappingException()
    {
        $source = FourthTestClass::createEmpty();
        $target = FirstTestClass::createWithEachAttrDifferent("Foo");

        $res = Mapper::map($source, $target);
    }
    */

    /**
     * @test
     * @expectedException Arrynn\MultilayeredInfrastructure\Mapper\Exceptions\MappingException
     */
    public function nestedMapping_withEmptySource_throwsException()
    {
        $source = SixthTestClass::createEmpty();
        $target = FifthTestClass::createEmpty();

        Mapper::map($source, $target);
    }

    /**
     * @test
     */
    public function nestedMapping_withMinimalValidSource_succeeds()
    {
        $source = SixthTestClass::createWithThirdAttrAs(FirstTestClass::createEmpty());
        $target = FifthTestClass::createEmpty();

        /**
         * @var FifthTestClass $result
         */
        $result = Mapper::map($source, $target);

        self::assertTrue($result instanceof FifthTestClass);
        self::assertTrue($result->secondAttribute instanceof SecondTestClass);

        self::assertNull($result->firstAttributeDiff);
        self::assertNull($result->thirdAttribute);
        self::assertNull($result->secondAttribute->firstAttribute);
        self::assertNull($result->secondAttribute->secondAttributeDifferent);
        self::assertNull($result->secondAttribute->thirdAttribute);
    }


    /**
     * @test
     */
    public function nestedMapping_withValidSource_succeeds()
    {
        $source = SixthTestClass::createWithThirdAttrAs(FirstTestClass::createWithEachAttrDifferent('Foo'));
        $source->firstAttributeDiff = 'FirstAttr';
        $source->secondAttributeDiff= 'SecondAttr';
        $target = FifthTestClass::createEmpty();

        /**
         * @var FifthTestClass $result
         */
        $result = Mapper::map($source, $target);

        self::assertTrue($result instanceof FifthTestClass);
        self::assertTrue($result->secondAttribute instanceof SecondTestClass);

        self::assertEquals($source->firstAttributeDiff, $result->firstAttributeDiff);
        self::assertEquals($source->secondAttributeDiff, $result->thirdAttribute);
        self::assertEquals($source->thirdAttributeDiff->firstAttribute, $result->secondAttribute->firstAttribute);
        self::assertEquals($source->thirdAttributeDiff->secondAttribute, $result->secondAttribute->secondAttributeDifferent);
        self::assertEquals($source->thirdAttributeDiff->thirdAttribute, $result->secondAttribute->thirdAttribute);
    }

    /**
     * @test
     */
    public function nestedMapping_withValidSource_withChangedOrder_succeeds()
    {
        $source = FifthTestClass::createEmptyWithInnerObject();
        $source->firstAttributeDiff = 'FirstAttr';
        $source->thirdAttribute = 'ThirdAttr';
        $source->secondAttribute->firstAttribute = 'Second.FirstAttr';
        $source->secondAttribute->secondAttributeDifferent= 'Second.SecondAttr';
        $source->secondAttribute->thirdAttribute = 'Second.ThirdAttr';
        $target = SeventhTestClass::createEmpty();

        /**
         * @var SeventhTestClass $result
         */
        $result = Mapper::map($source, $target);

        self::assertTrue($result instanceof SeventhTestClass);
        self::assertTrue($result->thirdAttributeDiff instanceof ThirdTestClass);

        self::assertEquals($source->firstAttributeDiff, $result->firstAttributeDiff);
        self::assertEquals($source->thirdAttribute, $result->secondAttributeDiff);
        self::assertEquals($source->secondAttribute->firstAttribute, $result->thirdAttributeDiff->firstAttribute);
        self::assertEquals($source->secondAttribute->secondAttributeDifferent, $result->thirdAttributeDiff->secondAttribute);
        self::assertEquals($source->secondAttribute->thirdAttribute, $result->thirdAttributeDiff->thirdAttributeDifferent);
    }

}