<?php

// localTime.php

require_once('timeZones.php');

/*
 * Return the time zone for the specified country.
 * If the country has more than one time zone, return
 * the time zone nearest to the specified longitude.
 */
function ip2c_getTimeZone($countryCode2, $longitude)
{
	$timeZone = "Unknown";
	global $IP2C_TIME_ZONES;
	if (array_key_exists($countryCode2, $IP2C_TIME_ZONES))
	{
		$timeZoneInfo = $IP2C_TIME_ZONES[$countryCode2];
		if (is_array($timeZoneInfo))
		{
			$timeZone = _ip2c_getNearestTimeZone($timeZoneInfo, $longitude);
		}
		else
		{
			$timeZone = $timeZoneInfo;
		}
	}
	return $timeZone;
}

/*
 * Return the local time in the specified time zone
 * or zero if the time zone is "Unknown".
 */
function ip2c_getLocalTime($timeZone)
{
	$epoch = 0;
	if ($timeZone != "Unknown")
	{
		$command = "localTime.pl $timeZone";
		$output = shell_exec($command);
		if ($output != "" and is_int($output * 1))
		{
			$epoch = $output;
		}
	}
	return $epoch;
}

/*
 * Return the time zone in the specified list of time zones
 * whose longitude is closest to the specified longitude.
 */
function _ip2c_getNearestTimeZone($timeZones, $longitude)
{
	$nearestDistance = 10000;
	foreach ($timeZones as $timeZoneInfo)
	{
		$distance = abs(abs($longitude) - abs($timeZoneInfo[1]));
		if ($distance < $nearestDistance)
		{
			$nearestDistance = $distance;
			$nearestTimeZone = $timeZoneInfo[0];
		}
	}
	return $nearestTimeZone;
}

?>
