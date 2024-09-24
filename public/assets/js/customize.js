document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM fully loaded and parsed');

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
                    console.log('Camera icon clicked');
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
        function handleCheckAll(checkAllId, tableId) {
            const checkAllCheckbox = document.getElementById(checkAllId);
            if (checkAllCheckbox) {
                checkAllCheckbox.addEventListener('change', function () {
                    const isChecked = this.checked;
                    const checkboxes = getCheckboxes(tableId);
                    checkboxes.forEach(checkbox => {
                        checkbox.checked = isChecked;
                    });
                    updateButtonState(tableId); // Update button state after checking all
                    updateSelectedCustomerIds(tableId);
                });
            }
        }
    
        // Function to update the state of the buttons based on the table ID
        function updateButtonState(tableId) {
            const checkboxes = getCheckboxes(tableId); // Get all checkboxes in the specified table
            const anyChecked = Array.from(checkboxes).some(checkbox => checkbox.checked); // Check if any checkbox is checked
    
            // Mapping table IDs to their respective buttons
            const buttonMapping = {
                'verified-leads-table': 'assign-leads-btn',
                'my-leads-table': 'return-leads-btn',
                'return-leads-table': 'reassign-leads-btn',  // Added this for reassign leads
                'leads-table': 'some-other-button-id', // Add other buttons here as needed
            };
    
            const buttonId = buttonMapping[tableId];
            if (buttonId) {
                const button = document.getElementById(buttonId);
                if (button) {
                    button.disabled = !anyChecked;
                }
            }
        }
    
        // Update the selected customer IDs and total selected leads value
        function updateSelectedCustomerIds(tableId) {
            const checkboxes = getCheckboxes(tableId);
            const selectedIds = Array.from(checkboxes)
                .filter(checkbox => checkbox.checked)
                .map(checkbox => checkbox.closest('tr').dataset.id);

            const totalSelectedLeads = document.getElementById('total-selected-leads');
            if (totalSelectedLeads) {
                totalSelectedLeads.value = selectedIds.length;
            }

            const selectedCustomerIdsInput = document.getElementById('selected-customer-ids');
            if (selectedCustomerIdsInput) {
                selectedCustomerIdsInput.value = selectedIds.join(',');
            }
        }
    
        // Function to handle individual checkbox change events
        function handleIndividualCheckboxes(tableId) {
            const checkboxes = getCheckboxes(tableId);
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function () {
                    updateButtonState(tableId); // Update button state when an individual checkbox is changed
                    updateSelectedCustomerIds(tableId); // Update selected customer IDs
                });
            });
        }
    
        // Initialize the "Check All" functionality for specific tables
        function initializeCheckAll() {
            handleCheckAll('checkAllVerified', 'verified-leads-table');
            handleCheckAll('checkAllLeads', 'leads-table');
            handleCheckAll('checkAllAssign', 'assign-leads-table');
            handleCheckAll('checkAllreturn', 'my-leads-table');
            handleCheckAll('checkAllReassign', 'return-leads-table'); // Added for reassign leads
        }
    
        // Open modal for a specific button
        function openModal(buttonId, modalId) {
            const button = document.getElementById(buttonId);
            if (button) {
                button.addEventListener('click', function () {
                    const modal = document.getElementById(modalId);
                    if (modal) {
                        modal.classList.remove('hidden');
        
                        // Check if the modal being opened is the reassign modal
                        if (modalId === 'open-reassign-modal') {
                            updateReassignModalContent(modalId); // Specific function for reassign leads modal
                        } else {
                            updateModalContent(modalId); // General function for other modals
                        }
                    }
                });
            }
        }
    
        // Update modal content based on modal ID
        function updateModalContent(modalId) {
            const selectedCustomerIdsInput = document.getElementById('selected-customer-ids');
            const selectedCustomerIds = selectedCustomerIdsInput ? selectedCustomerIdsInput.value : '';
        
            const totalSelectedLeads = document.getElementById('total-selected-leads');
            const modalContent = document.getElementById(modalId).querySelector('#modal-content');
        
            if (modalContent && totalSelectedLeads) {
                modalContent.textContent = `You have selected ${totalSelectedLeads.value} customers.`;
            }
        }

        // New function specifically for updating the Reassign Leads Modal content
        function updateReassignModalContent(modalId) {
            const selectedCustomerIdsInput = document.getElementById('selected-customer-ids');
            const selectedCustomerIds = selectedCustomerIdsInput ? selectedCustomerIdsInput.value.split(',') : [];
            
            const totalSelectedLeads = selectedCustomerIds.length;
            const modalTextElement = document.getElementById('reassign-modal-text');
        
            // Get the employee ID of the first selected customer
            const firstCheckedCheckbox = document.querySelector('#return-leads-table input[type="checkbox"]:checked');
            const employeeId = firstCheckedCheckbox ? firstCheckedCheckbox.closest('tr').dataset.employeeId : 'N/A';
        
            // Update modal content based on the number of leads and employee ID
            if (modalTextElement && totalSelectedLeads > 0) {
                modalTextElement.textContent = `Reassigning these ${totalSelectedLeads} leads to Employee ID: ${employeeId}`;
            }
        
            // Update the total leads field in the modal
            const totalLeadsInput = document.getElementById('total-leads');
            if (totalLeadsInput) {
                totalLeadsInput.value = totalSelectedLeads;
            }
        
            // Set the Branding Specialist Name if needed
            const brandingSpecialistInput = document.getElementById('employee-select');
            if (brandingSpecialistInput) {
                brandingSpecialistInput.value = employeeId; // Set employee ID here
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
    
            // Attach event listeners to individual checkboxes to update the button state and selected IDs
            handleIndividualCheckboxes('verified-leads-table');
            handleIndividualCheckboxes('return-leads-table');
    
            // Initially call the function to set the correct state on page load
            updateButtonState('verified-leads-table');
            updateButtonState('return-leads-table');
    
            // Initialize modals
            openModal('assign-leads-btn', 'open-assign-modal');
            openModal('return-leads-btn', 'open-return-modal');
            openModal('reassign-leads-btn', 'open-reassign-modal'); // Added for reassign leads modal
            closeModal('open-assign-modal');
            closeModal('open-return-modal');
            closeModal('open-reassign-modal'); // Added for reassign leads modal
        }
    
        // Run the initialization
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
                    usersHeading.innerText = 'Affected users';
                    usersList.innerHTML = '';
                    data.profiles.forEach(profile => {
                        const li = document.createElement('li');
                        li.innerText = `-${profile.first_name}  ${profile.last_name}`;
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
});

