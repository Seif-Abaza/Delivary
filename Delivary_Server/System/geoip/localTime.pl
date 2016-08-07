#!/usr/bin/perl

# localTime.pl

# Return the current time in epoch seconds in the specified time zone

use DateTime;
use DateTime::TimeZone;

$timeZoneName = $ARGV[$argnum];
$timeZone     = DateTime::TimeZone->new(name => $timeZoneName);
$timeNow      = time();
$dateTime     = DateTime->from_epoch(epoch => $timeNow);
$offset       = $timeZone->offset_for_datetime($dateTime);
$localTime    = $timeNow + $offset;
print "$localTime";
