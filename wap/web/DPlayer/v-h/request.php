<?php
function get_url($url, $type = 0, $post_data = "", $ua = "", $cookie = "", $redirect = true)
{
	$refere = "https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
	$header = array("Referer:" . $refere, "User-Agent:" . $_SERVER["HTTP_USER_AGENT"]);
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $url);
	if (empty($ua) == false) {
		$header[] = "User-Agent:" . $_SERVER["HTTP_USER_AGENT"];
	}
	if (empty($cookie) == false) {
		$header[] = "Cookie:" . $cookie;
	}
	if (empty($ua) == false || empty($cookie) == false || empty($header) == false) {
		curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
	}
	if ($type == 1) {
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
	}
	if ($redirect == false) {
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
	}
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($curl, CURLOPT_HEADER, false);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	$return = curl_exec($curl);
	if (curl_getinfo($curl, CURLINFO_HTTP_CODE) == "200") {
		$return_header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
		$return_header = substr($return, 0, $return_header_size);
		$return_data = substr($return, $return_header_size);
	}
	curl_close($curl);
	return $return;
}