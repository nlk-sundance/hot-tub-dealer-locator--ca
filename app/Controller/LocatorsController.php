<?php

class LocatorsController extends AppController
{
    //var $scaffold;
    var $uses = array("Dealer", "State", "Country", "Zipcode", 'MasterTable');
    public $helpers = array('Image.Image');
    var $lngTxt = array();
    var $country;
    var $subDomain;

    function beforeFilter($subDomain = null){
        $this->subDomain = $_SERVER['SERVER_NAME'];
        $this->subDomain = explode('.', $this->subDomain);
        $this->subDomain = $this->subDomain[0];

        #used when testing on localhost. Default to english.
        if ($this->subDomain == "localhost"){
            $this->subDomain = "hottubs";
        }

        //switch($this->subDomain)
        switch ($subDomain){
            //case 'en':
            case 'hottubs':
            default:
                // --------------- ENGLISH -------------- //

                $lngTxt['toFind']         = 'Please select your country. If you are in the US or Canada, you must also enter your zip code or postal code.';
                //$lngTxt['ifUS']         = 'If you are in the US or Canada, enter your zip code or postal code as well.';
                $lngTxt['country']        = 'Country:';
                $lngTxt['zipCode']        = 'Zip Code:';
                $lngTxt['noRetailers']    = 'Sorry, there are no Sundance Spas dealerships within ';
                $lngTxt['contact']        = 'Please contact a Sundance Spas representative by phone at ';
                $lngTxt['preferCustSup']  = 'Or if you prefer, contact Customer Support to email your request. You will receive a response within 48 hours.';
                $lngTxt['locateDealer']   = 'FIND YOUR NEAREST RETAILER';
                $lngTxt['supportHrs']     = "SUPPORT HOURS";
                $lngTxt['custSupport']    = "CUSTOMER SUPPORT";
                $lngTxt['searchResults']  = "Search Results:";
                $lngTxt['displaying']     = "Displaying ";
                $lngTxt['numResults']     = " Location";
                $lngTxt['hours']          = "(M-F, 8AM-5PM Pacific)";
                $lngTxt['defaultCountry'] = 1; #USA
            break;

            case 'fr':
                // --------------- Francais (Canadien) -------------- //

                $lngTxt['toFind']         = 'Pour trouver le d&#233;taillant Sundance Spas le plus proche, veuillez s&#233;lectionner votre pays. Si vous vivez aux Etas-Unis ou au Canada, entrez &#233;galement votre code postal.';
                //$lngTxt['ifUS']         = 'Si vous vivez aux Etas-Unis ou au Canada, entrez ÃÂ©galement votre code postal.';
                $lngTxt['country']        = 'Pays:';
                $lngTxt['zipCode']        = 'Code postal:';
                $lngTxt['noRetailers']    = 'D&#233;sol&#233; mais il n&#39;y a pas de d&#233positaire Sundance Spas dans un rayon de ';
                $lngTxt['contact']        = 'Veuillez communiquer avec un repr&#233;sentant anglais Sundance Spas par t&#233;l&#233;phone en csant le ';
                $lngTxt['preferCustSup']  = 'Ou, si vous le pr&#233;f&#233;rez, remplissez le formulaire ci-dessous. Vous receverez une r&#233;ponsans un d&#233;lai de 48 heures.';
                $lngTxt['locateDealer']   = 'TROUVER UN DEPOSITAIRE';
                $lngTxt['supportHrs']     = "HEURES D'OUVERTURE";
                $lngTxt['custSupport']    = "CONTACTER SUNDANCE SPAS";
                $lngTxt['searchResults']  = "R&#233;ultats de recherche:";
                $lngTxt['displaying']     = "Affichage de ";
                $lngTxt['numResults']     = " Emplacement";
                $lngTxt['hours']          = "(l-v, 8 &#224; 17 h, Pacifique).";
                $lngTxt['defaultCountry'] = 3; #Canada
            break;    
        }
        
        $this->set("lngTxt", $lngTxt);
        $this->set("subdomain", $this->subDomain);
    }
    
    function defaultcountry(){
        /*
        $query = explode('=', $_SERVER['QUERY_STRING']);
        if(isset($query[1])){
            $this->beforeFilter($query[1]);
        }
        $subDomain = '';
        $defaultCtry = $this->Country->field('id', "Country.name = 'United States'");

        if ((isset($query[1]) && $query[1] == 'fr') || $this->subDomain == "fr")
        {
            $subDomain = 'fr';
            $defaultCtry = $this->Country->field('id', "Country.name = 'Canada'");
        }
        return array($defaultCtry, $subDomain);
        */
        //if($this->Session->check('country')){
        //    $country = $this->Session->read('country');
        //    if(!empty($country)){
        //        return $this->Country->field('id', array('Country.name' => $country));
        //    }
        if(isset($_SESSION['country']) && !empty($_SESSION['country'])){
            return $this->Country->field('id', array('Country.name' => $_SESSION['country']));
        }
        return 1;
    }

    function index(){
        $this->layout = "sundance"; # locator/jacuzzi        
        $defaultCtry = $this->defaultcountry();
        $this->set('defaultCtry', $defaultCtry);
        $this->set('countryList', $this->Country->getCountryList());
        $this->set('stateList', $this->State->find('all', array('conditions' => array('not' => array('State.name' => array("", "DC")), 'State.country_id' => 1), 'fields' => array('name', 'abbreviation'), 'sort' => 'name ASC', 'recursive' => -1))); #generate list of states
        $this->set('provList', $this->State->find('all', array('conditions' => array('not' => array('State.name' => array("", "DC")), 'State.country_id' => 3), 'fields' => array('name', 'abbreviation'), 'sort' => 'name ASC', 'recursive' => -1))); #generate list of states
        $this->set('layoutTitle', 'Hot Tub Dealers: Find Sundance Spas Stores & Retailers | Sundance Spas');
        $this->set('metaKeyword', 'Hot Tub Dealers,Spa Dealer,Hot Tub Dealer,Spa Dealers');
        $this->set('metaDesc', 'Find local hot tub dealers of the world\'s most recognized brand, Sundance Spas. Locate your authorized Sundance Spas store for the best discounts and deals.');
        $this->set('barTitle', 'Hot Tub Dealers');
        $this->set('ga_action', 'Main');
    }

    function verifyUSCA($countryID){
        $inUSCA = null;
        if ($countryID){
            #checks to see if this country is US or CA
            $inUSCA = $this->Country->find('first', array('conditions' => array('Country.id' => $countryID, 'Country.abbreviation' => array('US', 'CA'))));
        }
        return $inUSCA;
    }
    /*
    function show_flash(){
        $this->layout = "blank";
        $country = $_GET['country'];
        $this->set('country', $country);
        
        $inUSCA = $this->verifyUSCA($country); #check to see if searching in US/CA
        $owns = null;

        #ONLY if country is US or CA
        if (!empty($inUSCA))
        {
            $isCanada = $inUSCA['Country']['abbreviation'] == "CA";
            $isUS = $inUSCA['Country']['abbreviation'] == "US";
            $zip = trim(preg_replace('/\s+/', '', $_GET['zipcode'])); #take out spaces in zipcode
            $zip = strtoupper($zip);
            $this->set('zip', $zip);
            $road_wiggle = 1.625;
            #check to see if any retailers own the zipcode. For US ONLY.
            $temp = null;
            $threeZipCandada = ($isCanada) ? substr($zip, 0, 3) : $zip;
            $zipQuery = ($isCanada) ? "AND dz.zipcode_id = '".substr($zip, 0, 3)."'" : "AND dz.zipcode_id = '$zip'";

            $temp = null;
            $temp = $this->Dealer->query("SELECT dz.zipcode_id
                                               FROM dealers_zipcodes dz
                                               WHERE dz.zipcode_id = '".$threeZipCandada."'"
                                        );

            if (!empty($temp))
            {
                $owns = $this->Zipcode->query("SELECT DISTINCT(Dealer.id), Dealer.name, Dealer.address1, Dealer.address2, Dealer.city, Dealer.state_id, Dealer.zip, Dealer.country_id, Dealer.email, Dealer.phone, Dealer.fax, Dealer.website, Country.name, Country.abbreviation, State.abbreviation,
                                               $road_wiggle * ( 3963 *
                                                       acos( truncate(sin( zipcodesearch.latitude / 57.2958 )
                                                       * sin( zipcodes.latitude / 57.2958 )
                                                       + cos( zipcodesearch.latitude / 57.2958 )
                                                       * cos( zipcodes.latitude / 57.2958 )
                                                       * cos( zipcodes.longitude / 57.2958
                                                       - zipcodesearch.longitude / 57.2958 ),8)) ) AS Dealer_Distance
                                               FROM dealers Dealer, dealers_zipcodes dz, zipcodes, countries Country, zipcodes AS zipcodesearch, states State
                                               WHERE zipcodesearch.zipcode = Dealer.zip
                                               AND Dealer.id = dz.dealer_id
                                               AND Country.id = Dealer.country_id
                                               AND State.id = Dealer.state_id
                                               AND Dealer.published = 'Y'
                                               $zipQuery
                                               AND zipcodes.zipcode ='".$zip."'
                                               ORDER BY Dealer_Distance");
            }

            #if Canada or if "owns" query returned 0 results, do distance calculations to find closest retailer
            #(Canadian retailers do not own postal codes, so the code defaults to the closest retailer)
            if (empty($owns))
            {
                $zipQuery = "zipcodesearch.zipcode = '" .addslashes($zip). "'";
                #if in Canada and in Quebec (Quebec zips start with G, H or J)
                #Quebec dealers should only be displayed when searching for Quebec zipcodes 
                if ($isCanada && !empty($zip))
                {
                    if ($zip{0} == "G" || $zip{0} == "J" || $zip{0} == "H")
                    {
                        $zipQuery .= " AND (Dealer.state_id IN (SELECT id from states where abbreviation = 'QC'))";
                    }
                    else
                    {
                        $zipQuery .= " AND (Dealer.state_id NOT IN (SELECT id from states where abbreviation = 'QC'))";
                    }
                }
                $temp = $this->Dealer->query("SELECT Dealer.address1, Dealer.name, Dealer.id,
                                                        Dealer.zip, Dealer.city, Dealer.state_id, Dealer.country_id, Dealer.fax,
                                                        Dealer.website, Dealer.directions, Dealer.email, Dealer.address2, Dealer.phone,
                                                        Country.name, Country.abbreviation, State.abbreviation, $road_wiggle * ( 3963 *
                                                        acos( truncate(sin( zipcodesearch.latitude / 57.2958 )
                                                        * sin( zipcodes.latitude / 57.2958 )
                                                        + cos( zipcodesearch.latitude / 57.2958 )
                                                        * cos( zipcodes.latitude / 57.2958 )
                                                        * cos( zipcodes.longitude / 57.2958
                                                        - zipcodesearch.longitude / 57.2958 ),8)) ) AS Dealer_Distance
                                                    FROM dealers Dealer, zipcodes, zipcodes AS zipcodesearch, countries Country, states State
                                                    WHERE (".$zipQuery.")
                                                    AND Country.id = Dealer.country_id
                                                    AND State.id = Dealer.state_id
                                                    AND Dealer.zip = zipcodes.zipcode
                                                    AND Dealer.published = 'Y'
                                                    AND Dealer.country_id = '". addslashes($country) ."' 
                                                    GROUP BY Dealer.address1 ORDER BY Dealer_Distance LIMIT 1");

                #takes only dealers who are within at least 500 miles from zipcode
                if (is_array($temp))
                {
                    foreach ($temp as $dealerID=>$dealer)
                    {
                        if (round($dealer[0]['Dealer_Distance']) <= 500)
                        {
                            $owns[] = $dealer;
                        }
                    }
                }

            }
        }

        #country other than US or CA
        else
        {
            $owns = $this->Dealer->query("SELECT Dealer.address1, Dealer.name, Dealer.id,
                                                        Dealer.zip, Dealer.city, Dealer.state_id, Dealer.country_id, Dealer.fax,
                                                        Dealer.website, Dealer.directions, Dealer.email, Dealer.address2, Dealer.address1,
                                                        Dealer.phone, Country.name, Country.abbreviation
                                                        FROM dealers Dealer, countries Country
                                                        WHERE Dealer.country_id=".$country."
                                                        AND Country.id = Dealer.country_id
                                                        AND Dealer.published = 'Y'
                                                        GROUP BY Dealer.address1 ORDER BY Dealer.name LIMIT 10");
        }
        
        $this->set('owns',$owns);
    }
    */
    /*
    #updates dealers_zipcodes table from 6 character Canadian postal codes to just the first 3.
    function updateCanadianCodesForOwns()
    {
        $data = $this->Dealer->query("SELECT * from dealers_zipcodes");
        $zipsCandadian = array();
        
        foreach ($data as $d)
        {
            if (is_numeric($d['dealers_zipcodes']['zipcode_id']))
            {
                continue;
            }
            elseif ($d['dealers_zipcodes']['zipcode_id'])
            {
                $threeZipChars = substr($d['dealers_zipcodes']['zipcode_id'], 0, 3);
                
                if (!isset($zipsCandadian[$d['dealers_zipcodes']['dealer_id']]) || !in_array($threeZipChars, $zipsCandadian[$d['dealers_zipcodes']['dealer_id']]))
                {
                    $zipsCandadian[$d['dealers_zipcodes']['dealer_id']][] = $threeZipChars;
                    $this->Dealer->query("DELETE FROM dealers_zipcodes where dealer_id = {$d['dealers_zipcodes']['dealer_id']} AND zipcode LIKE '".$threeZipChars."%'");
                    echo "DELETE FROM dealers_zipcodes where dealer_id = {$d['dealers_zipcodes']['dealer_id']} AND zipcode LIKE '".$threeZipChars."%'<Br>";
                    $this->Dealer->query("INSERT INTO dealers_zipcodes (dealer_id, zipcode_id, zipcode) VALUES ('{$d['dealers_zipcodes']['dealer_id']}', '{$threeZipChars}', '{$threeZipChars}')");
                    echo "INSERT INTO dealers_zipcodes (dealer_id, zipcode_id, zipcode) VALUES ('{$d['dealers_zipcodes']['dealer_id']}', '{$threeZipChars}', '{$threeZipChars}')<br>";
                    pr($zipsCandadian);
                }
            }
        }
        die();
    }
    */
    
    function omniture($id){
        $this->layout = 'blank';
        $dealer = $this->Dealer->find('first', array('conditions' => array('Dealer.id' => $id), 'recursive' => -1)); #get dealer info
        $this->set('dealer', $dealer);
    }
    /*
    function convert()
    {
        $this->layout = '';
        echo '<h1>h1</h1>';
        $data = $this->MasterTable->findAll("Dealer_Country = 'United States'");

        $this->set('data', $data);
        pr($data);
        $queryArray = array();
        $count = 0; #count for INSERT. up to 500 values
        #$masterCount = 0; #counts the number of fields
        $query = "INSERT INTO dealers_zipcodes (dealer_id, zipcode_id) VALUES ";
        foreach($data as $masterNum=>$master)
        {
            $dealerNum = $master['MasterTable']['Dealer_Number'];
            $dealer = $this->Dealer->find("dealer_number = '".$dealerNum."'");
            $dealerID = $dealer['Dealer']['id'];

            if (!empty($dealerID)) #check to see that the dealerID is not empty
            {
                $associated = preg_split("/[\s]+/", $master['MasterTable']['Dealer_Region'], -1, PREG_SPLIT_NO_EMPTY);
                $countAssoc = count($associated);
                for($i = 0; $i < $countAssoc; $i++)
                {
                    $zip = trim($associated[$i]);
                    if(!empty($zip))
                    {
                        $zipID = $this->Zipcode->find("zipcode = ".$zip);
                        $zipcodeID = $zipID['Zipcode']['id'];
                        if (!empty ($zipcodeID)) #verify that the zipcodeID is not empty
                        {
                            #this if statement will remove any duplicates that will give an error when inserting
                            if (!in_array("(".$dealerID.",".$zipcodeID.")", $queryArray) 
                                && !in_array("(".$dealerID.",".$zipcodeID."), ", $queryArray))
                            {
                                #up to 500 values or when you reach the last one
                                if ($count == 500 || $master == $data[count($data)-1])
                                {
                                    $query .= "(".$dealerID.",".$zipcodeID.")";
                                    $queryArray[] = "(".$dealerID.",".$zipcodeID.")";
                                    $count = 0;
                                    echo $query."<Br>";
                                    #run query
                                    $this->Dealer->query($query);
                                    $query = "INSERT INTO dealers_zipcodes (dealer_id, zipcode_id) VALUES ";
                                }
                                else
                                {
                                    $query .= "(".$dealerID.",".$zipcodeID."), ";
                                    $queryArray[] = "(".$dealerID.",".$zipcodeID."), ";
                                    $count++;
                                }
                            }
                        }
                    }
                }
                #$masterCount++;
            }
        }
    }
    */
    /*
    function zips_wo_dealers()
    {
        $zips = $this->Zipcode->findAll(null, "zipcode");
        $owns = null;
        
        foreach($zips as $z)
        {
            $zip = $z['Zipcode']['zipcode'];
            $countryID = (is_numeric($zip)) ? $this->Country->field("id", "Country.abbreviation = 'US'") : $this->Country->field("id", "Country.abbreviation = 'CA'");

            #ONLY if country is US or CA
            if(!empty($countryID))
            {
                $isCanada = ($countryID == 3) ? true : false;
                $isUS = ($countryID == 1) ? true : false;
                $road_wiggle = 1.625;

                #check to see if any retailers own the zipcode. Starting 05/2007 US & now CA only.
                $threeZipCandada = ($isCanada) ? substr($zip, 0, 3) : $zip;
                $zipQuery = "AND dz.zipcode_id = '".$threeZipCandada."'";
                $zipQuery .= ($isUS) ? " AND zipcodes.zipcode = '".$threeZipCandada."'" : " AND zipcodes.zipcode LIKE '".$threeZipCandada."%'";

                $temp = null;
                $temp = $this->Dealer->query("SELECT dz.zipcode_id
                                                   FROM dealers_zipcodes dz
                                                   WHERE dz.zipcode_id = '".$threeZipCandada."'"
                                            );
                                            
    
                if (!empty($temp))
                {
                      $own = $this->Zipcode->query("SELECT DISTINCT(Dealer.id), Dealer.name, Dealer.address1, Dealer.address2, Dealer.city, Dealer.state_id, Dealer.zip, Dealer.country_id, Dealer.email, Dealer.phone, Dealer.fax, Dealer.website, Country.name, Country.abbreviation, State.abbreviation,
                                               $road_wiggle * ( 3963 *
                                                       acos( truncate(sin( zipcodesearch.latitude / 57.2958 )
                                                       * sin( zipcodes.latitude / 57.2958 )
                                                       + cos( zipcodesearch.latitude / 57.2958 )
                                                       * cos( zipcodes.latitude / 57.2958 )
                                                       * cos( zipcodes.longitude / 57.2958
                                                       - zipcodesearch.longitude / 57.2958 ),8)) ) AS Dealer_Distance
                                                   FROM dealers Dealer, dealers_zipcodes dz, zipcodes, countries Country, zipcodes AS zipcodesearch, states State
                                                   WHERE zipcodesearch.zipcode = Dealer.zip
                                                   AND Dealer.id = dz.dealer_id
                                                   AND Country.id = Dealer.country_id
                                                AND State.id = Dealer.state_id
                                                AND Dealer.published = 'Y'
                                                $zipQuery
                                                   ORDER BY Dealer_Distance");
                    if(empty($own))
                    {
                        $owns[] = $zip;
                    }
                    continue;
                }

                #if Canada or if "owns" query returned 0 results, do distance calculations to find closest retailer
                #(Canadian retailers do not own postal codes, so the code defaults to the closest retailer)
                if(empty($owns))
                {
                    #$zipQuery = ($isCanada) ? "Dealer.zip LIKE '" .$threeZipCandada. "%' AND " : "";
                    #$zipQuery = ($isUS) ? "zipcodesearch.zipcode = '" .$zip. "'" : "";
                    #if in Canada and in Quebec (Quebec zips start with G, H or J)
                    #Quebec dealers should only be displayed when searching for Quebec zipcodes 
                    $zipQuery = '';
                    if($isCanada && !empty($zip))
                    {
                        if ($zip{0} == "G" || $zip{0} == "J" || $zip{0} == "H")
                        {
                            $zipQuery = "Dealer.state_id IN (SELECT id from states where abbreviation = 'QC')";
                        }
                        else
                        {
                            $zipQuery = "Dealer.state_id NOT IN (SELECT id from states where abbreviation = 'QC')";
                        }
                    }

                    $temp = $this->Dealer->query("SELECT Dealer.address1, Dealer.name, Dealer.id,
                                                            Dealer.zip, Dealer.city, Dealer.state_id, 
                                                            Dealer.country_id, Dealer.fax,
                                                            Dealer.website, Dealer.directions, Dealer.email, 
                                                            Dealer.address2, Dealer.phone, 
                                                            Country.name, Country.abbreviation, State.abbreviation, 
                                                            $road_wiggle * ( 3963 *
                                                            acos( truncate(sin( zipcodesearch.latitude / 57.2958 )
                                                            * sin( zipcodes.latitude / 57.2958 )
                                                            + cos( zipcodesearch.latitude / 57.2958 )
                                                            * cos( zipcodes.latitude / 57.2958 )
                                                            * cos( zipcodes.longitude / 57.2958
                                                            - zipcodesearch.longitude / 57.2958 ),8)) ) AS Dealer_Distance
                                                        FROM dealers Dealer, zipcodes, zipcodes AS zipcodesearch, countries Country, states State, dealers_zipcodes dz
                                                        WHERE Country.id = Dealer.country_id
                                                        AND State.id = Dealer.state_id
                                                        $zipQuery
                                                        AND Dealer.zip = zipcodes.zipcode
                                                        AND Dealer.published = 'Y'
                                                        AND Dealer.country_id = '". $countryID ."' 
                                                        GROUP BY Dealer.address1 ORDER BY Dealer_Distance LIMIT 1");

                    #takes only dealers who are within at least 500 miles from zipcode
                    if(!empty($temp))
                    {
                        foreach ($temp as $dealerID=>$dealer)
                        {
                            if (round($dealer[0]['Dealer_Distance']) > 500)
                            {
                                $owns[] = $zip." ".$dealer[0]['Dealer_Distance'];
                            }
                            continue;
                        }
                    }
                    else
                    {
                        $owns[] = $zip;
                    }
                }
            }
        }
    }
    */
    
    function isOhio($state=null){
        return ($state == 'oh') ? true : false;
    }
    
    function states($state=null){
        $this->layout = "sundance"; # locator/jacuzzi

        //$defaultCtry = $this->defaultcountry();
        //$this->set('defaultCtry', $defaultCtry); 
        //$this->set('subDomain' , $subDomain);
        
        if(!empty($state)){ //selected state info
            $redirect = $this->isOhio($state);
            if($redirect) { //redirect oh to ohio-oh
                $state = 'ohio-oh';
                $this->redirect('/'.$state.'/');
                exit();
            }
            $stateArray = explode('-', $state);
            $stateAbbr = $stateArray[count($stateArray)-1];
            $stateInfo = $this->State->find('first', array('conditions' => array("State.abbreviation" => $stateAbbr), 'fields' => array('name', 'id')));
            $stateName = $stateInfo['State']['name'];
            $stateId = $stateInfo['State']['id'];
            $countryId = $this->State->getCountryId($stateId);
            $defaultCtry = $countryId;
            //$this->Session->write('country', $this->Country->field('name', array('Country.id' => $defaultCtry)));
            $_SESSION['country'] =  $this->Country->field('name', array('Country.id' => $defaultCtry));
            $this->set('defaultCtry', $defaultCtry);
            
            $this->set('barTitle', 'Hot Tub Dealer in '.$stateName);
            $this->set('stateName', $stateName);
            $this->set('stateAbbr', $stateAbbr);
            $this->set('stateTitle', '+/- Search By State');
            $this->set('name_abbrev', str_replace(' ', '-', strtolower($stateName.'-'.$stateAbbr)));

            //general info
            $this->set('countryList', $this->Country->getCountryList()); #generate list of countries
            if($countryId == 3){
                //Canada
                $query = array('State.country_id' => 3);
            }else{
                $query = array(
                    'not' => array(
                        'State.name' => array("", "DC")
                    ), 
                    'State.country_id' => 1
                );
            }
            //$query = ($countryId == 3) ? 'State.country_id = 3' : 'State.name NOT IN ("", "DC") AND State.country_id = 1';
            $stateList = $this->State->find('all', array('conditions' => $query, 'fields' => array('name', 'abbreviation'), 'sort' => 'name ASC', 'recursive' => -1));
            //$stateList = $this->State->findAll($query, array('name', 'abbreviation'), 'name ASC', null, null, -1);
            $this->set('stateList', $stateList); #generate list of countries
            $this->set('cityList', $this->Dealer->find('all', array('conditions' => array('Dealer.state_id' => $stateId, 'published' => 'Y'), 'fields' => array('DISTINCT(slug)', 'city'), 'order' => 'city', 'recursive' => -1)));
            //$this->set('cityList', $this->Dealer->findAll("Dealer.state_id = '".$stateId."'", array('DISTINCT(city)'), 'city', null, null, -1));
            $this->set("countryId", $countryId);
            
            //layout variables
            if($countryId == 3){
                $this->set('layoutTitle', 'Hot Tubs '.$stateName.': Find Hot Tub Spa Dealers in '.$stateName.' | Sundance Spas');
                $this->set('metaDesc', 'Find a wide selection of hot tubs and spas in '.$stateName.'. Sundance Spas dealers offer spa accessories and covers at stores in '.$stateName.'.');
            }else{
                $this->set('layoutTitle', "Hot Tubs ".$stateName.": Find Sundance Spas Dealers in ".$stateName." | Sundance Spas");
                $this->set('metaDesc', 'Find '.$stateName.' hot tub dealers of the world\'s most recognized brand, Sundance Spas. Search for authorized Sundance Spas dealers in '.$stateName.' to find the best discounts and deals.');
            }
            $this->set('metaKeyword', 'Hot Tubs in '.$stateName.',Hot Tubs '.$stateName.','.$stateName.' Hot Tubs,Sundance Spas Dealers '.$stateName);
            $this->set('ga_action', 'State');
            $ga_label = $stateName.', '.$this->Country->field('name', array('Country.id' => $countryId));
            $this->set('ga_label', $ga_label);
        }else{
            $this->redirect('/locators/index/');
        }
    }
    /*
    function dealers($stateInfo=null, $cityInfo=null, $dealerID=null)
    {
        //die($stateInfo." ".$cityInfo." ".$dealerID);
        $this->layout = "jacuzzi"; # locator/jacuzzi
        //general page data
        $defaultCtry = $this->defaultcountry();
        $this->set('defaultCtry', $defaultCtry); 
        //$this->set('subDomain' , $subDomain);
        
        $this->set('countryList', $this->Country->getCountryList()); #generate list of countries
        $this->set('stateList',$this->State->findAll('State.name NOT IN ("", "DC") AND State.country_id = 1', array('name', 'abbreviation'), 'name ASC', null, null, -1)); #generate list of countries
        $this->set('provList', $this->State->findAll('State.name NOT IN ("", "DC") AND State.country_id = 3', array('name', 'abbreviation'), 'name ASC', null. null, -1)); #generate list of provinces
        
        if(!empty($dealerID) && !empty($stateInfo) && !empty($cityInfo))
        {
            $redirect = $this->isOhio($stateInfo);
            if($redirect) { //redirect oh to ohio-oh
                $stateInfo = 'ohio-oh';
                $this->redirect('/'.$stateInfo.'/'.$cityInfo.'/'.$dealerID.'/');
                exit();
            }
            $this->set('countryID', $this->Country->find("Country.id = 1")); //US
            $this->set('inUSCA', $this->verifyUSCA('1'));
            $_SESSION['country'] = 'United States';
            $dealer = $this->Dealer->find("Dealer.id = '".$dealerID."'", null, null, 0);
            $this->set('d', $dealer);
            
            $cityName = ucwords(strtolower($dealer['Dealer']['city']));
            
            $stateName = (!empty($dealer['State']['name'])) ? strtoupper($dealer['State']['name']) : '';
            $stateAbbr = (!empty($dealer['State']['name'])) ? strtoupper($dealer['State']['abbreviation']) : '';
            $stateId = $dealer['Dealer']['state_id'];
            $zipcode = (!empty($dealer['Dealer']['zip'])) ? ', '.$dealer['Dealer']['zip'] : '';
            $dealerName = strtoupper($dealer['Dealer']['name']);
            $_SESSION['zip'] = $zipcode;
            
            //layout variables
            $this->set('layoutTitle', $dealerName." in ".$cityName.$zipcode." - Jacuzzi Hot Tubs");
            $this->set('metaKeyword', $dealerName." in ".$cityName.' '.$dealer['Dealer']['zip'].','.' Hot Tubs at '.$dealerName.','.$dealerName.' Jacuzzi Dealers');
            $this->set('metaDesc', 'Find hot tubs at '.$dealerName.', an Authorized Jacuzzi hot tub and spa dealer in '.$cityName.', '.$stateAbbr);

            //googleMapAddr
            $googleMapAddr = (!empty($dealer['Dealer']['address1'])) ? trim($dealer['Dealer']['address1']).' ' : '';
            $googleMapAddr .= (!empty($dealer['Dealer']['address2'])) ? trim($dealer['Dealer']['address2']).' ' : '';
            $googleMapAddr .= (!empty($dealer['Dealer']['city'])) ? trim($dealer['Dealer']['city']).' ' : '';
            $googleMapAddr .= (!empty($dealerd['State']['abbreviation'])) ? trim($dealer['State']['abbreviation']).' ' : '';
            $googleMapAddr .= (!empty($dealer['Dealer']['zip'])) ? trim($dealer['Dealer']['zip']) : '';
            $googleMapAddr = str_replace(' ', '+', trim($googleMapAddr));

            $this->set('stateInfo', $stateInfo);
            $this->set('cityInfo', $cityInfo);
            $this->set('cityName', $cityName);
            $this->set('googleMapAddr', $googleMapAddr);
            
            $zip = $dealer['Dealer']['zip'];
            if(empty($zip)) {
                $cityName2 = $this->replaceMtStNS($cityName);
                $zip = $this->Zipcode->field('zipcode', "Zipcode.city_name in ('".$cityName."', '".$cityName2."') AND Zipcode.state_id = '".$stateId."'");
            }
            $this->set('nearbyCities', $this->nearby_cities_lists($zip));
        }
    }
    */
    function locator($countryID=null){
        $this->layout = "sundance"; # locator/jacuzzi
        
        //general page data
        $defaultCtry = $this->defaultcountry();
        $this->set('defaultCtry', $defaultCtry); 
        //$this->set('subDomain' , $subDomain);
        
        $this->set('countryList', $this->Country->getCountryList()); #generate list of countries
        $this->set('stateList',$this->State->find('all', array('conditions' => array('not' => array('State.name' => array("", "DC")), 'State.country_id' => 1), 'fields' => array('name', 'abbreviation'), 'sort' => 'name ASC', 'recursive' => -1))); #generate list of countries
        $this->set('provList',$this->State->find('all', array('conditions' => array('not' => array('State.name' => array("", "DC")), 'State.country_id' => 3), 'fields' => array('name', 'abbreviation'), 'sort' => 'name ASC', 'recursive' => -1))); #generate list of provinces
        //$this->set('stateList',$this->State->findAll('State.name NOT IN ("", "DC") AND State.country_id = 1', array('name', 'abbreviation'), 'name ASC', null, null, -1)); #generate list of countries
        //$this->set('provList', $this->State->findAll('State.name NOT IN ("", "DC") AND State.country_id = 3', array('name', 'abbreviation'), 'name ASC', null. null, -1)); #generate list of provinces
        $dealer = $this->show('', $countryID); //get dealers
        return $dealer;
    }
    
    function replaceMtStNS($cityName=null){
        $cityArray = explode(' ', $cityName);

        foreach($cityArray as $i=>$c) {
            if(ucwords($c) == 'St') {
                $cityArray[$i] = 'Saint';
            }
            elseif(ucwords($c) == 'Mt') {
                $cityArray[$i] = 'Mount';
            }
            elseif(ucwords($c) == 'N') {
                $cityArray[$i] = 'North';
            }
            elseif(ucwords($c) == 'S') {
                $cityArray[$i] = 'South';
            }
        }
        $cityName2 = implode(' ', $cityArray);
        return $cityName2;
    }
    
    function cities($stateInfo=null, $cityInfo=null, $extra_num=null){
        if(!empty($extra_num)){
            $this->redirect('/'.$stateInfo.'/'.$cityInfo.'/');
            exit();
        }
        //$this->layout = "dealers"; # locator/jacuzzi
        $this->layout = "sundance";
        //general page data
        //$defaultCtry = $this->defaultcountry();
        //$this->set('defaultCtry', $defaultCtry); 
        //$this->set('subDomain' , $subDomain);
        
        $dealer = array();
        $cityName = '';
        $countryId = 1;
        $errorMsg = '';
        $seo_page_type = '';
        
        if(!empty($cityInfo) && !empty($stateInfo)) {
            if(strpos($cityInfo, '-hot-tub-accessories') !== FALSE){
                $city = explode('-hot-tub-accessories', $cityInfo);
                $seo_page_type = 'accessories';
                $barTitle = 'Hot Tub Accessories';
            }elseif(strpos($cityInfo, '-hot-tub-sale') !== FALSE){
                $city = explode('-hot-tub-sale', $cityInfo);
                $seo_page_type = 'sale';
                $barTitle = 'Hot Tub Sale';
            }elseif(strpos($cityInfo, '-hot-tub-reviews') !== FALSE){
                $city = explode('-hot-tub-reviews', $cityInfo);
                $seo_page_type = 'reviews';
                $barTitle = 'Hot Tub Reviews';
            }else{
                $city = explode('hot-tubs-', $cityInfo);
                $barTitle = 'Hot Tubs';
            }
            if(!empty($seo_page_type)){
                $this->redirect('/'.$stateInfo.'/'.implode('', $city).'-hot-tubs/', 301);
                exit();
            }
            $cityName = ucwords(str_replace('-', ' ', $city[0]));
            $cityName2 = $this->replaceMtStNS($cityName);
            
            $redirect = $this->isOhio($stateInfo);
            if($redirect) { //redirect oh to ohio-oh
                $stateInfo = 'ohio-oh';
                $this->redirect('/'.$stateInfo.'/'.$cityInfo.'/');
                exit();
            }
            $stateArray = explode('-', $stateInfo);
            $stateAbbr = $stateArray[count($stateArray)-1];
            $stateData = $this->State->find('first', array('conditions' => array("State.abbreviation" => $stateAbbr), 'recursive' => -1));
            //$stateData = $this->State->find("State.abbreviation = '".$stateAbbr."'", null, null, -1);
            $stateName = ucwords(strtolower($stateData['State']['name'])); //state full name
            $countryId = $stateData['State']['country_id'];
            $defaultCtry = $countryId;
            $stateId = $stateData['State']['id']; //state db id
            
            $dealer = $this->Dealer->find('all', array('conditions' => array('Dealer.slug' => $cityInfo, 'Dealer.state_id' => $stateId, 'published' => 'Y'), 'contain' => array('State', 'Country', 'User', 'Quote', 'Image', 'Staff', 'Service')));
            if(!empty($dealer)){
                $cityName = $dealer[0]['Dealer']['city'];
            }else{
                $dealer = $this->Dealer->find('all', array('conditions' => array('Dealer.city' => array($cityName, $cityName2), 'Dealer.state_id' => $stateId, 'published' => 'Y'), 'contain' => array('State', 'Country', 'User', 'Quote', 'Image', 'Staff', 'Service')));
            }
            $this->set('stateName', $stateName);
            $this->set('cityName', $cityName);
            $this->set('barTitle', $cityName.' '.$barTitle);

            //pr($dealer);
            //die();
            //$dealer = $this->Dealer->findAll("(Dealer.city = '".addslashes($cityName)."' OR Dealer.city = '".addslashes($cityName2)."') AND Dealer.state_id = '".$stateId."'", null, null, null, null, 0);
            $countryId = $this->State->getCountryId($stateId);

            $cityn = (in_array(substr(strtolower($cityName), 0, 1), array('a', 'e', 'i', 'o', 'u')) ? 'n' : '');
            $this->set('cityn', $cityn);
            //layout variables
            //if($countryId == 3){
                $this->set('layoutTitle', 'Hot Tubs '.$cityName.': Find Hot Tubs from '.$dealer[0]['Dealer']['name'].' in '.$cityName.' '.$dealer[0]['Dealer']['zip'].' | Sundance Spas');
                $this->set('metaDesc', $dealer[0]['Dealer']['name'].' is your authorized Sundance Spas dealer in '.$cityName.', '.strtoupper($stateAbbr).'.  Call '.$dealer[0]['Dealer']['phone'].' to schedule a no-hassle visit, request hot tub pricing, or download a free brochure today!');
            //}else{
            //    $this->set('layoutTitle', 'Hot Tubs '.$cityName.': Find Hot Tub Dealers In '.$cityName.', '.strtoupper($stateAbbr).' | Jacuzzi&reg; Hot Tubs');
            //    $this->set('metaDesc', 'Find a wide selection of hot tubs and spas at a Jacuzzi hot tub spa dealer in '.$cityName.', '.$stateName.'. Search for Jacuzzi hot tub covers and accessories at a hot tub store near you.');
            //}
            $this->set('metaKeyword', $cityName.' Hot Tubs, '.$cityName.' Hot Tub Dealers, '.$cityName.' Hot Tub Stores, Hot Tubs in '.$cityName.', '.$stateAbbr.', Sundance Spa Dealers '.$cityName.', '.$stateAbbr);
            $this->set('image_title', $cityName.' Hot Tubs');
            $this->set('image_alt', 'Find a'.$cityn.' '.$cityName.' Hot Tub Dealer');
            /*if($countryId == 1) {
                $zip = $this->Zipcode->field('zipcode', "Zipcode.city_name in ('".$cityName."', '".$cityName2."') AND Zipcode.state_id = '".$stateId."'");
                if(empty($zip)) {
                    $zip = $dealer['Dealer']['zipcode'];
                }
                $this->set('nearbyCities', $this->nearby_cities_lists($zip));
            }*/
        }elseif(isset($_POST['zipcodeSearch']) && $_POST['zipcodeSearch'] == 1) {
            if(!isset($this->data['Dealer']['country_id']) || empty($this->data['Dealer']['country_id'])){
                $countryId = 1;
            }else{
                $countryId = $this->data['Dealer']['country_id'];
            }
            if(!isset($_POST['zip'])){
                $_POST['zip'] = $this->data['Dealer']['zip'];
            }
            $validZip = ($countryId == '1' || $countryId == '3') ? $this->validZip($_POST['zip']) : true;
            
            if($countryId == '1' || $countryId == '3'){
                $zipCountryMatch = $this->checkCountryZip($countryId, $_POST['zip']);
                if(!$zipCountryMatch && $countryId == 1){
                    $zipCountryMatch = $this->checkCountryZip(3, $_POST['zip']);
                    if($zipCountryMatch){
                        $countryId = 3;
                    }
                }
                if(!$zipCountryMatch && $countryId == 3){
                    $zipCountryMatch = $this->checkCountryZip(1, $_POST['zip']);
                    if($zipCountryMatch){
                        $countryId = 1;
                    }
                }
            }else $zipCountryMatch = true;
            $defaultCtry = $countryId;
            $inUSCA = $this->verifyUSCA($countryId);
            if($inUSCA) {
                $zip_searched = $_POST['zip'];
                if(!$zipCountryMatch) {
                    $errorMsg = 'Sorry, there were no results found for your search. Please verify that you have selected the correct country and have entered a valid zip code or postal code.';
                }elseif(!$validZip) { //invalid zip code/postal code
                    $errorMsg = 'Sorry, there were no results found for your search. Please make sure you have entered a valid zip code or postal code and try again.';
                }else {
                    $subDomain = '';
                    $dealer = $this->show($subDomain, $countryId); //get dealers
                    if(!empty($dealer)) {
                        //$cityName = ucwords(strtolower($dealer[0]['Dealer']['city']));
                        $stateInfo = str_replace(' ', '-', strtolower($dealer[0]['State']['name'].'-'.$dealer[0]['State']['abbreviation']));
                        //$cityInfo = str_replace(' ', '-', strtolower($cityName)).'-hot-tubs';
                        $_SESSION['zip_searched'] = $zip_searched;
                        $this->redirect('/'.$stateInfo.'/'.$dealer[0]['Dealer']['slug'].'/');
                    }
                }
            }
            /*elseif($this->data['Dealer']['country_id'] == '3') { //Canada
                if(!$zipCountryMatch) {
                    $errorMsg = 'No results found. Please verify that you have selected the correct country and have entered a valid zip code or postal code.';
                }
                elseif(!$validZip) {
                    $errorMsg = 'No results found. Please verify that you have entered a valid zip code.';
                }
                else {
                    $countryId = $this->data['Dealer']['country_id'];
                    //$dealer = $this->locator($countryId);
                    $dealer = $this->show($subDomain, $countryId); //get dealers
                    if(!empty($dealer)) {
                        $cityName = ucwords(strtolower($dealer[0]['Dealer']['city']));
                        $stateInfo = str_replace(' ', '-', strtolower($dealer[0]['State']['name'].'-'.$dealer[0]['State']['abbreviation']));
                        $cityInfo = str_replace(' ', '-', strtolower($cityName)).'-hot-tubs';
                        $this->redirect('/'.$stateInfo.'/'.$cityInfo.'/');
                    }
                    $this->set('outsideUS', true);
                }
            }*/
            else { //other countries
                if(isset($this->data['Dealer']['country_id'])){
                    $countryId = $this->data['Dealer']['country_id'];
                }elseif(isset($this->data['country_id'])){
                    $countryId = $this->data['country_id'];
                }
                $defaultCtry = $countryId;
                $dealer = $this->locator($countryId);
                $this->set('outsideUS', true);
                $outsideUS = TRUE;
                $this->view = 'international_cities';
            }
        }
        
        if(isset($_SESSION['zip_searched']) && !empty($_SESSION['zip_searched'])){
            if(!isset($zip_searched) || empty($zip_searched)){
                $zip_searched = $_SESSION['zip_searched'];
            }
            $_SESSION['zip_searched'] = '';
        }
            
        if(isset($defaultCtry) && !empty($defaultCtry)){
            $_SESSION['country'] =  $this->Country->field('name', array('Country.id' => $defaultCtry));
        }else{
            $defaultCtry = $this->defaultcountry();
        }
        $this->set('defaultCtry', $defaultCtry);
        if(isset($dealer['Dealer']['custom_seo_text']) && !empty($dealer['Dealer']['custom_seo_text'])){
            $this->set('custom_seo_text', $dealer['Dealer']['custom_seo_text']);
        }elseif(isset($dealer[0]['Dealer'])){
            foreach($dealer as $d){
                if(isset($d['Dealer']['custom_seo_text']) && !empty($d['Dealer']['custom_seo_text'])){
                    $this->set('custom_seo_text', $d['Dealer']['custom_seo_text']);
                    break;
                }
            }
        }
        //Look for url_redirect variable to see if the page needs to be redirected
        if(isset($dealer['Dealer']['url_redirect']) && !empty($dealer['Dealer']['url_redirect'])){
            $url_redirect = $dealer['Dealer']['url_redirect'];
        }elseif(isset($dealer[0]['Dealer'])){
            foreach($dealer as $d){
                if(isset($d['Dealer']['url_redirect']) && !empty($d['Dealer']['url_redirect'])){
                    $url_redirect = $d['Dealer']['url_redirect'];
                    break;
                }
            }
        }
        //only redirect if the user isn't on a mobile device
        if(isset($url_redirect) && !empty($url_redirect)){
            $useragent=$_SERVER['HTTP_USER_AGENT'];
            if(!preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))){
                header('Location: '.$url_redirect);
                exit;
            }
        }
        
        $this->set('seo_page_type', $seo_page_type);

        
        if(empty($dealer[0]['Image'])){
            $dealer[0]['Image'] = array(
                array(
                    'dealer_id' => 'default',
                    'path' => 'SDSDefault1.png'
                ),
                array(
                    'dealer_id' => 'default',
                    'path' => 'SDSdeafult2.png'
                )
            );
        }
        if(empty($dealer[0]['Quote'])){
            $dealer[0]['Quote'] = array(
                array(
                    'quote' => 'It was such a great decision for us to go in, actually see and touch and experience the spa for ourselves.',
                    'name' => 'Teresa Cole'
                ),
                array(
                    'quote' => 'Our Optima is also much quieter than our previous spa. Very easy to maintain as well. Would recommend to anyone looking for a very high quality spa.',
                    'name' => 'Tanner Family'
                ),
                array(
                    'quote' => 'The most important part of our purchasing process was going into the dealer and getting a real idea of what the best options were for us.',
                    'name' => 'Michael C.'
                ),
                array(
                    'quote' => 'I went through the Yellow Pages for Spa Dealers and went to them and the spas didn\'t compare, they didn\'t compare at all.',
                    'name' => 'Scott Family'
                )
            );
        }
        $this->set('errorMsg', $errorMsg);
        if(isset($outsideUS)){
            $this->set('dealer', $dealer);
        }else{
            $this->set('dealer', $dealer[0]);
        }
        $this->set('stateInfo', $stateInfo);
        $this->set('cityInfo', $cityInfo);
        $this->set('cityName', $cityName);
        if(isset($city)){
            $this->set('city_link', $city[0]);
        }

        $this->set('countryList', $this->Country->getCountryList()); #generate list of countries
        $query = ($countryId == 3) ? array('State.country_id' => 3) : array('not' => array('State.name' => array("", "DC")), 'State.country_id' => 1);
        $this->set('stateList',$this->State->find('all', array($query, 'fields' => array('name', 'abbreviation'), 'sort' => 'name ASC', 'recursive' => -1))); #generate list of countries
        //$this->set('stateList',$this->State->findAll($query, array('name', 'abbreviation'), 'name ASC', null, null, -1)); #generate list of countries
        $this->set('countryID', $this->Country->find('first', array('conditions' => array('Country.id' => $countryId))));
        $this->set('inUSCA', $this->verifyUSCA($countryId));
        $this->set('ga_action', 'Search');
        $ga_label = $cityName.', ';
        if(isset($dealer[0]['State']['name']) && !empty($dealer[0]['State']['name'])){
            $ga_label .= $dealer[0]['State']['name'].', ';
        }
        if(isset($dealer[0]['Country']['name']) && !empty($dealer[0]['Country']['name'])){
            $ga_label .= $dealer[0]['Country']['name'];
        }
        $this->set('ga_label', $ga_label);
        if(isset($zip_searched)){
            $this->set('zip_searched', $zip_searched);
        }
        if(empty($dealer) || !isset($dealer[0]['Dealer'])){
            $this->view = 'international_cities';
            $this->layout = "sundance";
        }
    }
    
    //verify zip is valid (in our zipcodes database)
    function validZip($zip=null){
        $zip = str_replace(' ', '', $zip);
        if(empty($zip)){
            return 0;
        }
        if($this->Zipcode->find('count', array('recursive' => -1, 'conditions' => array('Zipcode.zipcode' => $zip)))){
            return true;
        }
        return 0;
    }
    
    //verify US zips select US as country and Canada zips select Canada as country; otherwise, display error
    function checkCountryZip($countryId=null, $zip=null){
        $zip = ( !is_null($zip) ) ? strtolower( str_replace(' ', '', $zip) ) : null;
        // javascript in top-right search box puts "Zip/Postal Code" which is submitted to form if no zip entered
        // we need to return errors if zip is blank or...
        // starts with an invalid character for US / Canadian zips or...
        // contains an invalid character, non-alphnumeric
        $valid_zip_start = array(0,1,2,3,4,5,6,7,8,9,'a','b','c','e','g','h','j','k','l','m','n','p','r','s','t','v','x','y'); # Values not in CA FSA's = d, f, i, o, q, u, w, z
        if ( !empty($zip) && in_array(substr($zip, 0, 1), $valid_zip_start) && !preg_match('/[^A-Za-z0-9]/', $zip) ) {
            if($countryId == '1' && is_numeric($zip{0})) {
                return true;
            }
            if($countryId == '3' && !is_numeric($zip{0})) {
                return true;
            }
        }
        return 0;
    }
    /*
    function getSpatialProximityByZip($zip, $distance, $precision, $unit='K')
    { 
        pr('hi');
        $sql = 'call zip_radius_custom( \'' . $unit . '\', ' . $zip . ', ' . $distance . ', ' . $precision . ' )';
          pr($sql);
        $result = $Zipcode->query( $sql );
          prd($result);
        return( $result );
    }
    */
    /*
    function enterstates(){
        $zips = $this->Zipcode->findall('');
    }
    */
    /*function nearby_cities_lists( $zip )
    {
        $zipinfo = $this->Zipcode->find(array('zipcode'=>$zip), array('longitude', 'latitude'));
        $A = $zipinfo['Zipcode']['longitude'];
        $B = $zipinfo['Zipcode']['latitude'];
        $matches = $this->Zipcode->query("SELECT Zipcodes.zipcode,Zipcodes.latitude,Zipcodes.longitude, Zipcodes.city_name, States.name, States.abbreviation, (SQRT( POW((69.1 * (".$B." - Zipcodes.latitude)), 2) + POW((53 * (".$A." - longitude)), 2))) AS distance FROM zipcodes Zipcodes, states States WHERE Zipcodes.state_id = States.id AND Zipcodes.state_id<>0 AND Zipcodes.city_name <> '' AND Zipcodes.city_name IN (SELECT Dealers.city FROM dealers Dealers WHERE Dealers.zip=Zipcodes.zipcode) AND Zipcodes.zipcode <> ".$zip." GROUP BY city_name ORDER BY distance LIMIT 16");
        $nearbyCitiesLists=array(0=>'', 1=>'', 2=>'', 3=>'');
        $count = 0;
        foreach($matches as $match){
            $states_code = strtolower(urlencode($match['States']['abbreviation']));
            $states_uri  = strtolower(urlencode($match['States']['name']));
            $cities_uri  = str_replace("+", "-", strtolower(urlencode($match['Zipcodes']['city_name'])));
            $uri = BASEDIR. '/' . $states_uri . '-' . $states_code . '/' . $cities_uri . '-hot-tubs/';
            $nearbyCitiesLists[ $count++ % 4 ] .= '<li><a href="' . $uri . '" title="' . $match['Zipcodes']['city_name'] . ' Hot Tubs">' . $match['Zipcodes']['city_name'] . '</a></li>' . "\n";
        }
        return $nearbyCitiesLists;
    }*/
    
    function show($subDomain, $country=null, $zip=null){
        $country = ($country) ? $country : 0;
        $countryID = array();
        
        if (!empty($country)){
            $countryID = $this->Country->find('first', array('conditions' => array('Country.id' => $country)));
        }
        
        /*$defaultCtry = $this->Country->field('id', "Country.name = 'United States'");

        if ((isset($query[1]) && $query[1] == 'fr') || $subDomain == "fr")
        {
            $subDomain = 'fr';
            $defaultCtry = $this->Country->field('id', "Country.name = 'Canada'");
        }*/
        
        $defaultCtry = $this->defaultcountry();
        $this->set('defaultCtry', $defaultCtry);
        
        $inUSCA = $this->verifyUSCA($country); #check to see if searching in US/CA
        $this->set('inUSCA',$inUSCA);
        $owns = null;
        $zip = '';

        #ONLY if country is US or CA
        if (!empty($inUSCA)){
            $isCanada = ($inUSCA['Country']['abbreviation'] == "CA") ? true : false;
            $isUS = ($inUSCA['Country']['abbreviation'] == "US") ? true : false;
            $zip = strtoupper(trim(preg_replace('/\s+/', '', $_POST['zip']))); #take out spaces in zipcode & upper case zip code
            $this->set('zip', $zip);
            $road_wiggle = 1.625;
            #check to see if any retailers own the zipcode. Starting 05/2007 US & now CA only.
            $threeZipCandada = ($isCanada) ? substr($zip, 0, 3) : $zip;
            $zipQuery = ($isCanada) ? "AND dz.zipcode_id = '".substr($zip, 0, 3)."'" : "AND dz.zipcode_id = '$zip'";

            $temp = null;
            $temp = $this->Dealer->query("SELECT dz.zipcode_id
                                               FROM dealers_zipcodes dz
                                               WHERE dz.zipcode_id = '".$threeZipCandada."'"
                                        );

            if (!empty($temp)){
                      $owns = $this->Zipcode->query("SELECT DISTINCT(Dealer.id), Dealer.name, Dealer.slug, Dealer.address1, Dealer.address2, Dealer.city, Dealer.state_id, Dealer.zip, Dealer.country_id, Dealer.email, Dealer.phone, Dealer.fax, Dealer.website, Country.name, Country.abbreviation, State.abbreviation, State.name,
                                               $road_wiggle * ( 3963 *
                                                       acos( truncate(sin( zipcodesearch.latitude / 57.2958 )
                                                       * sin( zipcodes.latitude / 57.2958 )
                                                       + cos( zipcodesearch.latitude / 57.2958 )
                                                       * cos( zipcodes.latitude / 57.2958 )
                                                       * cos( zipcodes.longitude / 57.2958
                                                       - zipcodesearch.longitude / 57.2958 ),8)) ) AS Dealer_Distance
                                               FROM dealers Dealer, dealers_zipcodes dz, zipcodes, countries Country, zipcodes AS zipcodesearch, states State
                                               WHERE zipcodesearch.zipcode = Dealer.zip
                                               AND Dealer.id = dz.dealer_id
                                               AND Country.id = Dealer.country_id
                                            AND State.id = Dealer.state_id
                                            AND Dealer.published = 'Y'
                                            AND Dealer.dealer_id IS NULL
                                            $zipQuery
                                               AND zipcodes.zipcode ='".$zip."'
                                               ORDER BY Dealer_Distance");
            }

            #if Canada or if "owns" query returned 0 results, do distance calculations to find closest retailer
            #(Canadian retailers do not own postal codes, so the code defaults to the closest retailer)
            if (empty($owns)){
                $zipQuery = "zipcodesearch.zipcode = '" .addslashes($zip). "'";
                #if in Canada and in Quebec (Quebec zips start with G, H or J)
                #Quebec dealers should only be displayed when searching for Quebec zipcodes 
                if ($isCanada && !empty($zip)){
                    if ($zip{0} == "G" || $zip{0} == "J" || $zip{0} == "H"){
                        $zipQuery .= " AND (Dealer.state_id IN (SELECT id from states where abbreviation = 'QC'))";
                    }else{
                        $zipQuery .= " AND (Dealer.state_id NOT IN (SELECT id from states where abbreviation = 'QC'))";
                    }
                }
                
                $temp = $this->Dealer->query("SELECT Dealer.address1, Dealer.name, Dealer.id,
                                                        Dealer.zip, Dealer.city, Dealer.state_id, 
                                                        Dealer.country_id, Dealer.fax, Dealer.slug,
                                                        Dealer.website, Dealer.directions, Dealer.email, 
                                                        Dealer.address2, Dealer.phone, State.name,
                                                        Country.name, Country.abbreviation, State.abbreviation, 
                                                        $road_wiggle * ( 3963 *
                                                        acos( truncate(sin( zipcodesearch.latitude / 57.2958 )
                                                        * sin( zipcodes.latitude / 57.2958 )
                                                        + cos( zipcodesearch.latitude / 57.2958 )
                                                        * cos( zipcodes.latitude / 57.2958 )
                                                        * cos( zipcodes.longitude / 57.2958
                                                        - zipcodesearch.longitude / 57.2958 ),8)) ) AS Dealer_Distance
                                                    FROM dealers Dealer, zipcodes, zipcodes AS zipcodesearch, countries Country, states State
                                                    WHERE (".$zipQuery.")
                                                    AND Country.id = Dealer.country_id
                                                    AND State.id = Dealer.state_id
                                                    AND Dealer.zip = zipcodes.zipcode
                                                    AND Dealer.published = 'Y'
                                                    AND Dealer.dealer_id IS NULL
                                                    AND Dealer.country_id = '". addslashes($country) ."' 
                                                    GROUP BY Dealer.address1 ORDER BY Dealer_Distance LIMIT 1");

                #takes only dealers who are within at least 500 miles from zipcode
                if (is_array($temp)){
                    foreach ($temp as $dealerID=>$dealer){
                        if (round($dealer[0]['Dealer_Distance']) <= 500){
                            $owns[] = $dealer;
                        }
                    }
                }

            }
        }

        #country other than US or CA
        else{
            $owns = $this->Dealer->query("SELECT Dealer.address1, Dealer.name, Dealer.id, Dealer.slug,
                                                        Dealer.zip, Dealer.city, Dealer.state_id, Dealer.country_id, Dealer.fax,
                                                        Dealer.website, Dealer.directions, Dealer.email, Dealer.address2, Dealer.address1,
                                                        Dealer.phone, Country.name, Country.abbreviation
                                                        FROM dealers Dealer, countries Country
                                                        WHERE Dealer.country_id=".$country."
                                                        AND Country.id = Dealer.country_id
                                                        AND Dealer.published = 'Y'
                                                        AND Dealer.dealer_id IS NULL
                                                        GROUP BY Dealer.address1 ORDER BY Dealer.name LIMIT 10");
        }
        return $owns;
        //$_SESSION['zip'] = $zip; #used for omniture
        //$this->set('stateList',$this->State->query('SELECT name, abbreviation FROM states WHERE name NOT IN ("", "DC") AND country_id = 1 ORDER BY name ASC')); #generate list of countries
    }
}
?>
