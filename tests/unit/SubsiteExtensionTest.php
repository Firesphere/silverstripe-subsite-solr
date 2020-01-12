<?php


namespace Firesphere\SolrSubsites\Tests;

use SilverStripe\Dev\SapphireTest;

class SubsiteExtensionTest extends SapphireTest
{
    public function testOnAfterInit()
    {
        $index = new TestIndex();

        $fields = $index->getFilterFields();

        $this->assertTrue(in_array('SubsiteID', $fields));
    }
}
