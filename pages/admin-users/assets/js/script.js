async function handleUserAction(form, action) {
    const formData = new FormData(form);
    formData.append('action', action);

    try {
        const response = await fetch('../../../handlers/userAdmin.handler.php', {
            method: 'POST',
            body: formData
        });

        const result = await response.json();
        alert(result.message);

        if (action === 'see' && result.users) {
            renderUsersTable(result.users);
        }

        if (action === 'find' && result.user) {
            document.getElementById('found-user-result').innerText =
                `${result.user.first_name} ${result.user.last_name} (${result.user.role})`;
        }

    } catch (error) {
        alert('⚠️ Request failed.');
        console.error(error);
    }
}

function renderUsersTable(users) {
    const tableContainer = document.getElementById('users-table');
    if (!tableContainer) return;

    if (tableContainer.innerHTML.trim() !== '') {
        tableContainer.innerHTML = ''; // Hide table if already visible
        return;
    }

    let html = '<table><thead><tr><th>ID</th><th>Username</th><th>Role</th></tr></thead><tbody>';
    users.forEach(user => {
        html += `<tr>
            <td>${user.user_id}</td>
            <td>${user.username}</td>
            <td>${user.role}</td>
        </tr>`;
    });
    html += '</tbody></table>';

    tableContainer.innerHTML = html;
}
