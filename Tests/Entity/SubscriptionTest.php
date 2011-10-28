<?php

namespace Gpupo\CamelSpiderBundle\Entity;

class SubscriptionTest extends \PHPUnit_Framework_TestCase {

    /**
     * @dataProvider providerKeywords
     */
    public function testNormalize($input, $normalized, $count)
    {
        $subscription = new Subscription;
        $string = $subscription->normalize($input);
        $this->assertInternalType('string', $string);
        $this->assertEquals($normalized, $string);
    }

    /**
     * @dataProvider providerKeywords
     */
    public function testExplode($input, $normalized, $count)
    {
        $subscription = new Subscription;
        $array = $subscription->_explode($input);
        $this->assertInternalType('array', $array);
        $this->assertEquals($count, count($array));
    }


    public function providerKeywords()
    {
        return array(
            array('type, fire, mass', 'type,fire,mass', 3),
            array('type, fire, mass,detected', 'type,fire,mass,detected', 4),
            array('type, fire ,mass, detected', 'type,fire,mass,detected', 4),
            array('type,fire,mass,detected', 'type,fire,mass,detected', 4),
            array($this->getText(), 'Seasonality,according,history,is about,Phrase Aplha', 5),

        );
    }

    public function getText()
    {
        return <<<EOF
            Seasonality
            according
            history
            is about
            Phrase Aplha
EOF;
    }
}
