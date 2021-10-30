<?php

/**
 * Interface IFrontendIterable
 */
interface IFrontendIterable
{
    /**
     * @param string $context
     * @return array
     */
    public function getFrontendIteration(string $context = ''):array;
}