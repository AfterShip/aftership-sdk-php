<?php


namespace AfterShip;

use PHPUnit\Framework\TestCase;


class TrackingAdditionalFieldsTest extends TestCase
{

    /** @test */
    public function it_could_not_valid_when_tracking_account_number_length_is_more_than_512()
    {
        try {
            TrackingAdditionalFields::buildQuery(['tracking_account_number' => str_repeat('T', 513)]);
        } catch (AfterShipException $e) {
            $this->assertInstanceOf(AfterShipException::class, $e);
            $this->assertEquals($e->getMessage(), 'Tracking account number max length is 512.');
        }
    }

    /** @test */
    public function it_could_not_valid_when_tracking_postal_coder_length_is_more_than_8()
    {
        try {
            TrackingAdditionalFields::buildQuery(['tracking_postal_code' => str_repeat('T', 9)]);
        } catch (AfterShipException $e) {
            $this->assertInstanceOf(AfterShipException::class, $e);
            $this->assertEquals($e->getMessage(), 'Tracking postal code max length is 8.');
        }
    }

    /** @test */
    public function it_could_not_valid_when_tracking_ship_date_length_is_more_than_8()
    {
        try {
            TrackingAdditionalFields::buildQuery(['tracking_ship_date' => str_repeat('T', 9)]);
        } catch (AfterShipException $e) {
            $this->assertInstanceOf(AfterShipException::class, $e);
            $this->assertEquals($e->getMessage(), 'Tracking ship date format should be YYYYMMDD.');
        }
    }

    /** @test */
    public function it_could_not_valid_when_tracking_key_length_is_less_than_1()
    {
        try {
            TrackingAdditionalFields::buildQuery(['tracking_key' => '']);
        } catch (AfterShipException $e) {
            $this->assertInstanceOf(AfterShipException::class, $e);
            $this->assertEquals($e->getMessage(), 'Tracking key at least contain 1 character.');
        }
    }

    /** @test */
    public function it_could_not_valid_when_tracking_origin_county_length_is_less_than_3()
    {
        try {
            TrackingAdditionalFields::buildQuery(['tracking_origin_county' => str_repeat('T', 2)]);
        } catch (AfterShipException $e) {
            $this->assertInstanceOf(AfterShipException::class, $e);
            $this->assertEquals($e->getMessage(), 'Tracking origin country should be 3 characters country code in ISO 3166-1 alpha-3 format.');
        }
    }


    /** @test */
    public function it_could_not_valid_when_tracking_destination_country_length_is_more_than_3()
    {
        try {
            TrackingAdditionalFields::buildQuery(['tracking_destination_country' => str_repeat('T', 4)]);
        } catch (AfterShipException $e) {
            $this->assertInstanceOf(AfterShipException::class, $e);
            $this->assertEquals($e->getMessage(), 'Tracking destination country should be 3 characters country code in ISO 3166-1 alpha-3 format.');
        }
    }

    /** @test */
    public function it_could_not_valid_when_tracking_state_length_is_less_than_1()
    {
        try {
            TrackingAdditionalFields::buildQuery(['tracking_state' => '']);
        } catch (AfterShipException $e) {
            $this->assertInstanceOf(AfterShipException::class, $e);
            $this->assertEquals($e->getMessage(), 'Tracking state at least contain 1 character.');
        }
    }

    /** @test */
    public function it_will_get_empty_query_string_when_no_additional_fields_passed()
    {
        $query = TrackingAdditionalFields::buildQuery([]);
        $this->assertEquals($query, '');
    }

    /** @test */
    public function it_will_get_query_string_when_pass_valid_additional_fields()
    {
        $query = TrackingAdditionalFields::buildQuery(['tracking_origin_county' => 'HKD', 'tracking_destination_country' => 'USA', 'tracking_state' => 'LA']);
        $this->assertEquals($query, 'tracking_origin_county=HKD&tracking_destination_country=USA&tracking_state=LA');
    }

    /** @test */
    public function it_will_get_query_string_when_pass_valid_additional_fields_and_a_question_mark()
    {
        $query = TrackingAdditionalFields::buildQuery(['tracking_account_number' => 'TEST-001', 'tracking_postal_code' => '65532', 'tracking_ship_date' => '20210316', 'tracking_key' => 'key001'], '?');
        $this->assertEquals($query, '?tracking_account_number=TEST-001&tracking_postal_code=65532&tracking_ship_date=20210316&tracking_key=key001');
    }

}