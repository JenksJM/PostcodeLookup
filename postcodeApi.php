<?php 
    class PostcodeAPI {
        // Properties
        private $apiUrl = 'api.postcodes.io';
        private $postcodes;
        private $endPoint;
        private $postData;
        private $result;
        private $addresses = array();

        function __construct() {
        }

        // Methods
        
        /**
         * runs postcode lookup depending on number of postcodes
         * */
        function dynamicPostcodeLookup(){
            if (count($this->get_postcodes()) > 1){
                $this->bulkPostCodeLookup();
                return;
            }
            $this->singlePostcodeLookup();
        }

        /**
         * single postcode lookup uses the following endpoint GET api.postcodes.io/postcodes/
         * */
        function singlePostcodeLookup(){
            $this->set_endPoint('/postcodes/' . $this->get_postcodes()[0]);
            $this->runApi('GET');
            $this->buildAddressFromResult();
        }

        /**
         * bulk postcode lookup uses the following endpoint POST api.postcodes.io/postcodes
         * */
        function bulkPostCodeLookup(){
            $this->set_endPoint('/postcodes');
            $this->set_postData(json_encode(array('postcodes' => $this->postcodes)));
            $this->runApi('POST');
            $this->buildAddressesFromResult();
        }

        /**
         * builds an address object from the single postcode lookup response
         * */
        function buildAddressFromResult(){
            $phpResult = json_decode($this->get_result(), 1);
            $address = new Address();
            $phpResult['result'] = ($phpResult['result']) ?? '';
            $address->buildAddressFromPostcodeApi($phpResult['result'], $this->postcodes[0]);
            $this->pushToAddresses($address);          
        }

        /**
         * builds address objects from the bulk postcode lookup response
         * */
        function buildAddressesFromResult(){
            $phpResult = json_decode($this->get_result(), 1);
            if (isset($phpResult['result'])){
                foreach($phpResult['result'] as $fullAddress){
                    $address = new Address();
                    $address->buildAddressFromPostcodeApi($fullAddress['result'], $fullAddress['query']);
                    $this->pushToAddresses($address);
                }
            }
        }

         /**
         * runs API calls and sets the result
         * */
        function runApi($restCommand){
            $curl = curl_init();
            
            switch($restCommand){
                case 'POST':
                    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
                    curl_setopt($curl, CURLOPT_POST, 1);
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $this->get_postData());
                break;
            }

            curl_setopt($curl, CURLOPT_URL, $this->get_apiUrl() . $this->get_endPoint());
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            $result = curl_exec($curl);
            curl_close($curl);
            
            $this->set_result($result);
        }
        
        /**
         * adds postcodes to an array. 
         * Removes preceeding and trailing white space from all entries
         * */
        function formatPostcodes($postcodes){
            $postcodeArray = explode(",", $postcodes);
            foreach($postcodeArray as &$postcode){
                $postcode = trim($postcode);
            }
            return $postcodeArray;
        }

        /**
         * pushs a new address to the addresses array
         * */
        function pushToAddresses($address){
            $addressArray = $this->get_addresses();
            $addressArray[] = $address;
            $this->set_addresses($addressArray);
        }

        //Getters & Setters
        function set_apiUrl($url) {
            $this->apiUrl = $url;
        }
        function get_apiUrl() {
            return $this->apiUrl;
        }

        function set_endPoint($endPoint) {
            $this->endPoint = $endPoint;
        }
        function get_endPoint() {
            return $this->endPoint;
        }

        function set_postData($postData) {
            $this->postData = $postData;
        }
        function get_postData() {
            return $this->postData;
        }

        function set_result($result) {
            $this->result = $result;
        }
        function get_result() {
            return $this->result;
        }

        function set_postcodes($postcodes) {
            $this->postcodes = $postcodes;
        }
        function get_postcodes() {
            return $this->postcodes;
        }

        function set_addresses($addresses) {
            $this->addresses = $addresses;
        }
        function get_addresses() {
            return $this->addresses;
        }
    }
