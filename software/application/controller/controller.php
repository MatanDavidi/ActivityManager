<?php


class Controller
{

    /**
     * Permette di redirezionare a un'azione di una classe controller da ovunque nel codice di un controller.
     * @param string $controller Il nome del controller che deve gestire la richiesta.
     * @param string $action Il nome dell'azione (metodo) al quale si vuole mandare.
     * Questo parametro è opzionale e ha un valore di default di "index".
     * @param array $parameters Eventuali parametri che si vuole passare all'azione, sotto forma di array.
     * Questo parametro è opzionale e ha un valore di default di un array vuoto, che significa che non vengono passati parametri.
     */
    public function redirect(string $controller, string $action = "index", Array $parameters = Array())
    {
        //Thanks to Robert Pitt for answering the question at https://stackoverflow.com/questions/4979614/redirection-php-inside-mvc

        //Costruisci l'URL della richiesta con l'URL di base dell'applicazione,
        // il nome del controller, quello del metodo e gli argomenti.
        $location = URL . "/" . $controller . "/" . $action . "/" . implode("/", $parameters);

        //Manda il browser a quell'URL
        header("Location: $location");

        //Ferma l'esecuzione del codice per evitare risultati inattesi
        die();

    }

}