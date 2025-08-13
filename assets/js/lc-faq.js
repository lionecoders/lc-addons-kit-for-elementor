(function () {
  function toggleFAQ(item, header, answer, wrap, multiple) {
    if (!multiple) {
      wrap.querySelectorAll('.lc-faq-item.active').forEach(function (openItem) {
        if (openItem !== item) {
          openItem.classList.remove('active');
        }
      });
    }
    item.classList.toggle('active');
    header.setAttribute('aria-expanded', item.classList.contains('active') ? 'true' : 'false');
  }

  document.addEventListener('click', function (e) {
    const header = e.target.closest('.lc-faq-question');
    if (!header) return;
    const item = header.closest('.lc-faq-item');
    const wrap = header.closest('.lc-faq');
    if (!item || !wrap) return;
    const multiple = wrap.dataset.multiple === 'true';
    toggleFAQ(item, header, null, wrap, multiple);
  });

  document.addEventListener('keydown', function (e) {
    if ((e.key === 'Enter' || e.key === ' ') && e.target.classList.contains('lc-faq-question')) {
      e.preventDefault();
      e.target.click();
    }
  });
})();
