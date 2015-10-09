<?php
/**
 * Created by PhpStorm.
 * User: craig
 * Date: 14/09/15
 * Time: 9:10 PM
 */

namespace App\Yelp;

//require_once('lib/\OAuth.php');

class Yelp {

    // Set your \OAuth credentials here
// These credentials can be obtained from the 'Manage API Access' page in the
// developers documentation (http://www.yelp.com/developers)
    protected $CONSUMER_KEY = 'D_-XDm7MI4N0KlnIOZ-_5A';
    protected $CONSUMER_SECRET = 'T8zgRBp--vY8mTX--W1jre6nG3g';
    protected $TOKEN = 'cZwv7u8AgG8RM3LB4WTaZvhkXQ97K6Tg';
    protected $TOKEN_SECRET = 'y1uRgPUBBDDEMmJLCAV_xsQLkRU';

    protected $API_HOST = 'api.yelp.com';
    protected $DEFAULT_TERM = 'dinner';
    protected $DEFAULT_LOCATION = 'San Francisco, CA';
    protected $SEARCH_LIMIT = 3;
    protected $SEARCH_PATH = '/v2/search/';
    protected $BUSINESS_PATH = '/v2/business/';

    function __construct()
    {
    }

    /**
     * Makes a request to the Yelp API and returns the response
     *
     * @param    $host    The domain host of the API
     * @param    $path    The path of the APi after the domain
     * @return   The JSON response from the request
     */
    function request($host, $path) {
        $unsigned_url = "http://" . $host . $path;

        // Token object built using the \OAuth library
        $token = new \OAuthToken($this->TOKEN, $this->TOKEN_SECRET);

        // Consumer object built using the \OAuth library
        $consumer = new \OAuthConsumer($this->CONSUMER_KEY, $this->CONSUMER_SECRET);

        // Yelp uses HMAC SHA1 encoding
        $signature_method = new \OAuthSignatureMethod_HMAC_SHA1();

        $oauthrequest = \OAuthRequest::from_consumer_and_token(
            $consumer,
            $token,
            'GET',
            $unsigned_url
        );

        // Sign the request
        $oauthrequest->sign_request($signature_method, $consumer, $token);

        // Get the signed URL
        $signed_url = $oauthrequest->to_url();

        // Send Yelp API Call
        $ch = curl_init($signed_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
    }

    /**
     * Query the Search API by a search term and location
     *
     * @param    $term        The search term passed to the API
     * @param    $location    The search location passed to the API
     * @return   The JSON response from the request
     */
    public function search($term, $location) {
        $url_params = array();

        $url_params['term'] = $term ?: $this->DEFAULT_TERM;
        $url_params['location'] = $location?: $this->DEFAULT_LOCATION;
        $url_params['limit'] = $this->SEARCH_LIMIT;
        $search_path = $this->SEARCH_PATH . "?" . http_build_query($url_params);

        return $this->request($this->API_HOST, $search_path);
    }

    /**
     * Query the Business API by business_id
     *
     * @param    $business_id    The ID of the business to query
     * @return   The JSON response from the request
     */
    function get_business($business_id) {
        $business_path = $this->BUSINESS_PATH . $business_id;
        return $this->request($this->API_HOST, $business_path);
    }

    /**
     * Queries the API by the input values from the user
     *
     * @param    $term        The search term to query
     * @param    $location    The location of the business to query
     */
    function query_api($term, $location) {
        $response = json_decode($this->search($term, $location));
        $business_id = $response->businesses[0]->id;

        print sprintf(
            "%d businesses found, querying business info for the top result \"%s\"\n\n",
            count($response->businesses),
            $business_id
        );

        $response = $this->get_business($business_id);

        print sprintf("Result for business \"%s\" found:\n", $business_id);
        print "$response\n";
    }

    public function best($categoryFilter, $location) {
        $url_params = array();

        /**
         * term	string	optional	Search term (e.g. "food", "restaurants"). If term isn’t included we search everything.
        limit	number	optional	Number of business results to return
        offset	number	optional	Offset the list of returned business results by this amount
        sort	number	optional	Sort mode: 0=Best matched (default), 1=Distance, 2=Highest Rated. If the mode is 1 or 2 a search may retrieve an additional 20 businesses past the initial limit of the first 20 results. This is done by specifying an offset and limit of 20. Sort by distance is only supported for a location or geographic search. The rating sort is not strictly sorted by the rating value, but by an adjusted rating value that takes into account the number of ratings, similar to a bayesian average. This is so a business with 1 rating of 5 stars doesn’t immediately jump to the top.
        category_filter	string	optional	Category to filter search results with. See the list of supported categories. The category filter can be a list of comma delimited categories. For example, 'bars,french' will filter by Bars and French. The category identifier should be used (for example 'discgolf', not 'Disc Golf').
        radius_filter	number	optional	Search radius in meters. If the value is too large, a AREA_TOO_LARGE error may be returned. The max value is 40000 meters (25 miles).
        deals_filter	bool	optional	Whether to exclusively search for businesses with deals
         */

//        $url_params['term'] = 'pizza',//$term ?: $this->DEFAULT_TERM;
        $url_params['location'] = $location; //$location?: $this->DEFAULT_LOCATION;
        $url_params['sort'] = 2; //$location?: $this->DEFAULT_LOCATION;
        $url_params['category_filter'] = $categoryFilter; //$location?: $this->DEFAULT_LOCATION;
        $url_params['radius_filter'] = '40000'; //$location?: $this->DEFAULT_LOCATION;
        $url_params['limit'] = 10; //$this->SEARCH_LIMIT;

        $search_path = $this->SEARCH_PATH . "?" . http_build_query($url_params);

        $response = json_decode($this->request($this->API_HOST, $search_path));
        if(!isset($response->businesses)) {
            return [];
        }
        return $response->businesses;
    }
}