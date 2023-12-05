<?php

    class User {

        public $id;
        public $name;
        public $lastname;
        public $email;
        public $password;
        public $image;
        public $bio;
        public $token;

    }

    interface UserDAOInterface {

        public function buildUser($data);
        public function create(User $user, $authUser = false);
        public function update(User $user);
        public function verifyToken($protected = false);
        public function setTokenSession($token, $redirect =  true);
        public function authenticteUser($email, $password);
        public function findByEmail($email);
        public function findByid($id);
        public function findByToken($token);
        public function changePassword(User $user);

    }