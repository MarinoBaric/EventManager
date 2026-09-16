<?php

/**
 * Description of RoleModel responsible for role data.
 *
 * @extends Model
 */
class RoleModel extends Model {

    private $role_id;
    private $name;

    public function getRoleId() {
        return $this->role_id;
    }

    public function getName() {
        return $this->name;
    }

    /**
     * Retrieves all roles.
     *
     * @return array The array of RoleModel objects.
     */
    public function getAll(): array {
        return $this->queryAll('SELECT role_id, name FROM role ORDER BY name', 'RoleModel');
    }

    /**
     * Retrieves a single role by its name.
     *
     * @param string $name The name of the role.
     * @return object|false The RoleModel object if found, false otherwise.
     */
    public function getByName(string $name): object|false {
        return $this->queryOne(
            'SELECT role_id, name FROM role WHERE name = :name',
            'RoleModel', ['name' => $name]
        );
    }
}