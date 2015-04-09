<?php

class State extends AppModel
{
	function getCountryId($stateId=null) {
		if(!empty($stateId)) {
			return $this->field("country_id", array("State.id" => $stateId));
		}
		return 1;
	}

}

?>