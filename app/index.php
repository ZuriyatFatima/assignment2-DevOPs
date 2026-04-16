<?php
$host = 'db';
$user = 'appuser';
$pass = 'apppass';
$dbname = 'notesdb';

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create table if not exists
$conn->query("CREATE TABLE IF NOT EXISTS notes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['title']) && !empty($_POST['content'])) {
    $title   = $conn->real_escape_string($_POST['title']);
    $content = $conn->real_escape_string($_POST['content']);
    $conn->query("INSERT INTO notes (title, content) VALUES ('$title', '$content')");
    $message = 'Note saved!';
}

$notes = $conn->query("SELECT * FROM notes ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Student Notes</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 40px auto; padding: 0 20px; background: #f5f5f5; }
        h1 { color: #333; }
        form { background: white; padding: 20px; border-radius: 8px; margin-bottom: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        input, textarea { width: 100%; padding: 8px; margin: 8px 0 16px; box-sizing: border-box; border: 1px solid #ddd; border-radius: 4px; }
        button { background: #0070f3; color: white; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer; }
        .note { background: white; padding: 16px; margin-bottom: 12px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .note h3 { margin: 0 0 8px; color: #0070f3; }
        .note p { margin: 0; color: #555; }
        .note small { color: #999; }
        .msg { color: green; font-weight: bold; }
    </style>
</head>
<body>
    <h1>📝 Student Notes</h1>
    <?php if ($message): ?><p class="msg"><?= $message ?></p><?php endif; ?>
    <form method="POST">
        <label>Title</label>
        <input type="text" name="title" placeholder="Note title" required>
        <label>Content</label>
        <textarea name="content" rows="4" placeholder="Write your note here..." required></textarea>
        <button type="submit">Save Note</button>
    </form>
    <h2>Saved Notes</h2>
    <?php while ($row = $notes->fetch_assoc()): ?>
    <div class="note">
        <h3><?= htmlspecialchars($row['title']) ?></h3>
        <p><?= nl2br(htmlspecialchars($row['content'])) ?></p>
        <small><?= $row['created_at'] ?></small>
    </div>
    <?php endwhile; ?>
</body>
</html>
<!-- Trigger v2 -->
