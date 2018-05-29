<?php
/**
 * Fastly CDN for Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Fastly CDN for Magento End User License Agreement
 * that is bundled with this package in the file LICENSE_FASTLY_CDN.txt.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Fastly CDN to newer
 * versions in the future. If you wish to customize this module for your
 * needs please refer to http://www.magento.com for more information.
 *
 * @category    Fastly
 * @package     Fastly_Cdn
 * @copyright   Copyright (c) 2016 Fastly, Inc. (http://www.fastly.com)
 * @license     BSD, see LICENSE_FASTLY_CDN.txt
 */
namespace Fastly\Cdn\Controller\Adminhtml\FastlyCdn;

use Fastly\Cdn\Model\Config;
use Fastly\Cdn\Model\Api;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Fastly\Cdn\Model\Statistic;
use Fastly\Cdn\Model\StatisticFactory;
use Fastly\Cdn\Model\StatisticRepository;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Filesystem\DirectoryList;

class PatternValidation extends Action
{
    /**
     * @var \Fastly\Cdn\Model\Api
     */
    private $api;

    /**
     * @var Config
     */
    private $config;

    /**
     * @var JsonFactory
     */
    private $resultJsonFactory;

    /**
     * @var Statistic
     */
    private $statistic;

    /**
     * @var StatisticFactory
     */
    private $statisticFactory;

    /**
     * @var StatisticRepository
     */
    private $statisticRepository;

    private $directoryList;

    private $reader;

    /**
     * TestConnection constructor.
     *
     * @param Context $context
     * @param Config $config
     * @param Api $api
     * @param JsonFactory $resultJsonFactory
     * @param Statistic $statistic
     * @param StatisticFactory $statisticFactory
     * @param StatisticRepository $statisticRepository
     */
    public function __construct(
        Context $context,
        Config $config,
        Api $api,
        JsonFactory $resultJsonFactory,
        Statistic $statistic,
        StatisticFactory $statisticFactory,
        StatisticRepository $statisticRepository,
        DirectoryList $directoryList
    ) {
        $this->api = $api;
        $this->config = $config;
        $this->resultJsonFactory = $resultJsonFactory;
        $this->statistic = $statistic;
        $this->statisticFactory = $statisticFactory;
        $this->statisticRepository = $statisticRepository;
        $this->directoryList = $directoryList;

        parent::__construct($context);
    }


    public function execute()
    {
        $result = $this->resultJsonFactory->create();
        $path = 'json_templates/';
        $moduleEtcPath = $this->config->getJsonTemplates();
        $filePath = $moduleEtcPath . '/' . $path;
        $json = file_get_contents($filePath . 'ttl.json');
        $decodedJson = json_decode($json, true);
        $templateData = $decodedJson['vcl']['0']['template'];
        $entryTemplate = $decodedJson['properties']['0']['entryTemplate'];

        return $result->setData([
            'status'        => true,
            'data'  => $templateData
        ]);
    }
}
