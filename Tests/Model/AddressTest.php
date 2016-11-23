<?php
/*
* (c) Wessel Strengholt <wessel.strengholt@gmail.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Usoft\PostcodeBundle\Tests\Model;

use Usoft\PostcodeBundle\Model\Address;

/**
 * Class AddressTest
 *
 * @author Wessel Strengholt <wessel.strengholt@gmail.com>
 */
class AddressTest extends \PHPUnit_Framework_TestCase
{
    public function testAddress()
    {
        $address = new Address('Test Street', '1010AB', 'Haarlem', 666, 'Noord-Holland');

        $this->assertSame($address->getStreet(), 'Test Street');
        $this->assertSame($address->getZipcode(), '1010AB');
        $this->assertSame($address->getCity(), 'Haarlem');
        $this->assertSame($address->getNumber(), 666);
        $this->assertSame($address->getProvince(), 'Noord-Holland');

        $this->assertSame([
            'street'        => 'Test Street',
            'zipcode'       => '1010AB',
            'city'          => 'Haarlem',
            'house_number'  => 666,
            'province'      => 'Noord-Holland',
        ], $address->toArray());
    }
}
