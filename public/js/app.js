function confirmDelete(event) {
    event.preventDefault(); // Prevent the form from submitting immediately
    const form = event.target; // The form that was submitted

    Swal.fire({
        title: 'Apakah Anda Yakin?',
        text: "Data yang dihapus tidak dapat dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: 'var(--danger)',
        cancelButtonColor: 'var(--primary)',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal',
        customClass: {
            popup: 'swal-custom'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit(); // If confirmed, submit the form
        }
    });
}

document.addEventListener('DOMContentLoaded', function() {
    // Dark/Light Mode Toggle
    const themeToggle = document.getElementById('theme-toggle');
    if (themeToggle) {
        themeToggle.addEventListener('click', (e) => {
            e.preventDefault();
            document.body.classList.toggle('dark-mode');
            let theme = 'light';
            if (document.body.classList.contains('dark-mode')) {
                theme = 'dark';
            }
            document.cookie = `farms_theme=${theme};path=/;max-age=${60*60*24*365}`;
        });
    }

    // Sidebar Toggle for Mobile
    const sidebarToggle = document.getElementById('sidebar-toggle');
    const sidebar = document.querySelector('.sidebar');
    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', () => {
            sidebar.classList.toggle('open');
        });
    }

    // Session Timeout Warning
    let timeoutWarningTimer;
    let logoutTimer;
    const IDLE_TIMEOUT = 30 * 60 * 1000; // 30 minutes
    const WARNING_TIME = 1 * 60 * 1000;  // 1 minute warning

    function resetTimers() {
        clearTimeout(timeoutWarningTimer);
        clearTimeout(logoutTimer);
        timeoutWarningTimer = setTimeout(showTimeoutWarning, IDLE_TIMEOUT - WARNING_TIME);
        logoutTimer = setTimeout(logoutUser, IDLE_TIMEOUT);
    }

    function showTimeoutWarning() {
        Swal.fire({
            title: 'Sesi Akan Berakhir!',
            html: 'Sesi Anda akan berakhir dalam <b>1 menit</b> karena tidak ada aktivitas.<br>Apakah Anda ingin melanjutkan?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Lanjutkan Sesi',
            cancelButtonText: 'Logout',
            timer: WARNING_TIME,
            timerProgressBar: true,
        }).then((result) => {
            if (result.isConfirmed) {
                // Ping server to extend session
                fetch(BASE_URL + 'ping').then(() => {
                    resetTimers();
                    Swal.fire('Sesi Dilanjutkan!', 'Sesi Anda telah diperpanjang.', 'success');
                });
            } else if (result.dismiss === Swal.DismissReason.timer || result.dismiss === Swal.DismissReason.cancel) {
                logoutUser();
            }
        });
    }

    function logoutUser() {
        window.location.href = BASE_URL + 'logout';
    }

    // Attach event listeners to reset timers on user activity
    ['mousemove', 'keydown', 'scroll', 'click'].forEach(event => {
        document.addEventListener(event, resetTimers);
    });

    // Initial timer start
    if (document.querySelector('.sidebar')) { // Only run timers if logged in
        resetTimers();
    }
});