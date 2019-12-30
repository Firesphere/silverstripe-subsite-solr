<?php


namespace Firesphere\SolrSubsites\Tests;


use Firesphere\SolrSearch\Queries\BaseQuery;
use Firesphere\SolrSubsites\States\SubsiteState;
use SilverStripe\Dev\SapphireTest;
use SilverStripe\Subsites\Model\Subsite;

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

        $this->assertTrue(Subsite::$disable_subsite_filter);
    }

    public function testUpdateQuery()
    {
        $this->markTestSkipped('No Subsites to test against yet');
        $state = new SubsiteState();
        Subsite::$disable_subsite_filter = false;
        Subsite::create([]);
        $query = new BaseQuery();

        $state->updateQuery($query);

        $result = $query->getFilter();

        $this->assertArrayHasKey('SubsiteID', $result);
    }
}
