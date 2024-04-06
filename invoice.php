<button type="button" class="btn btn-primary" onclick="tampilkanModalJenisPembayaran()" data-bs-toggle="modal" data-bs-target="#modalJenisPembayaran">
    Pilih Jenis Pembayaran
</button>

<div class="modal fade" id="modalJenisPembayaran" tabindex="-1" aria-labelledby="modalJenisPembayaranLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalJenisPembayaranLabel">Jenis Pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="list-group">
                    <li class="list-group-item">
                        <input type="radio" name="jenisPembayaran" value="tunai" checked> Tunai
                    </li>
                    <li class="list-group-item">
                        <input type="radio" name="jenisPembayaran" value="transfer"> Transfer Bank
                    </li>
                    <li class="list-group-item">
                        <input type="radio" name="jenisPembayaran" value="kartu_kredit"> Kartu Kredit
                    </li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="tutupModalJenisPembayaran()">Batal</button>
                <button type="button" class="btn btn-primary" onclick="simpanJenisPembayaran()">Simpan</button>
            </div>
        </div>
    </div>
</div>
<script>
    // Untuk menampilkan modal
    function tampilkanModalJenisPembayaran() {
        var modal = document.getElementById("modalJenisPembayaran");
        modal.style.display = "block";
    }

    // Untuk menutup modal
    function tutupModalJenisPembayaran() {
        var modal = document.getElementById("modalJenisPembayaran");
        modal.style.display = "none";
    }

    // Memanggil fungsi tampilkanModalJenisPembayaran() saat tombol ditekan
    document.getElementById("myBtn").addEventListener("click", tampilkanModalJenisPembayaran);

    // Memanggil fungsi tutupModalJenisPembayaran() saat tombol close ditekan
    document.getElementsByClassName("btn-close")[0].addEventListener("click", tutupModalJenisPembayaran);

    // Memanggil fungsi tutupModalJenisPembayaran() saat area luar modal ditekan
    window.addEventListener("click", function(event) {
        if (event.target == modal) {
            tutupModalJenisPembayaran();
        }
    });
</script>