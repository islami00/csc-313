<?php

// ini_set('session.save_handler', 'memcached');
// ini_set('session.save_path', getenv('MEMCACHIER_SERVERS'));
// if(version_compare(phpversion('memcached'), '3', '>=')) {
//     ini_set('memcached.sess_persistent', 1);
//     ini_set('memcached.sess_binary_protocol', 1);
// } else {
//     ini_set('session.save_path', 'PERSISTENT=myapp_session ' . ini_get('session.save_path'));
//     ini_set('memcached.sess_binary', 1);
// }
// ini_set('memcached.sess_sasl_username', getenv('MEMCACHIER_USERNAME'));
// ini_set('memcached.sess_sasl_password', getenv('MEMCACHIER_PASSWORD'));
    session_start();
    
    function isLoggedIn() {
        if (isset($_SESSION['user_id'])) {
            return true;
        } else {
            return false;
        }
    }

    function profilePicture() {
        if (isset($_SESSION['dp']) && !is_null($_SESSION['dp'])) {
                return $_SESSION['dp'];
        }

        else {
            if ($_SESSION['gender'] == 'M') {
                return URLROOT . '/dist/img/avatar.png';
            }

            if ($_SESSION['gender'] == 'F') {
                return URLROOT .'/dist/img/avatar2.png';
            }

            return URLROOT . '/dist/img/boxed-bg.jpg';
        }

    }

    function isRegistered($student) {
        $db = new Database;
        $db->query('SELECT * FROM students WHERE id=:id AND registered_courses=1');
      
        $db->bind(':id', $student);
      
        $result = $db->single();
      
        if ($result) {
          return true;
        }
        else {
          return false;
        }
    }

?>