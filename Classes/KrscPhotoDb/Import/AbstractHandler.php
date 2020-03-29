<?php
namespace KrscPhotoDb\Import;

/**
 * This file is part of Krsc-Photo-Db.
 *
 * Abstract class for Chain-of-responsibility pattern.
 *
 * @category KrscPhotoDb\Import
 * @copyright Copyright (c) 2020 Krzysztof Ruszczyński
 * @license https://www.gnu.org/licenses/gpl-3.0.html GPL
 * @author Krzysztof Ruszczyński <https://www.ruszczynski.eu>
 * @version 1.0.0, 2020-03-29
 */
abstract class AbstractHandler
{
    /**
     * @var AbstractHandler next object in chain-of-responsibility pattern
     */
    protected $_oNext;

    /**
     * @var string|array data needed for this particular chain (every chain can have different requirements)
     */
    protected $_mData;

    /**
     * Method for setting next object in chain-of-responsibility pattern.
     *
     * @param AbstractHandler $oNext
     *
     * @return AbstractHandler next object
     */
    public function appendNext(AbstractHandler $oNext)
    {
        $this->_oNext = $oNext;

        return $this->_oNext;
    }

    /**
     * Method setting data for this chain.
     *
     * @param mixed $mData data needed for this particular chain (every chain can have different requirements)
     *
     * @return $this
     */
    public function setData($mData)
    {
        $this->_mData = $mData;

        return $this;
    }

    abstract public function process();
}
