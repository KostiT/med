<?php

/**
 * This is basically for Listing and Purchasing DID Numbers.
 * API is communicating with several Vendor APIs to achieve it's purpose.
 *
 * @author raakesh
 */
class V2 extends MY_Controller {

    function __construct() {
        // Construct the parent class
        parent::__construct();
    }

    public function fetchRecords_get() {
        $ranges = Range::all();
        
        if (!empty($ranges)) {
            $ranges_array = array();
            foreach ($ranges as $key => $value) {
                $ranges_array[$key] = $value->to_array();
            }
            $this->response([
                'status' => true,
                'message' => 'Success.',
                'data' => $ranges_array,
                'code' => $this->response_codes['SUCCESS']
                    ], REST_Controller::HTTP_OK); // HTTP_SERVICE_UNAVAILABLE (503) being the HTTP response code  
            die();
        }
        $this->response([
            'status' => false,
            'message' => 'Failed.',
            'code' => $this->response_codes['FAILED']
                ], REST_Controller::HTTP_PARTIAL_CONTENT); // HTTP_SERVICE_UNAVAILABLE (503) being the HTTP response code  
        die();
    }

    public function fetchRecord_get($id) {
        $range = Range::first($id);
        
        if (!empty($range)) {

            $this->response([
                'status' => true,
                'message' => 'Success.',
                'data' => $range->to_array(),
                'code' => $this->response_codes['SUCCESS']
                    ], REST_Controller::HTTP_OK); // HTTP_SERVICE_UNAVAILABLE (503) being the HTTP response code  
            die();
        }
        $this->response([
            'status' => false,
            'message' => 'Failed.',
            'code' => $this->response_codes['FAILED']
                ], REST_Controller::HTTP_PARTIAL_CONTENT); // HTTP_SERVICE_UNAVAILABLE (503) being the HTTP response code  
        die();
    }

    public function AddRecord_post() {
        
        $request = json_decode($this->input->raw_input_stream);

        if (empty($request->name)) {
            $this->response([
                'status' => false,
                'message' => 'Record Name required',
                'code' => $this->response_codes['INVALID']
                    ], REST_Controller::HTTP_PARTIAL_CONTENT); // HTTP_SERVICE_UNAVAILABLE (503) being the HTTP response code  
            die();
        }


        if (empty($request->low)) {
            $this->response([
                'status' => false,
                'message' => 'Record Low required',
                'code' => $this->response_codes['INVALID']
                    ], REST_Controller::HTTP_PARTIAL_CONTENT); // HTTP_SERVICE_UNAVAILABLE (503) being the HTTP response code  
            die();
        }
        if (empty($request->high)) {
            $this->response([
                'status' => false,
                'message' => 'Record High required',
                'code' => $this->response_codes['INVALID']
                    ], REST_Controller::HTTP_PARTIAL_CONTENT); // HTTP_SERVICE_UNAVAILABLE (503) being the HTTP response code  
            die();
        }
        if (empty($request->unit)) {
            $this->response([
                'status' => false,
                'message' => 'Record Unit required',
                'code' => $this->response_codes['INVALID']
                    ], REST_Controller::HTTP_PARTIAL_CONTENT); // HTTP_SERVICE_UNAVAILABLE (503) being the HTTP response code  
            die();
        }
        $data = array(
            'name' => $request->name,
            'low' => $request->low,
            'high' => $request->high,
            'unit' => $request->unit
        );
        if (Range::create($data)) {
            $this->response([
                'status' => true,
                'message' => 'Successfully Added.',
                'code' => $this->response_codes['SUCCESS']
                    ], REST_Controller::HTTP_OK); // HTTP_SERVICE_UNAVAILABLE (503) being the HTTP response code  
            die();
        }
        $this->response([
            'status' => false,
            'message' => 'Failed.',
            'code' => $this->response_codes['FAILED']
                ], REST_Controller::HTTP_PARTIAL_CONTENT); // HTTP_SERVICE_UNAVAILABLE (503) being the HTTP response code  
        die();
    }

    public function UpdateRecord_post() {
        $request = json_decode($this->input->raw_input_stream);

        if (empty($request->id)) {
            $this->response([
                'status' => false,
                'message' => 'Record ID required',
                'code' => $this->response_codes['INVALID']
                    ], REST_Controller::HTTP_PARTIAL_CONTENT); // HTTP_SERVICE_UNAVAILABLE (503) being the HTTP response code  
            die();
        }

        
        $record = Range::find(array("conditions"=>array("id=?",$request->id)));
        if (empty($record)) {
            $this->response([
                'status' => false,
                'message' => 'Record ID is invalid. Please make sure you are sending correct ID',
                'code' => $this->response_codes['FAILED']
                    ], REST_Controller::HTTP_PARTIAL_CONTENT); // HTTP_SERVICE_UNAVAILABLE (503) being the HTTP response code  
            die();
        }


        if (empty($request->name)) {
            $this->response([
                'status' => false,
                'message' => 'Record Name required',
                'code' => $this->response_codes['INVALID']
                    ], REST_Controller::HTTP_PARTIAL_CONTENT); // HTTP_SERVICE_UNAVAILABLE (503) being the HTTP response code  
            die();
        }


        if (empty($request->low)) {
            $this->response([
                'status' => false,
                'message' => 'Record Low required',
                'code' => $this->response_codes['INVALID']
                    ], REST_Controller::HTTP_PARTIAL_CONTENT); // HTTP_SERVICE_UNAVAILABLE (503) being the HTTP response code  
            die();
        }
        if (empty($request->high)) {
            $this->response([
                'status' => false,
                'message' => 'Record High required',
                'code' => $this->response_codes['INVALID']
                    ], REST_Controller::HTTP_PARTIAL_CONTENT); // HTTP_SERVICE_UNAVAILABLE (503) being the HTTP response code  
            die();
        }
        if (empty($request->unit)) {
            $this->response([
                'status' => false,
                'message' => 'Record Unit required',
                'code' => $this->response_codes['INVALID']
                    ], REST_Controller::HTTP_PARTIAL_CONTENT); // HTTP_SERVICE_UNAVAILABLE (503) being the HTTP response code  
            die();
        }
        $data = array(
            'name' => $request->name,
            'low' => $request->low,
            'high' => $request->high,
            'unit' => $request->unit
        );
        
        if ($record->update_attributes($data)) {
            $this->response([
                'status' => true,
                'message' => 'Successfully Updated.',
                'code' => $this->response_codes['SUCCESS']
                    ], REST_Controller::HTTP_OK); // HTTP_SERVICE_UNAVAILABLE (503) being the HTTP response code  
            die();
        }
        $this->response([
            'status' => false,
            'message' => 'Failed.',
            'code' => $this->response_codes['FAILED']
                ], REST_Controller::HTTP_PARTIAL_CONTENT); // HTTP_SERVICE_UNAVAILABLE (503) being the HTTP response code  
        die();
    }

    public function DeleteRecord_post() {
        $request = json_decode($this->input->raw_input_stream);

        if (empty($request->id)) {
            $this->response([
                'status' => false,
                'message' => 'Record ID required',
                'code' => $this->response_codes['INVALID']
                    ], REST_Controller::HTTP_PARTIAL_CONTENT); // HTTP_SERVICE_UNAVAILABLE (503) being the HTTP response code  
            die();
        }

        $record = Range::find(array("conditions"=>array("id=?",$request->id)));
        if (empty($record)) {
            $this->response([
                'status' => false,
                'message' => 'Record ID is invalid. Please make sure you are sending correct ID',
                'code' => $this->response_codes['FAILED']
                    ], REST_Controller::HTTP_PARTIAL_CONTENT); // HTTP_SERVICE_UNAVAILABLE (503) being the HTTP response code  
            die();
        }

        if ($record->delete()) {
            $this->response([
                'status' => true,
                'message' => 'Successfully Deleted.',
                'code' => $this->response_codes['SUCCESS']
                    ], REST_Controller::HTTP_OK); // HTTP_SERVICE_UNAVAILABLE (503) being the HTTP response code  
            die();
        }
        $this->response([
            'status' => false,
            'message' => 'Failed.',
            'code' => $this->response_codes['FAILED']
                ], REST_Controller::HTTP_PARTIAL_CONTENT); // HTTP_SERVICE_UNAVAILABLE (503) being the HTTP response code  
        die();
    }
    
    
    public function test() {
        print_r("asdf");exit;   
    }
}

?>