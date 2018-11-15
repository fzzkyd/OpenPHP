<?php
/**
 * @package         OpenPHP
 * @author          Shi
 * @license         GPL-3.0
 * @deprecated      The OpenPHP framework was extracted from OpenCart and made some
 *                  adjustments, thanks to the OpenCart development team.
 */

/**
 * Response class
 */
class Response
{
    private $headers = array();
    private $level = 0;
    private $output;

    /**
     * Constructor
     *
     * @param   string      $header
     *
     */
    public function addHeader($header)
    {
        $this->headers[] = $header;
    }
    
    /**
     * redirect
     *
     * @param   string      $url
     * @param   int         $status
     *
     */
    public function redirect($url, $status = 302)
    {
        header('Location: ' . str_replace(array('&amp;', "\n", "\r"), array('&', '', ''), $url), true, $status);
        exit();
    }
    
    /**
     * setCompression
     *
     * @param   int         $level
     */
    public function setCompression($level)
    {
        $this->level = $level;
    }
    
    /**
     * getOutput
     *
     * @return  string
     */
    public function getOutput()
    {
        return $this->output;
    }
    
    /**
     * setOutput
     *
     * @param   string      $output
     */    
    public function setOutput($output)
    {
        $this->output = $output;
    }
    
    /**
     * compress
     *
     * @param   string      $data
     * @param   int         $level
     * 
     * @return  string
     */
    private function compress($data, $level = 0)
    {
        if (isset($_SERVER['HTTP_ACCEPT_ENCODING']) && (strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') !== false)) {
            $encoding = 'gzip';
        }

        if (isset($_SERVER['HTTP_ACCEPT_ENCODING']) && (strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'x-gzip') !== false)) {
            $encoding = 'x-gzip';
        }

        if (!isset($encoding) || ($level < -1 || $level > 9)) {
            return $data;
        }

        if (!extension_loaded('zlib') || ini_get('zlib.output_compression')) {
            return $data;
        }

        if (headers_sent()) {
            return $data;
        }

        if (connection_status()) {
            return $data;
        }

        $this->addHeader('Content-Encoding: ' . $encoding);

        return gzencode($data, (int)$level);
    }
    
    /**
     * output
     */
    public function output()
    {
        if ($this->output) {
            $output = $this->level ? $this->compress($this->output, $this->level) : $this->output;
            
            if (!headers_sent()) {
                foreach ($this->headers as $header) {
                    header($header, true);
                }
            }
            
            echo $output;
        }
    }
}
