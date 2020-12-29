<?php

declare(strict_types=1);

/*
 * This file is part of the package jweiland/maps2.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace JWeiland\Maps2\Configuration;

use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * This class will streamline the values from extension manager configuration
 */
class ExtConf implements SingletonInterface
{
    // general
    /**
     * @var string
     */
    protected $mapProvider = '';

    /**
     * @var string
     */
    protected $defaultMapProvider = '';

    /**
     * @var string
     */
    protected $defaultCountry = '';

    /**
     * @var
     */
    protected $defaultLatitude;

    /**
     * @var
     */
    protected $defaultLongitude;

    /**
     * @var int
     */
    protected $defaultRadius = 0;

    /**
     * @var bool
     */
    protected $explicitAllowMapProviderRequests = false;

    /**
     * @var bool
     */
    protected $explicitAllowMapProviderRequestsBySessionOnly = false;

    /**
     * @var string
     */
    protected $infoWindowContentTemplatePath = '';

    /**
     * @var string
     */
    protected $allowMapTemplatePath = '';

    // Google Maps

    /**
     * @var string
     */
    protected $googleMapsLibrary = '';

    /**
     * @var string
     */
    protected $googleMapsGeocodeUri = '';

    /**
     * @var string
     */
    protected $googleMapsJavaScriptApiKey = '';

    /**
     * @var string
     */
    protected $googleMapsGeocodeApiKey = '';

    // Open Street Map

    /**
     * @var string
     */
    protected $openStreetMapGeocodeUri = '';

    // Design/Color

    /**
     * @var string
     */
    protected $strokeColor = '';

    /**
     * @var
     */
    protected $strokeOpacity;

    /**
     * @var int
     */
    protected $strokeWeight = 0;

    /**
     * @var string
     */
    protected $fillColor = '';

    /**
     * @var
     */
    protected $fillOpacity;

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
     * ExtConf constructor.
     *
     * @param array|null $extConf
     */
    public function __construct(array $extConf = null)
    {
        if (!isset($extConf)) {
            $extConf = GeneralUtility::makeInstance(ExtensionConfiguration::class)->get('maps2');
        }
        if (is_array($extConf) && !empty($extConf)) {
            // call setter method foreach configuration entry
            foreach ($extConf as $key => $value) {
                $methodName = 'set' . ucfirst($key);
                if (method_exists($this, $methodName)) {
                    $this->$methodName($value);
                }
            }
        }
    }

    /**
     * @return string
     */
    public function getMapProvider(): string
    {
        if (empty($this->mapProvider)) {
            $this->mapProvider = 'both';
        }

        return $this->mapProvider;
    }

    /**
     * @param string $mapProvider
     */
    public function setMapProvider(string $mapProvider)
    {
        $this->mapProvider = $mapProvider;
    }

    /**
     * @return string
     */
    public function getDefaultMapProvider(): string
    {
        if (empty($this->defaultMapProvider)) {
            $this->defaultMapProvider = 'gm';
        }

        return $this->defaultMapProvider;
    }

    /**
     * @param string $defaultMapProvider
     */
    public function setDefaultMapProvider(string $defaultMapProvider)
    {
        $this->defaultMapProvider = $defaultMapProvider;
    }

    /**
     * @return string
     */
    public function getDefaultCountry(): string
    {
        return $this->defaultCountry;
    }

    /**
     * @param string $defaultCountry
     */
    public function setDefaultCountry(string $defaultCountry)
    {
        $this->defaultCountry = trim($defaultCountry);
    }

    /**
     * @return float
     */
    public function getDefaultLatitude(): float
    {
        if (empty($this->defaultLatitude)) {
            return 0.00;
        }
        return $this->defaultLatitude;
    }

    /**
     * @param $defaultLatitude
     */
    public function setDefaultLatitude($defaultLatitude)
    {
        $this->defaultLatitude = (float)$defaultLatitude;
    }

    /**
     * @return float
     */
    public function getDefaultLongitude(): float
    {
        if (empty($this->defaultLongitude)) {
            return 0.00;
        }
        return $this->defaultLongitude;
    }

    /**
     * @param $defaultLongitude
     */
    public function setDefaultLongitude($defaultLongitude)
    {
        $this->defaultLongitude = (float)$defaultLongitude;
    }

    /**
     * @return int
     */
    public function getDefaultRadius(): int
    {
        if (empty($this->defaultRadius)) {
            return 250;
        }
        return $this->defaultRadius;
    }

    /**
     * @param $defaultRadius
     */
    public function setDefaultRadius($defaultRadius)
    {
        $this->defaultRadius = (int)$defaultRadius;
    }

    /**
     * @return bool
     */
    public function getExplicitAllowMapProviderRequests(): bool
    {
        return $this->explicitAllowMapProviderRequests;
    }

    /**
     * @param $explicitAllowMapProviderRequests
     */
    public function setExplicitAllowMapProviderRequests($explicitAllowMapProviderRequests)
    {
        $this->explicitAllowMapProviderRequests = (bool)$explicitAllowMapProviderRequests;
    }

    /**
     * @return bool
     */
    public function getExplicitAllowMapProviderRequestsBySessionOnly(): bool
    {
        return $this->explicitAllowMapProviderRequestsBySessionOnly;
    }

    /**
     * @param $explicitAllowMapProviderRequestsBySessionOnly
     */
    public function setExplicitAllowMapProviderRequestsBySessionOnly($explicitAllowMapProviderRequestsBySessionOnly)
    {
        $this->explicitAllowMapProviderRequestsBySessionOnly = (bool)$explicitAllowMapProviderRequestsBySessionOnly;
    }

    /**
     * @return string
     */
    public function getInfoWindowContentTemplatePath(): string
    {
        if (empty($this->infoWindowContentTemplatePath)) {
            $this->infoWindowContentTemplatePath = 'EXT:maps2/Resources/Private/Templates/InfoWindowContent.html';
        }
        return $this->infoWindowContentTemplatePath;
    }

    /**
     * @param string $infoWindowContentTemplatePath
     */
    public function setInfoWindowContentTemplatePath(string $infoWindowContentTemplatePath)
    {
        $this->infoWindowContentTemplatePath = $infoWindowContentTemplatePath;
    }

    /**
     * @return string
     */
    public function getAllowMapTemplatePath(): string
    {
        if (empty($this->allowMapTemplatePath)) {
            $this->allowMapTemplatePath = 'EXT:maps2/Resources/Private/Templates/AllowMapForm.html';
        }
        return $this->allowMapTemplatePath;
    }

    /**
     * @param string $allowMapTemplatePath
     */
    public function setAllowMapTemplatePath(string $allowMapTemplatePath)
    {
        $this->allowMapTemplatePath = $allowMapTemplatePath;
    }

    /**
     * @return string
     */
    public function getGoogleMapsLibrary(): string
    {
        if (
            trim($this->googleMapsLibrary) === '|'
            || trim($this->googleMapsLibrary) === ''
        ) {
            $library = 'https://maps.googleapis.com/maps/api/js?key=|&libraries=places';
        } else {
            $library = $this->googleMapsLibrary;
        }

        if (!empty($library)) {
            // insert ApiKey
            $library = str_replace('|', $this->getGoogleMapsJavaScriptApiKey(), $library);
            // $parts: 0 = full string; 1 = s or empty; 2 = needed url
            if (preg_match('|^http(s)?://(.*)$|i', $library, $parts)) {
                return 'https://' . $parts[2];
            }
        }
        return '';
    }

    /**
     * @param string $googleMapsLibrary
     */
    public function setGoogleMapsLibrary(string $googleMapsLibrary)
    {
        $this->googleMapsLibrary = trim($googleMapsLibrary);
    }

    /**
     * @return string
     */
    public function getGoogleMapsGeocodeUri(): string
    {
        if (empty($this->googleMapsGeocodeUri)) {
            $this->googleMapsGeocodeUri = 'https://maps.googleapis.com/maps/api/geocode/json?address=%s&key=%s';
        }
        return $this->googleMapsGeocodeUri;
    }

    /**
     * @param string $googleMapsGeocodeUri
     */
    public function setGoogleMapsGeocodeUri(string $googleMapsGeocodeUri)
    {
        $this->googleMapsGeocodeUri = trim($googleMapsGeocodeUri);
    }

    /**
     * @return string
     */
    public function getGoogleMapsJavaScriptApiKey(): string
    {
        return $this->googleMapsJavaScriptApiKey;
    }

    /**
     * @param string $googleMapsJavaScriptApiKey
     */
    public function setGoogleMapsJavaScriptApiKey(string $googleMapsJavaScriptApiKey)
    {
        $this->googleMapsJavaScriptApiKey = trim($googleMapsJavaScriptApiKey);
    }

    /**
     * @return string
     */
    public function getGoogleMapsGeocodeApiKey(): string
    {
        return $this->googleMapsGeocodeApiKey;
    }

    /**
     * @param string $googleMapsGeocodeApiKey
     */
    public function setGoogleMapsGeocodeApiKey(string $googleMapsGeocodeApiKey)
    {
        $this->googleMapsGeocodeApiKey = trim($googleMapsGeocodeApiKey);
    }

    /**
     * @return string
     */
    public function getOpenStreetMapGeocodeUri(): string
    {
        if (empty($this->openStreetMapGeocodeUri)) {
            $this->openStreetMapGeocodeUri = 'https://nominatim.openstreetmap.org/search/%s?format=json&addressdetails=1';
        }
        return $this->openStreetMapGeocodeUri;
    }

    /**
     * @param string $openStreetMapGeocodeUri
     */
    public function setOpenStreetMapGeocodeUri(string $openStreetMapGeocodeUri)
    {
        $this->openStreetMapGeocodeUri = trim($openStreetMapGeocodeUri);
    }

    /**
     * @return string
     */
    public function getStrokeColor(): string
    {
        if (empty($this->strokeColor)) {
            return '#FF0000';
        }
        return $this->strokeColor;
    }

    /**
     * @param string $strokeColor
     */
    public function setStrokeColor(string $strokeColor)
    {
        $this->strokeColor = $strokeColor;
    }

    /**
     * @return float
     */
    public function getStrokeOpacity(): float
    {
        if (empty($this->strokeOpacity)) {
            return 0.8;
        }
        return $this->strokeOpacity;
    }

    /**
     * @param $strokeOpacity
     */
    public function setStrokeOpacity($strokeOpacity)
    {
        $this->strokeOpacity = (float)$strokeOpacity;
    }

    /**
     * @return int
     */
    public function getStrokeWeight(): int
    {
        if (empty($this->strokeWeight)) {
            return 2;
        }
        return $this->strokeWeight;
    }

    /**
     * @param $strokeWeight
     */
    public function setStrokeWeight($strokeWeight)
    {
        $this->strokeWeight = (int)$strokeWeight;
    }

    /**
     * @return string
     */
    public function getFillColor(): string
    {
        if (empty($this->fillColor)) {
            return '#FF0000';
        }
        return $this->fillColor;
    }

    /**
     * @param string $fillColor
     */
    public function setFillColor(string $fillColor)
    {
        $this->fillColor = $fillColor;
    }

    /**
     * @return float
     */
    public function getFillOpacity(): float
    {
        if (empty($this->fillOpacity)) {
            return 0.35;
        }
        return $this->fillOpacity;
    }

    /**
     * @param $fillOpacity
     */
    public function setFillOpacity($fillOpacity)
    {
        $this->fillOpacity = (float)$fillOpacity;
    }

    /**
     * @return int
     */
    public function getMarkerIconWidth(): int
    {
        return $this->markerIconWidth;
    }

    /**
     * @param $markerIconWidth
     */
    public function setMarkerIconWidth($markerIconWidth)
    {
        $this->markerIconWidth = (int)$markerIconWidth;
    }

    /**
     * @return int
     */
    public function getMarkerIconHeight(): int
    {
        return $this->markerIconHeight;
    }

    /**
     * @param $markerIconHeight
     */
    public function setMarkerIconHeight($markerIconHeight)
    {
        $this->markerIconHeight = (int)$markerIconHeight;
    }

    /**
     * @return int
     */
    public function getMarkerIconAnchorPosX(): int
    {
        return $this->markerIconAnchorPosX;
    }

    /**
     * @param $markerIconAnchorPosX
     */
    public function setMarkerIconAnchorPosX($markerIconAnchorPosX)
    {
        $this->markerIconAnchorPosX = (int)$markerIconAnchorPosX;
    }

    /**
     * @return int
     */
    public function getMarkerIconAnchorPosY(): int
    {
        return $this->markerIconAnchorPosY;
    }

    /**
     * @param $markerIconAnchorPosY
     */
    public function setMarkerIconAnchorPosY($markerIconAnchorPosY)
    {
        $this->markerIconAnchorPosY = (int)$markerIconAnchorPosY;
    }
}
