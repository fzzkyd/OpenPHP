<?php
/**
 * @package         OpenPHP
 * @author          Shi
 * @license         GPL-3.0
 * @deprecated      The OpenPHP framework was extracted from OpenCart and made some
 *                  adjustments, thanks to the OpenCart development team.
 */

/**
 * Encryption class
 */
final class Encryption
{
    /**
     * encrypt
     * 
     * @param   string      $key
     * @param   string      $value
     * 
     * @return  string
     */
    public function encrypt($key, $value)
    {
        return strtr(base64_encode(openssl_encrypt($value, 'aes-128-cbc', hash('sha256', $key, true))), '+/=', '-_,');
    }

    /**
     * decrypt
     * 
     * @param   string      $key
     * @param   string      $value
     * 
     * @return  string
     */
    public function decrypt($key, $value)
    {
        return trim(openssl_decrypt(base64_decode(strtr($value, '-_,', '+/=')), 'aes-128-cbc', hash('sha256', $key, true)));
    }
}