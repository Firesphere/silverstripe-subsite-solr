<?php


namespace Firesphere\SolrSubsites\States;


use Firesphere\SolrSearch\Interfaces\SiteStateInterface;
use Firesphere\SolrSearch\Queries\BaseQuery;
use Firesphere\SolrSearch\States\SiteState;
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
     * @param string $state
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
        if (Subsite::$disable_subsite_filter !== false) {
            $query->addFilter('SubsiteID', Subsite::getSubsiteIDForDomain());
        }
    }
}
