<?php
/**
 * @package         OpenPHP
 * @author          Shi
 * @license         GPL-3.0
 * @deprecated      The OpenPHP framework was extracted from OpenCart and made some
 *                  adjustments, thanks to the OpenCart development team.
 */

/**
 * Mail class
 */
class Mail
{
    protected $to;
    protected $from;
    protected $sender;
    protected $reply_to;
    protected $subject;
    protected $text;
    protected $html;
    protected $attachments = array();
    public $parameter;

    /**
     * Constructor
     *
     * @param   string      $adaptor
     */
    public function __construct($adaptor = 'mail')
    {
        $class = 'Mail\\' . $adaptor;

        if (class_exists($class)) {
            $this->adaptor = new $class();
        } else {
            trigger_error('Error: Could not load mail adaptor ' . $adaptor . '!');
            exit();
        }
    }

    /**
     * setTo
     *
     * @param   mixed       $to
     */
    public function setTo($to)
    {
        $this->to = $to;
    }

    /**
     * setFrom
     *
     * @param   string      $from
     */
    public function setFrom($from)
    {
        $this->from = $from;
    }

    /**
     * setSender
     *
     * @param   string      $sender
     */
    public function setSender($sender)
    {
        $this->sender = $sender;
    }

    /**
     * setReplyTo
     *
     * @param   string      $reply_to
     */
    public function setReplyTo($reply_to)
    {
        $this->reply_to = $reply_to;
    }

    /**
     * setSubject
     *
     * @param   string      $subject
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    /**
     * setText
     *
     * @param   string      $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * setHtml
     *
     * @param   string      $html
     */
    public function setHtml($html)
    {
        $this->html = $html;
    }

    /**
     * addAttachment
     *
     * @param   string      $filename
     */
    public function addAttachment($filename)
    {
        $this->attachments[] = $filename;
    }

    /**
     * send
     */
    public function send()
    {
        if (!$this->to) {
            throw new \Exception('Error: E-Mail to required!');
        }

        if (!$this->from) {
            throw new \Exception('Error: E-Mail from required!');
        }

        if (!$this->sender) {
            throw new \Exception('Error: E-Mail sender required!');
        }

        if (!$this->subject) {
            throw new \Exception('Error: E-Mail subject required!');
        }

        if ((!$this->text) && (!$this->html)) {
            throw new \Exception('Error: E-Mail message required!');
        }

        foreach (get_object_vars($this) as $key => $value) {
            $this->adaptor->$key = $value;
        }

        $this->adaptor->send();
    }
}