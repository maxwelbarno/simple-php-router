<?php

namespace DataMapper;

use Exceptions\CustomException;
use Model\User;
use Query\Query;

class UserMapper
{
    public $table;
    public $primary_key;
    public $query;

    public function __construct()
    {
        $this->table = "guests";
        $this->primary_key = "id";
        $this->query = new Query($this->table, $this->primary_key);
    }

    public function save(User $user)
    {
        $data = [
            "firstname" => $user->getFirstName(),
            "lastname" => $user->getLastName(),
            "email" => $user->getEmail()
        ];
        return $this->query->create($data);
    }

    public function findAll()
    {
        try {
            $list = array();
            $data = $this->query->fetchAll();
            foreach ($data as $row) {
                $user = new User($row);
                $list[] = $user;
            }
            return $list;
        } catch (CustomException $e) {
            $e->render();
        }
    }

    public function findOne($id)
    {
        try {
            $data = $this->query->fetchById($id);
            if ($data) {
                $user = new User($data);
                return $user;
            }
        } catch (CustomException $e) {
            $e->render();
        }
    }

    public function update(User $user, $id)
    {
        $data = [
            "firstname" => $user->getFirstName(),
            "lastname" => $user->getLastName(),
            "email" => $user->getEmail()
        ];
        return $this->query->update($data, $id);
    }

    public function delete($id)
    {
        return $this->query->delete($id);
    }
}
