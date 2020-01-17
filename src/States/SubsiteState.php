<?php
/**
 * Class SubsiteState|Firesphere\SolrSubsites\States\SubsiteState Enable each subsite to be indexed independently by
 * switching the SiteState
 * {@see \Firesphere\SolrSearch\States\SiteState} and {@see \Firesphere\SolrSearch\Interfaces\SiteStateInterface}
 *
 * @package Firesphere\SolrSubsites\States
 * @author Simon `Firesphere` Erkelens; Marco `Sheepy` Hermo
 * @copyright Copyright (c) 2018 - now() Firesphere & Sheepy
 */


namespace Firesphere\SolrSubsites\States;

use Firesphere\SolrSearch\Interfaces\SiteStateInterface;
use Firesphere\SolrSearch\Queries\BaseQuery;
use Firesphere\SolrSearch\States\SiteState;
use SilverStripe\Core\ClassInfo;
use SilverStripe\ORM\DataObject;
use SilverStripe\Subsites\Model\Subsite;

/**
 * Class \Firesphere\SolrSubsites\States\SubsiteState
 *
 * Apply states for Subsites
 *
 * @package Firesphere\SolrSubsites\States
 */
class SubsiteState extends SiteState implements SiteStateInterface
{

    /**
     * Is this state applicable to this extension
     * In case of subsites, only apply if there actually are subsites
     *
     * @param int|string $state
     * @return bool
     */
    public function stateIsApplicable($state): bool
    {
        return Subsite::get()->byID($state) !== null;
    }

    /**
     * Reset the SiteState to it's default state
     * In case of subsites, we don't care about it, as it's handled at query time
     *
     * @param string|null $state
     * @return mixed
     */
    public function setDefaultState($state = null)
    {
        Subsite::changeSubsite($state);
    }

    /**
     * Return the current state of the site
     * The current state does not need to be reset in any way for pages
     *
     * @return string|null
     */
    public function currentState()
    {
        $subsite = Subsite::currentSubsite();
        return $subsite ? $subsite->ID : null;
    }

    /**
     * Activate a given state. This should only be done if the state is applicable
     * States don't need to be activated, as we index all pages anyway, so set it to disabled
     *
     * @param string $state
     * @return mixed
     * @todo This needs to properly set the state
     */
    public function activateState($state)
    {
        Subsite::$disable_subsite_filter = true;
    }

    /**
     * Method to alter the query. Can be no-op.
     *
     * @param BaseQuery $query
     * @return mixed
     */
    public function updateQuery(&$query)
    {
        // Only add a Subsite filter if there are actually subsites to filter on
        if (!Subsite::$disable_subsite_filter && Subsite::currentSubsite()) {
            foreach ($query->getClasses() as $class) {
                $this->addSubsiteFilter($query, $class);
            }
        }
    }

    /**
     * Add the Subsite specific filter if the class has the extension applied
     *
     * @param BaseQuery $query
     * @param string $class
     */
    protected function addSubsiteFilter(&$query, $class): void
    {
        if (DataObject::getSchema()->hasOneComponent($class, 'Subsite')) {
            $class = ClassInfo::shortName($class);
            $query->addFilter($class . '.SubsiteID', Subsite::currentSubsite()->ID);
        }
    }
}
