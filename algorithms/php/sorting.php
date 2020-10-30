<?php

class ClientReading
{
    private $id;
    public $reading;

    public function __construct($id, $reading)
    {
        $this->id = $id;
        $this->reading = $reading;
    }

    public function __toString()
    {
        return $this->id.' '.$this->reading;
    }

    public function getClientReading()
    {
        return $this->reading;
    }
}

$clients = [
    new ClientReading(uniqid(), 2000),
    new ClientReading(uniqid(), 1000),
    new ClientReading(uniqid(), 300),
    new ClientReading(uniqid(), 500),
    new ClientReading(uniqid(), 50),
    new ClientReading(uniqid(), 3000),
    new ClientReading(uniqid(), 1000),
];

// Do something here to sort the clients descending by their reading!

foreach ($clients as $client) {
    $reading[] = $client->getClientReading(); //any object field
}

array_multisort($reading, SORT_DESC, $clients);

print_r($clients);



