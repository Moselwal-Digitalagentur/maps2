<?php

declare(strict_types=1);

/*
 * This file is part of the package jweiland/maps2.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace JWeiland\Maps2\Client;

use JWeiland\Maps2\Client\Request\RequestInterface;
use JWeiland\Maps2\Helper\MessageHelper;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Abstract client to send Requests to Map Providers
 */
abstract class AbstractClient implements ClientInterface
{
    /**
     * @var MessageHelper
     */
    protected $messageHelper;

    /**
     * AbstractClient constructor.
     *
     * @param \JWeiland\Maps2\Helper\MessageHelper|null $messageHelper
     */
    public function __construct(MessageHelper $messageHelper = null)
    {
        $this->messageHelper = $messageHelper ?? GeneralUtility::makeInstance(MessageHelper::class);
    }

    /**
     * @param \JWeiland\Maps2\Client\Request\RequestInterface $request
     * @return array
     * @throws \TYPO3\CMS\Core\Exception
     */
    public function processRequest(RequestInterface $request): array
    {
        if (!$request->isValidRequest()) {
            $this->messageHelper->addFlashMessage(
                'URI is empty or contains invalid chars. URI: ' . $request->getUri(),
                'Invalid request URI',
                FlashMessage::ERROR
            );
            return [];
        }

        $processedResponse = [];
        $clientReport = [];
        $response = GeneralUtility::getUrl($request->getUri(), 0, null, $clientReport);
        $this->checkClientReportForErrors($clientReport);
        if (!$this->hasErrors()) {
            $processedResponse = json_decode($response, true);
            $this->checkResponseForErrors($processedResponse);
        }

        if ($this->hasErrors()) {
            $processedResponse = [];
        }

        return $processedResponse;
    }

    /**
     * @return bool
     */
    public function hasErrors(): bool
    {
        return $this->messageHelper->hasErrorMessages();
    }

    /**
     * @return FlashMessage[]
     */
    public function getErrors(): array
    {
        return $this->messageHelper->getErrorMessages();
    }

    /**
     * This method will only check the report of the client and not the result itself.
     *
     * @param array $clientReport
     */
    protected function checkClientReportForErrors(array $clientReport)
    {
        if (!empty($clientReport['message'])) {
            $this->messageHelper->addFlashMessage(
                $clientReport['message'],
                $clientReport['title'],
                $clientReport['severity']
            );
        }
    }

    /**
     * @param array|null $processedResponse
     * @return mixed
     */
    abstract protected function checkResponseForErrors(?array $processedResponse);
}
