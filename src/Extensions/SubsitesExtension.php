<?php
/**
 * Class SubsitesExtension|Firesphere\SolrSubsites\Extensions\SubsitesExtension Add Subsite filter field to the index
 *
 * @package Firesphere\Solr\Subsites
 * @author Simon `Firesphere` Erkelens; Marco `Sheepy` Hermo
 * @copyright Copyright (c) 2018 - now() Firesphere & Sheepy
 */

namespace Firesphere\SolrSubsites\Extensions;

use Firesphere\SolrSearch\Indexes\BaseIndex;
use Firesphere\SolrSearch\States\SiteState;
use SilverStripe\Core\Extension;
use SilverStripe\Subsites\Model\Subsite;

/**
 * Class \Firesphere\SolrSubsites\Extensions\SubsitesExtension
 *
 * Add support for subsites in the Index for filtering
 *
 * @package Firesphere\Solr\Subsites
 * @property BaseIndex|SubsitesExtension $owner
 */
class SubsitesExtension extends Extension
{
    /**
     * Add default unfiltered state
     */
    public function onBeforeInit()
    {
        $sites = Subsite::get()->filter(['IsPublic' => true]);
        SiteState::addStates($sites->getIDList());
    }

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
