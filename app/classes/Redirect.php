<?php

class Redirect
{
    /**
     * Método para reedirigir a un usuario a otra seccion
     * 
     * @param string $loc
     * @return void
     */
    private $loc;

    public static function to($loc)
    {
        $self = new self();
        $self->loc = $loc;

        //  Validar que las cabeceras ya fueron enviadas
        if (headers_sent()) {
            echo '<script>';
            echo 'window.location.href="' . URL . $self->loc . '";';
            echo '<script>';
            echo '<noscript>';
            echo '<meta http-equiv="refresh" content="0;url=' . URL . $self->loc . '"/>';
            echo '</noscript>';
            die();
        }

        // Si pasamos una url externa a nuestro sitio
        if (strpos($self->loc, 'http') !== false) {
            header('Location: ' . $self->loc);
            die();
        }

        // Reedirigir al usuario a alguna seccion
        header('Location: ' . URL . $self->loc);
        die();
    }
}
