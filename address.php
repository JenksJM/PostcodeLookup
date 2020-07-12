<?php 
    class Address {
        // Properties
        private $query;
        private $postcode = 'N/A';
        private $parish = 'N/A';
        private $adminDistrict = 'N/A';
        private $country = 'N/A';
        private $longitude = 'N/A';
        private $latitude = 'N/A';

        function __construct() {
            
        }

        function buildAddressFromPostcodeApi($addressResponse, $query){
            $this->set_query($query);
            if ($addressResponse){
                $this->set_postcode($addressResponse['postcode']);
                $this->set_parish($addressResponse['parish']);
                $this->set_adminDistrict($addressResponse['admin_district']);
                $this->set_country($addressResponse['country']);
                $this->set_longitude($addressResponse['longitude']);
                $this->set_latitude($addressResponse['latitude']);
            }
        }

        //Getters & Setters
        function set_postcode($postcode) {
            $this->postcode = $postcode;
        }
        function get_postcode() {
            return $this->postcode;
        }

        function set_parish($parish) {
            $this->parish = $parish;
        }
        function get_parish() {
            return $this->parish;
        }

        function set_adminDistrict($adminDistrict) {
            $this->adminDistrict = $adminDistrict;
        }
        function get_adminDistrict() {
            return $this->adminDistrict;
        }

        function set_longitude($longitude) {
            $this->longitude = $longitude;
        }
        function get_longitude() {
            return $this->longitude;
        }

        function set_country($country) {
            $this->country = $country;
        }
        function get_country() {
            return $this->country;
        }

        function set_latitude($latitude) {
            $this->latitude = $latitude;
        }
        function get_latitude() {
            return $this->latitude;
        }

        function set_query($query) {
            $this->query = $query;
        }
        function get_query() {
            return $this->query;
        }
    }
?>