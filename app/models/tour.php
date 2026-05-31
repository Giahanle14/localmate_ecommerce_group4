<?php
class Tour {
    private $conn;
    private $table_name = "Tour";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Hàm lấy danh sách toàn bộ các Tour đang có trong hệ thống CSDL
    public function getAllTours() {
        $query = "SELECT t.*, q.HoTen as TenQTV, q.Avatar as AvatarQTV 
                  FROM " . $this->table_name . " t
                  LEFT JOIN QTV q ON t.MaQTV = q.MaQTV 
                  ORDER BY t.NgayTao DESC";
                  
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}
?>