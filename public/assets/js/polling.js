let lastCheck = new Date().toISOString();  // Keep track of last time we polled

function pollForReturnedLeads() {
    setInterval(() => {
        console.log('Polling for returned leads...'); // Debugging
        
        // Send the last check timestamp to fetch only new leads
        fetch(`/returned-leads?last_check=${lastCheck}`, {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            console.log('Returned leads response:', data); // Debugging

            // Update the last check timestamp for the next poll
            lastCheck = data.last_check;

            // Add new returned leads to the table
            data.return_customers.forEach(customer => {
                addNewCustomerRow(customer, 'return-leads-table'); // Update the return leads table
            });
        })
        .catch(error => console.error('Error fetching returned leads:', error));
    }, 5000); // Poll every 5 seconds
}

function pollForAssignedLeads() {
    setInterval(() => {
        console.log('Polling for assigned leads...'); // Check if polling is happening
        fetch('/assigned-leads', {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            console.log('Assigned leads response:', data); // Log the data returned by the server

            data.assigned_customers.forEach(customer => {
                console.log(`Processing customer ID: ${customer.id}`); // Log customer ID before adding the row
                addNewCustomerRow(customer, 'assign-leads-table'); // Ensure correct table ID
            });
        })
        .catch(error => console.error('Error fetching assigned leads:', error));
    }, 5000); // Poll every 5 seconds
}

function pollForEmployeeAssignedLeads() {
    setInterval(() => {
        console.log('Polling for employee assigned leads...'); // Debugging
        fetch('/my-assigned-leads', {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            console.log('Employee assigned leads response:', data); // Log the server response

            data.assigned_customers.forEach(customer => {
                console.log(`Processing customer ID: ${customer.id}`); // Debugging
                addNewCustomerRow(customer, 'my-leads-table'); // Ensure correct table
            });
        })
        .catch(error => console.error('Error fetching employee assigned leads:', error));
    }, 5000); // Poll every 5 seconds
}

// Function to add a new customer row to the table dynamically
function addNewCustomerRow(customer, tableId) {
    const tableBody = document.querySelector(`#${tableId} tbody`);
    
    // Check if a row with this customer ID already exists in the table
    const existingRow = document.querySelector(`tr[data-id="${customer.id}"]`);

    // Avoid adding duplicate rows by checking if the row already exists
    if (existingRow) {
        console.log(`Customer with ID ${customer.id} already exists in the table.`);
        return; // Don't add the row again if it exists
    }

    // Create a new row for the customer
    const newRow = `
        <tr class="customer-row fade-in" data-id="${customer.id}">
            <td><input type="checkbox" class="form-checkbox select-lead" /></td>
            <td>${new Date(customer.date_created).toLocaleDateString()}</td>
            <td>${customer.first_name} ${customer.last_name}</td>
            <td>${customer.email}</td>
            <td>${customer.address || 'N/A'}</td>
        </tr>`;
    
    // Append the new row to the table body
    tableBody.insertAdjacentHTML('beforeend', newRow); // Insert the new row into the table
    console.log(`Customer with ID ${customer.id} added to the ${tableId}.`); // Debugging
}

// Start polling for each table when the page loads
window.onload = function() {
    pollForAssignedLeads();  // Start polling assigned leads
    pollForReturnedLeads();  // Start polling returned leads
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