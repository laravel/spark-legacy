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
            ['name' => 'Alabama', 'abbreviation' => 'AL'],
            ['name' => 'Alaska', 'abbreviation' => 'AK'],
            ['name' => 'American Samoa', 'abbreviation' => 'AS'],
            ['name' => 'Arizona', 'abbreviation' => 'AZ'],
            ['name' => 'Arkansas', 'abbreviation' => 'AR'],
            ['name' => 'California', 'abbreviation' => 'CA'],
            ['name' => 'Colorado', 'abbreviation' => 'CO'],
            ['name' => 'Connecticut', 'abbreviation' => 'CT'],
            ['name' => 'Delaware', 'abbreviation' => 'DE'],
            ['name' => 'District of Columbia', 'abbreviation' => 'DC'],
            ['name' => 'Federated States Of Micronesia', 'abbreviation' => 'FM'],
            ['name' => 'Florida', 'abbreviation' => 'FL'],
            ['name' => 'Georgia', 'abbreviation' => 'GA'],
            ['name' => 'Guam', 'abbreviation' => 'GU'],
            ['name' => 'Hawaii', 'abbreviation' => 'HI'],
            ['name' => 'Idaho', 'abbreviation' => 'ID'],
            ['name' => 'Illinois', 'abbreviation' => 'IL'],
            ['name' => 'Indiana', 'abbreviation' => 'IN'],
            ['name' => 'Iowa', 'abbreviation' => 'IA'],
            ['name' => 'Kansas', 'abbreviation' => 'KS'],
            ['name' => 'Kentucky', 'abbreviation' => 'KY'],
            ['name' => 'Louisiana', 'abbreviation' => 'LA'],
            ['name' => 'Maine', 'abbreviation' => 'ME'],
            ['name' => 'Marshall Islands', 'abbreviation' => 'MH'],
            ['name' => 'Maryland', 'abbreviation' => 'MD'],
            ['name' => 'Massachusetts', 'abbreviation' => 'MA'],
            ['name' => 'Michigan', 'abbreviation' => 'MI'],
            ['name' => 'Minnesota', 'abbreviation' => 'MN'],
            ['name' => 'Mississippi', 'abbreviation' => 'MS'],
            ['name' => 'Missouri', 'abbreviation' => 'MO'],
            ['name' => 'Montana', 'abbreviation' => 'MT'],
            ['name' => 'Nebraska', 'abbreviation' => 'NE'],
            ['name' => 'Nevada', 'abbreviation' => 'NV'],
            ['name' => 'New Hampshire', 'abbreviation' => 'NH'],
            ['name' => 'New Jersey', 'abbreviation' => 'NJ'],
            ['name' => 'New Mexico', 'abbreviation' => 'NM'],
            ['name' => 'New York', 'abbreviation' => 'NY'],
            ['name' => 'North Carolina', 'abbreviation' => 'NC'],
            ['name' => 'North Dakota', 'abbreviation' => 'ND'],
            ['name' => 'Northern Mariana Islands', 'abbreviation' => 'MP'],
            ['name' => 'Ohio', 'abbreviation' => 'OH'],
            ['name' => 'Oklahoma', 'abbreviation' => 'OK'],
            ['name' => 'Oregon', 'abbreviation' => 'OR'],
            ['name' => 'Palau', 'abbreviation' => 'PW'],
            ['name' => 'Pennsylvania', 'abbreviation' => 'PA'],
            ['name' => 'Rhode Island', 'abbreviation' => 'RI'],
            ['name' => 'South Carolina', 'abbreviation' => 'SC'],
            ['name' => 'South Dakota', 'abbreviation' => 'SD'],
            ['name' => 'Tennessee', 'abbreviation' => 'TN'],
            ['name' => 'Texas', 'abbreviation' => 'TX'],
            ['name' => 'Utah', 'abbreviation' => 'UT'],
            ['name' => 'Vermont', 'abbreviation' => 'VT'],
            ['name' => 'Virgin Islands', 'abbreviation' => 'VI'],
            ['name' => 'Virginia', 'abbreviation' => 'VA'],
            ['name' => 'Washington', 'abbreviation' => 'WA'],
            ['name' => 'West Virginia', 'abbreviation' => 'WV'],
            ['name' => 'Wisconsin', 'abbreviation' => 'WI'],
            ['name' => 'Wyoming', 'abbreviation' => 'WY'],
            ['name' => 'Armed Forces Africa / Canada / Europe / Middle East', 'abbreviation' => 'AE'],
            ['name' => 'Armed Forces America (Except Canada)', 'abbreviation' => 'AA'],
            ['name' => 'Armed Forces Pacific', 'abbreviation' => 'AP'],
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
            ['name' => 'Alberta', 'abbreviation' => 'AB'],
            ['name' => 'British Columbia', 'abbreviation' => 'BC'],
            ['name' => 'Manitoba', 'abbreviation' => 'MB'],
            ['name' => 'New Brunswick', 'abbreviation' => 'NB'],
            ['name' => 'Newfoundland and Labrador', 'abbreviation' => 'NL'],
            ['name' => 'Northwest Territories', 'abbreviation' => 'NT'],
            ['name' => 'Nova Scotia', 'abbreviation' => 'NS'],
            ['name' => 'Nunavut', 'abbreviation' => 'NU'],
            ['name' => 'Ontario', 'abbreviation' => 'ON'],
            ['name' => 'Prince Edward Island', 'abbreviation' => 'PE'],
            ['name' => 'Quebec', 'abbreviation' => 'QC'],
            ['name' => 'Saskatchewan', 'abbreviation' => 'SK'],
            ['name' => 'Yukon', 'abbreviation' => 'YT'],
        ];
    }
}
