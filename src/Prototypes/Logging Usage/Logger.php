<?php
    include ("LogEntry.php");
/*
 * Logger reads log entries from the log file and writes log entries to the log file.
 */
class Logger
{
    const FILENAME = 'Log.json';

    // Append a Log Entry to the Log File
    public static function appendLog(LogEntry $logEntry)
    {
        $jsonArray = null;
        if (file_exists(FILENAME))
        { // if file exists we need to get entries and then append to it
            $jsonArray = json_decode(file_get_contents(FILENAME), true);
            $entryCount = count($jsonArray);
            $jsonArray[$entryCount + 1] = self::getArray($logEntry);
        }
        else
        { // no file
            $jsonArray['1'] = self::getArray($logEntry);
        }

        $fp = fopen(FileName, 'w');
        fwrite($fp, json_encode($jsonArray));
        fclose($fp);
    }

    // Read Contents of Log file.
    public static function readLog()
    {
        if (file_exists(FILENAME))
        {
            $jsonArray = json_decode(file_get_contents(FILENAME), true);
            $array[] = new ArrayObject();
            for ($i = 0; $i < count($jsonArray); $i++)
            {
                array_push($array, new LogEntry($jsonArray[i]));
            }

            // TODO Figure out how we want to use the array of log entries
        }
    }

    // helper method to get an array form of a log entry
    private static function getArray(LogEntry $logEntry)
    {
        return ['name' => $logEntry->getName(),
                    'genre' => $logEntry->getGenre(),
                    'type' => $logEntry->getType(),
                    'date' => $logEntry->getDatte(),
                    'user' => $logEntry->getUser()];
    }
}
