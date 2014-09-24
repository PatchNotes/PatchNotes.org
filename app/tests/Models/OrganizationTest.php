<?php
namespace Models;

use TestCase;
use Organization;

class OrganizationTest extends TestCase {
    public function testIsInvalidWithoutAName() {
        $org = new Organization();

        $this->assertFalse($org->validate());
    }
}
