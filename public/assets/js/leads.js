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
        const editButton = document.getElementById('edit-button');
    
        if (!leadInfoBox) {
            console.error('Lead info box not found');
            return;
        }
    
        function resetLeadInfo() {
            detailsContainer.innerHTML = '<ul><li>No data selected</li></ul>';
            if (editButton) {
                editButton.style.display = 'none'; // Hide edit button when no data is selected
            }

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
                            let assignToField = '';
                            if (data.customer.assign_to && data.customer.assign_to !== data.customer.current_user_name) {
                                assignToField = `<li><strong>Assign To:</strong> ${data.customer.assign_to}</li>`;
                            }

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
                                                        ? '<i class="fas fa-check-circle" gap-2 style="color: green;"></i>'
                                                        : '<i class="fas fa-times-circle" gap-2 style="color: red;"></i>'
                                                    }
                                                </span>
                                            </li>
                                        `).join('')}
                                        </ul>
                                    </li>
                                    ${assignToField}                                    
                                </ul>
                            `;

                            if (editButton) {
                                editButton.href = `/customers/${customerId}/edit`; // Update edit button URL
                                editButton.style.display = 'inline-block'; // Show edit button
                            }
                        }
                    })
                    .catch(error => console.error('Error fetching customer details:', error));
            });
        });
    })();
    

    (function () {
        document.querySelectorAll('.tab-link').forEach(tabLink => {
            tabLink.addEventListener('click', function(event) {
                event.preventDefault();
    
                // Remove active class from all tabs and hide all tab contents
                document.querySelectorAll('.tab-link').forEach(link => {
                    link.classList.remove('active');
                });
                document.querySelectorAll('.tab-content').forEach(content => {
                    content.classList.remove('active');
                });
    
                // Add active class to the clicked tab
                this.classList.add('active');
    
                // Show the corresponding tab content
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.classList.add('active');
                }
            });
        });
    
        // Optionally, set the default active tab (first tab in this case)
        document.querySelector('.tab-link').click();
    })();
    

    (function () {
        const updateStatusButton = document.getElementById('update-status-button');
        const modal = document.getElementById('open-status-modal');
        const form = document.getElementById('status-update-form');
        const customerIdInput = document.getElementById('customer-id');
        const nameInput = document.getElementById('name');
        const booksInput = document.getElementById('books');
        const contactNumbersContainer = document.getElementById('contact_numbers_container');

        // Function to format books as a string
        function formatBooks(books) {
            if (Array.isArray(books)) {
                return books.map(book => book.title).join(', ');
            }
            return '';
        }

        // Function to show/hide the Update Status button and modal
        function updateUI(selectedData) {
            console.log('Updating UI with selected data:', selectedData); // Debugging line
    
            contactNumbersContainer.innerHTML = ''; // Clear existing content
    
            if (selectedData && selectedData.contactNumbers && Array.isArray(selectedData.contactNumbers)) {
                console.log('Updating UI with selected data:', selectedData); // Debugging line
    
                updateStatusButton.classList.remove('hidden');
                updateStatusButton.addEventListener('click', function () {
                    console.log('Update Status button clicked'); // Debugging line
                    // Populate the modal with selected data
                    customerIdInput.value = selectedData.customerId;
                    nameInput.value = selectedData.name;
                    booksInput.value = formatBooks(selectedData.books);
    
                    // Clear previous contact numbers
                    contactNumbersContainer.innerHTML = '';
    
                    // Append each contact number as an input field
                    selectedData.contactNumbers.forEach((contact, index) => {
                        const contactNumberField = document.createElement('div');
                        contactNumberField.classList.add('mb-4', 'flex', 'space-x-2');
        
                        contactNumberField.innerHTML = `
                            <input type="hidden" name="contact_numbers[${index}][id]" value="${contact.id}">
                            <input type="text" name="contact_numbers[${index}][number]" value="${contact.contact_number}" class="form-input mt-1 block w-full" readonly>
                            <select name="contact_numbers[${index}][status]" class="form-select mt-1 block w-full">
                                <option value="Not Verified" ${contact.status === 'Not Verified' ? 'selected' : ''}>Not Verified</option>
                                <option value="Verified" ${contact.status === 'Verified' ? 'selected' : ''}>Verified</option>
                            </select>
                        `;
        
                        contactNumbersContainer.appendChild(contactNumberField);
                    });
    
                    // Show the modal
                    modal.classList.remove('hidden');
                });
            } else {
                console.log('No data selected or available'); // Debugging line
                updateStatusButton.classList.add('hidden');
            }
        }
    
        // Function to handle row selection
        document.querySelectorAll('.customer-row').forEach(row => {
            row.addEventListener('click', function () {
                const selectedData = {
                    customerId: this.dataset.id, // Use data-id
                    name: this.dataset.name,
                    books: this.dataset.books ? JSON.parse(this.dataset.books) : '', // Parse books JSON
                    contactNumbers: JSON.parse(this.dataset.contactNumbers || '[]') // Ensure JSON parsing is done correctly
                };
    
                console.log('Selected Data:', selectedData); // Debugging line
    
                // Update UI based on selection
                updateUI(selectedData);
            });
        });
        
    })();
});