<?php
session_start();
//membuat koneksi ke database
$conn = mysqli_connect("localhost", "root", "","stockbarang");

//Menambah user baru
if(isset($_POST['addnewuser'])){
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    
    $addtotable = mysqli_query($conn, "INSERT into login (username, email, password, role ) values('$username', '$email','$password','$role')");
    if($addtotable){
        header('location:account.php');
    }else{
        echo 'Gagal ';
        header('location: account.php');
    }
}

//Menambah barang baru
if(isset($_POST['addnewbarang'])){
    $namabarang = $_POST['namabarang'];
    $type = $_POST['type'];
    $stock = $_POST['stock'];
    
    $addtotable = mysqli_query($conn, "INSERT into stock (namabarang, type, stock) values('$namabarang', '$type','$stock')");
    if($addtotable){
        header('location:index.php');
    }else{
        echo 'Gagal ';
        header('location: index.php');
    }
}

//Menambah barang masuk
if(isset($_POST['barangmasuk'])){
    $barangnya = $_POST['barangnya'];
    $keterangan = $_POST['keterangan'];
    $qty = $_POST['qty'];

    $cekstocksekarang = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang='$barangnya'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);

    $stocksekarang = $ambildatanya['stock'];
    $tambahkanstocksekarangdenganquantity = $stocksekarang+$qty;
    $addtomasuk = mysqli_query($conn, "INSERT into masuk (idbarang, keterangan, qty) values('$barangnya','$keterangan','$qty') ");
    $updatestockmasuk = mysqli_query($conn, "update stock set stock = '$tambahkanstocksekarangdenganquantity' where idbarang='$barangnya'");
    if($addtomasuk&&$updatestockmasuk){
        $cekdatauser = mysqli_query($conn, "SELECT * FROM login where email='$email' and password='$password' ");
        $ambildatanya = mysqli_fetch_array($cekdatauser);
        if($ambildatanya['role'] == 'admin'){
            header('location:masuk.php');
        }else{
            header('location:masuk2.php');
        }
    }else{
        echo 'Gagal ';
        $cekdatauser = mysqli_query($conn, "SELECT * FROM login where email='$email' and password='$password' ");
        $ambildatanya = mysqli_fetch_array($cekdatauser);
        if($ambildatanya['role'] == 'admin'){
            header('location:masuk.php');
        }else{
            header('location:masuk2.php');
        }
    }
}
//Menambah barang keluar
if(isset($_POST['addbarangkeluar'])){
    $barangnya = $_POST['barangnya'];
    $penerima = $_POST['penerima'];
    $qty = $_POST['qty'];

    $cekstocksekarang = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang='$barangnya'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);

    $stocksekarang = $ambildatanya['stock'];
    $tambahkanstocksekarangdenganquantity = $stocksekarang-$qty;
    $addtokeluar = mysqli_query($conn, "INSERT into keluar (idbarang, penerima, qty) values('$barangnya','$penerima','$qty') ");
    $updatestockmasuk = mysqli_query($conn, "update stock set stock = '$tambahkanstocksekarangdenganquantity' where idbarang='$barangnya'");
    if($addtokeluar&&$updatestockmasuk){
        $cekdatauser = mysqli_query($conn, "SELECT * FROM login where email='$email' and password='$password' ");
        $ambildatanya = mysqli_fetch_array($cekdatauser);
        if($ambildatanya['role'] == 'admin'){
            header('location:keluar.php');
        }else{
            header('location:keluar2.php');
        }
    }else{
        echo 'Gagal ';
        $cekdatauser = mysqli_query($conn, "SELECT * FROM login where email='$email' and password='$password' ");
        $ambildatanya = mysqli_fetch_array($cekdatauser);
        if($ambildatanya['role'] == 'admin'){
            header('location:keluar.php');
        }else{
            header('location:keluar2.php');
        }
    }
}
//Update info user
if(isset($_POST['updateuser'])){
    $idu= $_POST['idu'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    $update = mysqli_query($conn, "UPDATE login set username='$username', email='$email', password='$password', role='$role' WHERE iduser='$idu'");
    if($update){
        header('location:account.php');
    }else{
        echo 'Gagal';
        header('location:account.php');
    }
}

//Hapus barang dari stock
if(isset($_POST['hapususer'])){
    $idu= $_POST['idu'];

    $hapus = mysqli_query($conn, "DELETE FROM login WHERE iduser='$idu'");
    if($hapus){
        header('location:account.php');
    }else{
        echo 'Gagal';
        header('location:account.php');
    }
}

//Update info barang
if(isset($_POST['updatebarang'])){
    $idb= $_POST['idb'];
    $namabarang = $_POST['namabarang'];
    $type = $_POST['type'];
    $stock = $_POST['stock'];

    $update = mysqli_query($conn, "UPDATE stock set namabarang='$namabarang', type='$type', stock='$stock' WHERE idbarang='$idb'");
    if($update){
        header('location:index.php');
    }else{
        echo 'Gagal';
        header('location:index.php');
    }
}

//Hapus barang dari stock
if(isset($_POST['hapusbarang'])){
    $idb= $_POST['idb'];

    $hapus = mysqli_query($conn, "DELETE FROM stock WHERE idbarang='$idb'");
    if($hapus){
        header('location:index.php');
    }else{
        echo 'Gagal';
        header('location:index.php');
    }
}

//Mengubah data barang masuk
if(isset($_POST['updatebarangmasuk'])){
    $idb = $_POST['idb'];
    $idm = $_POST['idm'];
    $deskripsi = $_POST['keterangan'];
    $qty = $_POST['qty'];

    $lihatstock = mysqli_query($conn, "SELECT * FROM stock where idbarang='$idb'");
    $stocknya = mysqli_fetch_array($lihatstock);
    $stockskrg = $stocknya['stock'];

    $qtyskrg = mysqli_query($conn, "SELECT * FROM masuk where idmasuk ='$idm'");
    $qtynya = mysqli_fetch_array($qtyskrg);
    $qtyskrg = $qtynya['qty'];
    if($qty > $qtyskrg){
        $selisih = $qty - $qtyskrg;
        $kurangin = $stockskrg + $selisih;
        $kurangistocknya = mysqli_query($conn, "UPDATE stock set stock='$kurangin' where idbarang='$idb'");
        $updatenya = mysqli_query($conn, "UPDATE masuk set qty='$qty', keterangan='$deskripsi' WHERE idmasuk='$idm'");
            if($kurangistocknya&&$updatenya){
                $cekdatauser = mysqli_query($conn, "SELECT * FROM login where email='$email' and password='$password' ");
                $ambildatanya = mysqli_fetch_array($cekdatauser);
                if($ambildatanya['role'] == 'admin'){
                    header('location:masuk.php');
                }else{
                    header('location:masuk2.php');
                }
            }else{
                echo 'Gagal';
                $cekdatauser = mysqli_query($conn, "SELECT * FROM login where email='$email' and password='$password' ");
                $ambildatanya = mysqli_fetch_array($cekdatauser);
                if($ambildatanya['role'] == 'admin'){
                    header('location:masuk.php');
                }else{
                    header('location:masuk2.php');
                }
            }
    }else{
        $selisih = $qtyskrg - $qty;
        $kurangin = $stockskrg - $selisih;
        $kurangistocknya = mysqli_query($conn, "UPDATE stock set stock='$kurangin' where idbarang='$idb'");
        $updatenya = mysqli_query($conn, "UPDATE masuk set qty='$qty', keterangan='$deskripsi' WHERE idmasuk='$idm'");
            if($kurangistocknya&&$updatenya){
                $cekdatauser = mysqli_query($conn, "SELECT * FROM login where email='$email' and password='$password' ");
                $ambildatanya = mysqli_fetch_array($cekdatauser);
                if($ambildatanya['role'] == 'admin'){
                    header('location:masuk.php');
                }else{
                    header('location:masuk2.php');
                }
            }else{
                echo 'Gagal';
                $cekdatauser = mysqli_query($conn, "SELECT * FROM login where email='$email' and password='$password' ");
                $ambildatanya = mysqli_fetch_array($cekdatauser);
                if($ambildatanya['role'] == 'admin'){
                    header('location:masuk.php');
                }else{
                    header('location:masuk2.php');
                }
            }
    }
}

//Menghapus barang masuk
if(isset($_POST['hapusbarangmasuk'])){
    $idb = $_POST['idb'];
    $qty = $_POST['kty'];
    $idm = $_POST['idm'];

    $getdatastock = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang='$idb'");
    $data = mysqli_fetch_array($getdatastock);
    $stock = $data['stock'];

    $selisih = $stock-$qty;
    $update = mysqli_query($conn, "UPDATE stock set stock='$selisih' WHERE idbarang='$idb'");
    $hapusdata = mysqli_query($conn, "DELETE from masuk WHERE idmasuk='$idm'");

    if($update&&$hapusdata){
        $cekdatauser = mysqli_query($conn, "SELECT * FROM login where email='$email' and password='$password' ");
        $ambildatanya = mysqli_fetch_array($cekdatauser);
        if($ambildatanya['role'] == 'admin'){
            header('location:masuk.php');
        }else{
            header('location:masuk2.php');
        }
    }else{
        $cekdatauser = mysqli_query($conn, "SELECT * FROM login where email='$email' and password='$password' ");
        $ambildatanya = mysqli_fetch_array($cekdatauser);
        if($ambildatanya['role'] == 'admin'){
            header('location:masuk.php');
        }else{
            header('location:masuk2.php');
        }
    }
}
//Mengubah data barang keluar
if(isset($_POST['updatebarangkeluar'])){
    $idb = $_POST['idb'];
    $idk = $_POST['idk'];
    $penerima = $_POST['penerima'];
    $qty = $_POST['qty'];

    $lihatstock = mysqli_query($conn, "SELECT * FROM stock where idbarang='$idb'");
    $stocknya = mysqli_fetch_array($lihatstock);
    $stockskrg = $stocknya['stock'];

    $qtyskrg = mysqli_query($conn, "SELECT * FROM keluar where idkeluar ='$idk'");
    $qtynya = mysqli_fetch_array($qtyskrg);
    $qtyskrg = $qtynya['qty'];
    if($qty > $qtyskrg){
        $selisih = $qty - $qtyskrg;
        $kurangin = $stockskrg - $selisih;
        $kurangistocknya = mysqli_query($conn, "UPDATE stock set stock='$kurangin' where idbarang='$idb'");
        $updatenya = mysqli_query($conn, "UPDATE keluar set qty='$qty', penerima='$penerima' WHERE idkeluar='$idk'");
            if($kurangistocknya&&$updatenya){
                $cekdatauser = mysqli_query($conn, "SELECT * FROM login where email='$email' and password='$password' ");
                $ambildatanya = mysqli_fetch_array($cekdatauser);
                if($ambildatanya['role'] == 'admin'){
                    header('location:keluar.php');
                }else{
                    header('location:keluar2.php');
                }
            }else{
                echo 'Gagal';
                $cekdatauser = mysqli_query($conn, "SELECT * FROM login where email='$email' and password='$password' ");
                $ambildatanya = mysqli_fetch_array($cekdatauser);
                if($ambildatanya['role'] == 'admin'){
                    header('location:keluar.php');
                }else{
                    header('location:keluar2.php');
                }
            }
    }else{
        $selisih = $qtyskrg - $qty;
        $kurangin = $stockskrg + $selisih;
        $kurangistocknya = mysqli_query($conn, "UPDATE stock set stock='$kurangin' where idbarang='$idb'");
        $updatenya = mysqli_query($conn, "UPDATE keluar set qty='$qty', penerima='$penerima' WHERE idkeluar='$idk'");
            if($kurangistocknya&&$updatenya){
                $cekdatauser = mysqli_query($conn, "SELECT * FROM login where email='$email' and password='$password' ");
                $ambildatanya = mysqli_fetch_array($cekdatauser);
                if($ambildatanya['role'] == 'admin'){
                    header('location:keluar.php');
                }else{
                    header('location:keluar2.php');
                }
            }else{
                echo 'Gagal';
                $cekdatauser = mysqli_query($conn, "SELECT * FROM login where email='$email' and password='$password' ");
                $ambildatanya = mysqli_fetch_array($cekdatauser);
                if($ambildatanya['role'] == 'admin'){
                    header('location:keluar.php');
                }else{
                    header('location:keluar2.php');
                }
            }
    }
}

//Menghapus barang keluar
if(isset($_POST['hapusbarangkeluar'])){
    $idb = $_POST['idb'];
    $qty = $_POST['kty'];
    $idk = $_POST['idk'];

    $getdatastock = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang='$idb'");
    $data = mysqli_fetch_array($getdatastock);
    $stock = $data['stock'];

    $selisih = $stock+$qty;
    $update = mysqli_query($conn, "UPDATE stock set stock='$selisih' WHERE idbarang='$idb'");
    $hapusdata = mysqli_query($conn, "DELETE from keluar WHERE idkeluar='$idk'");

    if($update&&$hapusdata){
        $cekdatauser = mysqli_query($conn, "SELECT * FROM login where email='$email' and password='$password' ");
        $ambildatanya = mysqli_fetch_array($cekdatauser);
        if($ambildatanya['role'] == 'admin'){
            header('location:keluar.php');
        }else{
            header('location:keluar2.php');
        }
    }else{
        $cekdatauser = mysqli_query($conn, "SELECT * FROM login where email='$email' and password='$password' ");
        $ambildatanya = mysqli_fetch_array($cekdatauser);
        if($ambildatanya['role'] == 'admin'){
            header('location:keluar.php');
        }else{
            header('location:keluar2.php');
        }
    }
}
?>