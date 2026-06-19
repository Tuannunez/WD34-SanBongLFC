<?php

class Stadium
{
    private $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

  public function getAll()
{
    $sql = "
        SELECT *
        FROM stadiums
        ORDER BY id DESC
    ";

    $stmt = $this->conn->prepare($sql);

    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
public function create($data)
{
    $sql = "
        INSERT INTO stadiums
        (
            name,
            address,
            description,
            image,
            type,
            price_per_hour,
            status
        )
        VALUES
        (
            :name,
            :address,
            :description,
            :image,
            :type,
            :price_per_hour,
            :status
        )
    ";

    $stmt = $this->conn->prepare($sql);

    return $stmt->execute([
        ':name'           => $data['name'],
        ':address'        => $data['address'],
        ':description'    => $data['description'],
        ':image'          => $data['image'],
        ':type'           => $data['type'],
        ':price_per_hour' => $data['price_per_hour'],
        ':status'         => $data['status']
    ]);
}
public function update($id, $data)
{
    $sql = "
        UPDATE stadiums
        SET
            name = :name,
            address = :address,
            description = :description,
            image = :image,
            type = :type,
            price_per_hour = :price_per_hour
        WHERE id = :id
    ";

    $stmt = $this->conn->prepare($sql);

    return $stmt->execute([
        ':id'             => $id,
        ':name'           => $data['name'],
        ':address'        => $data['address'],
        ':description'    => $data['description'],
        ':image'          => $data['image'],
        ':type'           => $data['type'],
        ':price_per_hour' => $data['price_per_hour']
    ]);
}
public function findById($id)
{
    $sql = "
        SELECT *
        FROM stadiums
        WHERE id = :id
    ";

    $stmt = $this->conn->prepare($sql);

    $stmt->execute([
        ':id' => $id
    ]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}
public function delete($id)
{
    $sql = "DELETE FROM stadiums WHERE id = :id";

    $stmt = $this->conn->prepare($sql);

    return $stmt->execute([
        ':id' => $id
    ]);
}
}