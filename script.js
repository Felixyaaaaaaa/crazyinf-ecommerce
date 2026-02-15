function tampilkanOpsi() {
  const metode = document.getElementById("metode").value;
  const opsiBank = document.getElementById("opsi-bank");
  const opsiEwallet = document.getElementById("opsi-ewallet");
  const info = document.getElementById("info-pembayaran");
  const finalInput = document.getElementById("opsi_pembayaran_final");

  opsiBank.classList.add("d-none");
  opsiEwallet.classList.add("d-none");
  info.classList.add("d-none");
  info.innerHTML = "";
  finalInput.value = "";

  if (metode === "bank") {
    opsiBank.classList.remove("d-none");
  } else if (metode === "ewallet") {
    opsiEwallet.classList.remove("d-none");
  }
}

function tampilkanInfoPembayaran(tipe) {
  const selectedValue = document.getElementById(tipe).value;
  const info = document.getElementById("info-pembayaran");
  const finalInput = document.getElementById("opsi_pembayaran_final");

  const nomor = {
    BCA: "1234567890 (a.n. PT CRAZY.IN BCA)",
    BNI: "9876543210 (a.n. PT CRAZY.IN BNI)",
    Mandiri: "1122334455 (a.n. PT CRAZY.IN Mandiri)",
    BRI: "5566778899 (a.n. PT CRAZY.IN BRI)",
    OVO: "081234567890 (a.n. CRAZY.IN OVO)",
    DANA: "089876543210 (a.n. CRAZY.IN DANA)",
    Gopay: "085678901234 (a.n. CRAZY.IN GOPAY)",
    ShopeePay: "082345678901 (a.n. CRAZY.IN SHOPEEPAY)"
  };

  if (selectedValue && nomor[selectedValue]) {
    info.innerHTML = `<strong>Silakan transfer ke:</strong><br>${nomor[selectedValue]}`;
    info.classList.remove("d-none");
    finalInput.value = selectedValue; // ini yang dikirim ke backend
    console.log(finalInput.value);

  } else {
    info.classList.add("d-none");
    info.innerHTML = "";
    finalInput.value = "";
    console.log(finalInput.value);
  }
}


function tampilkanOpsi() {
  const metode = document.getElementById("metode").value;
  const opsiBank = document.getElementById("opsi-bank");
  const opsiEwallet = document.getElementById("opsi-ewallet");
  const info = document.getElementById("info-pembayaran");
  const finalInput = document.getElementById("opsi_pembayaran_final");

  const bankSelect = document.getElementById("bank");
  const ewalletSelect = document.getElementById("ewallet");

  // Reset semua tampilan dan required
  opsiBank.classList.add("d-none");
  opsiEwallet.classList.add("d-none");
  info.classList.add("d-none");
  info.innerHTML = "";
  finalInput.value = "";

  bankSelect.required = false;
  ewalletSelect.required = false;

  // Tampilkan berdasarkan metode yang dipilih
  if (metode === "bank") {
    opsiBank.classList.remove("d-none");
    bankSelect.required = true; // <- wajib isi bank
  } else if (metode === "ewallet") {
    opsiEwallet.classList.remove("d-none");
    ewalletSelect.required = true; // <- wajib isi e-wallet
  }
}

