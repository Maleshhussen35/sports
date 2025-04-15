<?php
include '../../db/connection.php';

$stmt = $pdo->query('SELECT * FROM members');
$members = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<div>
    <h2>Members</h2>
    <table>
        <?php foreach ($members as $member): ?>
            <tr>
                <td><?= $member['name']; ?></td>
                <!-- Display other fields -->
            </tr>
        <?php endforeach; ?>
    </table>
</div>