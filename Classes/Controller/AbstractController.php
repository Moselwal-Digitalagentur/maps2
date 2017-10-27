<?php
namespace JWeiland\Maps2\Controller;

/*
 * This file is part of the maps2 project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use JWeiland\Maps2\Configuration\ExtConf;
use JWeiland\Maps2\Service\MapService;
use JWeiland\Maps2\Utility\DataMapper;
use JWeiland\Maps2\Utility\GeocodeUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Mvc\View\ViewInterface;
use TYPO3\CMS\Extbase\Reflection\ObjectAccess;

/**
 * Class AbstractController
 *
 * @category Controller
 * @package  Maps2
 * @author   Stefan Froemken <projects@jweiland.net>
 * @license  http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @link     https://github.com/jweiland-net/maps2
 */
class AbstractController extends ActionController
{
    /**
     * @var ExtConf
     */
    protected $extConf;

    /**
     * @var DataMapper
     */
    protected $dataMapper;

    /**
     * @var GeocodeUtility
     */
    protected $geocodeUtility;

    /**
     * @var MapService
     */
    protected $mapService;

    /**
     * inject extConf
     *
     * @param ExtConf $extConf
     *
     * @return void
     */
    public function injectExtConf(ExtConf $extConf)
    {
        $this->extConf = $extConf;
    }

    /**
     * inject dataMapper
     *
     * @param DataMapper $dataMapper
     *
     * @return void
     */
    public function injectDataMapper(DataMapper $dataMapper)
    {
        $this->dataMapper = $dataMapper;
    }

    /**
     * inject geocodeUtility
     *
     * @param GeocodeUtility $geocodeUtility
     *
     * @return void
     */
    public function injectGeocodeUtility(GeocodeUtility $geocodeUtility)
    {
        $this->geocodeUtility = $geocodeUtility;
    }

    /**
     * inject mapService
     *
     * @param MapService $mapService
     *
     * @return void
     */
    public function injectMapService(MapService $mapService)
    {
        $this->mapService = $mapService;
    }

    /**
     * Initializes the controller before invoking an action method.
     *
     * @return void
     */
    public function initializeAction()
    {
        $this->settings['infoWindowContentTemplatePath'] = trim($this->settings['infoWindowContentTemplatePath']);
        $this->mapService->explicitAllowGoogleMapRequests($this->request);
    }

    /**
     * initialize view
     * add some global vars to view
     *
     * @param ViewInterface $view The view to be initialized
     *
     * @return void
     */
    public function initializeView(ViewInterface $view)
    {
        $view->assign('data', $this->configurationManager->getContentObject()->data);
        $view->assign('environment', array(
            'settings' => $this->settings,
            'extConf' => ObjectAccess::getGettableProperties($this->extConf),
            'id' => $GLOBALS['TSFE']->id,
            'contentRecord' => $this->configurationManager->getContentObject()->data
        ));
    }
}
