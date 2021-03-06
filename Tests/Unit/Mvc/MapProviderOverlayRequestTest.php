<?php

/*
 * This file is part of the package jweiland/maps2.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace JWeiland\Maps2\Tests\Unit\Mvc;

use JWeiland\Maps2\Configuration\ExtConf;
use JWeiland\Maps2\Mvc\MapProviderOverlayRequestHandler;
use JWeiland\Maps2\Service\MapService;
use Nimut\TestingFramework\TestCase\UnitTestCase;
use Prophecy\Prophecy\ObjectProphecy;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Mvc\Web\Response;
use TYPO3\CMS\Extbase\Object\ObjectManager;

/**
 * Class MapProviderOverlayRequest
 */
class MapProviderOverlayRequestTest extends UnitTestCase
{
    /**
     * @var ObjectManager|ObjectProphecy
     */
    protected $objectManager;

    /**
     * @var MapProviderOverlayRequestHandler
     */
    protected $subject;

    protected function setUp()
    {
        $_SESSION['mapProviderRequestsAllowedForMaps2'] = false;

        $extConf = new ExtConf([]);
        $extConf->setExplicitAllowMapProviderRequests(1);
        $extConf->setExplicitAllowMapProviderRequestsBySessionOnly(1);
        GeneralUtility::setSingletonInstance(ExtConf::class, $extConf);

        $this->objectManager = $this->prophesize(ObjectManager::class);

        $this->subject = new MapProviderOverlayRequestHandler($this->objectManager->reveal());
    }

    protected function tearDown()
    {
        unset($this->googleMapsService, $this->mapProviderRequestService, $this->subject);
        parent::tearDown();
    }

    /**
     * @test
     */
    public function canHandleRequestWillReturnFalseInCliContext()
    {
        Environment::initialize(
            Environment::getContext(),
            true,
            false,
            Environment::getProjectPath(),
            Environment::getPublicPath(),
            Environment::getVarPath(),
            Environment::getConfigPath(),
            Environment::getBackendPath() . '/index.php',
            Environment::isWindows() ? 'WINDOWS' : 'UNIX'
        );

        self::assertFalse(
            $this->subject->canHandleRequest()
        );
    }

    /**
     * @test
     */
    public function canHandleRequestWillReturnFalseWhenExtKeyIsNotMaps2()
    {
        Environment::initialize(
            Environment::getContext(),
            false,
            false,
            Environment::getProjectPath(),
            Environment::getPublicPath(),
            Environment::getVarPath(),
            Environment::getConfigPath(),
            Environment::getBackendPath() . '/index.php',
            Environment::isWindows() ? 'WINDOWS' : 'UNIX'
        );

        /** @var ConfigurationManagerInterface|ObjectProphecy $configurationManager */
        $configurationManager = $this->prophesize(ConfigurationManagerInterface::class);
        $configurationManager
            ->getConfiguration('Framework')
            ->shouldBeCalled()
            ->willReturn([
                'extensionName' => 'events2'
            ]);
        $this->objectManager
            ->get(ConfigurationManagerInterface::class)
            ->shouldBeCalled()
            ->willReturn($configurationManager->reveal());

        self::assertFalse(
            $this->subject->canHandleRequest()
        );
    }

    /**
     * @test
     */
    public function canHandleRequestWillReturnTrueWhenExtKeyIsMaps2()
    {
        Environment::initialize(
            Environment::getContext(),
            false,
            false,
            Environment::getProjectPath(),
            Environment::getPublicPath(),
            Environment::getVarPath(),
            Environment::getConfigPath(),
            Environment::getBackendPath() . '/index.php',
            Environment::isWindows() ? 'WINDOWS' : 'UNIX'
        );

        /** @var ConfigurationManagerInterface|ObjectProphecy $configurationManager */
        $configurationManager = $this->prophesize(ConfigurationManagerInterface::class);
        $configurationManager
            ->getConfiguration('Framework')
            ->shouldBeCalled()
            ->willReturn([
                'extensionName' => 'maps2'
            ]);
        $this->objectManager
            ->get(ConfigurationManagerInterface::class)
            ->shouldBeCalled()
            ->willReturn($configurationManager->reveal());

        self::assertTrue(
            $this->subject->canHandleRequest()
        );
    }

    /**
     * @test
     */
    public function getPriorityReturnsHigherValueThan100()
    {
        self::assertGreaterThan(
            100,
            $this->subject->getPriority()
        );
    }

    /**
     * @test
     */
    public function handleRequestWillAppendMapFormToContent()
    {
        $testString = 'testHtml';

        $response = new Response();
        $this->objectManager->get(Response::class)->shouldBeCalled()->willReturn($response);

        /** @var MapService|ObjectProphecy $mapService */
        $mapService = $this->prophesize(MapService::class);
        $mapService->showAllowMapForm()->shouldBeCalled()->willReturn($testString);
        GeneralUtility::addInstance(MapService::class, $mapService->reveal());

        self::assertSame(
            $testString,
            $this->subject->handleRequest()->getContent()
        );
    }
}
