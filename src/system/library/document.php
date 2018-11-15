<?php
/**
 * @package         OpenPHP
 * @author          Shi
 * @license         GPL-3.0
 * @deprecated      The OpenPHP framework was extracted from OpenCart and made some
 *                  adjustments, thanks to the OpenCart development team.
 */

/**
 * Document class
 */
class Document
{
    private $title;
    private $description;
    private $keywords;
    private $links = array();
    private $styles = array();
    private $scripts = array();

    /**
     * setTitle
     *
     * @param   string      $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * getTitle
     *
     * @return  string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * setDescription
     *
     * @param   string      $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * description
     *
     * @return  string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * keywords
     *
     * @param   string      $keywords
     */
    public function setKeywords($keywords)
    {
        $this->keywords = $keywords;
    }

    /**
     *getKeywords
     *
     * @return  string
     */
    public function getKeywords()
    {
        return $this->keywords;
    }

    /**
     * addLink
     *
     * @param   string      $href
     * @param   string      $rel
     */
    public function addLink($href, $rel)
    {
        $this->links[$href] = array(
            'href' => $href,
            'rel'  => $rel
        );
    }

    /**
     * getLinks
     *
     * @return  array
     */
    public function getLinks()
    {
        return $this->links;
    }

    /**
     * addStyle
     *
     * @param   string      $href
     * @param   string      $rel
     * @param   string      $media
     */
    public function addStyle($href, $rel = 'stylesheet', $media = 'screen')
    {
        $this->styles[$href] = array(
            'href'  => $href,
            'rel'   => $rel,
            'media' => $media
        );
    }

    /**
     * getStyles
     *
     * @return  array
     */
    public function getStyles()
    {
        return $this->styles;
    }

    /**
     * addScript
     *
     * @param   string      $href
     * @param   string      $postion
     */
    public function addScript($href, $postion = 'header')
    {
        $this->scripts[$postion][$href] = $href;
    }

    /**
     * getScripts
     *
     * @param   string      $postion
     *
     * @return  array
     */
    public function getScripts($postion = 'header')
    {
        if (isset($this->scripts[$postion])) {
            return $this->scripts[$postion];
        } else {
            return array();
        }
    }
}