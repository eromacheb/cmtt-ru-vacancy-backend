<?php declare(strict_types=1);

namespace model;

class Ad extends DatabaseInstance
{
    const TABLE = 'ads';

    protected $db;

    function __construct($db)
    {
        $this->db = $db;
    }

    public function getAll()
    {
        return $this->db->query("SELECT a.id,
                                        a.text,
                                        a.price,
                                        a.limit,
                                        a.banner
                                FROM ads as a
                                ORDER BY a.id"
        );
    }

    public function getById(int $id)
    {
        return $this->db->queryFirstRow("SELECT a.id,
                                                a.text,
                                                a.price,
                                                a.limit,
                                                a.banner
                                        FROM ads as a
                                        WHERE a.id=%i", $id
        );
    }

    public function getRelevant()
    {
        return $this->db->queryFirstRow("SELECT a.id,
                                                a.text,
                                                a.banner
                                        FROM (SELECT * FROM ads as a WHERE a.limit!=0) as a
                                        ORDER BY a.price DESC"
        );
    }

}
