<?php


namespace Firesphere\SolrSubsites\Tests;


use Firesphere\SolrSubsites\States\SubsiteState;
use SilverStripe\Dev\SapphireTest;

class SubsiteStateTest extends SapphireTest
{

    public function testIsApplicable()
    {
        $state = new SubsiteState();

        // There is always a first, thus true, It's a Subsite thing
        $this->assertTrue($state->stateIsApplicable(0));
    }
}
