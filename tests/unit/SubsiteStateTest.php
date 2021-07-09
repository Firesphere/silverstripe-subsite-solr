<?php


namespace Firesphere\SolrSubsites\Tests;

use Firesphere\SolrSearch\Queries\BaseQuery;
use Firesphere\SolrSubsites\States\SubsiteState;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Dev\SapphireTest;
use SilverStripe\Subsites\Model\Subsite;
use SilverStripe\Subsites\State\SubsiteState as SubsiteStateHandler;

class SubsiteStateTest extends SapphireTest
{
    public function testIsApplicable()
    {
        $state = new SubsiteState();

        $this->assertFalse($state->stateIsApplicable(0));
    }

    public function testSetDefaultState()
    {
        $state = new SubsiteState();

        $this->assertNull($state->setDefaultState(0));
    }

    public function testCurrentState()
    {
        $state = new SubsiteState();

        $this->assertNull($state->currentState());
    }

    public function testActivateState()
    {
        $state = new SubsiteState();
        $state->activateState(0);

        $this->assertFalse(Subsite::$disable_subsite_filter);
        $this->assertNull(Subsite::currentSubsite());
    }

    public function testUpdateQuery()
    {
        $state = new SubsiteState();
        Subsite::$disable_subsite_filter = false;
        $query = new BaseQuery();
        $query->addClass(SiteTree::class);

        $state->updateQuery($query);

        $result = $query->getFilter();

        $this->assertNotContains('SiteTree_SubsiteID', $result);

        $id = Subsite::create(['Title' => 'Hello'])->write();

        SubsiteStateHandler::singleton()->setUseSessions(true);
        Subsite::changeSubsite($id);

        $state->updateQuery($query);

        $result = $query->getFilter();

        $this->assertArrayHasKey('SiteTree_SubsiteID', $result);
    }
}
