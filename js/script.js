function toggleSubfolder(folderId) {
    var subfolder = document.getElementById(folderId);
    if (subfolder.style.display === 'block') {
        subfolder.style.display = 'none';
    } else {
        subfolder.style.display = 'block';
    }
}
function togglePopup() {
    var popup = document.getElementById('profilePopup');
    popup.classList.toggle('active');
}

  // untuk seacrh folder
function searchDocuments() {
    var input, filter, additionalContent, i;
    input = document.getElementById("searchInput");
    filter = input.value.toUpperCase();
    additionalContent = document.getElementsByClassName("additional-content");

    for (i = 0; i < additionalContent.length; i++) {
        var contentText = additionalContent[i].getElementsByTagName("span")[0];
        if (contentText.innerHTML.toUpperCase().indexOf(filter) > -1) {
            additionalContent[i].style.display = "";
        } else {
            additionalContent[i].style.display = "none";
        }
    }
}

function goToApprovalPage() {
    window.location.href = 'approval.php';
}

function confirmAction(action) {
    var confirmationMessage = '';
    var title = '';
    var icon = '';

    // Menyesuaikan pesan, judul, dan ikon pop-up berdasarkan aksi
    switch (action) {
        case 'info':
            // Menampilkan detail file
            Swal.fire({
                title: 'Detail File',
                html: '<b>Nama:</b> dapen.pdf<br><b>Status:</b> Menunggu<br><b>Tanggal:</b> 16 Januari 2024',
                icon: 'info'
            });
            return; // Menghindari pemanggilan Swal.fire() kedua di bawah
        default:
            confirmationMessage = 'Apakah Anda yakin ingin melanjutkan?';
            title = 'Konfirmasi';
            icon = 'warning';
    }

    // Tampilkan pop-up konfirmasi untuk aksi approve atau decline
    Swal.fire({
        title: title,
        text: confirmationMessage,
        icon: icon,
        showCancelButton: true,
        cancelButtonColor: "#d33",
        confirmButtonColor: "#3085d6",
        confirmButtonText: "Lanjut",
        cancelButtonText: "Tidak"
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                text: "Operasi berhasil dilakukan.",
                icon: "success"
            });
        }
    });
}