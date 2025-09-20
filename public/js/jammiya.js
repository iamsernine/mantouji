        const menuBtnx = document.getElementById('menu-toggle');
        const menuBtn = document.getElementById('menu-toggle');
        const sidebar = document.getElementById('sidebar');
        const openModalBtn = document.getElementById('openModal');
        const modal = document.getElementById('productModal');
        const closeModalBtn = document.getElementById('closeModal');

        menuBtnx.addEventListener('click', () => {
            sidebar.classList.toggle('open');
        });

        openModalBtn.addEventListener('click', () => {
            modal.style.display = 'flex';
        });

        closeModalBtn.addEventListener('click', () => {
            modal.style.display = 'none';
        });

        // Ila kliki barra men modal, tsed
        window.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.style.display = 'none';
            }
        });

