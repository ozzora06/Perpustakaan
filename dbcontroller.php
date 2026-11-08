<?php class dbcontroller
{
    private $host = "127.0.0.1";
    private $user = "root";
    private $password = "";
    private $database = "perpus";
    private $koneksi;

    public function __construct()
    {
        $this->koneksi = $this->koneksiDB();
    }

    public function koneksiDB()
    {
        $koneksi = mysqli_connect($this->host, $this->user, $this->password, $this->database);
        return $koneksi;
    }

    public function getALL($sql)
    {
        $result = mysqli_query($this->koneksi, $sql);

        if (!$result) {
            die("Query Error: " . mysqli_error($this->koneksi));
        }

        $data = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }

        return $data;
    }

    public function getITEM($sql)
    {
        $result = mysqli_query($this->koneksi, $sql);
        $row = mysqli_fetch_assoc($result);
        return ($row);
    }

    public function rowCOUNT($sql)
    {
        $result = mysqli_query($this->koneksi, $sql);
        $count = mysqli_num_rows($result);
        return $count;
    }

    public function runSQL($sql)
    {
        return mysqli_query($this->koneksi, $sql);
    }

    public function getError()
    {
        return mysqli_error($this->koneksi);
    }

    public function pesan($text = "")
    {
        echo $text;
    }
}
