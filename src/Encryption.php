<?php

namespace AfterShip;

use phpseclib\Crypt\RSA;

/**
 * Class Encryption
 * @package AfterShip
 */
class Encryption
{
    const ENCRYPTION_RSA = 'RSA';

    const ENCRYPTION_AES = 'AES';

    /**
     * @var string
     */
    private $apiSecret = '';
    /**
     * @var string
     */
    private $encryptionMethod = '';
    /**
     * @var string
     */
    private $encryptionPassword = '';
    /**
     * Request constructor.
     *
     * @param $apiSecret the private key
     * @param $encryptionMethod 'RSA' or 'AES'
     * @param $encryptionPassword the private key password
     */
    function __construct($apiSecret, $encryptionMethod, $encryptionPassword)
    {
        $this->apiSecret = $apiSecret;
        $this->encryptionMethod = $encryptionMethod;
        $this->encryptionPassword = $encryptionPassword;
    }

    /**
     * Calculate the digest of data with RSA_SIGN_PSS_2048_SHA256 algorithm.
     * https://www.aftership.com/docs/tracking/quickstart/authentication#3-rsa
     * @param $data The data to be encrypted.
     * @return string the encrypted result with base64 encode
     * @throws AfterShipException
     */
    function rsaPSSSha256Encrypt($data) {
        $rsa = new RSA();
        if (!empty($this->encryptionPassword )) {
            $rsa->setPassword($this->encryptionPassword);
        }
        $loadResult = $rsa->loadKey($this->apiSecret, RSA::PRIVATE_FORMAT_PKCS1);
        if (!$loadResult) {
            throw new AfterShipException('Load private key failed');
        }
        $rsa->setHash("sha256");
        $rsa->setMGFHash('sha256');
        $rsa->setSignatureMode(RSA::SIGNATURE_PSS);
        $key = $rsa->sign($data);
        if (empty($key)) {
            throw new AfterShipException('Sign with RSA_SIGN_PSS_2048_SHA256 failed');
        }

        return base64_encode($key);
    }

    /**
     * Calculate the hash of data with hmac-sha256 algorithm.
     * https://www.aftership.com/docs/tracking/quickstart/authentication#2-aes
     * @param $data The data to be encrypted.
     * @return string the encrypted result with base64 encode
     * @throws AfterShipException
     */
    function hmacSha256Encrypt($data) {
        return base64_encode(hash_hmac('sha256', $data, $this->apiSecret, true));
    }

}
