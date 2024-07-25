<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Backrooms Game - Room 0</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Backrooms Game - Room 0</h1>
    <a href="../../logout.php" id="logout">Logout</a>
    <a href="../../games.php" id="games">Back</a>
    <div class="terminal">
        <div id="output" class="output"></div>
        <form id="commandForm" action="process_commands.php" method="post">
            <input type="text" id="command" name="command" autocomplete="off" placeholder="Digite seu comando...">
            <input type="hidden" name="level" value="0">
            <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id'] ?? 0; ?>">
        </form>
    </div>
    <script>
        document.getElementById('commandForm').addEventListener('submit', async function (e) {
            e.preventDefault();
            const command = document.getElementById('command').value;
            const formData = new FormData(this);
            const response = await fetch('process_commands.php', {
                method: 'POST',
                body: formData
            });
            const result = await response.text();
            document.getElementById('output').innerHTML += `<div>$ ${command}</div><div>${result}</div>`;
            document.getElementById('command').value = '';
            document.getElementById('output').scrollTop = document.getElementById('output').scrollHeight;
        });
    </script>
</body>
</html>
