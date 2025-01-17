document.addEventListener('DOMContentLoaded', function() {
    // console.log('DOM fully loaded and parsed');

    (function () {
        const imageUpload = document.getElementById('imageUpload');
        const profileImage = document.getElementById('profileImage');
    
        if (imageUpload && profileImage) {
            imageUpload.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        profileImage.src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            });
    
            const cameraIconOverlay = document.getElementById('cameraIconOverlay');
            if (cameraIconOverlay) {
                cameraIconOverlay.addEventListener('click', function() {
                    // console.log('Camera icon clicked');
                    const clickEvent = new MouseEvent('click', {
                        bubbles: true,
                        cancelable: true,
                        view: window
                    });
                    imageUpload.dispatchEvent(clickEvent);
                });
            }
        }
    })();

    //Checkbox for Leads
    // (function () {
    //     // Function to get checkboxes in a specific table
    //     function getCheckboxes(tableId) {
    //         const table = document.getElementById(tableId);
    //         return table ? table.querySelectorAll('tbody input[type="checkbox"]') : [];
    //     }
    
    //     // Handle "Check All" checkbox changes
    //     function handleCheckAll(checkAllId, tableId) {
    //         const checkAllCheckbox = document.getElementById(checkAllId);
    //         if (checkAllCheckbox) {
    //             checkAllCheckbox.addEventListener('change', function () {
    //                 const isChecked = this.checked;
    //                 const checkboxes = getCheckboxes(tableId);
    //                 checkboxes.forEach(checkbox => {
    //                     checkbox.checked = isChecked;
    //                 });
    //                 updateAssignButtonState(tableId); // Update button state after checking all
    //                 updateSelectedCustomerIds(tableId);
    //             });
    //         }
    //     }
    
    //     // Function to update the state of the Assign Leads button
    //     function updateAssignButtonState(tableId) {
    //         const checkboxes = getCheckboxes(tableId); // Get all checkboxes in the specified table
    //         const assignButton = document.getElementById('assign-leads-btn'); // Get the assign button

    //         const anyChecked = Array.from(checkboxes).some(checkbox => checkbox.checked); // Check if any checkbox is checked

    //         // Enable the assign button only in the Verified Leads tab if checkboxes are checked
    //         if (tableId === 'verified-leads-table') {
    //             assignButton.disabled = !anyChecked; // Enable or disable the button based on checkbox state
    //         } else {
    //             assignButton.disabled = true; // Disable the button for other tabs
    //         }
    //     }
    
    //     // Update the selected customer IDs and total selected leads value
    //     function updateSelectedCustomerIds(tableId) {
    //         const checkboxes = getCheckboxes(tableId);
    //         const selectedIds = Array.from(checkboxes)
    //             .filter(checkbox => checkbox.checked)
    //             .map(checkbox => checkbox.closest('tr').dataset.id);

    //         const totalSelectedLeads = document.getElementById('total-selected-leads');
    //         if (totalSelectedLeads) {
    //             totalSelectedLeads.value = selectedIds.length;
    //         }

    //         const selectedCustomerIdsInput = document.getElementById('selected-customer-ids');
    //         if (selectedCustomerIdsInput) {
    //             selectedCustomerIdsInput.value = selectedIds.join(',');
    //         }
    //     }

    //     // Function to handle individual checkbox change events
    //     function handleIndividualCheckboxes(tableId) {
    //         const checkboxes = getCheckboxes(tableId);
    //         checkboxes.forEach(checkbox => {
    //             checkbox.addEventListener('change', function () {
    //                 updateAssignButtonState(tableId); // Update button state when an individual checkbox is changed
    //                 updateSelectedCustomerIds(tableId); // Update selected customer IDs
    //             });
    //         });
    //     }

    //     // Initialize the "Check All" functionality for specific tables
    //     function initializeCheckAll() {
    //         handleCheckAll('checkAllVerified', 'verified-leads-table');
    //         handleCheckAll('checkAllLeads', 'leads-table');
    //         handleCheckAll('checkAllAssign', 'assign-leads-table');
    //         handleCheckAll('checkAllUsers', 'users-table');
    //         // Add more handlers if there are additional tables
    //     }

    //     // Open modal
    //     function openModal() {
    //         const assignButton = document.getElementById('assign-leads-btn');
    //         if (assignButton) {
    //             assignButton.addEventListener('click', function () {
    //                 const modal = document.getElementById('open-assign-modal');
    //                 if (modal) {
    //                     modal.classList.remove('hidden');
    //                     // Update modal content with the selected customer IDs
    //                     updateModalContent();
    //                 }
    //             });
    //         }
    //     }

    //     // Update modal content with the selected customer IDs
    //     function updateModalContent() {
    //         const selectedCustomerIdsInput = document.getElementById('selected-customer-ids');
    //         const selectedCustomerIds = selectedCustomerIdsInput.value;

    //         // Here you can dynamically update the modal content based on selectedCustomerIds
    //         // For example, show the number of selected customers
    //         const totalSelectedLeads = document.getElementById('total-selected-leads');
    //         const modalContent = document.getElementById('modal-content');

    //         if (modalContent) {
    //             modalContent.textContent = `You have selected ${totalSelectedLeads.value} customers for assignment.`;
    //         }
    //     }

    //     // Close modal when clicking outside
    //     function closeModal() {
    //         const modal = document.getElementById('open-assign-modal');
    //         if (modal) {
    //             modal.addEventListener('click', function (event) {
    //                 if (event.target === modal) {
    //                     modal.classList.add('hidden');
    //                 }
    //             });
    //         }
    //     }

    //     // Initialize the script
    //     function initialize() {
    //         initializeCheckAll();
    //         openModal();
    //         closeModal();
            
    //         // Attach event listeners to individual checkboxes to update the button state and selected IDs
    //         handleIndividualCheckboxes('verified-leads-table');

    //         // Initially call the function to set the correct state on page load
    //         updateAssignButtonState('verified-leads-table');
    //     }

    //     // Run the initialization
    //     initialize();
    // })();

    (function () {
        // Function to get checkboxes in a specific table
        function getCheckboxes(tableId) {
            const table = document.getElementById(tableId);
            return table ? table.querySelectorAll('tbody input[type="checkbox"]') : [];
        }
    
        // Handle "Check All" checkbox changes
        function handleCheckAll(checkAllId, tableId, modalId) {
            const checkAllCheckbox = document.getElementById(checkAllId);
            if (checkAllCheckbox) {
                checkAllCheckbox.addEventListener('change', function () {
                    const isChecked = this.checked;
                    const checkboxes = getCheckboxes(tableId);
                    checkboxes.forEach(checkbox => {
                        checkbox.checked = isChecked;
                    });
                    updateButtonState(tableId); // Update button state after checking all
                    updateSelectedCustomerIds(tableId, modalId); // Update selected customer IDs
                });
            }
        }
    
        // Function to update the state of the buttons based on the table ID
        function updateButtonState(tableId) {
            const checkboxes = getCheckboxes(tableId);
            const anyChecked = Array.from(checkboxes).some(checkbox => checkbox.checked);
    
            // Mapping table IDs to their respective buttons
            const buttonMapping = {
                'unassigned-leads-table': 'assign-leads-btn',
                'assign-leads-table': 'unassign-leads-btn',
                'assigned-leads-body': 'unassign-leads-btn',
                'my-leads-table': 'return-leads-btn',  // Link `my-leads-table` with `return-leads-btn`
                'assigned-customers-list': 'return-leads-btn',
                'return-leads-table': 'reassign-leads-btn',
                'returned-leads-body': 'reassign-leads-btn'
            };
    
            const buttonId = buttonMapping[tableId];
            if (!buttonId) {
                console.log(`No button mapping found for table ID "${tableId}".`);
                return; // Exit if there's no mapping for the table
            }

            const button = document.getElementById(buttonId);
            if (!button) {
                console.log(`Button with ID "${buttonId}" not found in the DOM.`);
                return; // Exit if the button is not present on the page
            }

            // Enable or disable the button based on whether any checkboxes are checked
            button.disabled = !anyChecked;
            console.log(`Button ${buttonId} is now ${button.disabled ? 'disabled' : 'enabled'}.`);
        }

        function updateSelectedCustomerIds(tableId, modalId) {
            const checkboxes = getCheckboxes(tableId); // Get checkboxes for the specific table
            const selectedIds = Array.from(checkboxes)
                .filter(checkbox => checkbox.checked)
                .map(checkbox => checkbox.closest('tr').dataset.id);
    
            // Update the total number of selected leads in the specific modal
            const totalSelectedLeads = document.querySelector(`#${modalId} #total-selected-leads`);
            if (totalSelectedLeads) {
                if (totalSelectedLeads.tagName === 'INPUT') {
                    totalSelectedLeads.value = selectedIds.length;  // Update the lead count in the modal
                } else {
                    // If it's not an input (likely a span), update the innerText for Reassign Leads modal
                    totalSelectedLeads.innerText = selectedIds.length;  // Update the text for Reassign Leads modal
                }
            }
    
            // Update the hidden input field for selected customer IDs in the specific modal
            const selectedCustomerIdsInput = document.querySelector(`#${modalId} #selected-customer-ids`);
            if (selectedCustomerIdsInput) {
                selectedCustomerIdsInput.value = selectedIds.join(',');  // Set selected IDs in hidden input
            }

            // Clear any previously created hidden inputs for customer IDs
            const selectedCustomerIdsContainer = document.querySelector(`#${modalId} #selected-customer-ids`);
            selectedCustomerIdsContainer.innerHTML = '';  // Clear existing inputs

            // Create a hidden input for each selected customer ID
            selectedIds.forEach(customerId => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'customers[]';  // Send as an array
                input.value = customerId;
                selectedCustomerIdsContainer.appendChild(input);  // Append the input to the container
            });
        }
    
        // Function to handle individual checkbox change events
        function handleIndividualCheckboxes(tableId, modalId) {
            const checkboxes = getCheckboxes(tableId);
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function () {
                    updateButtonState(tableId); // Update button state for individual check
                    updateSelectedCustomerIds(tableId, modalId); // Update selected customer count in the modal
                });
            });
        }

        window.handleIndividualCheckboxes = handleIndividualCheckboxes;

        // Add confirmation functionality to modal submit button
        function handleModalSubmit(modalId, submitButtonId) {
            const submitButton = document.getElementById(submitButtonId);
            const modal = document.getElementById(modalId);

            if (submitButton && modal) {
                submitButton.addEventListener('click', function (event) {
                    event.preventDefault(); // Prevent default form submission behavior

                    const selectedCustomerIdsInput = modal.querySelector('#selected-customer-ids');
                    const selectedIds = selectedCustomerIdsInput?.value.split(',') || [];

                    if (selectedIds.length === 0) {
                        alert('Please select at least one lead to proceed.');
                        return;
                    }

                    // Confirm the action with the user
                    const confirmation = confirm('Are you sure you want to proceed with the selected leads?');
                    if (confirmation) {
                        // Submit the form programmatically or handle the business logic here
                        const form = modal.querySelector('form');
                        if (form) {
                            form.submit(); // Submit the form
                        }
                    }
                });
            }
        }

    
        // Initialize the "Check All" functionality for specific tables
        function initializeCheckAll() {
            handleCheckAll('checkAllUnassigned', 'unassigned-leads-table', 'open-assign-modal'); 
            handleCheckAll('checkAllAssign', 'assign-leads-table', 'unassign-leads-modal');
            handleCheckAll('checkAllLeads', 'leads-table');
            handleCheckAll('checkAllreturn', 'my-leads-table', 'open-return-modal');
            handleCheckAll('checkAllReassign', 'return-leads-table', 'open-reassign-modal');
            handleCheckAll('checkAllUsers', 'users-table');
            handleCheckAll('checkAllDesignation', 'des-table');
            handleCheckAll('checkAllDepartment', 'dep_table');
        }
    
        // Open modal for a specific button
        function openModal(buttonId, modalId) {
            const button = document.getElementById(buttonId);
            if (button) {
                button.addEventListener('click', function () {
                    const modal = document.getElementById(modalId);
                    if (modal) {
                        modal.classList.remove('hidden');
                    }
                });
            }
        }
    
        // Close modal when clicking outside
        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.addEventListener('click', function (event) {
                    if (event.target === modal) {
                        modal.classList.add('hidden');
                    }
                });
            }
        }
    
        // Initialize the script
        function initialize() {
            initializeCheckAll();
    
            // Attach event listeners to individual checkboxes
            handleIndividualCheckboxes('unassigned-leads-table', 'open-assign-modal');
            handleIndividualCheckboxes('assign-leads-table', 'unassign-leads-modal');
            handleIndividualCheckboxes('return-leads-table', 'open-reassign-modal');
            handleIndividualCheckboxes('my-leads-table', 'open-return-modal'); // Ensure `my-leads-table` is included here
    
            // Initial button state update on page load
            updateButtonState('unassigned-leads-table');
            updateButtonState('my-leads-table'); // Ensure `my-leads-table` button state is set
            updateButtonState('return-leads-table');
    
            // Initialize modals
            openModal('assign-leads-btn', 'open-assign-modal');
            openModal('return-leads-btn', 'open-return-modal');
            openModal('reassign-leads-btn', 'open-reassign-modal');
            openModal('unassign-leads-btn', 'unassign-leads-modal');
            closeModal('open-assign-modal');
            closeModal('open-return-modal');
            closeModal('open-reassign-modal');
            closeModal('unassignedModal');

            // Add modal submit button logic
            handleModalSubmit('open-assign-modal', 'assign-modal-submit');
            handleModalSubmit('open-return-modal', 'return-modal-submit');
            handleModalSubmit('open-reassign-modal', 'reassign-modal-submit');
            handleModalSubmit('unassign-leads-modal', 'unassign-modal-submit');
        }
    
        initialize();
    })();

    (function () {
        //delete Department or Designation
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        function handleDeleteCheck(event, url, deleteUrl, successMessage, errorMessage) {
            event.preventDefault();
            const id = event.currentTarget.dataset.id;
        
            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                const modal = document.getElementById('usersModal');
                const modalTitle = document.getElementById('modalTitle');
                const modalMessage = document.getElementById('modalMessage');
                const usersHeading = document.getElementById('usersHeading');
                const usersList = document.getElementById('usersList');
                const okayButton = document.getElementById('okayButton');
                const cancelButton = document.getElementById('cancelButton');
                const confirmDeleteButton = document.getElementById('confirmDeleteButton');
        
                if (data.status === 'error') {
                    modalTitle.innerText = errorMessage;
                    modalMessage.innerText = data.message;
                    usersHeading.innerText = 'Affected users:';
                    usersList.innerHTML = '';
                    data.profiles.forEach(profile => {
                        const li = document.createElement('li');
                        li.innerText = `- ${profile.first_name}  ${profile.last_name}`;
                        usersList.appendChild(li);
                    });
                    okayButton.classList.remove('hidden');
                    cancelButton.classList.add('hidden');
                    confirmDeleteButton.classList.add('hidden');
                } else {
                    modalTitle.innerText = 'Confirm Deletion';
                    modalMessage.innerText = successMessage;
                    usersHeading.innerText = '';
                    usersList.innerHTML = '';
                    okayButton.classList.add('hidden');
                    cancelButton.classList.remove('hidden');
                    confirmDeleteButton.classList.remove('hidden');
        
                    // Attach the event listener here
                    confirmDeleteButton.onclick = function() {
                        fetch(deleteUrl, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'Content-Type': 'application/json',
                            },
                        }).then(() => {
                            window.location.reload();
                        });
                    };
                }
                modal.classList.remove('hidden');
            });
        }
        
        function setupDeleteButtons(selector, urlTemplate, deleteUrlTemplate, successMessage, errorMessage) {
            const deleteButtons = document.querySelectorAll(selector);
        
            deleteButtons.forEach(button => {
                button.addEventListener('click', function (event) {
                    const id = this.dataset.id;
                    const url = urlTemplate.replace(':id', id);
                    const deleteUrl = deleteUrlTemplate.replace(':id', id);
                    handleDeleteCheck(event, url, deleteUrl, successMessage, errorMessage);
                });
            });
        }
        
        setupDeleteButtons('.delete-department-btn', '/admin/departments/:id/delete/check', 
            '/admin/departments/:id/delete', 'Are you sure you want to delete this department?', 'Users in Department');
        setupDeleteButtons('.delete-designation-btn', '/admin/designations/:id/delete/check', 
            '/admin/designations/:id/delete', 'Are you sure you want to delete this designation?', 'Users in Designation');

    })();

    (function () {
        // Function to show the modal
        function showModal(modalId) {
            document.getElementById(modalId).classList.remove('hidden');
        }

        // Function to hide the modal
        function hideModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }

        // Event listener for Coming Soon links
        document.querySelectorAll('[data-coming-soon]').forEach(link => {
            link.addEventListener('click', function (e) {
                e.preventDefault(); // Prevent navigation
                showModal('comingSoonModal');
            });
        });
    })

    (function () {
        let currentStep = 1;
        const totalSteps = 3;
    
        const progressBar = document.getElementById('progress-bar');
        const prevButton = document.getElementById('prev-button');
        const nextButton = document.getElementById('next-button');
        const submitButton = document.getElementById('submit-button');
    
        const stepContents = document.querySelectorAll('.step-content');
        const connectors = [...document.querySelectorAll('[id^="connector-"]')];
    
        // Function to validate required fields in the current step
        function validateStep() {
            const currentStepContent = stepContents[currentStep - 1];
            const requiredFields = currentStepContent.querySelectorAll('[required]');
        
            let isValid = true;
        
            requiredFields.forEach((field) => {
                if ((field.tagName === 'INPUT' || field.tagName === 'TEXTAREA') && !field.value.trim()) {
                    isValid = false;
                    field.classList.add('border-red-500');
                    field.nextElementSibling?.classList.remove('hidden'); // Show error message
                } else if (field.tagName === 'SELECT' && !field.value) {
                    isValid = false;
                    field.classList.add('border-red-500');
                    field.nextElementSibling?.classList.remove('hidden'); // Show error message
                } else {
                    field.classList.remove('border-red-500');
                    field.nextElementSibling?.classList.add('hidden'); // Hide error message
                }
            });
        
            return isValid;
        }
    
        // Function to update UI based on current step
        function updateStepUI() {
            stepContents.forEach((content, index) => {
                content.classList.toggle('hidden', index !== currentStep - 1);
            });
    
            // Update progress bar steps
            for (let i = 1; i <= totalSteps; i++) {
                const stepElement = document.getElementById(`step-${i}`);
                const connector = document.getElementById(`connector-${i - 1}`);

                if (!stepElement) {
                    console.log(`Step element with ID 'step-${i}' not found.`);
                    continue;
                }

                if (i < currentStep) {
                    stepElement.classList.add('bg-primary', 'text-white');
                    stepElement.classList.remove('bg-gray-300', 'text-gray-600');
                    if (connector) {
                        connector.style.width = '100%';
                    } else {
                        console.log(`Connector element with ID 'connector-${i - 1}' not found.`);
                    }
                } else if (i === currentStep) {
                    stepElement.classList.add('bg-primary', 'text-white');
                    stepElement.classList.remove('bg-gray-300', 'text-gray-600');
                    if (connector) {
                        connector.style.width = '50%';
                    } else {
                        console.log(`Connector element with ID 'connector-${i - 1}' not found.`);
                    }
                } else {
                    stepElement.classList.add('bg-gray-300', 'text-gray-600');
                    stepElement.classList.remove('bg-primary', 'text-white');
                    if (connector) {
                        connector.style.width = '0%';
                    } else {
                        console.log(`Connector element with ID 'connector-${i - 1}' not found.`);
                    }
                }
            }

    
            // Update button visibility
            if (!prevButton) {
                console.log("Previous button element 'prevButton' not found.");
            } else {
                prevButton.disabled = currentStep === 1;
            }

            if (!nextButton) {
                console.log("Next button element 'nextButton' not found.");
            } else {
                nextButton.classList.toggle('hidden', currentStep === totalSteps);
            }

            if (!submitButton) {
                console.log("Submit button element 'submitButton' not found.");
            } else {
                submitButton.classList.toggle('hidden', currentStep !== totalSteps);
            }

        }
    
        // Event listeners for navigation
        // Ensure buttons exist before adding event listeners
        if (prevButton) {
            prevButton.addEventListener('click', () => {
                if (typeof currentStep === 'undefined' || typeof updateStepUI !== 'function') {
                    console.log('`currentStep` or `updateStepUI` is not properly defined.');
                    return;
                }
                if (currentStep > 1) currentStep--;
                updateStepUI();
            });
        } else {
            console.log('`prevButton` element not found in the DOM.');
        }

        if (nextButton) {
            nextButton.addEventListener('click', () => {
                if (typeof validateStep !== 'function' || typeof currentStep === 'undefined' || typeof totalSteps === 'undefined') {
                    console.log('`validateStep`, `currentStep`, or `totalSteps` is not properly defined.');
                    return;
                }
                if (validateStep() && currentStep < totalSteps) {
                    currentStep++;
                    updateStepUI();
                }
            });
        } else {
            console.log('`nextButton` element not found in the DOM.');
        }


    
        // Initial UI setup
        updateStepUI();
    })();

    (function () {
        // Author's Name Suggestions
        const authorInput = document.getElementById('authorsName');
        const authorSuggestionsBox = document.getElementById('authorsSuggestions');
        let authorSpinner = null;
        if (authorSuggestionsBox) {
            authorSpinner = authorSuggestionsBox.querySelector('.loading-spinner');
            if (!authorSpinner) {
                console.log("Loading spinner inside 'authorsSuggestions' not found.");
            }
        }
        const bookInput = document.getElementById('BookTitle');
        const bookSuggestionsBox = document.getElementById('bookSuggestions');
        
        let bookSpinner = null;
        if (bookSuggestionsBox) {
            bookSpinner = bookSuggestionsBox.querySelector('.loading-spinner');
            if (!bookSpinner) {
                console.log("Loading spinner inside 'bookSuggestions' not found.");
            }
        }
    
        if (!authorInput || !authorSuggestionsBox || !bookInput || !bookSuggestionsBox || !authorSpinner || !bookSpinner) {
            console.log('Required elements not found in the DOM.');
            return;
        }
    
        // Function to handle showing suggestions
        function showSuggestions(box) {
            box.classList.add('show');
        }
    
        // Function to handle hiding suggestions
        function hideSuggestions(box) {
            box.classList.remove('show');
        }
    
        // Function to handle showing spinner
        function showSpinner(spinner) {
            spinner.style.display = 'block';
        }
    
        // Function to handle hiding spinner
        function hideSpinner(spinner) {
            spinner.style.display = 'none';
        }
    
        // Fetch and display author suggestions
        authorInput.addEventListener('input', function () {
            const query = authorInput.value.trim();
    
            if (query.length < 1) {
                hideSuggestions(authorSuggestionsBox);
                hideSpinner(authorSpinner);
                return;
            }
    
            showSuggestions(authorSuggestionsBox);
            showSpinner(authorSpinner); // Show spinner during fetch
    
            fetch(`/get-authors-suggestions?query=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    authorSuggestionsBox.innerHTML = ''; // Clear previous suggestions
    
                    if (data.length > 0) {
                        data.forEach(item => {
                            const div = document.createElement('div');
                            div.textContent = item.name; // Author's name
                            div.className = 'suggestion-item';
    
                            div.addEventListener('click', function () {
                                authorInput.value = item.name;
                                hideSuggestions(authorSuggestionsBox);
    
                                // Load book suggestions for the selected author
                                loadBookSuggestions(item.name);
                            });
    
                            authorSuggestionsBox.appendChild(div);
                        });
                    } else {
                        hideSuggestions(authorSuggestionsBox);
                    }
                })
                .catch(error => {
                    console.error('Error fetching author suggestions:', error);
                    hideSuggestions(authorSuggestionsBox);
                })
                .finally(() => {
                    hideSpinner(authorSpinner); // Hide spinner after fetch
                });
        });
    
        // Fetch and display book suggestions based on author name
        function loadBookSuggestions(authorName) {
            bookInput.addEventListener('input', function () {
                const query = bookInput.value.trim();
    
                if (query.length < 1 || !authorName) {
                    hideSuggestions(bookSuggestionsBox);
                    hideSpinner(bookSpinner);
                    return;
                }
    
                showSuggestions(bookSuggestionsBox);
                showSpinner(bookSpinner); // Show spinner during fetch
    
                fetch(`/get-book-titles?author_name=${encodeURIComponent(authorName)}&query=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(data => {
                        bookSuggestionsBox.innerHTML = ''; // Clear previous suggestions
    
                        if (data.length > 0) {
                            data.forEach(item => {
                                const div = document.createElement('div');
                                div.textContent = item; // Book title
                                div.className = 'suggestion-item';
    
                                div.addEventListener('click', function () {
                                    bookInput.value = item;
                                    hideSuggestions(bookSuggestionsBox);
                                });
    
                                bookSuggestionsBox.appendChild(div);
                            });
                        } else {
                            hideSuggestions(bookSuggestionsBox);
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching book suggestions:', error);
                        hideSuggestions(bookSuggestionsBox);
                    })
                    .finally(() => {
                        hideSpinner(bookSpinner); // Hide spinner after fetch
                    });
            });
        }
    
        // Global click handler to hide suggestions when clicking outside
        document.addEventListener('click', function (event) {
            if (!authorSuggestionsBox.contains(event.target) && event.target !== authorInput) {
                hideSuggestions(authorSuggestionsBox);
            }
    
            if (!bookSuggestionsBox.contains(event.target) && event.target !== bookInput) {
                hideSuggestions(bookSuggestionsBox);
            }
        });
    })();
});



