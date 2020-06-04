<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class employeeController extends Controller
{
    
    public function createEmployee(Request $request)
    {

        
        $name = $request->input("name");
        $position = $request->input("position");
        $salary = $request->input("salary");
        $job_type = $request->input("job_type");
        $status = $request->input("status");
        $duration = $request->input("duration");
        

        $name = addslashes(trim($name));
        $position = addslashes(trim($position));
        $salary = addslashes(trim($salary));
        $job_type = addslashes(trim($job_type));
        $status = addslashes(trim($status));
        $duration = addslashes(trim($duration));

        $date=date("d F, Y");
        $time=date("h:i A");

        if($name == "" || $position == "" || $salary == "" || $job_type =="" || $status == "" || $duration == "")
        {
            $error_message = array("message"=>"Fields must not be empty!");
            return response()->json($error_message);
        }
        else
        {
           
            $post_query = DB::table("employees")->insert([
                "Name" => $name,
                "Position" => $position,
                "Salary" => $salary,
                "Job_Type" => $job_type,
                "Status" => $status,
                "Duration" => $duration,
                "Date" => $date,
                "Time" => $time
            ]);

            if($post_query)
            {
                $success_message = array("message"=>"Employee added successfully");
                return response()->json($success_message);
            }
            else
            {
                $success_message = array("message"=>"Failed to add Employee");
                return response()->json($success_message);
            }
        }
    }

    public function getAllEmployee(Request $request)
    {
        $api_token = $request->token;
        
        $api_token = addslashes(trim($api_token));

       if($api_token < 40)
        {
            $error_message = array("message"=>"Unable to make a request");
            return response()->json($error_message);
        }

        $check_api = DB::select("SELECT * FROM api_token WHERE Api= :api_token",["api_token"=>$api_token]);

        if($check_api)
        {
            $query = DB::table("employees")->get();

            if($query)
            {
                return response()->json($query);
            }
        }
        else
        {
            $error_message = array("message"=>"Unable to make a request");
            return response()->json($error_message);
        }
    }

    public function getEmployeeById(Request $request)
    {
        $api_token = $request->token;
        $emp_id = $request->id;
        
        $api_token = addslashes(trim($api_token));

       if($api_token < 40)
        {
            $error_message = array("message"=>"Unable to make a request");
            return response()->json($error_message);
        }

        $check_emp_id = DB::select("SELECT * FROM employees WHERE ID= :emp_id",["emp_id"=>$emp_id]);

        if($check_emp_id)
        {

            $check_api = DB::select("SELECT * FROM api_token WHERE Api= :api_token",["api_token"=>$api_token]);

            if($check_api)
            {
                $query_by_id = DB::table("employees")->where("ID",$emp_id)->first();

                if($query_by_id)
                {
                    return response()->json($query_by_id);
                }
            }
            else
            {
                $error_message = array("message"=>"Unable to make a request");
                return response()->json($error_message);
            }
        }
        else
        {
            $error_message = array("message"=>"Employee id does not exist!");
            return response()->json($error_message);
        }
    }

    public function updateEmployee(Request $request)
    {
        $emp_id = $request->id;
        $api_token = $request->token;

        $name = $request->input("name");
        $position = $request->input("position");
        $salary = $request->input("salary");
        $job_type = $request->input("job_type");
        $status = $request->input("status");
        $duration = $request->input("duration");
        

        $name = addslashes(trim($name));
        $position = addslashes(trim($position));
        $salary = addslashes(trim($salary));
        $job_type = addslashes(trim($job_type));
        $status = addslashes(trim($status));
        $duration = addslashes(trim($duration));

        $date=date("d F, Y");
        $time=date("h:i A");

        if($name == "" || $position == "" || $salary == "" || $job_type =="" || $status == "" || $duration == "")
        {
            $error_message = array("message"=>"Fields must not be empty!");
            return response()->json($error_message);
        }

        $check_emp_id = DB::select("SELECT * FROM employees WHERE ID= :emp_id",["emp_id"=>$emp_id]);

        if($check_emp_id)
        {
            $check_api = DB::select("SELECT * FROM api_token WHERE Api= :api_token",["api_token"=>$api_token]);

            if($check_api)
            {
                //$query_update = DB::update("UPDATE employees SET `Name`=:fname, Position=:position, Salary=:salary, Job_Type=:job_type,`Status`=:phone,Duration=:duration WHERE ID= :emp_id",["fname"=>$name,"position"=>$position,"salary"=>$salary,"job_type"=>$job_type,"status"=>$status,"duration"=>$duration,"emp_id"=>$emp_id]);
                $query_update = DB::update("UPDATE employees SET `Name`=:fname,Position=:position, Salary=:salary, Job_Type=:job_type,`Status`=:status,Duration=:duration WHERE ID= :emp_id",["fname"=>$name,"position"=>$position,"salary"=>$salary,"job_type"=>$job_type,"status"=>$status,"duration"=>$duration, "emp_id"=>$emp_id]);

                if($query_update)
                {
                    $success_message = array("message"=>"Employee updated successfully!");
                    return response()->json($success_message);
                }
                else
                {
                    $error_message = array("message"=>"Unable to update employee!");
                    return response()->json($error_message);
                }
            }
            else
            {
                $error_message = array("message"=>"Unable to make a request");
                return response()->json($error_message);
            }
        }
        else
        {
            $error_message = array("message"=>"Employee id does not exist!");
            return response()->json($error_message);
        }
        

    }

    public function deleteEmployee(Request $request)
    {
        $emp_id = $request->id;
        $api_token = $request->token;

        $check_emp_id = DB::select("SELECT * FROM employees WHERE ID= :emp_id",["emp_id"=>$emp_id]);

        if($check_emp_id)
        {
            $check_api = DB::select("SELECT * FROM api_token WHERE Api= :api_token",["api_token"=>$api_token]);

            if($check_api)
            {
                $query_delete = DB::update("DELETE FROM employees WHERE ID= :emp_id",["emp_id"=>$emp_id]);

                if($query_delete)
                {
                    $success_message = array("message"=>"Employee deleted successfully!");
                    return response()->json($success_message);
                }
                else
                {
                    $error_message = array("message"=>"Unable to delete employee!");
                    return response()->json($error_message);
                }
            }
            else
            {
                $error_message = array("message"=>"Unable to make a request");
                return response()->json($error_message);
            }
        }
        else
        {
            $error_message = array("message"=>"Employee id does not exist!");
            return response()->json($error_message);
        }

    }
}
