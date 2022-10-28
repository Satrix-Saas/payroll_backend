<?php
namespace Tenant\Satrix\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Tenant\Registration\Model\TokenFactory as token;

class Data extends AbstractHelper
{
    public function __construct(token $TokenFactory)
    {
        $this->TokenFactory = $TokenFactory;
    }
    public function requiredFields($requiredFieldName, $validate_enabled, $name)
    {
        $response = [];


        $validation_field_array = self::validationFieldsArray($name);

        if ($validate_enabled) {
            foreach ($requiredFieldName as $required_field => $value) {
                if (!isset($validation_field_array[$required_field])) {
					if(!isset($response["status"])){
						$response["status"] = "error";
					}
                    $response[$required_field] = "Unknown column " . $required_field;
                } else {
                    $response[$required_field] = $value;
                }
            }
			if(!isset($response["status"])){
			   $response["status"] = "success";
			}
            return $response;
        }
    }

    public function validationFieldsArray($field_array_name)
    {
        if ($field_array_name == "register") {
            $validation[$field_array_name] = [
                "username" => "",
                "org_name" => "",
                "email" => "",
                "contact" => "",
				"password" => "",
                "org_size" => "",
                "emp_type" => "",
            ];
        }
        if ($field_array_name == "login") {
            $validation[$field_array_name] = ["email" => "", "password" => ""];
        }
        if ($field_array_name == "company") {
            $validation[$field_array_name] = [
                "cmp_name" => "",
                "cmp_name" => "",
                "cmp_brand_name" => "",
                "cmp_address" => "",
                "state" => "",
                "pincode" => "",
            ];
        }
        if ($field_array_name == "department") {
            $validation[$field_array_name] = [
                "dept_name" => "",
            ];
        }
        if ($field_array_name == "employee") {
            $validation[$field_array_name] = [
                "emp_type" => "",
                "emp_name" => "",
                "emp_email" => "",
                "emp_addr" => "",
                "emp_hire_date" => "",
                "emp_post" => "",
                "emp_dept" => "",
                "mng_name" => "",
                "emp_salary" => "",
                "emp_location" => "",
                
            ];
        }
		if ($field_array_name == "leave") {
            $validation[$field_array_name] = [
                "emp_id" => "",
                "leave_status" => "",
                "leave_from" => "",
                "leave_to" => "",
                "remark" => "",
            ];
        }
        if ($field_array_name == "attendance") {
            $validation[$field_array_name] = [
                "emp_id" => "",
                "date" => "",
                "emp_status" => "",
                "check_in" => "",
                "check_out" => "",
                "duration" => "",
                "remark" => "",
            ];
        }
        if ($field_array_name == "holiday") {
            $validation[$field_array_name] = [
                "sr_no" => "",
                "title" => "",
                "holiday_date" => "",
                "day" => "",
                "action" => "",
            ];
        }

        if (isset($validation[$field_array_name])) {
            return $validation[$field_array_name];
        } else {
            return $validation[$field_array_name] = "";
        }
    }

    public function createToken($id)
    {
        $model = $this->TokenFactory->create();
        $header = json_encode(["typ" => "JWT", "alg" => "HS256"]);
        $payload = json_encode(["user_id" => $id]);
        $base64UrlHeader = str_replace(
            ["+", "/", "="],
            ["-", "_", ""],
            base64_encode($header)
        );
        $base64UrlPayload = str_replace(
            ["+", "/", "="],
            ["-", "_", ""],
            base64_encode($payload)
        );
        $signature = hash_hmac(
            "sha256",
            $base64UrlHeader . "." . $base64UrlPayload,
            "abC123!",
            true
        );
        $base64UrlSignature = str_replace(
            ["+", "/", "="],
            ["-", "_", ""],
            base64_encode($signature)
        );
        // Create JWT
        $customerToken =
            $base64UrlHeader .
            "." .
            $base64UrlPayload .
            "." .
            $base64UrlSignature;

        $token_array = ["reg_id" => $id, "token" => $customerToken];
        $model->setData($token_array)->save();
        return 1;
    }
}
