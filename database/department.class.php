<?php 
declare (strict_types = 1);

class Department {
    public int $id;
    public string $name;

    public function __construct(?int $id, ?string $name) {
        $this->id = $id;
        $this->name = $name;
    }

    static function getDepartments(PDO $db) : array {
        $stmt = $db->prepare('SELECT id, name FROM Departments');
        $stmt->execute();
        $departments = array();
        foreach ($stmt->fetchAll() as $department) {
            array_push($departments, new Department($department['id'], $department['name']));
        }
        return $departments;
    }

    static function getDepartment(PDO $db, ?int $id) : ?Department {
        if ($id == null) {
            return null;
        }
        $stmt = $db->prepare('SELECT id, name FROM Departments WHERE id = ?');
        $stmt->execute(array($id));
        $department = $stmt->fetch();
        if ($department) {
            return new Department($department['id'], $department['name']);
        }
        return null;
    }
}
