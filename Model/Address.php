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

    /** @var integer */
    private $number;

    /** @var string */
    private $province;

    /** @var array */
    private $geoLocation;

    /**
     * @param string  $street
     * @param string  $zipcode
     * @param string  $city
     * @param integer $number
     * @param string  $province
     */
    public function __construct($street, $zipcode, $city, $number, $province)
    {
        $this->street   = $street;
        $this->zipcode  = $zipcode;
        $this->city     = $city;
        $this->number   = $number;
        $this->province = $province;
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
     * @return integer
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @return string
     */
    public function getProvince()
    {
        return $this->province;
    }

    /**
     * @return array
     */
    public function getGeoLocation()
    {
        return $this->geoLocation;
    }

    /**
     * @param array $geoLocation
     */
    public function setGeoLocation($geoLocation)
    {
        $this->geoLocation = $geoLocation;
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
            'province'      => $this->getProvince(),
            'geo_location'  => $this->getGeoLocation(),
        ];
    }
}
