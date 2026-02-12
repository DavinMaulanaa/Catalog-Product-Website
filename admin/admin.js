// ===== COLLARBONE ADMIN PANEL - JavaScript =====

// ===== SIDEBAR TOGGLE (Mobile) =====
function initSidebar() {
    const menuBtn = document.querySelector('.mobile-menu-btn');
    const sidebar = document.querySelector('.sidebar');
    const overlay = document.querySelector('.sidebar-overlay');

    if (menuBtn) {
        menuBtn.addEventListener('click', () => {
            sidebar.classList.toggle('open');
            overlay.classList.toggle('active');
        });
    }

    if (overlay) {
        overlay.addEventListener('click', () => {
            sidebar.classList.remove('open');
            overlay.classList.remove('active');
        });
    }
}

// ===== TOAST NOTIFICATION =====
function showToast(message, type = 'success') {
    const container = document.querySelector('.toast-container') || createToastContainer();

    const iconSvg = {
        success: `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="toast-icon" style="color:var(--success)"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>`,
        error: `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="toast-icon" style="color:var(--danger)"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>`,
        info: `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="toast-icon" style="color:var(--info)"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>`,
    };

    const toast = document.createElement('div');
    toast.className = `toast ${type}`;
    toast.innerHTML = `
    ${iconSvg[type] || iconSvg.info}
    <span class="toast-message">${message}</span>
    <button class="toast-close" onclick="this.parentElement.remove()">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
    </button>
  `;

    container.appendChild(toast);

    setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transform = 'translateX(20px)';
        toast.style.transition = 'all 0.3s ease';
        setTimeout(() => toast.remove(), 300);
    }, 4000);
}

function createToastContainer() {
    const container = document.createElement('div');
    container.className = 'toast-container';
    document.body.appendChild(container);
    return container;
}

// ===== MODAL FUNCTIONS =====
function openModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
    }
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.remove('active');
        document.body.style.overflow = '';
    }
}

// Close modal on overlay click
document.addEventListener('click', (e) => {
    if (e.target.classList.contains('modal-overlay')) {
        e.target.classList.remove('active');
        document.body.style.overflow = '';
    }
});

// Close modal on Escape key
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        const openModals = document.querySelectorAll('.modal-overlay.active');
        openModals.forEach(modal => {
            modal.classList.remove('active');
        });
        document.body.style.overflow = '';
    }
});

// ===== TOGGLE SWITCH =====
function initToggles() {
    document.querySelectorAll('.toggle').forEach(toggle => {
        toggle.addEventListener('click', () => {
            toggle.classList.toggle('active');
        });
    });
}

// ===== DELETE CONFIRMATION =====
function confirmDelete(itemName) {
    return confirm(`Are you sure you want to delete "${itemName}"? This action cannot be undone.`);
}

// ===== PRODUCT TABLE ACTIONS =====
function editProduct(id) {
    openModal('editProductModal');
    showToast(`Editing product #${id}`, 'info');
}

function deleteProduct(id, name) {
    if (confirmDelete(name)) {
        showToast(`"${name}" has been deleted`, 'error');
        // In a real app, this would make an API call
        const row = document.querySelector(`[data-product-id="${id}"]`);
        if (row) {
            row.style.opacity = '0';
            row.style.transform = 'translateX(-10px)';
            row.style.transition = 'all 0.3s ease';
            setTimeout(() => row.remove(), 300);
        }
    }
}

function duplicateProduct(id, name) {
    showToast(`"${name}" has been duplicated`, 'success');
}

// ===== HERO SLIDE ACTIONS =====
function editSlide(index) {
    openModal('editSlideModal');
    showToast(`Editing slide #${index}`, 'info');
}

function deleteSlide(index) {
    if (confirmDelete(`Slide #${index}`)) {
        showToast(`Slide #${index} has been deleted`, 'error');
    }
}

// ===== CATEGORY ACTIONS =====
function editCategory(id) {
    openModal('editCategoryModal');
    showToast(`Editing category #${id}`, 'info');
}

function deleteCategory(id, name) {
    if (confirmDelete(name)) {
        showToast(`Category "${name}" has been deleted`, 'error');
    }
}

// ===== FILE UPLOAD PREVIEW =====
function initImageUpload() {
    document.querySelectorAll('.image-upload-area').forEach(area => {
        const input = area.querySelector('input[type="file"]');
        const previewGrid = area.parentElement.querySelector('.image-preview-grid');

        if (!input) return;

        area.addEventListener('click', () => input.click());

        area.addEventListener('dragover', (e) => {
            e.preventDefault();
            area.style.borderColor = 'var(--accent-teal)';
            area.style.background = 'var(--accent-teal-glow)';
        });

        area.addEventListener('dragleave', () => {
            area.style.borderColor = '';
            area.style.background = '';
        });

        area.addEventListener('drop', (e) => {
            e.preventDefault();
            area.style.borderColor = '';
            area.style.background = '';
            handleFiles(e.dataTransfer.files, previewGrid);
        });

        input.addEventListener('change', () => {
            handleFiles(input.files, previewGrid);
        });
    });
}

function handleFiles(files, previewGrid) {
    if (!previewGrid) return;

    Array.from(files).forEach(file => {
        if (!file.type.startsWith('image/')) return;

        const reader = new FileReader();
        reader.onload = (e) => {
            const item = document.createElement('div');
            item.className = 'image-preview-item';
            item.innerHTML = `
        <img src="${e.target.result}" alt="Preview">
        <button class="remove-btn" onclick="this.parentElement.remove()">×</button>
      `;
            previewGrid.appendChild(item);
        };
        reader.readAsDataURL(file);
    });
}

// ===== SEARCH FUNCTIONALITY =====
function initSearch() {
    const searchInputs = document.querySelectorAll('.topbar-search input, .table-search input');
    searchInputs.forEach(input => {
        input.addEventListener('input', (e) => {
            const query = e.target.value.toLowerCase();
            const table = document.querySelector('.data-table');
            if (!table) return;

            table.querySelectorAll('tbody tr').forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(query) ? '' : 'none';
            });
        });
    });
}

// ===== TAB SWITCHING =====
function initTabs() {
    document.querySelectorAll('.tabs').forEach(tabGroup => {
        const tabs = tabGroup.querySelectorAll('.tab');
        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                tabs.forEach(t => t.classList.remove('active'));
                tab.classList.add('active');

                const target = tab.dataset.tab;
                if (target) {
                    const panels = tab.closest('.card, .page-content')
                        .querySelectorAll('.tab-panel');
                    panels.forEach(panel => {
                        panel.style.display = panel.id === target ? 'block' : 'none';
                    });
                }
            });
        });
    });
}

// ===== CHART ANIMATION =====
function initCharts() {
    document.querySelectorAll('.chart-bar').forEach((bar, index) => {
        setTimeout(() => {
            bar.style.transition = 'height 0.8s cubic-bezier(0.16, 1, 0.3, 1)';
            bar.style.height = bar.dataset.height || bar.style.height;
        }, index * 80);
    });
}

// ===== SCROLL ANIMATIONS =====
function initScrollAnimations() {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1, rootMargin: '0px' });

    document.querySelectorAll('.fade-in, .slide-in-up').forEach(el => {
        observer.observe(el);
    });
}

// ===== INIT =====
document.addEventListener('DOMContentLoaded', () => {
    initSidebar();
    initToggles();
    initImageUpload();
    initSearch();
    initTabs();
    initCharts();
    initScrollAnimations();
});
