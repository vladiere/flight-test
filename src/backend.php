<?php 

    require './database.php';

    class backend
    {
        /**
         * 
         * kani diring dapita diri ang mga pultahan ang mga function na tawagon sa router para mag send ug mag recieve
         * sa mga gipang return ani nila
         * 
         * 
         */
        public function register($username, $email, $number, $password)
        {
            return self::registerRequest($username, $email, $number, $password);
        }

        public function login($username, $password)
        {
            return self::loginRequest($username, $password);
        }

        public function flight($plane_type, $speed, $distanation, $tank_size)
        {
            return self::addFlight($plane_type, $speed, $distanation, $tank_size);
        }

        public function displayFlight()
        {
            return self::display();
        }

        public function delete($xid)
        {
            return self::deleteTest($xid);
        }

        public function upgrade($id, $speed, $destination, $gas_tank)
        {
            return self::upgradeParts($id, $speed, $destination, $gas_tank);
        }

        private function deleteTest($xid)
        {
            try {
                /**
                 * 
                 * same ra ang tanang function na naka private na pdo statement ni sila 
                 * initialize ang database tawagon ang mga function sa database dayon tawagon ang mga queries na naa sa ubus
                 * 
                 */
                if ($xid != '') {
                    $db = new database("localhost","root","","sample");
                    if ($db->getStatus()) {
                        $stmt = $db->getConnection()->prepare($this->deleteFlight());
                        $stmt->execute(array($xid));
                        $db->closeConnection();
                        return "200";
                    } else {
                        return "403";
                    }
                } else {
                    return "403";
                }
            } catch (PDOException $e) {
                return $e;
            }
        }

        private function upgradeParts($id, $speed, $destination, $gas_tank)
        {
            try {
                if ($this->checkValidity($id, $speed, $destination, $gas_tank)) {
                    $db = new database("localhost","root","","sample");
                    if ($db->getStatus()) {
                        $stmt = $db->getConnection()->prepare($this->upgradeQuery());
                        $stmt->execute(array($speed, $destination, $gas_tank, $id, $this->getId()));
                        $res = $stmt->fetch();
                        if (!$res) {
                            $db->closeConnection();
                            return "200";
                        } else {
                            return "404";
                        }
                    } else {
                        return "403";
                    }
                } else {
                    return "403";
                }
            } catch (PDOException $e) {
                return $e;
            }
        }

        private function display()//e display ang mga naa sa database na data
        {
            try {
                if ($this->checkLogin($_SESSION['username'], $_SESSION['password'])) {
                    $db = new database("localhost","root","","sample");
                    if ($db->getStatus()) {
                        $stmt = $db->getConnection()->prepare($this->getFlight());
                        $stmt->execute(array($this->getId()));
                        $result = $stmt->fetchAll();
                        $db->closeConnection();
                        return json_encode($result);
                    }else{
                        return "403";
                    }
                }else{
                    return "403";
                }
            } catch (PDOException $e) {
                return "501";
            }
        }

        private function loginRequest($username, $password)
        {
            try {
                if ($this->checkLogin($username, $password)) {
                    $db = new database("localhost", "root", "", "sample");
                    if ($db->getStatus()) {
                        $pass = md5($password);
                        $stmt = $db->getConnection()->prepare($this->loginQuery());
                        $stmt->execute(array($username, $pass));
                        $res = $stmt->fetch();
                        if ($res) {
                            $_SESSION['username'] = $username;//session storage ni para sa browser
                            $_SESSION['password'] = $pass;
                            $db->closeConnection();
                            return "200";
                        } else {
                            return "404";
                        }
                    } else {
                        return "403";
                    }
                } else {
                    return "403";
                }
            } catch (PDOException $e) {
                return "501";
            }
        }

        private function registerRequest($username, $email, $number, $password)//same ra ug flow sa akong gi explain sa ubus
        {
            try {
                if ($this->checkValidity($username, $email, $number, $password)) {
                    $db = new database('localhost', 'root', '', 'sample');
                    if ($db->getStatus()) {
                        $stmt = $db->getConnection()->prepare($this->registerQuery());
                        $stmt->execute(array($username, $email, $number, md5($password), $this->getDate()));
                        $res = $stmt->fetch();
                        if (!$res) {
                            $db->closeConnection();
                            return "200";
                        } else {
                            return "404";
                        }
                    } else {
                        return "403";
                    }
                } else {
                    return "403";
                }
            } catch (PDOException $e) {
                return $e->getMessage();
            }
        }

        private function addFlight($plane_type,$speed, $destination, $tank_size){
            try {
                try {
                    $tmp_u = $_SESSION['username'];
                    $tmp_p = $_SESSION['password'];
                    if ($this->checkLogin($tmp_u, $tmp_p)) {
                        $db = new database("localhost","root","","sample");
                        if ($db->getStatus()) {
                            $stmt = $db->getConnection()->prepare($this->addFlightQuery());#mao ni ang query na akong gi ingon sa ubos
                            $stmt->execute(array($this->getId(),$plane_type, $speed, $destination, $tank_size, $this->getDate()));#mao ni ang parameter na mo sulod sa katong mga question mark sa queries sa ubus
                            $result = $stmt->fetch();
                            if (!$result) {
                                $db->closeConnection();
                                return "200";
                            }else{
                                $db->closeConnection();
                                return "404";
                            }
                        }else{
                            return "403";
                        }
                    } else {
                        return "403";
                    }
                } catch (PDOException $th) {
                    return "501";
                }
            } catch (PDOException $th) {
                return "501";
            }
        }

        private function getId(){#kuhaon ang id sa naka login na account
            try {
                $db = new database("localhost","root","","sample");
                if ($db->getStatus()) {
                    $stmt = $db->getConnection()->prepare($this->loginQuery());
                    $stmt->execute(array($_SESSION['username'],$_SESSION['password']));
                    $tmp = null;
                    while ($row = $stmt->fetch()) {
                        $tmp = $row['id'];
                    }
                    $db->closeConnection();
                    return $tmp;
                }
            } catch (PDOException $th) {
                echo $th;
            }        
        }

        private function checkValidity($username, $email, $number, $password)#same ra sa pag check sa login
        {
            if ($username != '' && $email != '' && $number != '' && $password != '') {
                return true;
            }
            else{
                return false;
            }
        }

        private function checkLogin($username, $password)#checker ni sa login ug empty ba ang gi pasa sa ajax padung sa router padong diri
        {
            if ($username != '' && $password != '') {
                return true;
            } else {
                return false;
            }
        }

        private function getDate()
        {
            return date('Y/m/d');#pagbuhat ni ug date karon
        }

        /**
         * 
         * mao ni ang mga queries sql queries diring dapita ang mag silbing pag duwa sa database
         * ang pag insert o create, ang pag select o retrieve, ang pag update o edit, ang pag delete o remove sa data gikan sa database
         * kaning queries diri mao niy tawagon nimo sa katong nasa baba na functions
         */
        private function upgradeQuery()
        {
            return "UPDATE `test` SET `speed` = ?, `destination` = ?, `gas_tank` = ? WHERE `id` = ? AND `user_id` = ?";
        }

        private function deleteFlight()
        {
            return "DELETE FROM `test` WHERE `id` = ?";
        }

        private function addFlightQuery()
        {
            return "INSERT INTO `test` (`user_id`, `plane_type`, `speed`, `destination`, `gas_tank`, `date`) VALUES (?, ?, ?, ?, ? ,?)";
        }

        private function loginQuery()
        {
            return "SELECT * FROM `account` WHERE `username` = ? AND `password` = ?";
        }

        private function getFlight()
        {
            return "SELECT * FROM `test` WHERE user_id = ?";
        }

        private function registerQuery()
        {
            return "INSERT INTO `account` (`username`, `email`, `number`, `password`, `date_created`) VALUES (?,?,?,?,?)";
        }
    }

?>