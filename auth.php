<?php

session_start();

function checkAuth($doRedirect) {
	if (isset($_SESSION["onidid"]) && $_SESSION["onidid"] != "") return $_SESSION["onidid"];

	 $pageURL = 'http';
	 if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
	 $pageURL .= "://";
	 if ($_SERVER["SERVER_PORT"] != "80") {
	  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["SCRIPT_NAME"];
	 } else {
	  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["SCRIPT_NAME"];
	 }

	$ticket = isset($_REQUEST["ticket"]) ? $_REQUEST["ticket"] : "";

	if ($ticket != "") {
		$url = "https://login.oregonstate.edu/cas/serviceValidate?ticket=".$ticket."&service=".$pageURL;
		$html = file_get_contents($url);
		$pattern = '/\\<cas\\:user\\>([a-zA-Z0-9]+)\\<\\/cas\\:user\\>/';
		preg_match($pattern, $html, $matches);
		if ($matches && count($matches) > 1) {
			$onidid = $matches[1];
			$_SESSION["onidid"] = $onidid;
			return $onidid;
		} 
	} else if ($doRedirect) {
		$url = "https://login.oregonstate.edu/cas/login?service=".$pageURL;
		echo "<script>location.replace('" . $url . "');</script>";
	} 
	return "";
}


function getAdvanced($onid) {
	$ds=ldap_connect("directory.oregonstate.edu");
 
$dn = "o=orst.edu";
$filter="(uid=$onid)";
$justthese = array("uid", "cn", "mail");
$sr=ldap_search($ds, $dn, $filter);
$info = ldap_get_entries($ds, $sr);

$rinfo;

//code courtesy of Prof Scaffidi 
for ($i = 0; $i < $info["count"]; $i++) {
                if ($i > 0)                                                                                                                                                                                                                                                                                                                                                                                                              
                                
 
                $altphonerec = $info[$i]["homephone"];
                /*if ("".$altphonerec == "Array")
                                $altphonerec = $altphonerec[0];
                if (strpos($altphonerec, "1 541 737 ") !== 0)
                                $altphonerec = "";
 
                $alttitle = $info[$i]["osuprimaryaffiliation"];
                if ("".$alttitle == "Array")
                                $alttitle = $alttitle[0];
                if ($alttitle == "S")
                                $alttitle = "Student";
                else
                                $alttitle = "";*/
 
                $altemail = $onid . "@onid.oregonstate.edu";                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             
                foreach ($justthese as $key) {
                                $value = $info[$i][$key];
                                if (is_array($value))
                                                $rinfo[$key]=$value[0];
                                else if ($key == "telephonenumber" && $value == "" && $altphonerec <> "")
                                                $rinfo[$key]=$altphonerec;
                                else if ($key == "title" && $value == "" && $alttitle <> "")
                                                $rinfo[$key]=$alttitle;
                                else if ($key == "mail" && $value == "" && $altemail <> "")
                                                $rinfo[$key]=$altemail;
                                else       
                                                $rinfo[$key]=$value;
 
                               
                }
}                                                                                                                                                                                                                                                                                                                                                                                          
ldap_close($ds);  

	return $rinfo;
}