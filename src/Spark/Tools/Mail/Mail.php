<?php
/**
 *
 *
 * Date: 28.06.14
 * Time: 02:26
 */

namespace Spark\Tools\Mail;


use Spark\Common\IllegalArgumentException;
use Spark\Utils\Asserts;
use Spark\Utils\Objects;
use Spark\Utils\StringUtils;
use Spark\Utils\ValidatorUtils;

class Mail {
    const D_CONTENT = "content";
    const D_FROM    = "from";
    const D_TITLE   = "title";

    private $title;
    private $content;
    private $from;
    private $fromName;
    private $to;

    private $cc;
    private $unsubscribeUrl;
    private $toName;

    /**
     * @param mixed $cc
     */
    public function setCc($cc) {
        $this->cc = $cc;
    }

    /**
     * @return mixed
     */
    public function getCc() {
        return $this->cc;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content) {
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getContent() {
        return $this->content;
    }

    /**
     * @param $fromEmail
     * @param null $fromName
     * @throws IllegalArgumentException
     */
    public function setFrom($fromEmail, $fromName = null) {
        Asserts::checkArgument(Objects::isString($fromEmail), "fromEmail must be string");

        if (StringUtils::isBlank($fromName)) {
            $fromName = $fromEmail;
        }

        Asserts::checkArgument(Objects::isString($fromName), "fromName must be string");
        $this->from = $fromEmail;
        $this->fromName = $fromName;
    }

    /**
     * @return mixed
     */
    public function getToName() {
        return $this->toName;
    }


    /**
     * @return mixed
     */
    public function getFrom() {
        return $this->from;
    }

    /**
     * @return mixed
     */
    public function getFromName() {
        return $this->fromName;
    }


    /**
     * @param mixed $title
     */
    public function setTitle($title) {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * @param String $to
     */
    public function setTo($to, $toName = null) {
        Asserts::checkArgument(Objects::isString($to), "Recipient (to) need to be string");

        if (StringUtils::isBlank($toName)) {
            $toName = $to;
        }
        $this->to = $to;
        $this->toName = $toName;
    }

    /**
     * @return mixed
     */
    public function getTo() {
        return $this->to;
    }


    public function getUnsubscribeUrl() {
        return $this->unsubscribeUrl;
    }

    /**
     * @param mixed $unsubscribeUrl
     */
    public function setUnsubscribeUrl($unsubscribeUrl) {
        $this->unsubscribeUrl = $unsubscribeUrl;
    }


}