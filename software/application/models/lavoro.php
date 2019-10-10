<?php

require_once "application/models/model.php";

/**
 * Classe Lavoro
 */
class Lavoro extends Model
{

    /**
     * @var string Il nome del lavoro
     */
    private $name;

    /**
     * @var string Le note che possono essere associate al lavoro
     */
    private $notes;

    /**
     * @var DateTime La data di inizio del lavoro
     */
    private $startDate;

    /**
     * @var DateTime La data di consegna del lavoro
     */
    private $deliveryDate;

    /**
     * @var int Il numero preventivato di ore che si passerà a lavorare sull'attività
     */
    private $estimatedHours;

    /**
     * Metodo costruttore per la classe Lavoro.
     * @param $name string Il nome del lavoro.
     * @param $notes string Eventuali note che l'amministratore può avere.
     * @param $startDate DateTime La data di inizio del lavoro.
     * @param $deliveryDate DateTime La data di consegna del lavoro.
     * @param $estimatedHours int Il numero preventivato di ore assegnate al lavoro.
     */
    public function __construct(string $name = null, string $notes = null, DateTime $startDate = null, DateTime $deliveryDate = null, int $estimatedHours = null)
    {
        parent::__construct("lavoro");
        $this->name = $name;
        $this->notes = $notes;
        $this->startDate = $startDate;
        $this->deliveryDate = $deliveryDate;
        $this->estimatedHours = $estimatedHours;
    }

    /**
     * Ottiene tutti i lavori leggendoli dal database.
     * @return array Un array contenente un oggetto di tipo Lavoro per ogni riga letta dal database.
     */
    public function getAllActivities(): Array
    {

        //Istanzia l'array da ritornare
        $lavoriArray = [];
        //Ottieni i dati dal database grazie alla superclasse 'Model'
        $models = $this->getAllModels();

        //Cicla tutti gli elementi letti dal database e per ognuno aggiungi un elemento all'array lavoriArray
        //contenente un oggetto di tipo Lavoro con i dati dell'elemento corrente di models.
        foreach ($models as $model) {

            array_push(
                $lavoriArray,
                new Lavoro(
                    $model["nome"],
                    $model["note"],
                    DateTime::createFromFormat("Y-m-d", $model["data_inizio"]),
                    DateTime::createFromFormat("Y-m-d", $model["data_consegna"]),
                    intval($model["ore_preventivate"])
                )
            );

        }

        return $lavoriArray;

    }

    /**
     * Ottiene un lavoro con il nome specificato.
     * @param string $name Il nome per il quale cercare un lavoro all'interno del database.
     * @return Lavoro Un oggetto il cui valore dei campi è uguale ai dati
     * della riga il cui nome corrisponde al valore del parametro name.
     */
    public function getActivityByName(string $name): Lavoro
    {
        //TODO: Generalizzare questo metodo?

        //Scrivi la query per la ricerca nel database
        $query = "SELECT * FROM lavoro WHERE nome = :name";
        //Prepara la query
        $statement = $this->database->prepare($query);
        //Assegna al segnaposto ':name' il valore del parametro name
        $statement->bindParam(":name", $name);
        //Esegui la query
        $statement->execute();
        //Vai a prendere i risultati
        $queryResult = $statement->fetchAll();

        //Se sono stati ritornati risultati
        if (count($queryResult) > 0) {

            //Ritorna un nuovo oggetto di tipo Lavoro con i dati del risultato
            return new Lavoro(
                $queryResult[0]["nome"],
                $queryResult[0]["note"],
                DateTime::createFromFormat("Y-m-d", $queryResult[0]["data_inizio"]),
                DateTime::createFromFormat("Y-m-d", $queryResult[0]["data_consegna"]),
                intval($queryResult[0]["ore_preventivate"])
            );

        }

        //Se arriviamo qui vuol dire che non è stato trovato alcun risultato, quindi ritorna null
        return null;

    }

}