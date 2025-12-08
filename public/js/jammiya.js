// Vérification et gestion du menu sidebar
const menuBtnx = document.getElementById('menu-toggle');
const sidebar = document.getElementById('sidebar');

if (menuBtnx && sidebar) {
    menuBtnx.addEventListener('click', () => {
        sidebar.classList.toggle('open');
    });
}

// Vérification et gestion du modal produit
const openModalBtn = document.getElementById('openModal');
const modal = document.getElementById('productModal');
const closeModalBtn = document.getElementById('closeModal');

if (openModalBtn && modal && closeModalBtn) {
    openModalBtn.addEventListener('click', () => {
        modal.style.display = 'flex';
    });

    closeModalBtn.addEventListener('click', () => {
        modal.style.display = 'none';
    });

    // Fermer le modal si on clique en dehors
    window.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.style.display = 'none';
        }
    });
}

// Prévisualisation de l'image uploadée
const imageInput = document.getElementById("imageInput");
const previewImage = document.getElementById("previewImage");

if (imageInput && previewImage) {
    imageInput.addEventListener("change", function(event) {
        const file = event.target.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                previewImage.style.display = "block";
            }
            reader.readAsDataURL(file);
        } else {
            previewImage.src = "";
            previewImage.style.display = "none";
        }
    });
}

// Fonction pour afficher/masquer les commentaires
function toggleComments(id) {
    let box = document.getElementById(id);
    if (box) {
        if (box.style.display === "none" || box.style.display === "") {
            box.style.opacity = 0;
            box.style.display = "block";
            setTimeout(() => box.style.opacity = 1, 10);
        } else {
            box.style.opacity = 0;
            setTimeout(() => box.style.display = "none", 300);
        }
    }
}
