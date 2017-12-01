<?php

/*
 * LogEntry is the class used to encapsulate data for each individual log.
 * It holds the information we want in each log entry.
 */
class LogEntry
{
    /* Properties */

    // name of file being viewed or downloaded
    private $name;

    // genre of file
    private $genre;

    // 'download' or 'view'
    private $type;

    // date of view or download
    private $date;

    // person that viewed/downlaoded
    // TODO not sure how we can get the user
    private $user;


    /* End properties */

    /* Constructor */
    public function __construct($decoded_json)
    {
        $data = $decoded_json[0];

        foreach ($data AS $key => $value)
        {
            if ($key === "name")
            {
                $this->name = $value;
            }
            else if ($key === "genre")
            {
                $this->genre = $value;
            }
            else if ($key === "type")
            {
                $this->type = $value;
            }
            else if ($key === "date")
            {
                $this->date = $value;
            }
            else if ($key === "user")
            {
                $this->user = $value;
            }
        }
    }

    /* End Constructor */

    /* Accessors */
    public function getName()
    {
        return $this->name;
    }

    public function getGenre()
    {
        return $this->genre;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function getUser()
    {
        return $this->date;
    }

    /* End Accessors */

    /* Mutators */

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setGenre($genre)
    {
        $this->genre = $genre;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function setDate($date)
    {
        $this->date = $date;
    }

    public function setUser($user)
    {
        $this->date = $user;
    }

    /* End Mutators */
}