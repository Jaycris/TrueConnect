document.addEventListener('DOMContentLoaded', function(){
    console.log('DOM fully loaded and parsed');

    // Contact number functionality
    (function () {
        console.log('Contact number functionality initialized');

        const addContactNumberButton = document.getElementById('add_contact_number');
        const contactNumbersContainer = document.getElementById('contact_numbers_container');
        const removeContactNumberButton = document.querySelector('.remove-contact-number');

        if (!addContactNumberButton || !contactNumbersContainer || !removeContactNumberButton) {
            console.error('One or more contact number elements not found');
            return;
        }

        addContactNumberButton.addEventListener('click', function () {
            var newInput = document.createElement('div');
            newInput.className = 'contact-input-group';
            newInput.innerHTML = `<input type="text" class="form-input" name="contact_numbers[]" placeholder="Enter Contact Number">`;
            contactNumbersContainer.appendChild(newInput);
            updateRemoveButtonVisibility();
        });

        removeContactNumberButton.addEventListener('click', function () {
            if (contactNumbersContainer.children.length > 1) {
                contactNumbersContainer.lastElementChild.remove();
            }
            updateRemoveButtonVisibility();
        });

        function updateRemoveButtonVisibility() {
            if (contactNumbersContainer.children.length > 1) {
                removeContactNumberButton.style.display = 'inline-block';
            } else {
                removeContactNumberButton.style.display = 'none';
            }
        }
        updateRemoveButtonVisibility();
    })();

    // Book fields functionality
    (function () {
        console.log('Book fields functionality initialized');

        const addBookButton = document.getElementById('add_book');
        const booksContainer = document.getElementById('books_container');
        const removeBookButton = document.querySelector('.remove-book');

        if (!addBookButton || !booksContainer || !removeBookButton) {
            console.error('One or more book elements not found');
            return;
        }

        addBookButton.addEventListener('click', function () {
            var newIndex = booksContainer.children.length;
            var newInput = document.createElement('div');
            newInput.className = 'book-input-group';
            newInput.innerHTML = `
                <input type="text" name="books[${newIndex}][title]" class="form-input" placeholder="Enter Book Title" required>
                <input type="url" name="books[${newIndex}][link]" class="form-input" placeholder="Enter Book Link (optional)">
            `;
            booksContainer.appendChild(newInput);
            updateBookButtonVisibility();
        });

        removeBookButton.addEventListener('click', function () {
            if (booksContainer.children.length > 1) {
                booksContainer.lastElementChild.remove();
            }
            updateBookButtonVisibility();
        });

        function updateBookButtonVisibility() {
            if (booksContainer.children.length > 1) {
                removeBookButton.style.display = 'inline-block';
            } else {
                removeBookButton.style.display = 'none';
            }
        }
        updateBookButtonVisibility();
    })();

    // Leads information functionality
    (function() {
        console.log('Leads information functionality initialized');
    
        const rows = document.querySelectorAll('.customer-row');
        const leadInfoBox = document.querySelector('.lead-info');
        const detailsContainer = leadInfoBox.querySelector('.details-container');
    
        if (!leadInfoBox) {
            console.error('Lead info box not found');
            return;
        }
    
        function resetLeadInfo() {
            detailsContainer.innerHTML = '<ul><li>No data selected</li></ul>';
        }
    
        resetLeadInfo();
    
        rows.forEach(row => {
            row.addEventListener('click', function() {
                console.log('Row clicked:', this);
    
                const customerId = this.getAttribute('data-id');
                if (!customerId) {
                    console.error('No customer ID found on clicked row');
                    return;
                }
    
                rows.forEach(row => row.classList.remove('bg-gray-200'));
                this.classList.add('bg-gray-200');
    
                fetch(`/customers/${customerId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            detailsContainer.innerHTML = `
                                <ul class="m-auto mt-5 flex flex-col space-y-2 font-semibold text-white-dark">
                                    <li class="flex items-center gap-2"><strong>Name:</strong> ${data.customer.name}</li>
                                    <li class="flex items-center gap-2"><strong>Email:</strong> ${data.customer.email}</li>
                                    <li class="flex items-center gap-2"><strong>Address:</strong> ${data.customer.address}</li>
                                    <li class="flex items-center gap-2"><strong>Website:</strong> ${data.customer.website ? data.customer.website : 'N/A'}</li>
                                    <li class="flex items-center gap-2"><strong>Viewed:</strong> ${data.customer.is_viewed ? 'Yes' : 'No'}</li>
                                    <li class="flex gap-2"><strong>Books:</strong>
                                        <ul>
                                            ${data.customer.books.map(book => `<li class="flex items-center gap-2"><a href="${book.link}" target="_blank">${book.title}</a></li>`).join('')}
                                        </ul>
                                    </li>
                                    <li class="flex gap-2"><strong>Contact #:</strong>
                                        <ul class="flex flex-col space-y-1 ml-6">
                                        ${data.customer.contact_numbers.map(contact => `
                                            <li class="flex items-center gap-2">
                                                ${contact.contact_number}
                                                <span class="status-icon" 
                                                      title="${contact.status}">
                                                    ${contact.status === 'Verified' 
                                                        ? '<i class="material-icons" style="color: green; margin-top:2px; font-size: 15px;">verified</i>'
                                                        : '<i class="material-icons" style="color: red; margin-top:2px; font-size: 15px;">cancel</i>'
                                                    }
                                                </span>
                                            </li>
                                        `).join('')}
                                        </ul>
                                    </li>
                                    <li><strong>Assign To:</strong> ${data.customer.assign_to ? data.customer.assign_to : 'N/A'}</li>                                    
                                </ul>
                            `;
                        }
                    })
                    .catch(error => console.error('Error fetching customer details:', error));
            });
        });
    })();
});