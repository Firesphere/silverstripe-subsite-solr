<?php


namespace Firesphere\SolrSubsites\Tests;


use SilverStripe\Dev\Debug;
use SilverStripe\Dev\SapphireTest;

class SubsiteExtensionTest extends SapphireTest
{

    public function testOnAfterInit()
    {
        $index = new TestIndex();

        $fields = $index->getFilterFields();

        Debug::dump($fields);

        $this->assertTrue(in_array('SubsiteID', $fields));
    }
}
