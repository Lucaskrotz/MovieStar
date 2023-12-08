<?php

require_once("globals.php");
require_once("db.php");
require_once("models/User.php");
require_once("models/Message.php");
require_once("dao/UserDAO.php");

$message = new Message($BASE_URL);

$userDao = new UserDAO($conn, $BASE_URL);

// Resgata o tipo do formulário

$type = filter_input(INPUT_POST, "type");

// Verificação do tipo de formulario

if($type === "register") {

    $name = filter_input(INPUT_POST, "name");
    $lastname = filter_input(INPUT_POST, "lastname");
    $email = filter_input(INPUT_POST, "email");
    $password = filter_input(INPUT_POST, "password");
    $confirmpassword = filter_input(INPUT_POST, "confirmpassword");

// Verificação de dados mínimos

    if($name && $lastname && $email && $password){

        // Verificar se as Senhas batem

        if($password === $confirmpassword) {

            // Verificar se o email ja esta cadastrado no sistema

            if($userDao->findByEmail($email) === false) {

                $user = new User();

                // Criação de token e senha

                $userToken = $user->generateToken();
                $finalPassoword =  $user->generatePassword($password);

                $user->name = $name;
                $user->lastname = $lastname;
                $user->email = $email;
                $user->password = $finalPassoword;
                $user->token = $userToken;

                $auth = true;

                $userDao->create($user, $auth);
                

            } else {

                // Enviar uma msg de erro, usuário ja existe

                $message->setMessage("Usuário já cadastrado, tente outro e-mail.", "error", "back"); 

            }

        } else {
           // Enviar uma msg de erro, de senhas nao batem

        $message->setMessage("As senhas não sao iguais.", "error", "back"); 
        }

    } else {

        // Enviar uma msg de erro, de dados faltantes

        $message->setMessage("Por Favor, preencha todos os campos.", "error", "back");


    }

} else if($type === "login") {

    $email = filter_input(INPUT_POST, "email");
    $password = filter_input(INPUT_POST, "password");

    // Tentar autenticar usuario

    if($userDao->authenticteUser($email,$password)){

        $message->setMessage("SeJa Bem-Vindo!", "success", "editprofile.php");

        //Redireciona o usuario, caso  nao conseguir autenticar
    }else{

        $message->setMessage("Usuario e/Ou senha incorretos", "error", "back");

    }

} else {

    $message->setMessage("Informações Invalidas", "error", "index.php");
}

