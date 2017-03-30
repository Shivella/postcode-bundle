<?php
/*
* (c) Wessel Strengholt <wessel.strengholt@gmail.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Usoft\PostcodeBundle\Tests\Model;

use PHPUnit\Framework\TestCase;
use Usoft\PostcodeBundle\Model\Address;

/**
 * Class AddressTest
 *
 * @author Wessel Strengholt <wessel.strengholt@gmail.com>
 */
class AddressTest extends TestCase
{
    public function testAddress()
    {
        $address = new Address('Test Street', '1010AB', 'Haarlem', 666, 'Noord-Holland');
        $address->setGeoLocation(['lat' => 42.3243, 'long' => 32.3424]);

        $this->assertSame($address->getStreet(), 'Test Street');
        $this->assertSame($address->getZipcode(), '1010AB');
        $this->assertSame($address->getCity(), 'Haarlem');
        $this->assertSame($address->getNumber(), 666);
        $this->assertSame($address->getProvince(), 'Noord-Holland');
        $this->assertSame($address->getGeoLocation(), ['lat' => 42.3243, 'long' => 32.3424]);

        $this->assertSame([
            'street'        => 'Test Street',
            'zipcode'       => '1010AB',
            'city'          => 'Haarlem',
            'house_number'  => 666,
            'province'      => 'Noord-Holland',
            'geo_location'  => ['lat' => 42.3243, 'long' => 32.3424],
        ], $address->toArray());
    }
}
