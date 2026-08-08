import './bootstrap';

import * as bootstrap from 'bootstrap';
window.bootstrap = bootstrap;

// Ensure Bootstrap components have instances created on DOM ready so
// calls like `getOrCreateInstance(...).hide()` don't hit null returns.
document.addEventListener('DOMContentLoaded', function () {
	try {
		const { Modal, Offcanvas, Tooltip, Toast, Collapse, Dropdown } = window.bootstrap || {};

		if (Modal) {
			document.querySelectorAll('.modal').forEach(el => {
				// create instance if one doesn't exist yet
				if (!Modal.getInstance(el)) new Modal(el);
			});
		}

		if (Offcanvas) {
			document.querySelectorAll('.offcanvas').forEach(el => {
				if (!Offcanvas.getInstance(el)) new Offcanvas(el);
			});
		}

		if (Tooltip) {
			document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => {
				if (!Tooltip.getInstance(el)) new Tooltip(el, { html: true });
			});
		}

		if (Toast) {
			document.querySelectorAll('.toast').forEach(el => {
				if (!Toast.getInstance(el)) new Toast(el);
			});
		}

		if (Collapse) {
            document.querySelectorAll('.collapse').forEach(el => {
                if (!Collapse.getInstance(el)) new Collapse(el, { toggle: false });
            });
            }

		if (Dropdown) {
			document.querySelectorAll('[data-bs-toggle="dropdown"]').forEach(el => {
				// Dropdowns create on demand; instantiate to be safe
				const menu = el.closest('.dropdown');
				if (menu) {
					const toggle = el;
					if (!Dropdown.getInstance(toggle)) new Dropdown(toggle);
				}
			});
		}
	} catch (e) {
		// don't break the app if initialization fails; log for debugging
		console.error('Bootstrap auto-init error', e);
	}
	// If an element inside a hidden modal retained focus (e.g. via `autofocus`),
	// blur it to avoid browser aria-hidden warnings about focused descendants.
	try {
		document.querySelectorAll('.modal[aria-hidden="true"]').forEach(modal => {
			if (modal.contains(document.activeElement)) {
				try {
					document.activeElement.blur();
				} catch (_) {
					// ignore
				}
			}
		});

		// When any modal hides, ensure no focused element is left inside it.
		document.querySelectorAll('.modal').forEach(modal => {
			modal.addEventListener('hidden.bs.modal', () => {
				if (modal.contains(document.activeElement)) {
					try { document.activeElement.blur(); } catch (_) {}
				}
			});
		});
	} catch (e) {
		// ignore
	}
});