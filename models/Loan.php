<?php

class Loan {

    private $conn;

    public function __construct($db){
        $this->conn = $db;
    }

    public function getLoans($filter = ""){

        $query =
            "SELECT borrow_records.*, books.title
             FROM borrow_records
             LEFT JOIN books
             ON borrow_records.book_id = books.id
             WHERE borrow_records.status='active'";

        if($filter == "overdue"){

            $query .= " AND due_date < CURDATE()";

        } elseif($filter == "today"){

            $query .= " AND due_date = CURDATE()";

        } elseif($filter == "week"){

            $query .=
                " AND due_date BETWEEN CURDATE()
                  AND DATE_ADD(CURDATE(), INTERVAL 7 DAY)";
        }

        $query .= " ORDER BY due_date ASC";

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt->get_result();
    }
}

?>