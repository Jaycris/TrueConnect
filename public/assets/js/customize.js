document.addEventListener('DOMContentLoaded', function() {
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
});


//checkbox JS
document.querySelector('.checkAll').addEventListener('change', function() {
    let checkboxes = document.querySelectorAll('tbody input[type="checkbox"]');
    checkboxes.forEach(function(checkbox) {
        checkbox.checked = this.checked;
    }.bind(this));
});

//delete Department or Designation
document.addEventListener('DOMContentLoaded', function () {
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
});
