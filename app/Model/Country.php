<?php

class Country extends AppModel
{
    /*
	function generateListCountry($country)
	{
		$countries = $this->findAll(null, array('id', $country), $country.' ASC'); #returns a list of countries
		$countryArray = array();
		foreach($countries as $temp)
		{
			$id = $temp['Country']['id'];
			$countryArray[$id] = $temp['Country'][$country];
		}
		return $countryArray;
	}
        */
        function getCountryList(){
            $countryList = $this->find('list', array('sort' => 'name DESC'));
            arsort($countryList);
            foreach(array('Canada', 'United States') as $top_country){
                $top_id = array_search($top_country, $countryList);
                if($top_id){
                    unset($countryList[$top_id]);
                    $countryList[$top_id] = $top_country;
                }
            }
            $countryList = array_reverse($countryList, true);
            return $countryList;
        }
}

?>