<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Class Authentication_model
 * Check Duplication
 * Register
 * Login
 * Update
 * Forgot Password
 */
class Authentication_model extends CI_Model
{
    /**
     * @param array $data
     * @param string $action
     * @param int $regId
     * @return boolean
     *
     * User : User
     */
    public function userRegistrationAction($data = array(), $action = '', $regId = 0)
    {
        switch ($action) {
            case 'insert':
                $this->db->insert('users', $data);
                $insert_id = $this->db->insert_id();
                return $insert_id;
                break;

            case 'update':
                $this->db->where('id', $regId);
                $this->db->update('users', $data);
                return $regId;
                break;

            case 'delete':
                $this->db->where('id', $regId);
                $this->db->delete('users');
                return $regId;
                break;
        }
    }

    /**
     * @param string $email
     * @param string $regType
     * @param int $phone
     * @param int $regId
     * @param int $password
     * @param int $checkRegId
     * @param bool $checkIsVerified
     * @return bool
     *
     * Check user is exist with email or phone
     */
    public function checkUserExist($email = '', $phone = 0, $regType = '', $password = '', $checkIsVerified = 0, $apiToken = '', $imei_no = "")
    {
        $this->db->select('r.*');
        $this->db->from('tbl_users r');

        $whereCondition = '';
        if (strlen($email) && $phone && strlen($imei_no)) {
            $whereCondition = "(email = '$email' OR mobile_no = '$phone' OR imei_no = '$imei_no')";
        } elseif (strlen($email)) {
            $whereCondition = "email = '$email'";
        } elseif ($phone) {
            $whereCondition = "mobile_no = '$phone'";
        } elseif (strlen($imei_no)) {
            $whereCondition = "imei_no = '$imei_no'";
        }

        if (strlen($whereCondition)) {
            $this->db->where($whereCondition);
        }

        if (strlen($regType)) {
            $this->db->where('role', $regType);
        }

        if (strlen($password)) {
            $this->db->where('password', $password);
        }

        if ($checkIsVerified) {
            $this->db->where('r.is_otp_verified', 1);
        }

        if (strlen($apiToken)) {
            $this->db->where('api_token', $apiToken);
        }
        // if (strlen($imei_no)) {
        //     $this->db->where('imei_no', $imei_no);
        // }

        $this->db->where('r.is_deleted', 0);

        $result = $this->db->get();
        if ($result) {
            return $result->row_array();            //Exist
        } else {
            return array();           //Not Exist
        }
    }

    /**
     * @param int $otp
     * @param int $mobileNumber
     * @param string $email
     * @return array
     *
     * Match OTP either with mobile or email
     */
    public function matchOTP($otp = 0, $mobileNumber = 0, $email = '')
    {
        if ($mobileNumber || strlen($email)) {
            $this->db->select('*');
            $this->db->from('tbl_users r');

            $this->db->where('otp', $otp);
            // $this->db->where('is_block', IS_DELETE_NO);

            if ($mobileNumber) {
                $this->db->where('mobile_no', $mobileNumber);
            }

            if (strlen($email)) {
                $this->db->where('email', $email);
            }
            $result = $this->db->get();
            if ($result) {
                return $result->row_array();                //Matched
            } else {
                return array();               //Not Matched
            }
        } else {
            return array();
        }
    }

    //update api token on otp verification or login
    public function updateToken($data = array(), $regId = 0)
    {
        $this->db->where('id', $regId);
        $this->db->update('tbl_users', $data);
        return $regId;
    }

    public function checkWebUserExist($userId = '', $email = 0, $role = '', $isFranchiseUser = 0, $franchiseId = '')
    {

        $this->db->select('r.*');
        $this->db->from('tbl_users r');

        $whereCondition = '';
        if ($isFranchiseUser == 1) {
            $this->db->where('franchise_id', $franchiseId);
            $this->db->where('role', 4);
        } else {
            $this->db->where('web_franchise_user_id', $userId);
        }
        $this->db->where('r.is_deleted', 0);
        $this->db->where('r.status', 1);

        $result = $this->db->get();
        if ($result) {
            return $result->row_array();            //Exist
        } else {
            return array();           //Not Exist
        }
    }
}
