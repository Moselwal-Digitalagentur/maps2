<?php

declare(strict_types=1);

/*
 * This file is part of the package jweiland/maps2.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace JWeiland\Maps2\Domain\Model;

use JWeiland\Maps2\Configuration\ExtConf;
use JWeiland\Maps2\Service\MapService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Annotation as Extbase;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * Domain Model for PoiCollection
 * This is the main model for markers and radius records
 */
class PoiCollection extends AbstractEntity
{
    /**
     * @var string
     */
    protected $collectionType = '';

    /**
     * @var string
     * @Extbase\Validate("NotEmpty")
     */
    protected $title = '';

    /**
     * @var string
     */
    protected $address = '';

    /**
     * @var float
     */
    protected $latitude = 0.0;

    /**
     * @var float
     */
    protected $longitude = 0.0;

    /**
     * @var int
     */
    protected $radius = 0;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\JWeiland\Maps2\Domain\Model\Poi>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     */
    protected $pois;

    /**
     * @var string
     */
    protected $strokeColor = '';

    /**
     * @var string
     */
    protected $strokeOpacity = '';

    /**
     * @var string
     */
    protected $strokeWeight = '';

    /**
     * @var string
     */
    protected $fillColor = '';

    /**
     * @var string
     */
    protected $fillOpacity = '';

    /**
     * @var string
     */
    protected $infoWindowContent = '';

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
     */
    protected $infoWindowImages;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
     */
    protected $markerIcons;

    /**
     * @var int
     */
    protected $markerIconWidth = 0;

    /**
     * @var int
     */
    protected $markerIconHeight = 0;

    /**
     * @var int
     */
    protected $markerIconAnchorPosX = 0;

    /**
     * @var int
     */
    protected $markerIconAnchorPosY = 0;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\JWeiland\Maps2\Domain\Model\Category>
     */
    protected $categories;

    /**
     * distance
     * this is a helper var. This is not part of the db
     *
     * @var float
     */
    protected $distance = 0.0;

    /**
     * As I don't know, if foreign record has a valid DomainModel, the foreign records are arrays.
     * "null" marks this property as uninitialized.
     *
     * @var array|null
     */
    protected $foreignRecords;

    public function __construct()
    {
        $this->initStorageObjects();
    }

        protected function initStorageObjects(): void
    {
        $this->pois = new ObjectStorage();
        $this->categories = new ObjectStorage();
        $this->infoWindowImages = new ObjectStorage();
        $this->markerIcons = new ObjectStorage();
    }

    /**
     * @return string
     */
    public function getCollectionType(): string
    {
        return $this->collectionType;
    }

    /**
     * @param string $collectionType
     */
    public function setCollectionType(string $collectionType): void
    {
        $this->collectionType = $collectionType;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @param string $address
     */
    public function setAddress(string $address): void
    {
        $this->address = $address;
    }

    /**
     * @return float
     */
    public function getLatitude(): float
    {
        return $this->latitude;
    }

    /**
     * @param $latitude
     */
    public function setLatitude($latitude): void
    {
        $this->latitude = (float)$latitude;
    }

    /**
     * @return float
     */
    public function getLongitude(): float
    {
        return $this->longitude;
    }

    /**
     * @param $longitude
     */
    public function setLongitude($longitude): void
    {
        $this->longitude = (float)$longitude;
    }

    /**
     * @return int
     */
    public function getRadius(): int
    {
        return $this->radius;
    }

    /**
     * @param int $radius
     */
    public function setRadius(int $radius): void
    {
        $this->radius = $radius;
    }

    /**
     * @param \JWeiland\Maps2\Domain\Model\Poi $poi
     */
    public function addPoi(Poi $poi): void
    {
        $this->pois->attach($poi);
    }

    /**
     * @param \JWeiland\Maps2\Domain\Model\Poi $poiToRemove
     */
    public function removePoi(Poi $poiToRemove): void
    {
        $this->pois->detach($poiToRemove);
    }

    /**
     * @return ObjectStorage|Poi[]
     */
    public function getPois(): ObjectStorage
    {
        return $this->pois;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $pois
     */
    public function setPois(ObjectStorage $pois): void
    {
        $this->pois = $pois;
    }

    /**
     * @return string
     */
    public function getStrokeColor(): string
    {
        return $this->strokeColor;
    }

    /**
     * @param string $strokeColor
     */
    public function setStrokeColor(string $strokeColor): void
    {
        $this->strokeColor = $strokeColor;
    }

    /**
     * @return string
     */
    public function getStrokeOpacity(): string
    {
        return $this->strokeOpacity;
    }

    /**
     * @param string $strokeOpacity
     */
    public function setStrokeOpacity(string $strokeOpacity): void
    {
        $this->strokeOpacity = $strokeOpacity;
    }

    /**
     * @return string
     */
    public function getStrokeWeight(): string
    {
        return $this->strokeWeight;
    }

    /**
     * @param string $strokeWeight
     */
    public function setStrokeWeight(string $strokeWeight): void
    {
        $this->strokeWeight = $strokeWeight;
    }

    /**
     * @return string
     */
    public function getFillColor(): string
    {
        return $this->fillColor;
    }

    /**
     * @param string $fillColor
     */
    public function setFillColor(string $fillColor): void
    {
        $this->fillColor = $fillColor;
    }

    /**
     * @return string
     */
    public function getFillOpacity(): string
    {
        return $this->fillOpacity;
    }

    /**
     * @param string $fillOpacity
     */
    public function setFillOpacity(string $fillOpacity): void
    {
        $this->fillOpacity = $fillOpacity;
    }

    /**
     * @return string
     */
    public function getInfoWindowContent(): string
    {
        return $this->infoWindowContent;
    }

    /**
     * @param string $infoWindowContent
     */
    public function setInfoWindowContent(string $infoWindowContent): void
    {
        $this->infoWindowContent = $infoWindowContent;
    }

    /**
     * @param \JWeiland\Maps2\Domain\Model\Category $category
     */
    public function addCategory(Category $category): void
    {
        $this->categories->attach($category);
    }

    /**
     * @param \JWeiland\Maps2\Domain\Model\Category $category
     */
    public function removeCategory(Category $category): void
    {
        $this->categories->detach($category);
    }

    /**
     * @return ObjectStorage|Category[]
     */
    public function getCategories(): ObjectStorage
    {
        return $this->categories;
    }

    /**
     * @return \JWeiland\Maps2\Domain\Model\Category|null
     */
    public function getFirstFoundCategoryWithIcon(): ?Category
    {
        $category = null;
        foreach ($this->getCategories() as $category) {
            if ($category->getMaps2MarkerIcon()) {
                break;
            }
        }
        return $category;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $categories
     */
    public function setCategories(ObjectStorage $categories): void
    {
        $this->categories = $categories;
    }

    /**
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
     */
    public function getInfoWindowImages(): ObjectStorage
    {
        return $this->infoWindowImages;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $infoWindowImages
     */
    public function setInfoWindowImages(ObjectStorage $infoWindowImages): void
    {
        $this->infoWindowImages = $infoWindowImages;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $fileReference
     */
    public function addInfoWindowImage(FileReference $fileReference): void
    {
        $this->infoWindowImages->attach($fileReference);
    }

    /**
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $fileReference
     */
    public function removeInfoWindowImage(FileReference $fileReference): void
    {
        $this->infoWindowImages->detach($fileReference);
    }

    /**
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
     */
    public function getMarkerIcons(): ObjectStorage
    {
        return $this->markerIcons;
    }

    /**
     * @return string
     */
    public function getMarkerIcon(): string
    {
        $markerIcon = '';
        $categoryWithIcon = $this->getFirstFoundCategoryWithIcon();
        if ($categoryWithIcon instanceof Category) {
            $markerIcon = $categoryWithIcon->getMaps2MarkerIcon();
        }

        // override markerIcon, if we have a icon defined here in PoiCollection
        $this->markerIcons->rewind();
        // only one icon is allowed, so current() will give us the first icon
        $iconReference = $this->markerIcons->current();
        if (!$iconReference instanceof FileReference) {
            return $markerIcon;
        }

        $falIconReference = $iconReference->getOriginalResource();
        if (!$falIconReference instanceof \TYPO3\CMS\Core\Resource\FileReference) {
            return $markerIcon;
        }

        $siteUrl = GeneralUtility::getIndpEnv('TYPO3_SITE_URL');
        return $siteUrl . $falIconReference->getPublicUrl(false);
    }

    /**
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $markerIcons
     */
    public function setMarkerIcons(ObjectStorage $markerIcons): void
    {
        $this->markerIcons = $markerIcons;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $fileReference
     */
    public function addMarkerIcon(FileReference $fileReference): void
    {
        $this->markerIcons->attach($fileReference);
    }

    /**
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $fileReference
     */
    public function removeMarkerIcon(FileReference $fileReference): void
    {
        $this->markerIcons->detach($fileReference);
    }

    /**
     * @return int
     */
    public function getMarkerIconWidth(): int
    {
        // prevent using local markerIconWidth, if no markerIcon is set.
        if (
            empty($this->markerIconWidth)
            || (!empty($this->markerIconWidth) && $this->getMarkerIcons()->count() === 0)
        ) {
            $categoryWithIcon = $this->getFirstFoundCategoryWithIcon();
            if ($categoryWithIcon instanceof Category) {
                return $categoryWithIcon->getMaps2MarkerIconWidth();
            }
            /** @var ExtConf $extConf */
            $extConf = GeneralUtility::makeInstance(ExtConf::class);
            return $extConf->getMarkerIconWidth();
        }
        return $this->markerIconWidth;
    }

    /**
     * @param int $markerIconWidth
     */
    public function setMarkerIconWidth(int $markerIconWidth): void
    {
        $this->markerIconWidth = $markerIconWidth;
    }

    /**
     * @return int
     */
    public function getMarkerIconHeight(): int
    {
        // prevent using local markerIconHeight, if no markerIcon is set.
        if (
            empty($this->markerIconHeight)
            || (!empty($this->markerIconHeight) && $this->getMarkerIcons()->count() === 0)
        ) {
            $categoryWithIcon = $this->getFirstFoundCategoryWithIcon();
            if ($categoryWithIcon instanceof Category) {
                return $categoryWithIcon->getMaps2MarkerIconHeight();
            }
            /** @var ExtConf $extConf */
            $extConf = GeneralUtility::makeInstance(ExtConf::class);
            return $extConf->getMarkerIconHeight();
        }
        return $this->markerIconHeight;
    }

    /**
     * @param int $markerIconHeight
     */
    public function setMarkerIconHeight(int $markerIconHeight): void
    {
        $this->markerIconHeight = $markerIconHeight;
    }

    /**
     * @return int
     */
    public function getMarkerIconAnchorPosX(): int
    {
        // prevent using local markerIconAnchorPosX, if no markerIcon is set.
        if (
            empty($this->markerIconAnchorPosX)
            || (!empty($this->markerIconAnchorPosX) && $this->getMarkerIcons()->count() === 0)
        ) {
            $categoryWithIcon = $this->getFirstFoundCategoryWithIcon();
            if ($categoryWithIcon instanceof Category) {
                return $categoryWithIcon->getMaps2MarkerIconAnchorPosX();
            }
            /** @var ExtConf $extConf */
            $extConf = GeneralUtility::makeInstance(ExtConf::class);
            return $extConf->getMarkerIconAnchorPosX();
        }
        return $this->markerIconAnchorPosX;
    }

    /**
     * @param int $markerIconAnchorPosX
     */
    public function setMarkerIconAnchorPosX(int $markerIconAnchorPosX): void
    {
        $this->markerIconAnchorPosX = $markerIconAnchorPosX;
    }

    /**
     * @return int
     */
    public function getMarkerIconAnchorPosY(): int
    {
        // prevent using local markerIconAnchorPosY, if no markerIcon is set.
        if (
            empty($this->markerIconAnchorPosY)
            || (!empty($this->markerIconAnchorPosY) && $this->getMarkerIcons()->count() === 0)
        ) {
            $categoryWithIcon = $this->getFirstFoundCategoryWithIcon();
            if ($categoryWithIcon instanceof Category) {
                return $categoryWithIcon->getMaps2MarkerIconAnchorPosY();
            }
            /** @var ExtConf $extConf */
            $extConf = GeneralUtility::makeInstance(ExtConf::class);
            return $extConf->getMarkerIconAnchorPosY();
        }
        return $this->markerIconAnchorPosY;
    }

    /**
     * @param int $markerIconAnchorPosY
     */
    public function setMarkerIconAnchorPosY(int $markerIconAnchorPosY): void
    {
        $this->markerIconAnchorPosY = $markerIconAnchorPosY;
    }

    /**
     * @return float
     */
    public function getDistance(): float
    {
        return $this->distance;
    }

    /**
     * @param float $distance
     */
    public function setDistance(float $distance): void
    {
        $this->distance = $distance;
    }

    /**
     * @return array
     */
    public function getForeignRecords(): array
    {
        if ($this->foreignRecords === null) {
            $this->foreignRecords = [];
            /** @var MapService $mapService */
            $mapService = GeneralUtility::makeInstance(MapService::class);
            $mapService->addForeignRecordsToPoiCollection($this);
        }
        return $this->foreignRecords;
    }

    /**
     * @param array $foreignRecords
     */
    public function setForeignRecords(array $foreignRecords): void
    {
        foreach ($foreignRecords as $foreignRecord) {
            $this->addForeignRecord($foreignRecord);
        }
    }

    /**
     * @param array $foreignRecord
     */
    public function addForeignRecord(array $foreignRecord): void
    {
        if (!empty($foreignRecord)) {
            $this->foreignRecords[$foreignRecord['uid']] = $foreignRecord;
        }
    }

    /**
     * @param array $foreignRecord
     */
    public function removeForeignRecord(array $foreignRecord): void
    {
        unset($this->foreignRecords[$foreignRecord['uid']]);
    }
}
