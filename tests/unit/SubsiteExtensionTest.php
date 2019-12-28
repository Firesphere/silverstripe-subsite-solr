<?php


namespace Firesphere\SolrSubsites\Tests;


use Firesphere\SolrSubsites\Tests\TestIndex;
use SilverStripe\Dev\SapphireTest;

class SubsiteExtensionTest extends SapphireTest
{

    public function testOnAfterInit()
    {
        $index = new TestIndex();

        $fields = $index->getFilterFields();

        $this->assertArrayHasKey('SubsiteID', $fields);
    }
}
