<?php
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Core\UserBundle\Entity\country;

class LoadCountryData implements FixtureInterface
{
    /**
    *
    * @param ObjectManager $manager
    */
    public function load(ObjectManager $manager)
    {
        $countryName=array('Argentina', 'Uruguay', 'Paraguay','Brazil','Bolivia');
        for ($i = 0; $i < sizeof($countryName); $i++) {
            $this->createCountry($manager, $countryName[$i]);
        }
    }

    /**
    *
    * @param ObjectManager $manager
    * @param type $countryName
    */
    private function createCountry(ObjectManager $manager, $countryName)
    {
        $country = new country();
        $country->setName($countryName);
        

        $manager->persist($country);
        $manager->flush();
    }
}

