<?php
    require_once "view/view.php";
    require_once "mysqlDB.php";

    class PenyakitController{
        protected $db;

        public function __construct(){
            $this->db = new mysqlDB("localhost","root","","webdoctor");
        }

        public function diagnose(){
            session_start();
            $nama = $_SESSION['userlogin'];
            $kategori = $_SESSION['kateg'];
            session_write_close();
            $query = "SELECT `namaGejala` FROM `Gejala`";
            $res = $this->db->executeSelectQuery($query);
            $query = "SELECT `profil` FROM `member` WHERE `namaMember`='$nama'";
            $profil = $this->db->executeSelectQuery($query);
            $query = "SELECT `namaPenyakit` FROM (SELECT `idKategori` FROM `kategori` WHERE `namaKategori`='$kategori')AS `himpKategori` INNER JOIN `penyakit` ON `himpKategori`.`idKategori` = `penyakit`.`idKategori`";
            $namaPenyakit = $this->db->executeSelectQuery($query);
            $query = "SELECT `kodeGejala` FROM `gejala` WHERE `namaGejala`=";
            $jumlah = count($_GET['gejala']); //menghitung jumlah value yang di centang
            for($i=0; $i<$jumlah; $i++){
                $a=$_GET['gejala'][$i];
                $query.="'$a'";
                if($i!=$jumlah-1){
                    $query.=" OR `namaGejala`=";
                }
            }
            $gejala = $this->db->executeSelectQuery($query);
            $query = "SELECT DISTINCT(`namaPenyakit`),`idKategori`,`penyakit`.`kodePenyakit` FROM (SELECT `kodePenyakit` FROM `hubungan` WHERE `kodeGejala`=";
            for($i=0; $i<$jumlah; $i++){
                $a = $gejala[$i][0];
                $query.="$a";
                if($i!=$jumlah-1){
                    $query.=" OR `kodeGejala`=";
                }
            }
            $query.=")AS `himpPenyakit` INNER JOIN `penyakit` ON `himpPenyakit`.`kodePenyakit` = `penyakit`.`kodePenyakit`";
            $result = $this->db->executeSelectQuery($query);
            $kode = $result[0][2];
            $z = "SELECT `username` FROM `member` WHERE `namaMember`='$nama'";
            $y = $this->db->executeSelectQuery($z);
            $x = $y[0][0];
            $dt = new DateTime();
            $tglJoin = $dt->format('Ymd');
            $q = "INSERT INTO `diagnosa`(`waktu`,`kodePenyakit`,`username`) VALUES ('$tglJoin',$kode,'$x')";
            $this->db->executeNonSelectQuery($q);
            for($i=0; $i<$jumlah; $i++){
                $a = $gejala[$i][0];
                $q = "INSERT INTO `punya`(`waktu`,`username`,`kodeGejala`) VALUES('$tglJoin','$x',$a)";
                $this->db->executeNonSelectQuery($q);
            }
            if(count($res)!=0){
                $a=$result[0][0];
                $b=$result[0][1];
                $query = "SELECT `namaKategori` FROM `kategori` WHERE `idKategori`=$b";
                $hasil = $this->db->executeSelectQuery($query);
                $b = $hasil[0][0];
                return View::createHomepage('gejala1.php',[
                    "res"=>$res,
                    "profil"=>$profil,
                    "nama"=>$nama,
                    "msg1"=>$a,
                    "msg2"=>$b
                ]);
            }
            else{
                $a = "penyakit tidak ditemukan";
                return View::createHomepage('gejala1.php',[
                    "res"=>$res,
                    "profil"=>$profil,
                    "nama"=>$nama,
                    "msg1"=>$a
                ]);
            }
        }
        
        public function show(){ //menampilkan penyakit di bagian admin
            session_start();
            $nama = $_SESSION['userlogin'];
            session_write_close();
            $query = "SELECT `profil` FROM `member` WHERE `namaMember`='$nama'";
            $profil = $this->db->executeSelectQuery($query);
            return View::createHomepage('penyakit.php', [
                "nama"=>$nama,
                "res"=>$res,
                "profil"=>$profil
            ]);
        }

        public function addPenyakit(){ //menambahkan penyakit ke db
            $query = "INSERT INTO `Penyakit` (`namaPenyakit`) VALUES";
            $temp = $_POST['namaPenyakit'];
            if(isset($temp) && $temp != ''){
                $temp = $this->db->escapeString($temp);
                $query.= "('$temp')";
            }
            $res = $this->db->executeSelectNonQuery($query);
        }

        public function add(){
            return View::createAdmin('addPenyakit.php', []);
        }
    }
?>