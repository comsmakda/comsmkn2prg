// public/assets/js/main.js

document.addEventListener('DOMContentLoaded', () => {

  // ── ALERTS: auto-dismiss ──────────────────────────────────
  document.querySelectorAll('.alert[data-auto-dismiss]').forEach(el => {
    const delay = parseInt(el.dataset.autoDismiss, 10) || 5000;
    _scheduleAlertDismiss(el, delay);
  });

  // Default: dismiss all alerts without an explicit data attribute after 5s
  document.querySelectorAll('.alert:not([data-auto-dismiss="false"])').forEach(el => {
    if (!el.dataset.autoDismiss) _scheduleAlertDismiss(el, 5000);
  });

  // Close button inside alerts  → <button class="alert-close">
  document.addEventListener('click', (e) => {
    const closeBtn = e.target.closest('.alert-close');
    if (closeBtn) {
      const alert = closeBtn.closest('.alert');
      if (alert) _dismissAlert(alert);
    }
  });

  // ── SIDEBAR: close on outside click (mobile) ─────────────
  document.addEventListener('click', (e) => {
    const sidebar = document.getElementById('sidebar');
    const toggle  = document.querySelector('[data-sidebar-toggle]')
                 ?? document.querySelector('[onclick*="toggleSidebar"]');

    if (!sidebar) return;
    const clickedOutside = !sidebar.contains(e.target) && (!toggle || !toggle.contains(e.target));
    if (clickedOutside && window.innerWidth < 768) {
      _closeSidebar(sidebar);
    }
  });

  // ── SIDEBAR: close on Escape ──────────────────────────────
  document.addEventListener('keydown', (e) => {
    if (e.key !== 'Escape') return;
    const sidebar = document.getElementById('sidebar');
    if (sidebar && window.innerWidth < 768) _closeSidebar(sidebar);
  });

  // ── FORMS: loading state on submit ───────────────────────
  document.querySelectorAll('form[data-loading]').forEach(form => {
    form.addEventListener('submit', () => {
      form.querySelectorAll('button[type="submit"], .btn-primary').forEach(btn => {
        btn.classList.add('is-loading');
        btn.disabled = true;
      });
    });
  });

  // ── INPUTS: clear is-invalid on input ────────────────────
  document.addEventListener('input', (e) => {
    if (e.target.classList.contains('is-invalid')) {
      e.target.classList.remove('is-invalid');
      e.target.closest('.form-group')?.querySelector('.form-error')?.remove();
    }
  });

});


// ── HELPERS ───────────────────────────────────────────────────

function _scheduleAlertDismiss(el, delay) {
  const timer = setTimeout(() => _dismissAlert(el), delay);
  el.dataset._dismissTimer = timer;
}

function _dismissAlert(el) {
  if (el._dismissing) return;
  el._dismissing = true;

  clearTimeout(parseInt(el.dataset._dismissTimer, 10));

  const reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  if (reduced) {
    el.remove();
    return;
  }

  el.style.transition = 'opacity 0.35s ease, transform 0.35s ease, margin-top 0.35s ease, padding 0.35s ease';
  el.style.overflow   = 'hidden';
  el.style.opacity    = '0';
  el.style.transform  = 'translateY(-4px)';

  setTimeout(() => {
    el.style.marginTop = `-${el.offsetHeight}px`;
    el.style.padding   = '0';
  }, 200);

  setTimeout(() => el.remove(), 550);
}

function _closeSidebar(sidebar) {
  sidebar.classList.add('-translate-x-full');
  sidebar.setAttribute('aria-hidden', 'true');

  const toggle = document.querySelector('[data-sidebar-toggle]')
              ?? document.querySelector('[onclick*="toggleSidebar"]');
  if (toggle) toggle.setAttribute('aria-expanded', 'false');
}


// ── PUBLIC API ────────────────────────────────────────────────

/**
 * Programmatically show an alert.
 * @param {string} message   Alert body text
 * @param {'success'|'error'|'info'|'warning'} type
 * @param {string|null} title  Optional bold title line
 * @param {number} duration    ms before auto-dismiss (0 = sticky)
 * @param {Element|string} container  Target element or CSS selector
 */
function showAlert(message, type = 'info', title = null, duration = 5000, container = null) {
  const wrap = (typeof container === 'string' ? document.querySelector(container) : container)
             ?? document.querySelector('[data-alert-container]')
             ?? document.body;

  const el = document.createElement('div');
  el.className = `alert alert-${type}`;
  el.setAttribute('role', type === 'error' ? 'alert' : 'status');
  el.setAttribute('aria-live', type === 'error' ? 'assertive' : 'polite');

  el.innerHTML = `
    <div class="alert-content">
      ${title ? `<div class="alert-title">${_escapeHtml(title)}</div>` : ''}
      <div>${_escapeHtml(message)}</div>
    </div>
    <button class="alert-close btn btn-ghost btn-sm" aria-label="Tutup">&times;</button>
  `;

  wrap.prepend(el);

  // Animate in
  const reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  if (!reduced) {
    el.style.opacity   = '0';
    el.style.transform = 'translateY(-6px)';
    el.style.transition = 'opacity 0.25s ease, transform 0.25s ease';
    requestAnimationFrame(() => {
      el.style.opacity   = '1';
      el.style.transform = 'translateY(0)';
    });
  }

  if (duration > 0) _scheduleAlertDismiss(el, duration);
  return el;
}

function _escapeHtml(str) {
  return String(str)
    .replace(/&/g, '&amp;')
    .replace(/</g, '&lt;')
    .replace(/>/g, '&gt;')
    .replace(/"/g, '&quot;');
}