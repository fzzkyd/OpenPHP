<?php
/**
 * @package         OpenPHP
 * @author          Shi
 * @license         GPL-3.0
 * @deprecated      The OpenPHP framework was extracted from OpenCart and made some
 *                  adjustments, thanks to the OpenCart development team.
 */

/**
 * Log class
 */
class Log
{
    private $handle;
    
    /**
     * Constructor
     *
     * @param   string      $filename
     */
    public function __construct($filename)
    {
        $this->handle = fopen(DIR_LOGS . $filename, 'a');
    }
    
    /**
     * write
     *
     * @param   string      $message
     */
    public function write($message)
    {
        fwrite($this->handle, date('Y-m-d G:i:s') . ' - ' . print_r($message, true) . "\n");
    }
    
    /**
     * destruct
     */
    public function __destruct()
    {
        fclose($this->handle);
    }
}