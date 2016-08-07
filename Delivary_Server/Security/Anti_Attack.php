<?php

require_once MAIN_DIR . '/conf/Configration.php';

//Anti DDOS
$cookie = $_COOKIE['delivary'];
$othercookie = $_COOKIE['delivaryonline'];


if ($cookie && $othercookie > 0) {
    $iptime = 20;
}  // Minimum number of seconds between visits for users with certain cookie
else {
    $iptime = 10;
} // Minimum number of seconds between visits for everyone else


$ippenalty = 60; // Seconds before visitor is allowed back


if ($cookie && $othercookie > 0) {
    $ipmaxvisit = 30;
} // Maximum visits, per $iptime segment
else {
    $ipmaxvisit = 20;
} // Maximum visits per $iptime segment


$iplogdir = BLOCK_DDOS_DIR . DIRECTORY_SEPARATOR;
$iplogfile = "iplog.dat";

if (!file_exists($iplogdir)) {
    mkdir($iplogdir);
}

$ipfile = substr(md5($_SERVER["REMOTE_ADDR"]), -2);
$oldtime = 0;
if (file_exists($iplogdir . $ipfile)) {
    $oldtime = filemtime($iplogdir . $ipfile);
}

$time = time();
if ($oldtime < $time) {
    $oldtime = $time;
}
$newtime = $oldtime + $iptime;

if ($newtime >= $time + $iptime * $ipmaxvisit) {
    touch($iplogdir . $ipfile, $time + $iptime * ($ipmaxvisit - 1) + $ippenalty);
    $oldref = $_SERVER['HTTP_REFERER'];
    header("HTTP/1.0 503 Service Temporarily Unavailable");
    header("Connection: close");
    header("Content-Type: text/html");
    echo "<html><body bgcolor=#999999 text=#ffffff link=#ffff00>
<font face='Verdana, Arial'><p><b>
<h1>Temporary Access Denial</h1>Too many quick page views by your IP address (more than " . $ipmaxvisit . " visits within " . $iptime . " seconds).</b>
";
    echo "<br />Please wait " . $ippenalty . " seconds and reload.</p></font></body></html>";
    touch($iplogdir . $iplogfile); //create if not existing
    $fp = fopen($iplogdir . $iplogfile, "a");
    $yourdomain = $_SERVER['HTTP_HOST'];
    if ($fp) {
        $useragent = "<unknown user agent>";
        if (isset($_SERVER["HTTP_USER_AGENT"])) {
            $useragent = $_SERVER["HTTP_USER_AGENT"];
        }
        fputs($fp, $_SERVER["REMOTE_ADDR"] . " " . date("d/m/Y H:i:s") . " " . $useragent . "\n");
        fclose($fp);
        $yourdomain = $_SERVER['HTTP_HOST'];

        //the @ symbol before @mail means 'supress errors' so you wont see errors on the page if email fails.
        if ($_SESSION['reportedflood'] < 1 && ($newtime < $time + $iptime + $iptime * $ipmaxvisit)) {
            $mail = mail('flood_alert@' . $yourdomain, 'site flooded by ' . $cookie . ' '
                    . $_SERVER['REMOTE_ADDR'], 'http://' . $yourdomain . ' rapid website access flood occured and ban for IP ' . $_SERVER['REMOTE_ADDR'] . ' at http://' . $yourdomain . $_SERVER['REQUEST_URI'] . ' from ' . $oldref . ' agent ' . $_SERVER['HTTP_USER_AGENT'] . ' '
                    . $cookie . ' ' . $othercookie, "From: " . $yourdomain . "\n");
        }
        $_SESSION['reportedflood'] = 1;
    }
    exit(0);
} else {
    $_SESSION['reportedflood'] = 0;
}


//echo("loaded ".$cookie.$iplogdir.$iplogfile.$ipfile.$newtime);
touch($iplogdir . $ipfile, $newtime); //this just updates the IP file access date or creates a new file if it doesn't exist in /iplog
