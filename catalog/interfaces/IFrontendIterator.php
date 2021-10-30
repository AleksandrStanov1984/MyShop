<?php

/**
 * Interface IFrontendIterator
 */
interface IFrontendIterator
{
    /**
     * @param IFrontendIterable $object
     * @return array
     */
    public function getData(IFrontendIterable $object):array;

    /**
     * @return string
     */
    public function getContext():string;

    /**
     * @param IFrontendIterable $object
     * @return boolean
     */
    public function run(IFrontendIterable $object): bool;
}