<?php

declare(strict_types=1);

/*
 * This file is part of the package jweiland/maps2.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace JWeiland\Maps2\Service;

use JWeiland\Maps2\Client\ClientFactory;
use JWeiland\Maps2\Client\ClientInterface;
use JWeiland\Maps2\Client\Request\RequestFactory;
use JWeiland\Maps2\Domain\Model\Position;
use JWeiland\Maps2\Mapper\MapperFactory;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * With this class you can start requests to GeoCode API of Map Providers. Search for addresses, assign a POI
 * to a foreign record, save the foreign record and many more. It is designed as an API.
 */
class GeoCodeService implements SingletonInterface
{
    /**
     * Client depends on mapProvider which is either gm or osm
     *
     * @var ClientInterface
     */
    protected $client;

    /**
     * GeoCodeService constructor.
     *
     * @param \JWeiland\Maps2\Client\ClientInterface|null $client
     */
    public function __construct(ClientInterface $client = null)
    {
        $this->client = $client ?? GeneralUtility::makeInstance(ClientFactory::class)->create();
    }

    /**
     * @param string $address
     * @return ObjectStorage|Position[]
     */
    public function getPositionsByAddress(string $address): ObjectStorage
    {
        /** @var ObjectStorage $positions */
        $positions = GeneralUtility::makeInstance(ObjectStorage::class);

        // Prevent calls to Map Providers GeoCode API, if address is empty
        if (empty(trim($address))) {
            return $positions;
        }

        /** @var RequestFactory $requestFactory */
        $requestFactory = GeneralUtility::makeInstance(RequestFactory::class);
        $geocodeRequest = $requestFactory->create('GeocodeRequest');
        $geocodeRequest->addParameter('address', (string)$address);

        $response = $this->client->processRequest($geocodeRequest);
        if (!empty($response)) {
            /** @var MapperFactory $mapperFactory */
            $mapperFactory = GeneralUtility::makeInstance(MapperFactory::class);
            $positions = $mapperFactory->create()->map($response);
        }

        return $positions;
    }

    /**
     * @param string $address
     * @return \JWeiland\Maps2\Domain\Model\Position|null
     */
    public function getFirstFoundPositionByAddress(string $address): ?Position
    {
        $position = null;
        $positions = $this->getPositionsByAddress($address);
        if ($positions->count()) {
            $positions->rewind();
            /** @var Position $position */
            $position = $positions->current();
        }

        return $position;
    }

    /**
     * @return bool
     */
    public function hasErrors(): bool
    {
        return $this->client->hasErrors();
    }

    /**
     * @return FlashMessage[]
     */
    public function getErrors(): array
    {
        return $this->client->getErrors();
    }
}
