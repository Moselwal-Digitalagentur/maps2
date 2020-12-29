<?php

declare(strict_types=1);

/*
 * This file is part of the package jweiland/maps2.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace JWeiland\Maps2\Mapper;

use JWeiland\Maps2\Domain\Model\Position;
use TYPO3\CMS\Core\Utility\ArrayUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * Map Google Maps Request into Position object
 */
class GoogleMapsMapper implements MapperInterface
{
    /**
     * @param array $response
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
     */
    public function map(array $response): ObjectStorage
    {
        /** @var ObjectStorage $objectStorage */
        $objectStorage = GeneralUtility::makeInstance(ObjectStorage::class);
        foreach ($response['results'] as $data) {
            $objectStorage->attach($this->getPosition($data));
        }
        return $objectStorage;
    }

    /**
     * @param array $data
     * @return \JWeiland\Maps2\Domain\Model\Position
     */
    protected function getPosition(array $data): Position
    {
        /** @var Position $position */
        $position = GeneralUtility::makeInstance(Position::class);
        $position->setFormattedAddress($data['formatted_address']);

        try {
            $position->setLatitude((float)ArrayUtility::getValueByPath($data, 'geometry/location/lat'));
            $position->setLongitude((float)ArrayUtility::getValueByPath($data, 'geometry/location/lng'));
        } catch (\RuntimeException $exception) {
            // Path of ArrayUtility does not exist
            $position->setLatitude(0.0);
            $position->setLongitude(0.0);
        }

        return $position;
    }
}
