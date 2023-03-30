<?php
// contabile.fermi.intra
// ("localhost", "5ai_19_20_s01540", "s01540", "ya9HeiHa")
// (server, database, username, password)

/* CLASSE PER LA CONNESSIONE AL DATABASE */
class Database
{ 
    // credenziali database
    private $server;
    private $database;
    private $username;
    private $password;
    private $connection;
    
    // metodo costruttore
    public function __construct($server, $database, $username, $password)
    {
        $this->server       = $server;      // "localhost", "5ai_19_20_s01540", "root", "" == server, database, username, password
        $this->database     = $database;    // "5ai_19_20_s01540";
        $this->username     = $username;    // "root";
        $this->password     = $password;    // "";
        $this->connection   = null;
    }

    // get del server del database
    public function getServer()
    {
        return $this->server;
    }

    // get del nome del database
    public function getDatabase()
    {
        return $this->database;
    }

    // get dell'username dell'utente connesso al database
    public function getUsername()
    {
        return $this->username;
    }

    // get della password dell'utente connesso al database
    public function getPassword()
    {
        return $this->password;
    }

    // get della connessione al database
    public function getConnection()
    {
        return $this->connection;
    }

    // instaurazione della connessione al database tramite PDO
    public function openConnectionPDO()
    {
        /* CONNESSIONE AL DATABASE */

        // try-catch per il controllo del successo/insuccesso della connessione al database
        try
        {
            // operazione di connessione
            $this->connection = new PDO("mysql:host=" . $this->server . ";dbname=" . $this->ddatabasebName, $this->username, $this->password);
            
            // notifica positiva in caso di connessione effettuata
            echo "Connessione a MySQL tramite PDO effettuata.<br><br>";
        }
        catch(PDOException $exception)
        {
            // notifica negativa in caso di connessione fallita
            echo "Connessione non riuscita: " . $exception->getMessage() . ".<br>";
        }
 
        return $this->connection;
    }

    // chiusura della connessione al database tramite PDO
    public function closeConnectionPDO()
    {
        /* CHIUSURA DELLA CONNESSIONE */

        $this->connection = null;

        return $this->connection;
    }

    // instaurazione della connessione al database tramite MYSQLI
    public function openConnectionMYSQLI()
    {
        /* CONNESSIONE AL DATABASE */

        $this->connection = mysqli_connect($this->server, $this->username, $this->password)
        or die("Connessione non riuscita: " . mysqli_error($this->connection) . ".<br>");
        
        // echo "Connessione a MySQL tramite MYSQLI effettuata.<br><br>";
 
        return $this->connection;
    }

    // chiusura della connessione al database tramite SQLI
    public function closeConnectionMYSQLI()
    {
        /* CHIUSURA DELLA CONNESSIONE */

        mysqli_close($this->connection);
        $this->connection = null;

        return $this->connection;
    }
}

?>
