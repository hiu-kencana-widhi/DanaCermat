import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

const submitIntentMeta = {
    login: {
        title: 'Memverifikasi akun',
        description: 'Menyiapkan dashboard yang paling relevan untuk Anda.',
    },
    logout: {
        title: 'Menutup sesi',
        description: 'Sesi Anda sedang diamankan sebelum keluar.',
    },
    create: {
        title: 'Menyimpan data baru',
        description: 'Perubahan baru sedang dirapikan agar segera tampil.',
    },
    update: {
        title: 'Memperbarui data',
        description: 'Versi terbaru sedang diterapkan ke halaman Anda.',
    },
    delete: {
        title: 'Menghapus data',
        description: 'Data akan dilepas dengan aman dari tampilan Anda.',
    },
    default: {
        title: 'Memproses permintaan',
        description: 'Tunggu sebentar, kami sedang menyelesaikannya.',
    },
};

document.addEventListener('DOMContentLoaded', () => {
    if (window.requestIdleCallback) {
        requestIdleCallback(() => initAnimatedForms(), { timeout: 1000 });
    } else {
        setTimeout(() => initAnimatedForms(), 1);
    }
}, { once: true, passive: true });

function initAnimatedForms() {
    document.body.addEventListener('submit', (event) => {
        const form = event.target;
        
        if (form.tagName !== 'FORM' || shouldSkipFormAnimation(form)) return;

        /**
         * LOGIKA KRUSIAL:
         * Jika form sudah dikonfirmasi (untuk yang ada data-confirm) 
         * ATAU sudah dalam proses animasi (untuk form biasa),
         * biarkan browser melanjutkan pengiriman data ke server.
         */
        if (form.dataset.appConfirmed === 'true' || form.dataset.appSubmitting === 'true') {
            return;
        }

        // Hentikan submit awal untuk memberikan ruang animasi/konfirmasi
        event.preventDefault();

        // Tangani konfirmasi jika ada atribut data-confirm
        if (form.dataset.confirm) {
            const submitter = event.submitter || findSubmitter(form);
            
            openConfirmDialog({
                title: form.dataset.confirmTitle || 'Konfirmasi tindakan',
                message: form.dataset.confirm,
                confirmLabel: form.dataset.confirmButton || 'Lanjutkan',
                cancelLabel: form.dataset.cancelButton || 'Batal',
            }).then(confirmed => {
                if (confirmed) {
                    form.dataset.appConfirmed = 'true';
                    activateAnimatedSubmission(form, submitter);
                }
            });
            return;
        }

        // Jalankan animasi pengiriman untuk form standar
        activateAnimatedSubmission(form, event.submitter || findSubmitter(form));
    }, { passive: false });
}

function shouldSkipFormAnimation(form) {
    return form.dataset.noAnimate === 'true' || resolveFormMethod(form) === 'GET';
}

function activateAnimatedSubmission(form, submitter) {
    // Set flag bahwa animasi sudah dimulai
    form.dataset.appSubmitting = 'true';

    const intent = resolveSubmitIntent(form);
    const title = form.dataset.submitLabel
        || (intent === 'login' || intent === 'logout' || intent === 'delete'
            ? submitIntentMeta[intent].title
            : getButtonText(submitter))
        || submitIntentMeta[intent]?.title
        || submitIntentMeta.default.title;

    const description = form.dataset.submitSubtitle
        || submitIntentMeta[intent]?.description
        || submitIntentMeta.default.description;

    lockSubmitButtons(form, submitter);
    showSubmitOverlay({ title, description });

    const submitDelay = prefersReducedMotion ? 0 : (parseInt(form.dataset.submitDelay) || 160);

    window.setTimeout(() => {
        try {
            // Memicu kembali submit event. Karena appSubmitting sudah 'true', 
            // di pemanggilan kedua ini form akan lolos ke server.
            if (typeof form.requestSubmit === 'function') {
                form.requestSubmit(submitter);
            } else {
                form.submit();
            }
        } catch (e) {
            form.submit();
        }
    }, submitDelay);
}

function resolveSubmitIntent(form) {
    if (form.dataset.submitIntent) return form.dataset.submitIntent;

    const action = form.getAttribute('action') || '';
    const path = action.toLowerCase();
    const method = resolveFormMethod(form);

    if (path.includes('/login')) return 'login';
    if (path.includes('/logout')) return 'logout';
    if (method === 'DELETE') return 'delete';
    if (method === 'PUT' || method === 'PATCH') return 'update';
    if (method === 'POST') return 'create';

    return 'default';
}

function resolveFormMethod(form) {
    const spoofedMethod = form.querySelector('input[name="_method"]')?.value;
    return (spoofedMethod || form.getAttribute('method') || 'GET').toUpperCase();
}

function findSubmitter(form) {
    return form.querySelector('button[type="submit"], input[type="submit"]');
}

function lockSubmitButtons(form, submitter) {
    const submitButtons = form.querySelectorAll('button[type="submit"], input[type="submit"]');

    submitButtons.forEach((button) => {
        button.style.pointerEvents = 'none';
        button.setAttribute('aria-busy', 'true');
        button.classList.add('app-submit-button-loading');

        if (button instanceof HTMLButtonElement) {
            if (!button.dataset.originalHtml) {
                button.dataset.originalHtml = button.innerHTML;
            }

            const label = button === submitter
                ? getButtonText(button) || 'Memproses'
                : 'Memproses';

            button.innerHTML = `
                <span class="app-submit-button-label">
                    <span class="app-inline-spinner" aria-hidden="true"></span>
                    <span>${escapeHtml(label)}</span>
                </span>
            `;
        } else if (button instanceof HTMLInputElement) {
            if (!button.dataset.originalValue) {
                button.dataset.originalValue = button.value;
            }
            button.value = 'Memproses...';
        }
    });
}

let submitOverlayElement;

function showSubmitOverlay({ title, description }) {
    if (!submitOverlayElement) {
        submitOverlayElement = createSubmitOverlay();
        document.body.appendChild(submitOverlayElement);
    }

    submitOverlayElement.querySelector('[data-submit-title]').textContent = title;
    submitOverlayElement.querySelector('[data-submit-description]').textContent = description;
    
    requestAnimationFrame(() => {
        submitOverlayElement.classList.add('is-visible');
    });
}

function createSubmitOverlay() {
    const overlay = document.createElement('div');
    overlay.className = 'app-submit-overlay';
    // Pastikan posisi tetap di tengah layar meskipun CSS eksternal bermasalah
    overlay.style.cssText = 'position:fixed;inset:0;z-index:99999;display:none;align-items:center;justify-content:center;background:rgba(2,6,23,0.8);backdrop-filter:blur(8px);-webkit-backdrop-filter:blur(8px);';
    
    overlay.setAttribute('aria-hidden', 'true');
    overlay.innerHTML = `
        <div class="app-submit-card" style="transform: scale(0.98); opacity: 0; transition: all 0.2s ease-out;">
            <div class="relative flex items-center gap-6 p-8 bg-slate-900 border border-white/5 rounded-[2.5rem] shadow-2xl">
                <div class="relative flex h-20 w-20 items-center justify-center rounded-[2rem] bg-blue-500/10 text-blue-400">
                    <span class="app-submit-spinner" style="width:3.5rem; height:3.5rem; border:4px solid rgba(59,130,246,0.1); border-top-color:#3b82f6; border-radius:9999px; animation:app-spin 0.6s linear infinite;"></span>
                </div>

                <div class="relative min-w-0">
                    <p class="text-[11px] font-black uppercase tracking-[0.3em] text-blue-400/80">Mohon tunggu</p>
                    <p data-submit-title class="mt-2 text-2xl font-black text-white leading-tight"></p>
                    <p data-submit-description class="mt-2 text-sm font-medium leading-6 text-slate-400"></p>
                </div>
            </div>
        </div>
    `;

    return overlay;
}

let confirmDialogElements;

function createConfirmDialog() {
    const backdrop = document.createElement('div');
    backdrop.style.cssText = 'position:fixed;inset:0;z-index:99999;display:none;align-items:center;justify-content:center;background:rgba(2,6,23,0.7);backdrop-filter:blur(12px);-webkit-backdrop-filter:blur(12px);padding:1.5rem;';
    
    backdrop.innerHTML = `
        <div class="bg-white dark:bg-slate-900 w-full max-w-md rounded-[2.5rem] shadow-2xl relative overflow-hidden transform transition-all duration-300 scale-95 opacity-0" 
             style="border: 1px solid rgba(255,255,255,0.05);"
             data-confirm-card
             role="dialog" 
             aria-modal="true">
            <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-blue-500 to-indigo-600"></div>
            
            <div class="p-10 sm:p-12">
                <div class="mb-10">
                    <h2 data-confirm-title class="text-3xl font-black text-slate-800 dark:text-white leading-tight"></h2>
                    <p data-confirm-message class="text-base font-medium text-slate-500 dark:text-slate-400 mt-3 leading-relaxed"></p>
                </div>

                <div class="flex flex-col-reverse sm:flex-row sm:justify-end gap-4">
                    <button type="button" data-confirm-cancel class="inline-flex justify-center items-center rounded-2xl px-8 py-4 text-sm font-bold text-slate-500 hover:text-slate-800 dark:text-slate-400 dark:hover:text-white transition-colors">
                        Batal
                    </button>
                    <button type="button" data-confirm-accept class="inline-flex justify-center items-center rounded-2xl bg-blue-600 px-10 py-4 text-sm font-black text-white shadow-xl shadow-blue-900/20 transition hover:bg-blue-700 hover:-translate-y-1 active:translate-y-0 focus:outline-none focus:ring-4 focus:ring-blue-500/20">
                        Lanjutkan
                    </button>
                </div>
            </div>
        </div>
    `;

    const card = backdrop.querySelector('[data-confirm-card]');
    const elements = {
        backdrop,
        card,
        title: backdrop.querySelector('[data-confirm-title]'),
        message: backdrop.querySelector('[data-confirm-message]'),
        confirm: backdrop.querySelector('[data-confirm-accept]'),
        cancel: backdrop.querySelector('[data-confirm-cancel]'),
        resolve: null,
    };

    const openDialog = () => {
        backdrop.style.display = 'flex';
        document.documentElement.classList.add('overflow-hidden');
        document.body.classList.add('overflow-hidden');
        
        requestAnimationFrame(() => {
            card.classList.remove('scale-95', 'opacity-0');
            card.classList.add('scale-100', 'opacity-100');
            elements.confirm.focus();
        });
    };

    const closeDialog = (value) => {
        if (typeof confirmDialogElements.resolve === 'function') {
            confirmDialogElements.resolve(value);
            confirmDialogElements.resolve = null;
        }

        card.classList.remove('scale-100', 'opacity-100');
        card.classList.add('scale-95', 'opacity-0');

        window.setTimeout(() => {
            backdrop.style.display = 'none';
            document.documentElement.classList.remove('overflow-hidden');
            document.body.classList.remove('overflow-hidden');
        }, 200);
    };

    elements.confirm.addEventListener('click', () => {
        elements.confirm.style.pointerEvents = 'none';
        elements.confirm.innerHTML = '<span class="app-inline-spinner mr-2"></span> Memproses...';
        closeDialog(true);
    });
    
    elements.cancel.addEventListener('click', () => closeDialog(false));

    backdrop.addEventListener('click', (event) => {
        if (event.target === backdrop) closeDialog(false);
    });

    return { ...elements, openDialog };
}

async function openConfirmDialog({ title, message, confirmLabel, cancelLabel }) {
    if (!confirmDialogElements) {
        confirmDialogElements = createConfirmDialog();
        document.body.appendChild(confirmDialogElements.backdrop);
    }

    confirmDialogElements.title.textContent = title;
    confirmDialogElements.message.textContent = message;
    confirmDialogElements.confirm.textContent = confirmLabel;
    confirmDialogElements.cancel.textContent = cancelLabel;
    
    confirmDialogElements.confirm.style.pointerEvents = 'auto';
    confirmDialogElements.confirm.innerHTML = confirmLabel;

    confirmDialogElements.openDialog();

    return new Promise((resolve) => {
        confirmDialogElements.resolve = resolve;
    });
}

function getButtonText(button) {
    if (!button) return '';
    if (button instanceof HTMLInputElement) return button.value.trim();
    return button.textContent.replace(/\s+/g, ' ').trim();
}

function escapeHtml(value) {
    return value
        .replaceAll('&', '&amp;')
        .replaceAll('<', '&lt;')
        .replaceAll('>', '&gt;')
        .replaceAll('"', '&quot;')
        .replaceAll("'", '&#039;');
}
