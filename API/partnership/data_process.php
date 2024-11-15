<?php
require '../vendor/autoload.php';
session_start();
$viewDataClass = new Partnership\viewData();
$pdh = new ChurchApi\viewData;

function DataCleansing($opt, $data)
{
    if ($opt == 'str') {
        if (dataInstance_string($data) == False) {
            echo json_encode("Data cannot contain illegal characters");
            exit();
        }
    }
    if ($opt == 'num') {
        if (dataInstance_num($data) == False) {
            echo json_encode("Number cannot contain illegal characters");
            exit();
        }
    }
    if ($opt == 'arr') {
        if (dataInstance_array($data) == False) {
            echo json_encode("An error occurred please try again");
            exit();
        }
    }
    if ($opt == 'obj') {
        if (dataInstance_object($data) == False) {
            echo json_encode("An error occurred please try again");
            exit();
        }
    }
    if ($opt == 'date') {
        if (dataInstance_date($data) == False) {
            echo json_encode("illegal date formate detected");
            exit();
        }
    }

    if ($opt == 'bool') {
        if (dataInstance_bool($data) == 'False') {
            echo json_encode("An error occurred please try again");
            exit();
        }
    }
    return $data;
}
function dataInstance_num($data)
{
    return Intval($data) && is_numeric($data) ? $data : False;
}
function dataInstance_string($data)
{
    return is_string($data) && !preg_match('/[!@$%^&*()_+=*~;:><?]/', $data) ? $data : False;
}
function dataInstance_bool($data)
{
    return is_bool($data) ? $data : 'False';
}
function dataInstance_array($data)
{
    return is_array($data) ? $data : False;
}
function dataInstance_object($data)
{
    return is_object($data) ? $data : False;
}
function dataInstance_date($data)
{
    return ((DateTime::createFromFormat('Y-m-d', $data) !== False)) ? $data : False;
}

if (isset($_GET['submit'])) {
    if ($_GET['submit'] != 'upload_ind' && $_GET['submit'] != 'fetchlatest' && $_GET['submit'] != 'delete_file' && $_GET['submit'] != 'delete_ini' && $_GET['submit'] != 'filter' && $_GET['submit'] != 'export') {
        $name = DataCleansing('str', $_POST['name']);
        $partnership = $_POST['amount'];
        $email = $_POST['email'];
        $status = DataCleansing('str', $_POST['status']);
        $date = DataCleansing('date', $_POST['date']);
        $type = DataCleansing('str', $_POST['type']);
        $period = DataCleansing('str', $_POST['period']);
    }
    if ($_GET['submit'] == 'fetchlatest' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'true') {
        try {
            $data = json_decode(file_get_contents("php://input"), true);
            $num = $data['key'];
            $result_data = $viewDataClass->partnership_liveUpdate($num);
            echo json_encode($result_data);
        } catch (Exception $e) {
            $error_message = "Exception: " . $e->getMessage();
            echo json_encode(["status" => "error", "message" => $error_message]);
        }
    } else if ($_GET['submit'] == 'upload_ind' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'true') {
        try {
            $name = DataCleansing('num', $_POST['delete_key']);
            $amount = DataCleansing('num', $_POST['amount']);
            $date = date('Y-m-d');
            $result_data = $viewDataClass->partnership_view_individual_record_upload($name, 'house', $date, $amount);
            echo json_encode($result_data);
        } catch (Exception $e) {
            $error_message = "Exception: " . $e->getMessage();
            echo json_encode(["status" => "error", "message" => $error_message]);
        }
    } else
        if ($_GET['submit'] == 'upload' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'true') {
            try {
                if (isset($_GET['user']) && $_GET['user'] == 'true' && !isset($_GET['Admin'])) {
                    $result_data = $viewDataClass->ministries_upload_user($name, $partnership, $date, $status, $email, $type, $period);
                    $sitename = 'partnership form';
                    $title = 'data upload';
                    $resultFetch = $pdh->notification_set($sitename, $title);
                    if ($result_data == 'success') {
                        echo json_encode($result_data);
                    }
                } else {
                    $result_data = $viewDataClass->ministries_upload($name, $partnership, $date, $status, $email, $type, $period);
                    echo json_encode($result_data);
                }
            } catch (Exception $e) {
                $error_message = "Exception: " . $e->getMessage();
                echo json_encode(["status" => "error", "message" => $error_message]);
            }
        } else if ($_GET['submit'] == 'update_file' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'true') {
            try {
                $unique_id = DataCleansing('num', $_POST['delete_key']);
                $result_data = $viewDataClass->ministries_update($name, $partnership, $date, $status, $email, $type, $period, $unique_id);
                echo json_encode($result_data);
            } catch (Exception $e) {
                $error_message = "Exception: " . $e->getMessage();
                echo json_encode(["status" => "error", "message" => $error_message]);
            }
        } else if ($_GET['submit'] == 'delete_file' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'true') {
            try {
                $data = json_decode(file_get_contents("php://input"), true);
                $unique_id = DataCleansing('num', $data['key']);
                $resultFetch = $viewDataClass->ministries_delete($unique_id);
                echo json_encode($resultFetch);
            } catch (Exception $e) {
                $error_message = "Exception: " . $e->getMessage();
                echo json_encode(["status" => "error", "message" => $error_message]);
            }
        } else if ($_GET['submit'] == 'filter' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'true') {
            try {
                $data = json_decode(file_get_contents("php://input"), true);
                $search = DataCleansing('num', $data['key']);
                $nk = DataCleansing('num', $data['numData']);


                $resultFetch = $viewDataClass->ministries_filterSearch($search, $nk);
                echo json_encode(trim($resultFetch));
            } catch (Exception $e) {
                $error_message = "Exception: " . $e->getMessage();
                echo json_encode(["status" => "error", "message" => $error_message]);
            }
        } else if ($_GET['submit'] == 'export' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'true') {
            try {

                $resultFetch = $viewDataClass->partnership_export();
                echo json_encode(trim($resultFetch));
            } catch (Exception $e) {
                $error_message = "Exception: " . $e->getMessage();
                echo json_encode(["status" => "error", "message" => $error_message]);
            }
        } else if ($_GET['submit'] == 'delete_ini' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'true') {
            try {
                $data = json_decode(file_get_contents("php://input"), true);
                $unique_id = DataCleansing('num', $data['key']);


                $resultFetch = $viewDataClass->ministries_delete_inidividual($unique_id);
                echo json_encode($resultFetch);
            } catch (Exception $e) {
                $error_message = "Exception: " . $e->getMessage();
                echo json_encode(["status" => "error", "message" => $error_message]);
            }
        }


}