import './styles/theme.css';

document.addEventListener('DOMContentLoaded', () => {
  const toggle = document.querySelector<HTMLButtonElement>('.js-menu-toggle');
  const panel = document.getElementById('primary-mobile-nav');
  const iconOpen = document.querySelector('.js-menu-icon-open');
  const iconClose = document.querySelector('.js-menu-icon-close');

  if (!toggle || !panel) {
    return;
  }

  const setOpen = (open: boolean) => {
    panel.classList.toggle('hidden', !open);
    toggle.setAttribute('aria-expanded', String(open));
    panel.setAttribute('aria-hidden', String(!open));
    iconOpen?.classList.toggle('hidden', open);
    iconClose?.classList.toggle('hidden', !open);
  };

  toggle.addEventListener('click', () => {
    const willOpen = panel.classList.contains('hidden');
    setOpen(willOpen);
  });

  panel.querySelectorAll('a').forEach((link) => {
    link.addEventListener('click', () => {
      setOpen(false);
    });
  });
});
