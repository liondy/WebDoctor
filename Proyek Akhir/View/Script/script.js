var x;
var val;
var hasilNama;
var hasilAlamat;
var hasilEmail;
var hasilPassword;
var tahun;
var bulan;
var tanggal;
var kota;

function cekTahun() {
    tahun = document.getElementById('selectYear').value;
    if (tahun != "Tahun") {
        document.getElementById('valttl').innerHTML = '';
        tahun = true;
    } else {
        document.getElementById('valttl').style.color = 'red';
        document.getElementById('valttl').innerHTML = 'Harus diisi!';
        tahun = false;
    }
}

function cekBulan() {
    bulan = document.getElementById('selectMonth').value;
    if (bulan != "Bulan") {
        document.getElementById('valttl').innerHTML = '';
        bulan = true;
    } else {
        document.getElementById('valttl').style.color = 'red';
        document.getElementById('valttl').innerHTML = 'Harus diisi!';
        bulan = false;
    }
}

function cekTanggal() {
    tanggal = document.getElementById('selectDate').value;
    if (tanggal != "Tanggal") {
        document.getElementById('valttl').innerHTML = '';
        tanggal = true;
    } else {
        document.getElementById('valttl').style.color = 'red';
        document.getElementById('valttl').innerHTML = 'Harus diisi!';
        tanggal = false;
    }
}

function cekKota() {
    kota = document.getElementById('selectKota').value;
    if (kota != "Pilih Kota") {
        document.getElementById('valttl').innerHTML = '';
        kota = true;
    } else {
        document.getElementById('valkota').style.color = 'red';
        document.getElementById('valkota').innerHTML = 'Harus diisi!';
        kota = false;
    }
}

function checkPass() {
    if (document.getElementById('pass').value.length == 0) {
        document.getElementById('require').innerHTML = '';
        return false;
    }
    if (document.getElementById('pass').value.length < 8) {
        document.getElementById('require').style.color = 'red';
        document.getElementById('require').innerHTML = 'minimal password 8 karakter';
        return false;
    } else {
        document.getElementById('require').style.color = 'green';
        document.getElementById('require').innerHTML = '8 karakter';
        return true;
    }
}

function checkRePass() {
    if (document.getElementById('repass').value.length == 0) {
        document.getElementById('message').innerHTML = '';
        return false;
    }
    if (document.getElementById('pass').value == document.getElementById('repass').value) {
        document.getElementById('message').style.color = 'green';
        document.getElementById('message').innerHTML = 'match';
        return true;
    } else {
        document.getElementById('message').style.color = 'red';
        document.getElementById('message').innerHTML = 'not match';
        return false;
    }
}

function checkuser() {
    if (document.getElementById('username').value.length > 12) {
        document.getElementById('userlength').style.color = 'red';
        document.getElementById('userlength').innerHTML = 'username terlalu panjang';
        return false;
    } else {
        document.getElementById('userlength').innerHTML = '';
        return true;
    }
}

function check() {
    x = document.querySelectorAll("#formsignup input");
    validate();
    cekTahun();
    cekBulan();
    cekTanggal();
    cekKota();
    var y = document.getElementById('userauth');
    if (hasilNama && hasilAlamat && hasilEmail && tahun && bulan && tanggal && kota && checkuser() && checkPass() && checkRePass() && hasilPassword && y.innerHTML == "username tersedia") {
        return true;
    }
    return false;
}

function validate() {
    val = new SignUp(x[0], x[1], x[2], x[3], x[4], x[5]);
    hasilNama = val.validateNama();
    hasilAlamat = val.validateAlamat();
    hasilUsername = val.validateUsername();
    hasilEmail = val.validateEmail();
    hasilPassword = val.validatePassword();
}