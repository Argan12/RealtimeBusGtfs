<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: gtfs-realtime.proto

namespace Transit_realtime\TranslatedString;

use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>transit_realtime.TranslatedString.Translation</code>
 */
class Translation extends \Google\Protobuf\Internal\Message
{
    /**
     * A UTF-8 string containing the message.
     *
     * Generated from protobuf field <code>string text = 1;</code>
     */
    protected $text = '';
    /**
     * BCP-47 language code. Can be omitted if the language is unknown or if
     * no i18n is done at all for the feed. At most one translation is
     * allowed to have an unspecified language tag.
     *
     * Generated from protobuf field <code>optional string language = 2;</code>
     */
    protected $language = null;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $text
     *           A UTF-8 string containing the message.
     *     @type string $language
     *           BCP-47 language code. Can be omitted if the language is unknown or if
     *           no i18n is done at all for the feed. At most one translation is
     *           allowed to have an unspecified language tag.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\GtfsRealtime::initOnce();
        parent::__construct($data);
    }

    /**
     * A UTF-8 string containing the message.
     *
     * Generated from protobuf field <code>string text = 1;</code>
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * A UTF-8 string containing the message.
     *
     * Generated from protobuf field <code>string text = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setText($var)
    {
        GPBUtil::checkString($var, True);
        $this->text = $var;

        return $this;
    }

    /**
     * BCP-47 language code. Can be omitted if the language is unknown or if
     * no i18n is done at all for the feed. At most one translation is
     * allowed to have an unspecified language tag.
     *
     * Generated from protobuf field <code>optional string language = 2;</code>
     * @return string
     */
    public function getLanguage()
    {
        return isset($this->language) ? $this->language : '';
    }

    public function hasLanguage()
    {
        return isset($this->language);
    }

    public function clearLanguage()
    {
        unset($this->language);
    }

    /**
     * BCP-47 language code. Can be omitted if the language is unknown or if
     * no i18n is done at all for the feed. At most one translation is
     * allowed to have an unspecified language tag.
     *
     * Generated from protobuf field <code>optional string language = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setLanguage($var)
    {
        GPBUtil::checkString($var, True);
        $this->language = $var;

        return $this;
    }

}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(Translation::class, \Transit_realtime\TranslatedString_Translation::class);

