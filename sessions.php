 <?php
    ($GLOBALS["___mysqli_ston"] = mysqli_connect(HOST, USER, PASS));
    mysqli_select_db($GLOBALS["___mysqli_ston"], constant('DB'));

    function sess_open($sess_path, $sess_name) {
        return true;
    }

    function sess_close() {
        return true;
    }

    function sess_read($sess_id) {
        $result = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT Data FROM sessions WHERE SessionID = '$sess_id';");
        if (!mysqli_num_rows($result)) {
            $CurrentTime = time();
            mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO sessions (SessionID, DateTouched) VALUES ('$sess_id', $CurrentTime);");
            return '';
        } else {
            extract(mysqli_fetch_array($result), EXTR_PREFIX_ALL, 'sess');
            mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE sessions SET DateTouched = $CurrentTime WHERE SessionID = '$sess_id';");
            return $sess_Data;
        }
    }

    function sess_write($sess_id, $data) {
        $CurrentTime = time();
        mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE sessions SET Data = '$data', DateTouched = $CurrentTime WHERE SessionID = '$sess_id';");
        return true;
    }

    function sess_destroy($sess_id) {
        mysqli_query($GLOBALS["___mysqli_ston"], "DELETE FROM sessions WHERE SessionID = '$sess_id';");
        return true;
    }

    function sess_gc($sess_maxlifetime) {
        $CurrentTime = time();
        mysqli_query($GLOBALS["___mysqli_ston"], "DELETE FROM sessions WHERE DateTouched + $sess_maxlifetime < $CurrentTime;");
        return true;
    }

    session_set_save_handler("sess_open", "sess_close", "sess_read", "sess_write", "sess_destroy", "sess_gc");
    session_start();

    $_SESSION['foo'] = "bar";
    $_SESSION['baz'] = "wombat";
?> 