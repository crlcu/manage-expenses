<?php
    function distanceOfTimeInWords($fromTime, $toTime = 0) {
    	if($toTime==0) {
    		$toTime =time();
    	}
    	
    	$distanceInSeconds = round(abs($toTime - $fromTime));
    	$distanceInMinutes = round($distanceInSeconds / 60);
    	
    	if ($distanceInMinutes <= 1) {
    		if ($distanceInSeconds < 1) {
    			return $distanceInSeconds.' second ago';
    		}
    		else {
    			return $distanceInSeconds.' seconds ago';
    		}
    	} else if ($distanceInMinutes < 60) {
    		return $distanceInMinutes . ' minutes ago';
    	} else if ($distanceInMinutes < 120) {
    		$mins= $distanceInMinutes - 60;
    		if($mins==0) {
    			return '1 hour ago';
    		} else if($mins==1) {
    			return '1 hour 1 minute ago';
    		} else {
    			return '1 hour '.$mins. ' minutes ago';
    		}
    	} else if ($distanceInMinutes < 1440) {
    		$hours= intval(($distanceInMinutes) / 60);
    		$mins= $distanceInMinutes - ($hours * 60);
    		if($mins==0) {
    			return $hours.' hours ago';
    		} else if($mins==1) {
    			return $hours.' hours 1 minute ago';
    		} else {
    			return $hours.' hours '.$mins. ' minutes ago';
    		}
    	} else if ( $distanceInMinutes < 2880 ) {
    		return '1 day ago';
    	} else if ( $distanceInMinutes < 43200 ) {
    		return round(floatval($distanceInMinutes) / 1440) . ' days ago';
    	} else if ( $distanceInMinutes < 86400 ) {
    		return '1 month ago';
    	} else if ( $distanceInMinutes < 525600 ) {
    		return round(floatval($distanceInMinutes) / 43200) . ' months ago';
    	} else if ( $distanceInMinutes < 1051199 ) {
    		return '1 year ago';
    	}
    	
    	return round(floatval($distanceInMinutes) / 525600) . ' years ago';
    }