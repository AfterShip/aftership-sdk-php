<?php


namespace AfterShip;


class TrackingAdditionalFields
{

    /**
     * @param array $additionalFields Tracking additional fields array
     * @return array valid tracking  additional fields array
     * @throws AfterShipException
     */
    private static function validate($additionalFields)
    {
        $validAdditionalFields = [];
        if (array_key_exists('tracking_account_number', $additionalFields)) {
            if (strlen($additionalFields['tracking_account_number']) > 512) {
                throw new AfterShipException('Tracking account number max length is 512.');
            }
            $validAdditionalFields['tracking_account_number'] = $additionalFields['tracking_account_number'];
        }
        if (array_key_exists('tracking_postal_code', $additionalFields)) {
            if (strlen($additionalFields['tracking_postal_code']) > 8) {
                throw new AfterShipException('Tracking postal code max length is 8.');
            }
            $validAdditionalFields['tracking_postal_code'] = $additionalFields['tracking_postal_code'];
        }
        if (array_key_exists('tracking_ship_date', $additionalFields)) {
            if (strlen($additionalFields['tracking_ship_date']) != 8) {
                throw new AfterShipException('Tracking ship date format should be YYYYMMDD.');
            }
            $validAdditionalFields['tracking_ship_date'] = $additionalFields['tracking_ship_date'];
        }
        if (array_key_exists('tracking_key', $additionalFields)) {
            if (strlen($additionalFields['tracking_key']) < 1) {
                throw new AfterShipException('Tracking key at least contain 1 character.');
            }
            $validAdditionalFields['tracking_key'] = $additionalFields['tracking_key'];
        }
        if (array_key_exists('tracking_origin_county', $additionalFields)) {
            if (strlen($additionalFields['tracking_origin_county']) != 3) {
                throw new AfterShipException('Tracking origin country should be 3 characters country code in ISO 3166-1 alpha-3 format.');
            }
            $validAdditionalFields['tracking_origin_county'] = $additionalFields['tracking_origin_county'];
        }
        if (array_key_exists('tracking_destination_country', $additionalFields)) {
            if (strlen($additionalFields['tracking_destination_country']) != 3) {
                throw new AfterShipException('Tracking destination country should be 3 characters country code in ISO 3166-1 alpha-3 format.');
            }
            $validAdditionalFields['tracking_destination_country'] = $additionalFields['tracking_destination_country'];
        }
        if (array_key_exists('tracking_state', $additionalFields)) {
            if (strlen($additionalFields['tracking_state']) < 1) {
                throw new AfterShipException('Tracking state at least contain 1 character.');
            }
            $validAdditionalFields['tracking_state'] = $additionalFields['tracking_state'];
        }
        return $validAdditionalFields;

    }

    /**
     * @param array $additionalFields
     * @param string $mark , can be ? or & or empty
     * @return string
     * @throws AfterShipException
     */
    public static function buildQuery($additionalFields = [], $mark = null)
    {

        $validAdditionalFields = self::validate($additionalFields);

        if (empty($validAdditionalFields)) return '';

        if ($mark) {
            return $mark . http_build_query($validAdditionalFields);
        }

        return http_build_query($validAdditionalFields);

    }

}