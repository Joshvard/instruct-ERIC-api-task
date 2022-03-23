<?php
    namespace Classes;

    /**
     * Main API logic for the /service endpoint, all data operations will be carried out here for the specific endpoint
     */
    class ServiceController extends \Classes\Controller{
        // Override function for the GET endpoint
        protected function get($data){
            // If the incoming data does not exist, or is not what is expected, discard the request
            if(!array_key_exists('countryCode', $data)){
                $this->returnDataJson(array('response' => 'Unexpected arguments.'));
            }

            if(!$data['countryCode']){
                $this->returnDataJson(array('response' => 'Empty request.'));
            }

            if(count($data) > 2){
                $this->returnDataJson(array('response' => 'More arguments were provided than expected.'));
            }

            $apiData = array();

            if(!$conn = \Classes\Database::connect()){
                $this->returnDataJson(array('response' => 'The endpoint just encountered an error, please try again later.'));
            }
            
            // Query the service data based on country
            $statement = $conn->prepare("SELECT ref, centre, service, country FROM ServiceCategory WHERE country = ?");
            $statement->bind_param("s", $data['countryCode']);
            $statement->execute();

            $result = $statement->get_result();

            if($result->num_rows < 1){
                $this->returnDataJson(array('response' => 'No data was found under the request query.'));
            }

            // For every record found, push into our return array
            while($row = $result->fetch_assoc()){
               array_push($apiData, $row);
            }

            $this->returnDataJson($apiData);
        }

        protected function post($data){
            $expectedKeys = array(
                'ref',
                'centre',
                'service',
                'country'
            );

            // Empty data is useless, discard the request
            if(empty($data)){
                $this->returnDataJson(array('response' => 'Unexpected parameters.'));
            }

            // The POST request must contain at least each of the expected properties
            foreach($expectedKeys as $value){
                if(!array_key_exists($value, $data)){
                    $this->returnDataJson(array('response' => 'Unexpected parameters.'));
                }
            }

            if(!$conn = \Classes\Database::connect()){
                $this->returnDataJson(array('response' => 'The endpoint just encountered an error, please try again later.'));
            }
            
            // Check to see if the requested reference code exists within the dataset already
            $statement = $conn->prepare("SELECT service_id FROM ServiceCategory WHERE ref = ?");
            $statement->bind_param("s", $data['ref']);
            $statement->execute();
            $result = $statement->get_result();

            // If there is already an existing record based on the reference code, we will perform an update to the record
            if($result->num_rows > 0){
                $statement = $conn->prepare("UPDATE ServiceCategory SET centre = ?, service = ?, country = ? WHERE ref = ?");
                $statement->bind_param("ssss", $data['centre'], $data['service'], $data['country'], $data['ref']);

                if(!$statement->execute()){
                    // The update errored, let the requester know
                    $conn->close();
                    $this->returnDataJson(array('response' => 'Unexpected error occured with this endpoint, please try again later.'));
                }

                $conn->close();
                $this->returnDataJson(array('response' => 'Successfully updated record.'));
            }
        
            // No reference code was found, we shall insert a new record
            $statement = $conn->prepare("INSERT INTO ServiceCategory(ref, centre, service, country) VALUES (?, ?, ?, ?)");
            $statement->bind_param("ssss", $data['ref'], $data['centre'], $data['service'], $data['country']);

            if(!$statement->execute()){
                $conn->close();
                $this->returnDataJson(array('response' => 'Unexpected error occured with this endpoint, please try again later.'));
            }

            $conn->close();
            $this->returnDataJson(array('response' => 'Successfully added record.'));
        }

        private function returnDataJson($data){
            // The API will respond with JSON
            // Parse and encode all data in JSON and send it to the requester
            $parsedData = json_encode($data);

            echo $parsedData;
            exit();
        }
    }
?>