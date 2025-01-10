// State tracking
let previousAssignedData = []; // To track the previous data state
let previousReturnedData = [];
let lastCheckAssigned = new Date().toISOString();
let lastCheckReturned = new Date().toISOString();

// Polling for returned leads

function pollForReturnedLeads() {
    const returnedTableBody = document.getElementById('returned-leads-body');
    if (!returnedTableBody) {
        console.log('Returned Leads table not found. Polling for Returned Leads stopped.');
        return; // Exit if the table is not present
    }
    setInterval(() => {
        fetch(`/returned-leads?last_check=${lastCheckReturned}`, {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            lastCheckReturned = data.last_check;

            // Only update the table if there's new or modified data
            if (JSON.stringify(data.return_customers) !== JSON.stringify(previousReturnedData)) {
                previousReturnedData = data.return_customers; // Update the previous data tracker
                updateReturnedCustomerTable(
                    data.return_customers,
                    'returned-leads-body',
                    'no-returned-leads',
                    'No leads returned'
                );
            }
        })
        .catch(error => console.error('Error fetching returned leads:', error));
    }, 5000);
}

// Polling for assigned leads
function pollForAssignedLeads() {
    const assignedTableBody = document.getElementById('assigned-leads-body');
    if (!assignedTableBody) {
        console.log('Assigned Leads table not found. Polling for Assigned Leads stopped.');
        return; // Exit if the table is not present
    }

    setInterval(() => {
        fetch(`/assigned-leads?last_check=${lastCheckAssigned}`, {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            lastCheckAssigned = data.last_check;

            // Update only if there's new or modified data
            if (JSON.stringify(data.assigned_customers) !== JSON.stringify(previousAssignedData)) {
                previousAssignedData = data.assigned_customers; // Update the previous data tracker
                updateAssignedCustomerTable(
                    data.assigned_customers, 
                    'assigned-leads-body', 
                    'no-assigned-leads', 
                    'No leads assigned'
                );
            }
        })
        .catch(error => console.error('Error fetching assigned leads:', error));
    }, 5000);
}

function pollForEmployeeAssignedLeads() {
    setInterval(() => {
        // console.log('Polling for employee assigned leads...'); 
        
        fetch('/my-assigned-leads', {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            // console.log('Employee assigned leads response:', data); 

            const tableBody = document.getElementById('my-leads-table').querySelector('tbody');
            const noCustomersRow = document.getElementById('no-customers-row');

            // Check if we have customers
            if (data && Array.isArray(data.assigned_customers) && data.assigned_customers.length > 0) {
                // Remove the "No customers assigned" row if it exists
                if (noCustomersRow) {
                    noCustomersRow.remove();
                }

                // Loop through data and only add rows for new customers
                data.assigned_customers.forEach(customer => {
                    // Only add new rows that do not already exist in the table
                    if (!tableBody.querySelector(`tr[data-id="${customer.id}"]`)) {
                        // console.log(`Adding new customer ID: ${customer.id}`);
                        addNewCustomerRow(customer, 'my-leads-table');
                    }
                });
            } else {
                // No assigned customers: Ensure "No customers assigned" row is present
                if (!noCustomersRow) {
                    tableBody.innerHTML = `
                        <tr id="no-customers-row">
                            <td colspan="5" class="text-center">No customers assigned</td>
                        </tr>
                    `;
                }
            }
        })
        .catch(error => console.error('Error fetching employee assigned leads:', error));
    }, 5000);
}

// Function to add a new customer row to the table dynamically, avoiding duplicates
function addNewCustomerRow(customer, tableId) {
    const tableBody = document.getElementById(tableId).querySelector('tbody');

    if (!tableBody) {
        console.error(`Table body not found for table ID "${tableId}".`);
        return;
    }
    
    // Check if a row with this customer ID already exists in the table
    if (tableBody.querySelector(`tr[data-id="${customer.id}"]`)) {
        console.log(`Customer with ID ${customer.id} already exists in the table. Skipping.`);
        return; // Don't add the row again if it already exists
    }

    // Create a new row for the customer
    const newRow = `
        <tr class="customer-row fade-in" data-id="${customer.id}" onclick="markAsViewed(${customer.id})">
            <td><input type="checkbox" class="form-checkbox select-lead" /></td>
            <td>${new Date(customer.date_created).toLocaleDateString()}</td>
            <td>${customer.first_name} ${customer.last_name} ${!customer.is_viewed ? '<span class="new-label">New</span>' : ''}</td>
            <td>${customer.email}</td>
            <td>${customer.address || 'N/A'}</td>
        </tr>
    `;
    
    // Append the new row to the table body
    tableBody.insertAdjacentHTML('beforeend', newRow);
    // console.log(`Customer with ID ${customer.id} added to the ${tableId}.`);
    handleIndividualCheckboxes(tableId, 'open-return-modal');
}

// Function to update the table and manage the "No leads assigned" message
function updateAssignedCustomerTable(customers, tbodyId, emptyMessageId, emptyMessageText) {
    const tableBody = document.getElementById(tbodyId);
    const noDataRow = document.getElementById(emptyMessageId);

    // Preserve the checkbox state
    const checkboxStates = {};
    tableBody.querySelectorAll('.select-lead').forEach(checkbox => {
        const row = checkbox.closest('tr');
        if (row) {
            const id = row.getAttribute('data-id');
            checkboxStates[id] = checkbox.checked;
        }
    });

    // Create a Set of customer IDs from the new data
    const customerIds = new Set(customers.map(customer => customer.id));

    // Remove rows that are no longer in the new data
    tableBody.querySelectorAll('.customer-row').forEach(row => {
        const rowId = row.getAttribute('data-id');
        if (!customerIds.has(parseInt(rowId, 10))) {
            row.remove();
        }
    });

    // Add or update rows for the current customers
    customers.forEach(customer => {
        const existingRow = tableBody.querySelector(`tr[data-id="${customer.id}"]`);
        const rowContent = `
            <td><input type="checkbox" class="form-checkbox select-lead" /></td>
            <td>${formatDateToDMY(customer.date_created)}</td>
            <td>${customer.fullName || `${customer.first_name} ${customer.last_name}`}</td>
            <td>${customer.email}</td>
            <td>${customer.address || 'N/A'}</td>
        `;

        if (existingRow) {
            existingRow.innerHTML = rowContent;

            // Restore the checkbox state if it exists
            const checkbox = existingRow.querySelector('.select-lead');
            if (checkbox && checkboxStates[customer.id] !== undefined) {
                checkbox.checked = checkboxStates[customer.id];
            }
        } else {
            const newRow = document.createElement('tr');
            newRow.classList.add('customer-row');
            newRow.setAttribute('data-id', customer.id);
            newRow.innerHTML = rowContent;

            // Restore the checkbox state for new rows
            const checkbox = newRow.querySelector('.select-lead');
            if (checkbox && checkboxStates[customer.id] !== undefined) {
                checkbox.checked = checkboxStates[customer.id];
            }

            tableBody.appendChild(newRow);
        }
    });

    // Display "No leads assigned" message only if there are no rows
    if (customers.length === 0 && !tableBody.querySelector('.customer-row')) {
        if (!noDataRow) {
            const noDataRowElement = document.createElement('tr');
            noDataRowElement.id = emptyMessageId;
            noDataRowElement.innerHTML = `<td colspan="5" class="text-center">${emptyMessageText}</td>`;
            tableBody.appendChild(noDataRowElement);
        }
    } else if (noDataRow) {
        noDataRow.remove();
    }

    // Attach listeners to checkboxes for enabling/disabling the button
    handleIndividualCheckboxes(tbodyId, 'unassign-leads-btn');
}

function updateReturnedCustomerTable(customers, tbodyId, emptyMessageId, emptyMessageText) {
    const tableBody = document.getElementById(tbodyId);
    const noDataRow = document.getElementById(emptyMessageId);

    if (!tableBody) {
        console.error(`Table body with ID "${tbodyId}" not found.`);
        return;
    }

    // Add or update rows for the current customers
    customers.forEach(customer => {
        const existingRow = tableBody.querySelector(`tr[data-id="${customer.id}"]`);
        const rowContent = `
            <td><input type="checkbox" class="form-checkbox select-lead" /></td>
            <td>${formatDateToDMY(customer.date_created)}</td>
            <td>${customer.fullName || `${customer.first_name} ${customer.last_name}`}</td>
            <td>${customer.email}</td>
            <td>${customer.address || 'N/A'}</td>
        `;

        if (existingRow) {
            existingRow.innerHTML = rowContent;
        } else {
            const newRow = document.createElement('tr');
            newRow.classList.add('customer-row');
            newRow.setAttribute('data-id', customer.id);
            newRow.innerHTML = rowContent;

            tableBody.appendChild(newRow);
        }
    });

    // Display "No leads returned" message only if there are no rows
    if (customers.length === 0 && !tableBody.querySelector('.customer-row')) {
        if (!noDataRow) {
            const noDataRowElement = document.createElement('tr');
            noDataRowElement.id = emptyMessageId;
            noDataRowElement.innerHTML = `<td colspan="5" class="text-center">${emptyMessageText}</td>`;
            tableBody.appendChild(noDataRowElement);
        }
    } else if (noDataRow) {
        noDataRow.remove();
    }

    // Check if handleIndividualCheckboxes is available
    handleIndividualCheckboxes(tbodyId, 'open-reassign-modal');
}

// Utility function to format dates as `d M, Y`
function formatDateToDMY(dateString) {
    const date = new Date(dateString);
    const day = String(date.getDate()).padStart(2, '0');
    const month = date.toLocaleString('default', { month: 'short' });
    const year = date.getFullYear();
    return `${day} ${month}, ${year}`; // Matches `d M, Y` format
}

// Start polling when the page loads
window.onload = function() {
    pollForAssignedLeads();
    pollForReturnedLeads();
};


// Mark customer as viewed and remove the "New" label
function markAsViewed(customerId) {
    fetch(`/customers/${customerId}/mark-as-viewed`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ customer_id: customerId })
    }).then(response => response.json())
      .then(data => {
          if (data.success) {
              const row = document.querySelector(`tr[data-id='${customerId}']`);
              const newLabel = row.querySelector('.new-label');
              if (newLabel) {
                  newLabel.remove();  // Remove the "New" label after click
              }
          }
      })
      .catch(error => console.error('Error updating customer:', error));
}