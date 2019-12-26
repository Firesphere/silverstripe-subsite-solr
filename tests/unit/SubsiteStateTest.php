<?php


namespace Firesphere\SolrSubsites\Tests;


use Firesphere\SolrSubsites\States\SubsiteState;
use SilverStripe\Dev\SapphireTest;

class SubsiteStateTest extends SapphireTest
{

    public function testIsApplicable()
    {
        $state = new SubsiteState();

        $this->assertFalse($state->stateIsApplicable(10));
        $this->assertTrue($state->stateIsApplicable(0));
    }
}
