<?php

namespace HumanDirect\Socially;

/**
 * Interface ParserInterface.
 */
interface ParserInterface
{
    public const PLATFORM_FACEBOOK = 'facebook';
    public const PLATFORM_TWITTER = 'twitter';
    public const PLATFORM_LINKEDIN = 'linkedin';
    public const PLATFORM_GITHUB = 'github';
    public const PLATFORM_ANGELLIST = 'angel';
    public const PLATFORM_GRAVATAR = 'gravatar';
    public const PLATFORM_KLOUT = 'klout';
    public const PLATFORM_PINTEREST = 'pinterest';
    public const PLATFORM_BEHANCE = 'behance';
    public const PLATFORM_BITBUCKET = 'bitbucket';
    public const PLATFORM_DRIBBBLE = 'dribbble';
    public const PLATFORM_FLICKR = 'flickr';
    public const PLATFORM_GOOGLEPLUS = 'googleplus';
    public const PLATFORM_STACKOVERFLOW = 'stackoverflow';
    public const PLATFORM_REDDIT = 'reddit';
    public const PLATFORM_QUORA = 'quora';

    public const FACEBOOK_URL_REGEXS = [
        'http(s)?://(www\.)?(facebook|fb)\.com/[A-z0-9_\-\.]+/?',
    ];

    public const GITHUB_URL_REGEXS = [
        'http(s)?://(www\.)?github\.com/[A-z0-9_-]+/?',
    ];

    public const LINKEDIN_URL_REGEXS = [
        // private
        'http(s)?://([\w]+\.)?linkedin\.com/in/[A-z0-9_-]+/?',
        'http(s)?://([\w]+\.)?linkedin\.com/pub/[A-z0-9_-]+(\/[A-z 0-9]+){3}/?',
        // companies
        'http(s)?://(www\.)?linkedin\.com/company/[A-z0-9_-]+/?',
    ];

    public const TWITTER_URL_REGEXS = [
        'http(s)?://(.*\.)?twitter\.com\/[A-z0-9_]+/?',
    ];

    public const ANGELLIST_URL_REGEXS = [
        'http(s)?://(.*\.)?angel\.co\/[A-z0-9_]+/?',
    ];

    public const GRAVATAR_URL_REGEXS = [
        'http(s)?://([\w]+\.)?gravatar\.com\/[A-z0-9-]+/?',
    ];

    public const KLOUT_URL_REGEXS = [
        'http(s)?://(www\.)?klout\.com/[A-z0-9_]+/?',
    ];

    public const PINTEREST_URL_REGEXS = [
        'http(s)?://(www\.)?pinterest\.com/[A-z0-9_]+/?',
    ];

    public const BEHANCE_URL_REGEXS = [
        'http(s)?://(www\.)?behance\.net/[A-z0-9_-]+/?',
    ];

    public const BITBUCKET_URL_REGEXS = [
        'http(s)?://(www\.)?bitbucket\.org/[A-z0-9_]+/?',
    ];

    public const DRIBBBLE_URL_REGEXS = [
        'http(s)?://(www\.)?dribbble\.com/[A-z0-9_]+/?',
    ];

    public const FLICKR_URL_REGEXS = [
        'http(s)?://(www\.)?flickr\.com/people/[A-z0-9_\@]+/?',
    ];

    public const GOOGLEPLUS_URL_REGEXS = [
        'https?:\/\/plus\.google\.com\/\+[^/]+|(\d{21}|\+[A-z0-9_\.])',
    ];

    public const STACKOVERFLOW_URL_REGEXS = [
        'http(s)?://(www\.)?stackoverflow\.com/users/\d+/?',
        'http(s)?://careers.stackoverflow\.com/[A-z0-9-]+/?',
    ];

    public const REDDIT_URL_REGEXS = [
        'http(s)?://(www\.)?reddit\.com/user/[A-z0-9-]{3,20}/?',
    ];

    public const QUORA_URL_REGEXS = [
        'http(s)?://(www\.)?quora\.com/[A-z0-9-]+/?',
    ];

    public const SOCIAL_MEDIA_PATTERNS = [
        self::PLATFORM_FACEBOOK => self::FACEBOOK_URL_REGEXS,
        self::PLATFORM_TWITTER => self::TWITTER_URL_REGEXS,
        self::PLATFORM_LINKEDIN => self::LINKEDIN_URL_REGEXS,
        self::PLATFORM_GITHUB => self::GITHUB_URL_REGEXS,
        self::PLATFORM_ANGELLIST => self::ANGELLIST_URL_REGEXS,
        self::PLATFORM_GRAVATAR => self::GRAVATAR_URL_REGEXS,
        self::PLATFORM_KLOUT => self::KLOUT_URL_REGEXS,
        self::PLATFORM_PINTEREST => self::PINTEREST_URL_REGEXS,
        self::PLATFORM_BEHANCE => self::BEHANCE_URL_REGEXS,
        self::PLATFORM_BITBUCKET => self::BITBUCKET_URL_REGEXS,
        self::PLATFORM_DRIBBBLE => self::DRIBBBLE_URL_REGEXS,
        self::PLATFORM_FLICKR => self::FLICKR_URL_REGEXS,
        self::PLATFORM_GOOGLEPLUS => self::GOOGLEPLUS_URL_REGEXS,
        self::PLATFORM_STACKOVERFLOW => self::STACKOVERFLOW_URL_REGEXS,
        self::PLATFORM_REDDIT => self::REDDIT_URL_REGEXS,
        self::PLATFORM_QUORA => self::QUORA_URL_REGEXS,
    ];
}