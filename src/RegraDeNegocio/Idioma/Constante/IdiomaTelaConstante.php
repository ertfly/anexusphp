<?php

namespace AnexusPHP\RegraDeNegocio\Idioma\Constante;

class IdiomaTelaConstante
{
    const HEADER_OUT = 1;
    const FOOTER_OUT = 2;
    const LOGIN = 3;
    const REGISTER_STEP_1 = 4;
    const REGISTER_STEP_2 = 5;
    const REGISTER_STEP_3 = 6;
    const PASSWORD_RECOVER = 7;
    const ID_RECOVER = 8;

    public static $opcoes = [
        self::HEADER_OUT => 'Header Out',
        self::FOOTER_OUT => 'Footer Out',
        self::LOGIN => 'Login',
        self::REGISTER_STEP_1 => 'Register step 1',
        self::REGISTER_STEP_2 => 'Register step 2',
        self::REGISTER_STEP_3 => 'Register step 3',
        self::PASSWORD_RECOVER => 'Password Recover',
        self::ID_RECOVER => 'Id Recover',
    ];

    public static function getOpcoes()
    {
        return self::$opcoes;
    }

    public static function getOpcao($key)
    {
        if (!isset(self::$opcoes[$key])) {
            throw new \Exception('Opção inválida!');
        }

        return self::$opcoes[$key];
    }
}
