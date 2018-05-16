<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct() {
    }

	function getNameList($keyword) {
		$params = "?q=" . $keyword;
		if (isset($_GET["page"])) {
			$params .= "&page=" . $_GET["page"];
		}

        // create curl resource
        $ch = curl_init();

        // set url
        curl_setopt($ch, CURLOPT_URL, "https://api.github.com/search/users" . $params);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		    'Accept: application/vnd.github.v3.text-match+json',
		    'User-Agent: Awesome-Octocat-App'
		));

        //return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // $output contains the output string
        $output = curl_exec($ch);

        // close curl resource to free up system resources
        curl_close($ch);
        return $output;
    }

    function getFollowersList($username) {
		$params = "";
		if (isset($_GET["page"])) {
			$params = "?page=" . $_GET["page"];
		}

        // create curl resource
        $ch = curl_init();

        // set url
        curl_setopt($ch, CURLOPT_URL, "https://api.github.com/users/" . $username . "/followers" . $params);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		    'Accept: application/vnd.github.v3.text-match+json',
		    'User-Agent: Awesome-Octocat-App'
		));

        //return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // $output contains the output string
        $followers = curl_exec($ch);

        // close curl resource to free up system resources
        curl_close($ch);

		return $followers;
    }

    function followersPage($username) {
    	return view('followers', ['username' => $username]);
    }
}