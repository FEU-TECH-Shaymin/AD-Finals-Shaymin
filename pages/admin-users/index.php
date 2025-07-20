<?php
require_once __DIR__ . '/../../layouts/main.layout.php';

renderMainLayout(function () {
?>
<section class="admin-container">
    <h1>User Administration</h1>

    <form onsubmit="event.preventDefault(); handleUserAction(this, 'create');" class="glass-box">
        <h2>Create Users</h2>
        <div class="grid">
            <select name="role" required>
                <option value="">Role</option>
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>
            <input type="text" name="first_name" placeholder="First Name" required>
            <input type="text" name="middle_name" placeholder="Middle Name">
            <input type="text" name="last_name" placeholder="Last Name" required>
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
        </div>
        <button type="submit">Sign Up</button>
    </form>

    <form onsubmit="event.preventDefault(); handleUserAction(this, 'find');" class="glass-box">
        <h2>Find User by Username</h2>
        <input type="text" name="username" placeholder="Username">
        <button type="submit">Find</button>
        <p id="found-user-result"></p>
    </form>

    <form onsubmit="event.preventDefault(); handleUserAction(this, 'update');" class="glass-box">
        <h2>Update Username</h2>
        <input type="text" name="old_username" placeholder="Old Username">
        <input type="text" name="new_username" placeholder="New Username">
        <button type="submit">Update</button>
    </form>

    <form onsubmit="event.preventDefault(); handleUserAction(this, 'delete');" class="glass-box">
        <h2>Delete User</h2>
        <input type="text" name="username" placeholder="Username to Delete">
        <button type="submit">Delete</button>
    </form>

    <form onsubmit="event.preventDefault(); handleUserAction(this, 'see');" class="glass-box">
        <h2>See All Users</h2>
        <button type="submit">See Users</button>
        <div id="users-table"></div>
    </form>
</section>
<?php
}, [
    "css" => ["./assets/css/style.css"],
    "js" => ["./assets/js/script.js"]
]);
?>
