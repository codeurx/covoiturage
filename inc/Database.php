<?php

class Database
{
    private $pdo;

    private $date;

    private $settings;

    public function __construct()
    {
        $this->Connect();

    }

    private function Connect()
    {
        $this->settings = parse_ini_file("settings.ini.php");
        $dsn = 'mysql:dbname=' . $this->settings["dbname"] . ';host=' . $this->settings["host"] . '';
        try {
            $this->pdo = new PDO($dsn, $this->settings["user"], $this->settings["password"]);
        } catch (PDOException $e) {
            echo $e->getMessage();
            die();
        }
    }

    public function RegisterUser($fname, $lname, $mail, $password, $birthdate, $gender, $tel)
    {
        $query = $this->pdo->prepare("SELECT * FROM users WHERE email = '$mail'");

        $query->execute();

        if ($query->rowCount() > 0) {
            return 'verif';
        } else {
            $this->date = date('Y-m-d H:m:s');
            $birthdate = date("Y-m-d", strtotime($birthdate));
            $password = md5($password);

            $query = $this->pdo->prepare("INSERT INTO users (`fname`,`lname`,`birthdate`,`gender`,`email`,`password`,`avatar`,`register_date`,`profession`,`tabac`,`tel`) values ('$fname','$lname','$birthdate','$gender','$mail','$password','def-av.png','$this->date','Non Précisé','Non Précisé','$tel')");

            $query->execute();

            return 'success';
        }
    }

    public function ConnectUser($mail, $password)
    {
        $query = $this->pdo->prepare("SELECT * FROM users WHERE email = '$mail' AND password = '$password'");

        $query->execute();

        if ($query->rowCount() > 0) {
            session_start();
            $res = $query->fetchAll();
            foreach ($res as $user) {
                $_SESSION['userid'] = $user['userid'];
            }
            $date = date('Y-m-d');
            $uid = $_SESSION['userid'];
            $q = $this->pdo->prepare("UPDATE users set date_login='$date' WHERE userid='$uid'");
            $q->execute();
            return 'success';
        } else {
            return 'verif';
        }
    }

    public function GetUserInfo($userid)
    {
        $query = $this->pdo->prepare("SELECT * FROM users WHERE userid = '$userid'");

        $query->execute();

        return $query->fetchAll();
    }

    public function GetVehicleInfo($userid)
    {
        $query = $this->pdo->prepare("SELECT * FROM vehicles WHERE userid = '$userid'");

        $query->execute();

        $count = $query->rowCount();

        if ($count > 0) {
            return $query->fetchAll();
        } else {
            return '0';
        }
    }

    public function UpdateProfile($userid, $pic, $profession, $mark, $color, $air, $tabac)
    {
        $user = $this->GetUserInfo($userid);

        foreach ($user as $u) {
            $old_pic = $u['avatar'];
        }

        if (!empty($pic['name'])) {
            if ($old_pic != 'def-av.png') {
                unlink('../img/' . $old_pic);
            }
            $file_extension = end(explode('.',$pic['name']));
            $date           = date('Y-m-d H:m:s');
            $picname        = $userid.'_'.md5($date.$pic['name']).'.'.$file_extension;
            move_uploaded_file($pic['tmp_name'],'../img/'.$picname);
            $q = $this->pdo->prepare("UPDATE users set avatar='$picname',profession='$profession',tabac='$tabac' WHERE userid='$userid'");

            $q->execute();
        }else{
            $q = $this->pdo->prepare("UPDATE users set profession='$profession',tabac='$tabac' WHERE userid='$userid'");

            $q->execute();
        }

        $vehicle = $this->GetVehicleInfo($userid);

        if ($vehicle != 0){
            $q = $this->pdo->prepare("UPDATE vehicles set mark='$mark',color='$color',air_cond='$air' WHERE userid='$userid'");

            $q->execute();
        }else{
            $query = $this->pdo->prepare("INSERT INTO vehicles (`userid`,`mark`,`color`,`air_cond`) values ('$userid','$mark','$color','$air')");

            $query->execute();
        }

        return 'success';
    }

    public function SaveTrajet($userid,$depart,$ar,$places,$date,$arrive,$trajet,$time,$price){
        $q = $this->pdo->prepare("SELECT * FROM vehicles WHERE userid='$userid'");

        $q->execute();

        $vehicle = $q->fetchAll();

        foreach ($vehicle as $v){
            $vehicleid = $v['vehicleid'];
        }

        $query = $this->pdo->prepare("INSERT INTO trajets (`vehicleid`,`userid`,`depart`,`arriver`,`places`,`date`,`time`,`aller_retour`,`trajet`,`price`) values ('$vehicleid','$userid','$depart','$arrive','$places','$date','$time','$ar','$trajet','$price')");

        $query->execute();

        return 'success';
    }

    public function GetUsersAnnonces($userid){

        $query = $this->pdo->prepare("SELECT t.*,v.*,u.* FROM trajets t, vehicles v,users u WHERE t.userid = v.userid AND v.userid='$userid' AND u.userid='$userid' ORDER BY t.idtrajet DESC");

        $query->execute();

        $count = $query->rowCount();

        if ($count == 0){
            return 0;
        }else{
            return $query->fetchAll();
        }
    }

    public function DeleteAnnonce($id){
        $query = $this->pdo->prepare("DELETE FROM trajets WHERE idtrajet='$id'");

        $query->execute();

        return 'success';
    }

    public function GetAnnonceDetails($id){
        $query = $this->pdo->prepare("SELECT * FROM trajets WHERE idtrajet='$id'");

        $query->execute();

        return $query->fetchAll();
    }
    
    public function Search($depart,$arrive){
        $query = $this->pdo->prepare("SELECT t.*, u.avatar FROM trajets t, users u WHERE t.depart='$depart' AND t.arriver='$arrive' AND t.userid=u.userid ORDER BY t.idtrajet DESC");

        $query->execute();

        $count = $query->rowCount();

        if ($count > 0) {
            return $query->fetchAll();
        }else{
            return '0';
        }
    }

    public function GetAnnonces(){
        $query = $this->pdo->prepare("SELECT t.*, u.avatar, v.* FROM trajets t, users u, vehicles v WHERE  t.userid=u.userid AND t.vehicleid=v.vehicleid ORDER BY t.idtrajet DESC");

        $query->execute();

        return $query->fetchAll();
    }

    public function TotalAnnonces($userid){
        $query = $this->pdo->prepare("SELECT * FROM trajets WHERE userid='$userid'");

        $query->execute();

        return $query->rowCount();
    }

    public function UpdatePlaces($id){
        $query = $this->pdo->prepare("SELECT * FROM trajets WHERE idtrajet = '$id'");

        $query->execute();

        $res = $query->fetchAll();

        foreach ($res as $r){
            $places = $r['places'];
        }

        $new_places = $places - 1;

        $q = $this->pdo->prepare("UPDATE trajets set places='$new_places' WHERE idtrajet='$id'");

        $q->execute();

        return 'success';
    }
}
