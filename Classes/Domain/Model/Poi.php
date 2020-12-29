<?php

declare(strict_types=1);

/*
 * This file is part of the package jweiland/maps2.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace JWeiland\Maps2\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

/**
 * Domain Model for Poi
 * This model is part of PoiCollection and was needed, if you work with Markers of type: Route or Area
 */
class Poi extends AbstractEntity
{
    /**
     * @var int
     */
    protected $cruserId = 0;

    /**
     * @var int
     */
    protected $posIndex = 0;

    /**
     * @var float
     */
    protected $latitude = 0.0;

    /**
     * @var float
     */
    protected $longitude = 0.0;

    /**
     * @return int
     */
    public function getCruserId(): int
    {
        return $this->cruserId;
    }

    /**
     * @param int $cruserId
     */
    public function setCruserId(int $cruserId)
    {
        $this->cruserId = $cruserId;
    }

    /**
     * @return int
     */
    public function getPosIndex(): int
    {
        return $this->posIndex;
    }

    /**
     * @param int $posIndex
     */
    public function setPosIndex(int $posIndex)
    {
        $this->posIndex = $posIndex;
    }

    /**
     * @return float
     */
    public function getLatitude(): float
    {
        return $this->latitude;
    }

    /**
     * @param float $latitude
     */
    public function setLatitude(float $latitude)
    {
        $this->latitude = $latitude;
    }

    /**
     * @return float
     */
    public function getLongitude(): float
    {
        return $this->longitude;
    }

    /**
     * @param float $longitude
     */
    public function setLongitude(float $longitude)
    {
        $this->longitude = $longitude;
    }
}
