<?php
/*
* (c) Wessel Strengholt <wessel.strengholt@gmail.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Usoft\PostcodeBundle\Model;

/**
 * Class Address
 *
 * @author Wessel Strengholt <wessel.strengholt@gmail.com>
 */
class Address
{
    /** @var string */
    private $street;

    /** @var string */
    private $zipcode;

    /** @var string */
    private $city;

    /** @var string */
    private $number;

    /**
     * @param string $street
     * @param string $zipcode
     * @param string $city
     * @param string $number
     */
    public function __construct($street, $zipcode, $city, $number)
    {
        $this->street  = $street;
        $this->zipcode = $zipcode;
        $this->city    = $city;
        $this->number  = $number;
    }

    /**
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * @return string
     */
    public function getZipcode()
    {
        return $this->zipcode;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'street'        => $this->getStreet(),
            'zipcode'       => $this->getZipcode(),
            'city'          => $this->getCity(),
            'house_number'  => $this->getNumber(),
        ];
    }
}
