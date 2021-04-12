<?php
class User
{
    public $id;
    public $pass;
    public $name;
    public $email;

    private function __construct($id, $pass, $name, $email, $phoneNumber, $postcode, $address, $detailAddress, $extraAddress)
    {
        $this->id = $id;
        $this->pass = $pass;
        $this->name = $name;
        $this->email = $email;
        $this->phoneNumber = $phoneNumber;
        $this->postcode = $postcode;
        $this->address = $address;
        $this->detailAddress = $detailAddress;
        $this->extraAddress = $extraAddress;
    }

    public static function fromBasicDb($conn, $userId): User
    {
        $sql = "SELECT * FROM user WHERE id = '$userId'";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $row = mysqli_fetch_array($result);

            $user = null;
            if ($row) {
                $user = new static($row['id'], $row['pass'], $row['name'], $row['email'], $row['phone_number'], $row['postcode'], $row['address'], $row['detail_address'], $row['extra_address']);
            }
        }

        return $user;
    }
}
