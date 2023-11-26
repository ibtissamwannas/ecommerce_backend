<?php

define('MB', 1048576);

function filterRequest($requestname)
{
    return htmlspecialchars(strip_tags($_POST[$requestname]));
}

function getAllData($table, $where = null, $values = null, $json = true)
{
    global $con;
    $data = [];
    if ($where == null) {
        $stmt = $con->prepare("SELECT  * FROM $table");
    } else {
        $stmt = $con->prepare("SELECT  * FROM $table WHERE $where ");
    }
    $stmt->execute($values);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $count = $stmt->rowCount();
    if ($json == true) {
        if ($count > 0) {
            echo json_encode(['status' => 'success', 'data' => $data]);
        } else {
            echo json_encode(['status' => 'failure']);
        }

        return $count;
    } else {
        if ($count > 0) {
            return $data;
        } else {
            return json_encode(['status' => 'failure']);
        }
    }
}

function getData($table, $where = null, $values = null, $json = true)
{
    global $con;
    $data = [];
    $stmt = $con->prepare("SELECT  * FROM $table WHERE $where ");
    $stmt->execute($values);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    $count = $stmt->rowCount();
    if ($json == true) {
        if ($count > 0) {
            echo json_encode(['status' => 'success', 'data' => $data]);
        } else {
            echo json_encode(['status' => 'failure']);
        }
    } else {
        return $count;
    }
}

function insertData($table, $data, $json = true)
{
    global $con;
    foreach ($data as $field => $v) {
        $ins[] = ':'.$field;
    }
    $ins = implode(',', $ins);
    $fields = implode(',', array_keys($data));
    $sql = "INSERT INTO $table ($fields) VALUES ($ins)";

    $stmt = $con->prepare($sql);
    foreach ($data as $f => $v) {
        $stmt->bindValue(':'.$f, $v);
    }
    $stmt->execute();
    $count = $stmt->rowCount();
    if ($json == true) {
        if ($count > 0) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'failure']);
        }
    }

    return $count;
}

function updateData($table, $data, $where, $json = true)
{
    global $con;
    $cols = [];
    $vals = [];

    foreach ($data as $key => $val) {
        $vals[] = "$val";
        $cols[] = "`$key` =  ? ";
    }
    $sql = "UPDATE $table SET ".implode(', ', $cols)." WHERE $where";

    $stmt = $con->prepare($sql);
    $stmt->execute($vals);
    $count = $stmt->rowCount();

    if ($json == true) {
        if ($count > 0) {
            echo json_encode(['status' => 'success']);
        } else {
            print_r($count);
            echo json_encode(['status' => 'failure']);
        }
    }

    return $count;
}

function deleteData($table, $where, $json = true)
{
    global $con;
    $stmt = $con->prepare("DELETE FROM $table WHERE $where");
    $stmt->execute();
    $count = $stmt->rowCount();
    if ($json == true) {
        if ($count > 0) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'failure']);
        }
    }

    return $count;
}

function imageUpload($imageRequest)
{
    global $msgError;
    $imagename = rand(1000, 10000).$_FILES[$imageRequest]['name'];
    $imagetmp = $_FILES[$imageRequest]['tmp_name'];
    $imagesize = $_FILES[$imageRequest]['size'];
    $allowExt = ['jpg', 'png', 'gif', 'mp3', 'pdf'];
    $strToArray = explode('.', $imagename);
    $ext = end($strToArray);
    $ext = strtolower($ext);

    if (!empty($imagename) && !in_array($ext, $allowExt)) {
        $msgError = 'EXT';
    }
    if ($imagesize > 2 * MB) {
        $msgError = 'size';
    }
    if (empty($msgError)) {
        move_uploaded_file($imagetmp, '../upload/'.$imagename);

        return $imagename;
    } else {
        return 'fail';
    }
}

function deleteFile($dir, $imagename)
{
    if (file_exists($dir.'/'.$imagename)) {
        unlink($dir.'/'.$imagename);
    }
}

function checkAuthenticate()
{
    if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) {
        if ($_SERVER['PHP_AUTH_USER'] != 'wael' || $_SERVER['PHP_AUTH_PW'] != 'wael12345') {
            header('WWW-Authenticate: Basic realm="My Realm"');
            header('HTTP/1.0 401 Unauthorized');
            echo 'Page Not Found';
            exit;
        }
    } else {
        exit;
    }
}

function printFailure($message = 'none')
{
    echo json_encode(['status' => 'failure', 'message' => $message]);
}

function printSuccess($message = 'none')
{
    echo json_encode(['status' => 'success', 'message' => $message]);
}

function result($count, $messageSuccess, $messageFailure)
{
    if ($count > 0) {
        printSuccess($messageSuccess);
    } else {
        printFailure($messageFailure);
    }
}
function sendEmail($to, $title, $body)
{
    $header = 'from: support@ibtissamwannas.com'."\n".'cc: ibtissam123@gmail.com';

    mail($to, $title, $body, $header);
}

function sendGCM($title, $message, $topic, $pageid, $pagename)
{
    $url = 'https://fcm.googleapis.com/fcm/send';

    $fields = [
        'to' => '/topics/'.$topic,
        'priority' => 'high',
        'content_available' => true,

        'notification' => [
            'body' => $message,
            'title' => $title,
            'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
            'sound' => 'default',
        ],
        'data' => [
            'pageid' => $pageid,
            'pagename' => $pagename,
        ],
    ];

    $fields = json_encode($fields);
    $headers = [
        'Authorization: key=AAAA7nvBiuQ:APA91bHt3v_7PqruabjyQtpREvtdu8fGkBHRjmWESzx___iyCPUwLYmJ_yEiOH3l5m6mb99-OrabNaUMWm7Aa2oBPJilCVuk3sHHFLJ41udZIxBjDwrxTSFYv0FaEoPHIacJDRqWHz2v',
        'Content-Type: application/json',
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

    $result = curl_exec($ch);

    return $result;
    curl_close($ch);
}

function insertNotify($userId, $title, $body, $topic, $pageid, $pageName)
{
    global $con;
    $stmt = $con->prepare('INSERT INTO `notification`(`title`, `body`, `user_id`) VALUES (?,?,?)');
    $stmt->execute([$title, $body, $userId]);

    sendGCM($title, $body, $topic, $pageid, $pageName);
    $count = $stmt->rowCount();

    return $count;
}
