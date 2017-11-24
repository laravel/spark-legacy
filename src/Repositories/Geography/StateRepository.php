<?php

namespace Laravel\Spark\Repositories\Geography;

use Laravel\Spark\Contracts\Repositories\Geography\StateRepository as Contract;

class StateRepository implements Contract
{
    /**
     * {@inheritdoc}
     */
    public function abbreviationListForCountry($country)
    {
        return $this->forCountry($country)->pluck('abbreviation')->implode(',');
    }

    /**
     * {@inheritdoc}
     */
    public function forCountry($country)
    {
        switch ($country) {
            case 'US':
                return collect($this->getUsStates());

            case 'CA':
                return collect($this->getCanadianProvinces());

            default:
                return collect([]);
        }
    }

    /**
     * Get all of the US states.
     *
     * @return array
     */
    protected function getUsStates()
    {
        return [
            ['name' => __('Alabama'), 'abbreviation' => 'AL'],
            ['name' => __('Alaska'), 'abbreviation' => 'AK'],
            ['name' => __('American Samoa'), 'abbreviation' => 'AS'],
            ['name' => __('Arizona'), 'abbreviation' => 'AZ'],
            ['name' => __('Arkansas'), 'abbreviation' => 'AR'],
            ['name' => __('California'), 'abbreviation' => 'CA'],
            ['name' => __('Colorado'), 'abbreviation' => 'CO'],
            ['name' => __('Connecticut'), 'abbreviation' => 'CT'],
            ['name' => __('Delaware'), 'abbreviation' => 'DE'],
            ['name' => __('District of Columbia'), 'abbreviation' => 'DC'],
            ['name' => __('Federated States Of Micronesia'), 'abbreviation' => 'FM'],
            ['name' => __('Florida'), 'abbreviation' => 'FL'],
            ['name' => __('Georgia'), 'abbreviation' => 'GA'],
            ['name' => __('Guam'), 'abbreviation' => 'GU'],
            ['name' => __('Hawaii'), 'abbreviation' => 'HI'],
            ['name' => __('Idaho'), 'abbreviation' => 'ID'],
            ['name' => __('Illinois'), 'abbreviation' => 'IL'],
            ['name' => __('Indiana'), 'abbreviation' => 'IN'],
            ['name' => __('Iowa'), 'abbreviation' => 'IA'],
            ['name' => __('Kansas'), 'abbreviation' => 'KS'],
            ['name' => __('Kentucky'), 'abbreviation' => 'KY'],
            ['name' => __('Louisiana'), 'abbreviation' => 'LA'],
            ['name' => __('Maine'), 'abbreviation' => 'ME'],
            ['name' => __('Marshall Islands'), 'abbreviation' => 'MH'],
            ['name' => __('Maryland'), 'abbreviation' => 'MD'],
            ['name' => __('Massachusetts'), 'abbreviation' => 'MA'],
            ['name' => __('Michigan'), 'abbreviation' => 'MI'],
            ['name' => __('Minnesota'), 'abbreviation' => 'MN'],
            ['name' => __('Mississippi'), 'abbreviation' => 'MS'],
            ['name' => __('Missouri'), 'abbreviation' => 'MO'],
            ['name' => __('Montana'), 'abbreviation' => 'MT'],
            ['name' => __('Nebraska'), 'abbreviation' => 'NE'],
            ['name' => __('Nevada'), 'abbreviation' => 'NV'],
            ['name' => __('New Hampshire'), 'abbreviation' => 'NH'],
            ['name' => __('New Jersey'), 'abbreviation' => 'NJ'],
            ['name' => __('New Mexico'), 'abbreviation' => 'NM'],
            ['name' => __('New York'), 'abbreviation' => 'NY'],
            ['name' => __('North Carolina'), 'abbreviation' => 'NC'],
            ['name' => __('North Dakota'), 'abbreviation' => 'ND'],
            ['name' => __('Northern Mariana Islands'), 'abbreviation' => 'MP'],
            ['name' => __('Ohio'), 'abbreviation' => 'OH'],
            ['name' => __('Oklahoma'), 'abbreviation' => 'OK'],
            ['name' => __('Oregon'), 'abbreviation' => 'OR'],
            ['name' => __('Palau'), 'abbreviation' => 'PW'],
            ['name' => __('Pennsylvania'), 'abbreviation' => 'PA'],
            ['name' => __('Rhode Island'), 'abbreviation' => 'RI'],
            ['name' => __('South Carolina'), 'abbreviation' => 'SC'],
            ['name' => __('South Dakota'), 'abbreviation' => 'SD'],
            ['name' => __('Tennessee'), 'abbreviation' => 'TN'],
            ['name' => __('Texas'), 'abbreviation' => 'TX'],
            ['name' => __('Utah'), 'abbreviation' => 'UT'],
            ['name' => __('Vermont'), 'abbreviation' => 'VT'],
            ['name' => __('Virgin Islands'), 'abbreviation' => 'VI'],
            ['name' => __('Virginia'), 'abbreviation' => 'VA'],
            ['name' => __('Washington'), 'abbreviation' => 'WA'],
            ['name' => __('West Virginia'), 'abbreviation' => 'WV'],
            ['name' => __('Wisconsin'), 'abbreviation' => 'WI'],
            ['name' => __('Wyoming'), 'abbreviation' => 'WY'],
            ['name' => __('Armed Forces Africa / Canada / Europe / Middle East'), 'abbreviation' => 'AE'],
            ['name' => __('Armed Forces America (Except Canada)'), 'abbreviation' => 'AA'],
            ['name' => __('Armed Forces Pacific'), 'abbreviation' => 'AP'],
        ];
    }

    /**
     * Get all of the Canadian provinces.
     *
     * @return array
     */
    protected function getCanadianProvinces()
    {
        return [
            ['name' => __('Alberta'), 'abbreviation' => 'AB'],
            ['name' => __('British Columbia'), 'abbreviation' => 'BC'],
            ['name' => __('Manitoba'), 'abbreviation' => 'MB'],
            ['name' => __('New Brunswick'), 'abbreviation' => 'NB'],
            ['name' => __('Newfoundland and Labrador'), 'abbreviation' => 'NL'],
            ['name' => __('Northwest Territories'), 'abbreviation' => 'NT'],
            ['name' => __('Nova Scotia'), 'abbreviation' => 'NS'],
            ['name' => __('Nunavut'), 'abbreviation' => 'NU'],
            ['name' => __('Ontario'), 'abbreviation' => 'ON'],
            ['name' => __('Prince Edward Island'), 'abbreviation' => 'PE'],
            ['name' => __('Quebec'), 'abbreviation' => 'QC'],
            ['name' => __('Saskatchewan'), 'abbreviation' => 'SK'],
            ['name' => __('Yukon'), 'abbreviation' => 'YT'],
        ];
    }
}
