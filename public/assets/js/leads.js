document.addEventListener('DOMContentLoaded', function(){
    // console.log('DOM fully loaded and parsed');

    // Contact number functionality
    (function () {
        // console.log('Contact number functionality initialized');
    
        const addContactNumberButton = document.getElementById('add_contact_number');
        const contactNumbersContainer = document.getElementById('contact_numbers_container');
        const removeContactNumberButton = document.querySelector('.remove-contact-number');
    
        if (!addContactNumberButton || !contactNumbersContainer || !removeContactNumberButton) {
            console.error('One or more contact number elements not found');
            return;
        }
    
        addContactNumberButton.addEventListener('click', function () {
            const index = contactNumbersContainer.children.length; // Get the new index for the field
     
            // Create a new contact number input group
            const newInput = document.createElement('div');
            newInput.className = 'contact-input-group flex items-center space-x-2 mb-3';
            newInput.innerHTML = `
                <input type="text" class="form-input flex-1" name="contact_numbers[${index}][contact_number]" placeholder="Enter Contact Number">
                <select name="contact_numbers[${index}][status]" class="form-select text-white-dark w-1/3">
                    <option value="Not Verified" selected>Not Verified</option> <!-- Default -->
                    <option value="Verified">Verified</option>
                </select>
            `;
    
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
        // console.log('Book fields functionality initialized');

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
        // console.log('Leads information functionality initialized');

        const leadInfoBox = document.querySelector('.lead-info');
        const detailsContainer = leadInfoBox.querySelector('.details-container');
        const editButton = document.getElementById('edit-button');

        if (!leadInfoBox) {
            console.error('Lead info box not found');
            return;
        }

        function showLoading() {
            detailsContainer.innerHTML = '<ul><li>Loading...</li></ul>';
            if (editButton) editButton.style.display = 'none';
        }

        function resetLeadInfo() {
            detailsContainer.innerHTML = '<ul><li>No data selected</li></ul>';
            if (editButton) editButton.style.display = 'none';
        }

        resetLeadInfo();

        document.addEventListener('click', function(event) {
            const clickedRow = event.target.closest('.customer-row');
            if (!clickedRow) return;

            // console.log('Row clicked:', clickedRow);

            const customerId = clickedRow.getAttribute('data-id');
            if (!customerId) {
                console.error('No customer ID found on clicked row');
                return;
            }

            showLoading();

            document.querySelectorAll('.customer-row').forEach(row => row.classList.remove('bg-gray-200'));
            clickedRow.classList.add('bg-gray-200');

            //Fetch customer details
            fetch(`/customers/${customerId}`)
                .then(response => response.json())
                .then(data => {
                    // console.log('Fetched customer data:', data); // Check the data received
                    if (data.success && data.customer) {
                        displayCustomerInfo(data.customer); // Call function to display data
                    } else {
                        console.error('Customer data not found in response');
                        resetLeadInfo();
                    }
                })
                .catch(error => {
                    console.error('Error fetching customer details:', error);
                    resetLeadInfo();
                });
            
        });

        function isReturnLeadsPage() {
            return window.location.pathname.includes('/customers/returned');
        }

        // Display fetched customer data
        function displayCustomerInfo(customer) {
            let assignToField = '';
            if (customer.assign_to && customer.assign_to !== customer.current_user_name) {
                assignToField = `<li><strong>Assign To:</strong> ${customer.assign_to}</li>`;
            }

            let returnReasonField = '';
            if (isReturnLeadsPage()) {
                returnReasonField = `
                    <li><strong>Return Reason:</strong> ${customer.latest_return_reason || 'No reason available'}</li>
                `;
            }
        
            detailsContainer.innerHTML = `
                <ul class="m-auto mt-5 flex flex-col space-y-2 font-semibold text-white-dark">
                    <li><strong>Name:</strong> ${customer.name}</li>
                    <li><strong>Email:</strong> ${customer.email}</li>
                    <li><strong>Address:</strong> ${customer.address || 'N/A'}</li>
                    <li><strong>Website:</strong> ${customer.website || 'N/A'}</li>
                    <li><strong>Books:</strong>
                        <ul>
                            ${customer.books.map(book => `<li><a href="${book.link}" target="_blank">${book.title}</a></li>`).join('')}
                        </ul>
                    </li>
                    <li><strong>Contact #:</strong>
                        <ul>
                            ${customer.contact_numbers.map(contact => `
                                <li>
                                    ${contact.contact_number} - ${contact.status === 'Verified' ? '✔️' : '❌'}
                                </li>
                            `).join('')}
                        </ul>
                    </li>
                    ${assignToField}
                    ${returnReasonField}
                </ul>
            `;
        
            if (editButton) {
                const pathSegments = window.location.pathname.split('/').filter(segment => segment);
                const referrer = pathSegments.length > 1 ? pathSegments[pathSegments.length - 1] : 'index';
        
                editButton.href = `/customers/${customer.id}/edit?referrer=${referrer}`;
                editButton.style.display = 'inline-block';
            }
        }

        
    })();

    // (function() {
    //     console.log('Leads information functionality initialized');
    
    //     const leadInfoBox = document.querySelector('.lead-info');
    //     const detailsContainer = leadInfoBox.querySelector('.details-container');
    //     const editButton = document.getElementById('edit-button');
    
    //     if (!leadInfoBox) {
    //         console.error('Lead info box not found');
    //         console.error('Edit button not found in the DOM');
    //         return;
    //     }
    
    //     function showLoading() {
    //         detailsContainer.innerHTML = '<ul><li>Loading...</li></ul>';
    //         if (editButton) editButton.style.display = 'none';
    //     }
    
    //     function resetLeadInfo() {
    //         detailsContainer.innerHTML = '<ul><li>No data selected</li></ul>';
    //         if (editButton) editButton.style.display = 'none';
    //     }
    
    //     resetLeadInfo();
    
    //     // Listen for clicks on the rows of the customer table
    //     document.addEventListener('click', function(event) {
    //         const clickedRow = event.target.closest('.customer-row');
    //         if (!clickedRow) return;
    
    //         console.log('Row clicked:', clickedRow);
    
    //         const customerId = clickedRow.getAttribute('data-id');
    //         console.log('Clicked Customer ID:', customerId); // Debug line
    //         if (!customerId) {
    //             console.error('No customer ID found on clicked row');
    //             return;
    //         }
    
    //         showLoading();
    
    //         // Highlight the clicked row
    //         document.querySelectorAll('.customer-row').forEach(row => row.classList.remove('bg-gray-200'));
    //         clickedRow.classList.add('bg-gray-200');
    
    //         // Fetch customer details using the ID from the clicked row
    //         fetch(`/customers/${customerId}`)
    //             .then(response => response.json())
    //             .then(data => {
    //                 console.log('Fetched customer data:', data);
    //                 if (data.success && data.customer) {
    //                     displayCustomerInfo(data.customer); // Call function to display customer data
    //                 } else {
    //                     console.error('Customer data not found in response');
    //                     resetLeadInfo();
    //                 }
    //             })
    //             .catch(error => {
    //                 console.error('Error fetching customer details:', error);
    //                 resetLeadInfo();
    //             });
    //     });
    
    //     // Function to display the fetched customer data
    //     function displayCustomerInfo(customer) {
    //         let assignToField = '';
    //         if (customer.assign_to && customer.assign_to !== customer.current_user_name) {
    //             assignToField = `<li><strong>Assign To:</strong> ${customer.assign_to}</li>`;
    //         }
    
    //         detailsContainer.innerHTML = `
    //             <ul class="m-auto mt-5 flex flex-col space-y-2 font-semibold text-white-dark">
    //                 <li><strong>Name:</strong> ${customer.name}</li>
    //                 <li><strong>Email:</strong> ${customer.email}</li>
    //                 <li><strong>Address:</strong> ${customer.address || 'N/A'}</li>
    //                 <li><strong>Website:</strong> ${customer.website || 'N/A'}</li>
    //                 <li><strong>Books:</strong>
    //                     <ul>
    //                         ${customer.books.map(book => `<li><a href="${book.link}" target="_blank">${book.title}</a></li>`).join('')}
    //                     </ul>
    //                 </li>
    //                 <li><strong>Contact #:</strong>
    //                     <ul>
    //                         ${customer.contact_numbers.map(contact => `
    //                             <li>
    //                                 ${contact.contact_number} - ${contact.status === 'Verified' ? '✔️' : '❌'}
    //                             </li>
    //                         `).join('')}
    //                     </ul>
    //                 </li>
    //                 ${assignToField}
    //             </ul>
    //         `;
    
    //         // Update the Edit button with the customer ID
    //         console.log('Customer ID:', customer.id); // Debug

    //         if (editButton) {
    //             const editUrl = `/customers/${customer.id}/edit`;
    //             console.log('Setting Edit Button URL:', editUrl); // Debug
    //             editButton.href = editUrl; // Update URL
    //             editButton.style.display = 'inline-block'; // Show button
    //         }
    //     }
    // })();
    
    // Global tab initialization script (can be included in a common JavaScript file)
    (function () {
        const tabLinks = document.querySelectorAll('.tab-link');
        const tabContents = document.querySelectorAll('.tab-content');

        if (tabLinks.length > 0 && tabContents.length > 0) {
            tabLinks.forEach(tabLink => {
                tabLink.addEventListener('click', function(event) {
                    event.preventDefault();

                    // Reset active classes
                    tabLinks.forEach(link => link.classList.remove('active'));
                    tabContents.forEach(content => content.classList.remove('active'));

                    // Activate clicked tab and its content
                    this.classList.add('active');
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) target.classList.add('active');
                });
            });

            // Set default tab active
            tabLinks[0].click();
        } else {
            // console.log("No tabs detected on this page. Skipping tab initialization.");
        }
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
            // console.log('Updating UI with selected data:', selectedData); // Debugging line
    
            contactNumbersContainer.innerHTML = ''; // Clear existing content
    
            if (selectedData && selectedData.contactNumbers && Array.isArray(selectedData.contactNumbers)) {
                // console.log('Updating UI with selected data:', selectedData); // Debugging line
    
                updateStatusButton.classList.remove('hidden');
                updateStatusButton.addEventListener('click', function () {
                    // console.log('Update Status button clicked'); // Debugging line
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
                // console.log('No data selected or available'); // Debugging line
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
    
                // console.log('Selected Data:', selectedData); // Debugging line
    
                // Update UI based on selection
                updateUI(selectedData);
            });
        });
        
    })();
});