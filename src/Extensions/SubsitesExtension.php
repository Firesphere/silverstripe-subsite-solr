<?php
/**
 * Class SubsitesExtension|Firesphere\SolrSubsites\Extensions\SubsitesExtension Add Subsite filter field to the index
 *
 * @package Firesphere\SolrSubsites\Extensions
 * @author Simon `Firesphere` Erkelens; Marco `Sheepy` Hermo
 * @copyright Copyright (c) 2018 - now() Firesphere & Sheepy
 */

namespace Firesphere\SolrSubsites\Extensions;

use Firesphere\SolrSearch\Indexes\BaseIndex;
use SilverStripe\Core\Extension;

/**
 * Class \Firesphere\SolrSubsites\Extensions\SubsitesExtension
 *
 * Add support for subsites in the Index for filtering
 *
 * @package Firesphere\SolrSearch\Subsites
 * @property BaseIndex|SubsitesExtension $owner
 */
class SubsitesExtension extends Extension
{
    /**
     * Add the subsite ID for each page, if subsites is enabled.
     */
    public function onAfterInit()
    {
        // Add default support for Subsites.
        /** @var BaseIndex $owner */
        $owner = $this->owner;
        $owner->addFilterField('SubsiteID');
    }
}
