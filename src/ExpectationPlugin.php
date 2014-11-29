<?php

/**
 * This file is part of peridot-expectation package.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace expectation\peridot;

use expectation\Expectation;
use Evenement\EventEmitterInterface;


/**
 * Class ExpectationPlugin
 * @package expectation\peridot
 */
class ExpectationPlugin implements RegistrarInterface
{

    /**
     * @var string
     */
    private $configFilePath;


    /**
     * @param string|null $configurationFile
     */
    public function __construct($configFilePath = null)
    {
        $this->configFilePath = $configFilePath;
    }

    /**
     * @return ExpectationPlugin
     */
    public static function create()
    {
        return new self();
    }

    /**
     * @param string $configFilePath
     * @return ExpectationPlugin
     */
    public static function createWithConfig($configFilePath)
    {
        return new self($configFilePath);
    }

    /**
     * @return null|string
     */
    public function getConfigurationFilePath()
    {
        return $this->configFilePath;
    }

    /**
     * @return bool
     */
    public function isEmptyConfig()
    {
        return is_null($this->getConfigurationFilePath());
    }

    /**
     * {@inheritdoc}
     */
    public function registerTo(EventEmitterInterface $emitter)
    {
        $emitter->once(static::START_EVENT, [ $this, 'onPeridotStart' ]);
    }

    public function onPeridotStart()
    {
        if ($this->isEmptyConfig()) {
            Expectation::configure();
        } else {
            Expectation::configureWithFile($this->getConfigurationFilePath());
        }

        require_once __DIR__  . '/DSL.php';
    }

}
