<?php
/**
 * Definition of Application\Model\MatchFeeder
 *
 * @copyright Copyright (c) 2014 The Fußi-Team
 * @license   THE BEER-WARE LICENSE (Revision 42)
 *
 * "THE BEER-WARE LICENSE" (Revision 42):
 * The Fußi-Team wrote this software. As long as you retain this notice you
 * can do whatever you want with this stuff. If we meet some day, and you think
 * this stuff is worth it, you can buy us a beer in return.
 */

namespace Application\Model;

use Application\Model\Exceptions\UrlNotFoundException;
use Application\Model\Repository\MatchRepository;
use Zend\Feed\Writer\Feed as FeedWriter;

/**
 * Class MatchFeeder
 * @package Application\Model
 */
class MatchFeeder
{
    /**
     * Feed type to render
     */
    const FEED_TYPE = 'atom';

    /**
     * @var MatchRepository
     */
    protected $matchRepository;

    /**
     * @var FeedWriter
     */
    protected $feed;

    /**
     * @var string
     */
    protected $url;

    /**
     * @var string
     */
    protected $title;

    /**
     * @param FeedWriter      $feed
     * @param MatchRepository $matchRepository
     */
    function __construct(FeedWriter $feed, MatchRepository $matchRepository)
    {
        $this->feed            = $feed;
        $this->matchRepository = $matchRepository;
    }

    /**
     * @return string
     */
    public function generate()
    {
        $this->prepareFeed();
        $this->generateMatchEntries();

        return $this->feed->export(self::FEED_TYPE, true);
    }

    /**
     * @internal param \Zend\Feed\Writer\Feed $feed
     *
     * @return FeedWriter
     */
    private function prepareFeed()
    {
        $this->feed->setTitle($this->getTitle());
        $this->feed->setLink($this->getUrl());
        $this->feed->addAuthor(['name' => 'Fussi']);
        $this->feed->setDateModified(time());
    }

    /**
     * @return void
     */
    private function generateMatchEntries()
    {
        foreach ($this->getMatches() as $match) {
            $entry = $this->feed->createEntry();
            $entry->setTitle($this->makeMatchTitle($match));
            $entry->setDescription($this->makeMatchDescription($match));
            $entry->setLink($this->makeMatchLink($match));

            $entry->setDateCreated($match->getDate());
            $entry->setDateModified($match->getDate());

            $this->feed->addEntry($entry);
        }
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @throws UrlNotFoundException
     * @return string
     */
    public function getUrl()
    {
        if (is_null($this->url)) {
            throw new UrlNotFoundException('Feed-URL must be set');
        }

        return $this->url;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return \Application\Model\Entity\Match[]
     */
    private function getMatches()
    {
        $matches = $this->matchRepository->getLastMatches();

        return $matches;
    }

    /**
     * @param $match
     *
     * @return string
     */
    private function makeMatchTitle($match)
    {
        return sprintf('%s vs. %s', $match->getPlayer1()->getName(), $match->getPlayer2()->getName());
    }

    /**
     * @param $match
     *
     * @return string
     */
    private function makeMatchDescription($match)
    {
        return sprintf('Result: %s', $match->getScore());
    }

    /**
     * @param $match
     *
     * @return string
     */
    private function makeMatchLink($match)
    {
        return sprintf('%s%s%d', $this->getUrl(), '/match/', $match->getId());
    }
}
