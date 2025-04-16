document.addEventListener('DOMContentLoaded', function () {
  const filterForm = document.querySelector('#resource-filter');

  if (filterForm) {
    filterForm.addEventListener('change', function () {
      const checked = [...filterForm.querySelectorAll('input[type="checkbox"]:checked')];
      const categories = checked.map(input => input.value);

      const formData = new FormData();
      formData.append('action', 'filter_resources');
      formData.append('categories', JSON.stringify(categories));

      fetch(`${filter_script_data.ajax_url}`, {
        method: 'POST',
        body: formData
      })
        .then(response => response.text())
        .then(html => {
          document.querySelector('#resource-results').innerHTML = html;
        })
        .catch(error => {
          console.error('Error:', error);
        });

      fetch(`${filter_script_data.ajax_url}`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams({
          action: 'save_filter_session',
          categories: JSON.stringify(categories)
        })
      });
    });
  }
});
