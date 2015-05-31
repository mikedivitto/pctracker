<?php
include("config.php");
if($showErrors) {error_reporting(E_ALL); ini_set('display_errors', 1);}

//   Handle the incoming request
switch ($_REQUEST['action'])
{
    case "create":
        createRes();
        leave();
        break;
    case "modify":
        modifyRes();
        leave();
        break;
    case "get":
        if ($_REQUEST['format'] == "json") {echo getResJSON();}
        else {getRes();}
        break;
    case "getAll":
        if ($_REQUEST['format'] == "json") {echo getAllJSON();}
        else {getAll();}
        break;
    case "delete":
        deleteRes();
        leave();
        break;
    case "status":
        setStatus();
        leave();
        break;
    case "listtoday":
        showToday();
        break;
    default:
        echo "An error occurred";
        leave();
}

//   Redirects a user trying to access this file back to the main site
function leave() //Get out, right now...
{
    header("Location: ./");
}

//   Gets the current DateTime
function getCurrentDateTime()
{
    return date('Y-m-d H:i:s');   
}

//   Get's today's date
function getCurrentDate()
{
    return date('Y-m-d');
}

//   Gets a DateTime for Yesterday
function getYesterdayDateTime()
{
    return date("Y-M-j 23:59:59", strtotime("-1 day"));   
}

function getYesterdayDate()
{
    return date("Y-m-d", strtotime("-1 day"));
}

//   Converts a MySQLi result to an associative array
function toArray($obj)
{
    $res = array();
    while ($row = mysqli_fetch_assoc($obj)) {
        array_push($res, $row);	
    }
    return $res;
}

//   Performs the query on the database
function queryDB($query, $bool)
{
    $conn = getConn();
    if ($res = $conn->query($query)){/*echo "Completed Successfully";*/ $conn->close(); if($bool){return toArray($res);} else {return $res;}}
    else{echo "Failed"; $conn->close(); return false;}
}

//   Creates a new request
function createRes()
{
    //echo $_REQUEST['action'];
    $name = escape($_REQUEST['name']);
    $stid = escape($_REQUEST['stid']);
    $emal = escape($_REQUEST['emal']);
    $phon = escape($_REQUEST['phon']);
    $room = escape($_REQUEST['room']);
    $date = escape($_REQUEST['date']);
    $starttm = date('H:i:s', strtotime(escape($_REQUEST['starttm'])));
    $endtm = date('H:i:s', strtotime(escape($_REQUEST['endtm'])));
    checkRestriction($starttm, $endtm);
	//print_r(get_defined_vars());
    echo $query =   "INSERT INTO `" . TB_RSRV . "` (`NAME`, `STID`, `EMAL`, `PHON`, `ROOM`, `DATE`, `STARTTM`, `ENDTM`, `CREATED_ON`, `MODIFIED_ON`, `STATUS`) 
                    VALUES ('$name', '$stid', '$emal', '$phon', '$room', '$date', '$starttm', '$endtm', '" . getCurrentDateTime() . "', '" . getCurrentDateTime() . "', '" . DEFAULT_STATUS . "')";
    return queryDB($query, false);
}

//   Modifies a request in the table
function modifyRes()
{
    //echo $_REQUEST['action'];
    $name = escape($_REQUEST['name']);
    $stid = escape($_REQUEST['stid']);
    $emal = escape($_REQUEST['emal']);
    $phon = escape($_REQUEST['phon']);
    $room = escape($_REQUEST['room']);
    $date = escape($_REQUEST['date']);
    $starttm = date('H:i:s', strtotime(escape($_REQUEST['starttm'])));
    $endtm = date('H:i:s', strtotime(escape($_REQUEST['endtm'])));
    $id = escape($_REQUEST['id']);
    echo $query =   "UPDATE " . TB_RSRV . " SET NAME='$name', STID='$stid', EMAL='$emal', PHON='$phon', 
                    ROOM='$room', DATE='$date', STARTTM='$starttm', ENDTM='$endtm', MODIFIED_ON='" . getCurrentDateTime() . "' WHERE id='$id'"; 
    return queryDB($query, false);
}

//   Gets a request from the table
function getRes()
{
    //echo $_REQUEST['action'];
    $id = escape($_REQUEST['id']);
    $query = "SELECT * FROM " . TB_RSRV . " WHERE id='$id' LIMIT 1";
    return queryDB($query, true);
}

//   Gets a request and sends it back in JSON format
function getResJSON()
{
    return json_encode(getRes());   
}

//   Deletes a request from the table
function deleteRes()
{
    //echo $_REQUEST['action'];
    $id = escape($_REQUEST['id']);
    echo $query =   "DELETE FROM " . TB_RSRV . " WHERE id='$id'"; 
    return queryDB($query, false);
}

//   Returns everything in the table
function getAll()
{
    /*echo*/ $query =   "SELECT * FROM " . TB_RSRV; 
    return queryDB($query, true);
}

//   Returns everything in the table as a JSON Object
function getAllJSON()
{
    return json_encode(getAll());   
}

//   Modifiers for the Status of the Reservation
//   Setting the status as: PENDING, APPROVED, ARCHIVED, and DENIED

//   Handler to choose the correct function
function setStatus()
{
    switch ($_REQUEST['status'])
    {
        case "pending":
            setPending($_REQUEST['id']);
            break;
        case "approved":
            setApproved($_REQUEST['id']);
            break;
        case "archived":
            setArchived($_REQUEST['id']);
            break;
        case "denied":
            setDenied($_REQUEST['id']);
            break;
        default:
            echo "An error has occurred.";
            break;
    }
}

//   Gets all pending requests
function getPending()
{
    echo $query =   "SELECT * FROM " . TB_RSRV . " WHERE STATUS='PENDING'"; 
    return queryDB($query, true);
}

//   Sets a request to PENDING
function setPending($id)
{
    $id = escape($id);
    echo $query =   "UPDATE " . TB_RSRV . " SET STATUS='PENDING' WHERE id='$id'";
    return queryDB($query, false);
}


//   Gets all the approved requests
function getApproved()
{
    echo $query =   "SELECT * FROM " . TB_RSRV . " WHERE STATUS='APPROVED'"; 
    return queryDB($query, true);
}

//   Sets a request to APPROVED
function setApproved($id)
{
    $id = escape($id);
    echo $query =   "UPDATE " . TB_RSRV . " SET STATUS='APPROVED' WHERE id='$id'";
    return queryDB($query, false);
}

//   Gets all the archived requests
function getArchived()
{
    echo $query =   "SELECT * FROM " . TB_RSRV . " WHERE STATUS='ARCHIVED'"; 
    return queryDB($query, true);
}

//   Sets a request to ARCHIVED
function setArchived()
{
    echo $query =   "UPDATE " . TB_RSRV . " SET STATUS='ARCHIVED' WHERE DATE < " . getYesterdayDate();
    return queryDB($query, false);
}

//   Gets all the denied requests
function getDenied()
{
    echo $query =   "SELECT * FROM " . TB_RSRV . " WHERE STATUS='DENIED'";
    return queryDB($query, true);
}

//   Sets a request to DENIED
function setDenied($id)
{
    $id = escape($id);
    echo $query =   "UPDATE " . TB_RSRV . " SET STATUS='DENIED' WHERE id='$id'";
    return queryDB($query, false);
}

function getByRoomDay($room, $day)
{
    $room = escape($room);
    /*echo*/ $query =   "SELECT * FROM " . TB_RSRV . " WHERE ROOM='$room' AND DATE='$day' AND STATUS='APPROVED' ORDER BY STARTTM";
    return queryDB($query, true);
}

function showToday()
{
    if (!isset($_REQUEST['date'])) {$date = getCurrentDate();} else {$date = $_REQUEST['date'];} 
    $tdata = "";
    for ($i = 1; $i < 11; $i++)
    {
        $tdata .= "ROOM $i:\t";
        $info = getByRoomDay($i, $date);
        foreach ($info as $row)
        {
            $tdata .= "&nbsp;" . date("g:i A", strtotime($row['STARTTM'])) . "&nbsp;-&nbsp;" . date("g:i A", strtotime($row['ENDTM'])) . "&nbsp;In Use, ";
        }
        $tdata .= "<br>";
    }
    echo $tdata;
}

function checkRestriction($start, $end)
{
    if (($end - $start) > "03:00:00")
    {
       sendError("Time slot too large");
    }
    else {return;}
}

function sendError($message)
{
    $SESSION['message'] = $message;
    header("Location: .");
}