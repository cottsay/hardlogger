<?php

class HardloggerException extends Exception
{
    public function __construct($message, $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function handleHTTP()
    {
        header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
        echo $this->message;
        exit();
    }
}

class Hardlogger
{
    const Version = "2.1.0";

    #### SERVER CONFIG START
    const fancyBoxURL = "/fancybox";
    const jQueryURL = "/jquery";
    const jQueryWatermarkURL = "/jquery/watermark";
    #### SERVER CONFIG END

    #### DB CONFIG START
    private $hostname = "localhost";
    private $username = "hardlogger";
    private $password = "asdf1234";
    private $database = "hardlogger";

    #### DB CONFIG END

    # PRIVATE VARS START
    private $db = null;
    private $event = null;
    private $event_id = null;
    private $settings = null;
    # PRIVATE VARS END

    # CONSTRUCTOR/DESTRUCTOR START
    public function __destruct( )
    {
        $this->disconnect();
    }
    # CONSTRUCTOR/DESTRUCTOR END

    # STATIC FUNCTIONS START
    public static function fetchAll($result)
    {
        $result_arr = array();

        while ($row = $result->fetch_assoc())
        {
            $result_arr[] = $row;
        }

        return $result_arr;
    }
    # STATIC FUNCTIONS END

    # PUBLIC API START
    public function connect( )
    {
        if ($this->db == null)
        {
            @$this->db = new mysqli($this->hostname, $this->username, $this->password, $this->database);

            if ($this->db->connect_errno)
            {
                throw new HardloggerException("Database Connect failed: " . $this->db->connect_error);
            }
        }
    }

    public function disconnect( )
    {
        if ($this->db != null)
        {
            mysqli_close($this->db);

            $this->db = null;
        }
    }

    public function selectEvent($event_id = null)
    {
        if ($event_id != null)
        {
            if (is_numeric($event_id))
            {
                $this->event_id = $event_id;
            }
            else
            {
                throw new HardloggerException("Invalid event " . $event_id . " specified");
            }
        }
        else
        {
            $this->loadSettings();

            if (isset($this->settings['event']))
            {
                $this->event_id = $this->settings['event'];
            }
            else
            {
                throw new HardloggerException("No default event is specified");
            }
        }
    }

    public function currEvent()
    {
        if ($this->event_id == null)
        {
            $this->selectEvent();
        }

        return $this->event_id;
    }

    public function loadSettings()
    {
        if ($this->settings == null)
        {
            $this->connect();

            $result = $this->db->query("SELECT var,val FROM settings");

            if (!$result)
            {
                throw new HardloggerException("Failed to get settings: " . $this->db->error);
            }

            while ($row = $result->fetch_assoc())
            {
                $this->settings[$row['var']] = $row['val'];
            }

            $result->free();
        }
    }

    public function loadEvent()
    {
        if ($this->event == null)
        {
            $this->connect();

            if ($this->event_id == null)
            {
                $this->selectEvent();
            }

            $result = $this->db->query("SELECT id,event_name,callsign,contest,cat_operator,cat_assist,cat_band,cat_power,cat_mode,cat_transmitter,club,location,name,address,city,state,postal,country,operators,soapbox,chk,precidence,cat_mode_cat,cat_station FROM events WHERE id='" . $this->event_id . "'");

            if (!$result)
            {
                throw new HardloggerException("Failed to get event info: " . $this->db->error);
            }

            $row = $result->fetch_assoc();

            if (!$row)
            {
                throw new HardloggerException("Failed to get event info: event does not exist");
            }

            $this->event = $row;

            $result->free();
        }
    }

    public function getEvent()
    {
        $this->loadEvent();

        return $this->event;
    }

    public function getStats()
    {
        $this->connect();

        if ($this->event_id == null)
        {
            $this->selectEvent();
        }

        $result = $this->db->query("SELECT COUNT(id),COUNT(DISTINCT Section),MIN(LoggedAt),MAX(LoggedAt) FROM qsos WHERE EventID=" . $this->event_id . " AND Status=1");

        if (!$result)
        {
            throw new HardloggerException("Failed to get statistics: " . $this->db->error);
        }

        $row = $result->fetch_assoc();

        if (!$row)
        {
            throw new HardloggerException("Failed to get statistics: query returned no results");
        }

        $stats = array();

        $stats['count'] = $row['COUNT(id)'];
        $stats['sections'] = $row['COUNT(DISTINCT Section)'];
        $stats['first'] = $row['MIN(LoggedAt)'];
        $stats['last'] = $row['MAX(LoggedAt)'];

        return $stats;             
    }

    public function queryQSOs($cols, $conditions = array(), $order = null, $rev = false, $max = null)
    {
        $this->connect();

        if ($max != null)
        {
            if (!is_numeric($max))
            {
                throw new HardloggerException("Invalid 'max' value '" . $max . "'");
            }

            $limit = " LIMIT " . $max;
        }
        else
        {
            $limit = "";
        }

        if ($order)
        {
            $order_by = " ORDER BY " . $order . " " . ($rev ? "DESC" : "ASC");
        }
        else
        {
            $order_by = "";
        }

        $query_str = "SELECT " . implode(",", $cols) . " FROM qsos WHERE " . implode(" AND ", $conditions) . $order_by . $limit;

        $result = $this->db->query($query_str);

        if (!$result)
        {
            throw new HardloggerException("Failed to query qsos: " . $this->db->error);
        }

        $qsos = Hardlogger::fetchAll($result);

        $result->free();

        return $qsos;
    }

    public function queryQSOSections($conditions = array())
    {
        $this->connect();

        $result = $this->db->query("SELECT DISTINCT Section FROM qsos WHERE " . implode(" AND ", $conditions) . " ORDER BY Section ASC");

        if (!$result)
        {
            throw new HardloggerException("Failed to query qsos: " . $this->db->error);
        }

        $sections = Hardlogger::fetchAll($result);

        $result->free();

        return array_map(function($i) { return $i['Section']; }, $sections);
    }

    public function countQSOs($conditions = array())
    {
        $this->connect();

        $query_str = "SELECT COUNT(id) FROM qsos WHERE " . implode(" AND ", $conditions);

        $result = $this->db->query($query_str);

        if (!$result)
        {
            throw new HardloggerException("Failed to query qsos: " . $this->db->error);
        }

        $qsos = $result->fetch_assoc()['COUNT(id)'];

        $result->free();

        return $qsos;
    }

    public function editQSO($qso_id, $values)
    {
        $this->connect();

        $value_strs = [];

        foreach ($values as $key => $val)
        {
            switch ($key)
            {
            case 'CheckNum':
            case 'ContactNumber':
            case 'Serial':
            case 'Status':
                $value_strs[] = $key . "=" . $val;
                break;
            case 'Callsign':
            case 'Frequency':
            case 'LoggedAt':
            case 'Precedence':
            case 'Section':
                $value_strs[] = $key . "='" . $val . "'";
                break;
            default:
                throw new HardloggerException("Invalid QSO field '" . $key . "'");
                break;
            }
        }

        $result = $this->db->query("UPDATE qsos SET " . implode(", ", $value_strs) . " WHERE id=" . $qso_id);

        if (!$result)
        {
            throw new HardloggerException("Failed to update qso " . $qso_id . ": " . $this->db->error);
        }
    }
    # PUBLIC API END
}

?>
