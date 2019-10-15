<?php
class Course {
    private $code;
    private $name;
    private $prog;
    private $plan;
    private $id;
    private $db;

    public function __construct(){
        //Databasanslutning
        $this->db = new mysqli(DBHOST, DBUSER, DBPASS, DBDATABASE);
        if($this->db->connect_errno > 0){
            die('Fel vid anslutning [' . $this->db->connect_error . ']');
        }
    }
    //Hämta alla kurser
    public function getCourses() {
        $sql = "SELECT * FROM courses;";
        $result = $this->db->query($sql);

        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    //Lägg till kurs
    public function addCourse($code, $name, $prog, $plan) {
        $sql = "INSERT INTO courses(code, name, progression, plan) VALUES('" . $code . "', '" . $name . "', '" . $prog . "', '" . $plan . "');";
        return $result = $this->db->query($sql);
    }
    //Uppdatera kurs
    public function updateCourse($id, $code, $name, $prog, $plan) {
        $sql = "UPDATE courses SET code='" . $code . "', name='" . $name . "', progression='" . $prog . "', plan='" . $plan . "' WHERE id=$id;";
        return $result = $this->db->query($sql);
    }
    //Radera kurs
    public function deleteCourse($id) {
        $id = intval($id);
        $sql = "DELETE FROM courses WHERE id=$id;";
        return $result = $this->db->query($sql);
    }
}