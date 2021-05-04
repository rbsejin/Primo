<?php
class Item
{
    public $id;
    public $school;
    public $name;
    public $sex;
    public $price;
    public $image;
    public $image1;
    public $image2;
    public $image3;

    private function __construct($id, $school, $name, $sex, $price, $image, $image1, $image2, $image3)
    {
        $this->id = $id;
        $this->school = $school;
        $this->name = $name;
        $this->sex = $sex;
        $this->price = $price;
        $this->image = $image;
        $this->image1 = $image1;
        $this->image2 = $image2;
        $this->image3 = $image3;
    }

    public static function fromBasicDb($conn, $id): Item
    {
        $sql = "SELECT * FROM item WHERE id = '$id'";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $row = mysqli_fetch_array($result);

            $user = null;
            if ($row) {
                $item = new static($row['id'], $row['school'], $row['name'], $row['sex'], $row['price'], $row['image'], $row['image1'], $row['image2'], $row['image3']);
            }
        }

        return $item;
    }

    public static function insertToDb($conn, $school, $name, $sex, $price, $image, $image1 = 'gallery_01.png', $image2 = 'gallery_02.png', $image3 = 'gallery_03.png')
    {
        $sql = "SELECT count(*) FROM item WHERE school = '$school' AND name = '$name'";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $row = mysqli_fetch_array($result);
            $count = $row[0];

            if ($count > 0) {
                return false;
            }
        } else {
            return false;
        }

        $sql = "INSERT INTO item (school, name, sex, price, image, image1, image2, image3) VALUES ('$school', '$name', '$sex', $price, '$image', '$image1', '$image2', '$image3')";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            $sql = "SELECT LAST_INSERT_ID() FROM item";
            $result = mysqli_query($conn, $sql);

            if ($row = mysqli_fetch_row($result)) {
                $id = $row[0];
                return $id;
            }   
        }

        return false;
    }
}
