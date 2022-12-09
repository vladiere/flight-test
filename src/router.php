<?php 
    session_start();

    require './backend.php';
    /**
     * 
     * 
     * diri ang ajax padong sa katong log in register ug sa dashboard ang flow ano mura rani siyag bridge
     *  taytayan sa backend padung sa js scripts
     * kanang mga $_POST[""] diha kay mura na silag mga variables na wala pay sulod
     * 
     * 
     */
    if (isset($_POST['choice'])) {
        switch ($_POST['choice']) {
            case 'login':
                $back = new backend();
                echo $back->login($_POST['username'], $_POST['password']);
                break;
            case 'register':
                $back = new backend();
                echo $back->register($_POST['username'], $_POST['email'], $_POST['number'], $_POST['password']);
                break;
            case 'addFlight':
                $back = new backend();
                echo $back->flight($_POST['plane_type'], $_POST['speed'], $_POST['distanation'], $_POST['tank_size']);
                break;
            case 'upgrade':
                $back = new backend();
                echo $back->upgrade($_POST['id'], $_POST['speed'], $_POST['destination'], $_POST['gas_tank']);
                break;
            case 'delete':
                $back = new backend();
                echo $back->delete($_POST['id']);
                break;
            case 'display':
                $back = new backend();
                echo $back->displayFlight();
                break;
            case 'logout':
                session_unset();
                session_destroy();
                echo "200";
                break;
            default:
                # code...
                break;
        }
    }

?>