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
          addToCart(); //Re-initilizing the cart "behavior" on newly rendered content
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

  function addToCart() {
    const addToCartForms = document.querySelectorAll('form[action*="#"]');

    addToCartForms.forEach(form => {
      form.addEventListener('submit', async function (event) {
        event.preventDefault();

        const formData = new FormData(form);
        const listCountElement = document.querySelector('#listCount');

        try {
          const response = await fetch(window.location.href, {
            method: 'POST',
            body: formData
          });

          if (response.ok) {
            const button = form.querySelector('button[type="submit"]');
            
            button.disabled = true;
            button.textContent = "In PDF";

            let currentCount = parseInt(listCountElement.textContent.replace(/\D/g, '') || '0');
            currentCount++;
            listCountElement.textContent = `[${currentCount}]`;
            
          } else {
            alert("Failed to add to the PDF cart!")
          }
        } catch (error) {
          console.error('Error:', error)
        }
      });
    });
  };
  

  function removeItemFromCart() {
    document.addEventListener('submit', async function(event) {
      if (event.target.matches('form')) {
        const submitter = event.submitter;
        if (submitter && submitter.value == 'remove_item_from_cart') {
          event.preventDefault();

          const form = event.target;
          const formData = new FormData(form);
          const listCountElement = document.querySelector('#listCount');

          try {
            const response = await fetch(window.location.href, {
              method: 'POST',
              body: formData
            });

            if (response.ok) {
              submitter.closest('li').remove();

              let currentCount = parseInt(listCountElement.textContent.replace(/\D/g, '') || '0');
              currentCount = Math.max(currentCount - 1, 0);
              listCountElement.textContent = `[${currentCount}]`;
            }
          } catch (error) {
            console.error('Failed to remove this item from the cart', error);
          }
        }
      }
    });
  };

  function clearCart() {
    const clearButton = document.querySelector('form button[name="pdf_action"][value="remove_pdf"]');
    const clearForm = clearButton?.closest('form');

    if (!clearForm) {
      return;
    }

    clearForm.addEventListener('submit', async function(event) {
      event.preventDefault();

      const formData = new FormData(clearForm);

      formData.append(clearButton.name, clearButton.value);
      console.log('Clearing cart...', Object.fromEntries(formData));

      try {
        const response = await fetch(window.location.href, {
          method:'POST',
          body: formData
        });

        if (response.ok) {
          const cartList = document.querySelector('.cart-resources');
          if (cartList) {
            cartList.innerHTML = '';
          }

          const listCountElement = document.querySelector('#listCount');
          if (listCountElement) {
            listCountElement.textContent = `[0]`;
          }

          const container = document.querySelector('.message');
          if (container) {
            container.innerHTML = `<p>Your resources PDF is empty. <a href="javascript:history.go(-1)">Go back?</a></p>`;
          }

          const buttonsElement = document.querySelector('.buttons');
          buttonsElement.style.display = "none";
        }
      } catch (error) {
        console.error("Error clearing cart", error);
      }
    });
  }

  addToCart();
  removeItemFromCart();
  clearCart();
});
