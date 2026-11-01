document.addEventListener('DOMContentLoaded', () => {
  const toggle = document.querySelector('.mobile-toggle');
  const nav = document.querySelector('.main-nav');
  if (toggle && nav) toggle.addEventListener('click', () => nav.classList.toggle('nav-open'));
  document.querySelectorAll('input[type="file"]').forEach(input => {
    input.addEventListener('change', () => {
      const file = input.files[0];
      if (file && file.size > 5 * 1024 * 1024) {
        alert('Please choose an image smaller than 5 MB.');
        input.value = '';
      }
    });
  });
});
