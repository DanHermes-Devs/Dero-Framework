<?php

class homeController extends Controller
{
    function __construct()
    {
    }

    function index()
    {

        // Insertar usuarios con Modelo
        // try {

        //     $user = new usuarioModel();

        //     $user->name = 'Julia Mayern';
        //     $user->username = 'julimayen';
        //     $user->email = 'juli@mail.com';
        //     $user->created_at = nowDate();

        //     $user->store();
        // } catch (Exception $e) {
        //     echo $e->getMessage();
        // }

        try {
            $peticion_token = "9043a39ebbb72ac310d98a8a686b18c864eed4b9990d48229e58d5e49d4f946c";
            if(Csrf::validate($peticion_token, true)) {
                echo "es valido";
            } else {
                die('Cuidado, token no valido');
            }
            $user = new usuarioModel();
            $user->id = 18;
            $user->name = 'Abigail Julia Rojas Mayen';
            $user->username = 'julimayenrojas';
            $user->email = 'juli@mail.com';

            $user->update();
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        View::render('dero');

        die;
        try {
            // Select
            $sql = 'SELECT * FROM users WHERE id=:id';
            // $res = Db::query($sql, [':id' => '3']);
            // print_r($res);

            // Insert
            $sql = 'INSERT INTO users (name, email, created_at) VALUES (:name, :email, :created_at)';
            $registro = ['name' => 'Genesis', 'email' => 'genesis@mail.com', 'created_at' => nowDate()];
            // $id = Db::query($sql, $registro);
            // print_r($registro);

            // Update
            $sql = 'UPDATE users SET name=:name WHERE id=:id';
            $regsitro_actualizado = ['name' => 'Jesus', 'id' => 3];
            // print_r(Db::query($sql, $regsitro_actualizado));

            // Eliminar
            $sql = 'DELETE FROM users WHERE id=:id LIMIT 1';
            $registro_eliminar = ['id' => 3];
            // print_r(Db::query($sql, $registro_eliminar));

            // Alter Table
            $sql = 'ALTER TABLE users ADD column username VARCHAR(255) NULL AFTER name';
            // print_r(Db::query($sql));

        } catch (Exception $e) {
            echo 'Hubo un error: ' . $e->getMessage();
        }

        View::render('dero');
    }
}
