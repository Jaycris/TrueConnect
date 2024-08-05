// Add contact numbers
document.getElementById('add_contact_number').addEventListener('click', function () {
    var container = document.getElementById('contact_numbers_container');
    var newInput = document.createElement('div');
    newInput.className = 'contact-input-group';
    newInput.innerHTML = `
        <input type="text" class="form-input" name="contact_numbers[]" placeholder="Enter Contact Number">
    `;
    container.appendChild(newInput);
    updateRemoveButtonVisibility(); // Update button visibility after adding a new field
});

// Remove the last contact number
document.querySelector('.remove-contact-number').addEventListener('click', function () {
    var container = document.getElementById('contact_numbers_container');
    if (container.children.length > 1) {
        container.lastElementChild.remove();
    }
    updateRemoveButtonVisibility(); // Update visibility after removing a field
});

// Function to update the visibility of the remove button
function updateRemoveButtonVisibility() {
    var container = document.getElementById('contact_numbers_container');
    var removeButton = document.querySelector('.remove-contact-number');
    if (container.children.length > 1) {
        removeButton.style.display = 'inline-block'; // Show the - button
    } else {
        removeButton.style.display = 'none'; // Hide the - button
    }
}
// Initial call to set the correct visibility for the "-" button
updateRemoveButtonVisibility();



// Add book fields
document.getElementById('add_book').addEventListener('click', function () {
    var container = document.getElementById('books_container');
    var newIndex = container.children.length;
    var newInput = document.createElement('div');
    newInput.className = 'book-input-group';
    newInput.innerHTML = `
        <input type="text" name="books[${newIndex}][title]" class="form-input" placeholder="Enter Book Title" required>
        <input type="url" name="books[${newIndex}][link]" class="form-input" placeholder="Enter Book Link (optional)">
    `;
    container.appendChild(newInput);
    updateBookButtonVisibility(); // Update button visibility after adding a new field
});

// Remove the last book field
document.querySelector('.remove-book').addEventListener('click', function () {
    var container = document.getElementById('books_container');
    if (container.children.length > 1) {
        container.lastElementChild.remove();
    }
    updateBookButtonVisibility(); // Update visibility after removing a field
});

// Function to update the visibility of the remove button
function updateBookButtonVisibility() {
    var container = document.getElementById('books_container');
    var removeButton = document.querySelector('.remove-book');
    if (container.children.length > 1) {
        removeButton.style.display = 'inline-block'; // Show the - button
    } else {
        removeButton.style.display = 'none'; // Hide the - button
    }
}
// Initial call to set the correct visibility for the "-" button
updateBookButtonVisibility();