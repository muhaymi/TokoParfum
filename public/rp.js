function titik(number) {
  return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

function terbilang(number) {
  var satuan = [
    "",
    "Satu",
    "Dua",
    "Tiga",
    "Empat",
    "Lima",
    "Enam",
    "Tujuh",
    "Delapan",
    "Sembilan",
    "Sepuluh",
    "Sebelas",
  ];

  function toWords(num) {
    if (num < 12) {
      return satuan[num];
    } else if (num < 20) {
      return satuan[num - 10] + " Belas";
    } else if (num < 100) {
      return satuan[Math.floor(num / 10)] + " Puluh " + satuan[num % 10];
    } else if (num < 200) {
      return "Seratus " + toWords(num - 100);
    } else if (num < 1000) {
      return satuan[Math.floor(num / 100)] + " Ratus " + toWords(num % 100);
    } else if (num < 2000) {
      return "Seribu " + toWords(num - 1000);
    } else if (num < 1000000) {
      return toWords(Math.floor(num / 1000)) + " Ribu " + toWords(num % 1000);
    } else if (num < 1000000000) {
      return (
        toWords(Math.floor(num / 1000000)) + " Juta " + toWords(num % 1000000)
      );
    } else if (num < 1000000000000) {
      return (
        toWords(Math.floor(num / 1000000000)) +
        " Milyar " +
        toWords(num % 1000000000)
      );
    } else if (num < 1000000000000000) {
      return (
        toWords(Math.floor(num / 1000000000000)) +
        " Triliun " +
        toWords(num % 1000000000000)
      );
    } else {
      return "Angka terlalu besar";
    }
  }

  return toWords(number) + " Rupiah";
}

function getKasirName(id) {
  for (var i = 0; i < userData.length; i++) {
    if (id == userData[i]["id"]) {
      return userData[i]["username"];
    }
  }
  return "";
}

function getProdukName(id) {
  for (var i = 0; i < produkData.length; i++) {
    if (id == produkData[i]["id_produk"]) {
      return produkData[i]["nama_produk"];
    }
  }
  return "";
}

function getTokoName(id) {
  for (var i = 0; i < tokoData.length; i++) {
    if (id == tokoData[i]["id_toko"]) {
      return tokoData[i]["nama_toko"];
    }
  }
  return "";
}

function getMemberName(id) {
  for (var i = 0; i < memberData.length; i++) {
    if (id == memberData[i]["id_member"]) {
      return memberData[i]["nama_member"];
    }
  }
  for (var i = 0; i < tokoData.length; i++) {
    if (id == tokoData[i]["id_toko"]) {
      return tokoData[i]["nama_toko"];
    }
  }
  return "";
}

function ubahNilai() {
  function generateRandomNumber(length) {
    return Math.floor(Math.random() * Math.pow(10, length));
  }

  function calculateCheckDigit(angka12Digit) {
    var total = 0;
    for (var i = 0; i < angka12Digit.length; i++) {
      var digit = parseInt(angka12Digit[i]);
      total += i % 2 === 0 ? digit : digit * 3;
    }
    var checkDigit = (10 - (total % 10)) % 10;
    return checkDigit.toString();
  }

  function generateEAN13ID() {
    var angka12Digit = generateRandomNumber(12).toString();
    var digitKontrol = calculateCheckDigit(angka12Digit);
    return angka12Digit + digitKontrol;
  }

  var nilai = generateEAN13ID();

  document.getElementById("id_member").value = nilai;
}
