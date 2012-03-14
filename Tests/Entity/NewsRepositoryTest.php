<?php

namespace Gpupo\CamelSpiderBundle\Entity;

class NewsRepositoryTest extends \PHPUnit_Framework_TestCase {


    public function testTextParts()
    {

        $text = <<<EOF
When declaring associative arrays with the Array construct,
breaking the statement into multiple lines is encouraged. In this case,
each successive line must be padded with white space such that both the
keys and the values are aligned
EOF;

        $count = mb_strlen(trim($text));
        $this->assertEquals(235, $count);

        $repository = new NewsRepository(
            'News', new \Doctrine\ORM\Mapping\ClassMetadata('\Gpupo\CamelSpiderBundle\Entity\News')
        );
        // Test with pieces of 100 chars 
        $parts = $repository->getContentParts($text, 100);
        $this->assertEquals(235, $parts['len']);
        $this->assertEquals(3, count($parts['pieces']));

        foreach ($parts['pieces'] as $piece) {
            $this->assertTrue(80 < mb_strlen($piece));
            $this->assertTrue(101 > mb_strlen($piece));
        }
        // Test with pieces of 100 chars
        $parts = $repository->getContentParts($text, 300);
        $this->assertEquals(235, $parts['len']);
        $this->assertEquals(1, count($parts['pieces']));

        foreach ($parts['pieces'] as $piece) {
            $this->assertTrue(235 == mb_strlen($piece));
        }
        // Test with pieces of 200 chars
        $parts = $repository->getContentParts($text, 200);
        $this->assertEquals(235, $parts['len']);
        $this->assertEquals(2, count($parts['pieces']));

        foreach ($parts['pieces'] as $piece) {
            $this->assertTrue(180 < mb_strlen($piece));
            $this->assertTrue(201 > mb_strlen($piece));
        }
    }
}
