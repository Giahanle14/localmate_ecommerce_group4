<?php
class TourDetailModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getTourById($maTour) {
        $sql = "SELECT * FROM Tour WHERE MaTour = :matour";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':matour' => $maTour]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Lấy lịch trình từ bảng lichtrinhtour và sắp xếp theo ThuTu
    public function getItinerary($maTour) {
        $sql = "SELECT * FROM lichtrinhtour WHERE MaTour = :matour ORDER BY ThuTu ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':matour' => $maTour]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>