<?php


namespace Firesphere\SolrSearch\Subsites;

use Firesphere\SolrSearch\Indexes\BaseIndex;
use SilverStripe\ORM\DataExtension;

/**
 * Class \Firesphere\SolrSearch\Subsites\SubsitesExtension
 * Add support for subsites
 *
 * @package Firesphere\SolrSearch\Subsites
 * @property BaseIndex|SubsitesExtension $owner
 */
class SubsitesExtension extends DataExtension
{
    /**
     * Add the subsite ID for each page, if subsites is enabled.
     */
    public function onBeforeInit()
    {
        // Add default support for Subsites.
        if (class_exists('SilverStripe\\Subsites\\Model\\Subsite')) {
            /** @var BaseIndex $owner */
            $owner = $this->owner;
            $owner->addFilterField('SubsiteID');
        }
    }
}
